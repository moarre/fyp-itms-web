<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Emaildocs;
use App\Models\Interndata;
use App\Models\Lecturer;
use App\Models\Location;
use App\Models\PdfFile;
use App\Models\Program;
use App\Models\Semester;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Swift_Attachment;

class CoordinatorController extends Controller
{
    public function coordinatorIndex()
    {
        return view('coordinator.coordinator_login');
    } // end mehtod


    public function CoordinatorDashboard()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();
        $locations = Location::all();

        return view('coordinator.index', compact('students', 'programs', 'semesters', 'locations'));
    } // end mehtod


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = User::all();

        $programs = Program::pluck('code', 'id');

        $semesters = Semester::pluck('session', 'id', 'numSemester');

        $coordinators = Coordinator::pluck('name', 'id');

        $lecturers = Lecturer::pluck('name', 'id');

        return view('coordinator.create', compact('student', 'programs', 'semesters', 'coordinators', 'lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create([
            'program_id' => $request->program_id,
            'semester_id' => $request->semester_id,
            'coordinator_id' => $request->coordinator_id,
            'lecturer_id' => $request->lecturer_id,
            $request->all(),
        ]);

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function show(User $student)
    {
        return view('coordinator.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student)
    {
        $programs = Program::pluck('code', 'id');

        $semesters = Semester::pluck('session', 'id', 'numSemester');

        $coordinators = Coordinator::pluck('name', 'id');

        $lecturers = Lecturer::pluck('name', 'id');

        return view('coordinator.edit', compact('student', 'programs', 'semesters', 'coordinators', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $student)
    {

        $student->update($request->all());

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $student)
    {
        $student->delete();

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Student deleted successfully');
    }

    // Authentication

    public function CoordinatorLogin(Request $request)
    {
        // dd($request->all());

        $check = $request->all();
        if (Auth::guard('coordinator')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            return redirect()->route('coordinator.dashboard')->with('error', 'Coordinator Login Successfully');
        } else {
            return back()->with('error', 'Invalid Email Or Password');
        }
    } // end mehtod


    public function CoordinatorLogout()
    {

        Auth::guard('coordinator')->logout();
        return redirect()->route('coordinator_login_from')->with('error', 'Coordinator Logout Successfully');
    } // end mehtod


    public function CoordinatorRegister()
    {

        return view('coordinator.coordinator_register');
    } // end mehtod


    public function CoordinatorRegisterCreate(Request $request)
    {

        // dd($request->all());

        Coordinator::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'created_at' => Carbon::now(),

        ]);

        return redirect()->route('coordinator_login_from')->with('error', 'Coordinator Created Successfully');
    } // end mehtod


    //BLI01 page
    public function BLI01page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();

        return view('coordinator.bli01', compact('students', 'programs', 'semesters'));
    } // end mehtod

    //BLI01 generate
    public function uploadPDFsingle(User $user)
    {
        // check if user already has a pdf_id
        if ($user->li01_id) {
            return redirect()->route('coordinator.dashboard')
                ->with('success', 'Letter already generated for this user');
        }

        // check if user has li02 or li03 id
        if ($user->li02_id || $user->li03_id) {
            // Save li01 file within the same id as li02_id or li03_id
            $pdfFile = PdfFile::find($user->li02_id ?? $user->li03_id);
        } else {
            // create new pdffile id
            $pdfFile = new PdfFile();
        }

        $pdf = FacadePdf::loadView('coordinator.pdfbli01', compact('user'));

        // Convert the PDF file to binary data
        $binaryData = $pdf->output();

        // Save the binary data to the database
        $pdfFile->li01 = $binaryData;
        $pdfFile->save();

        // Update the user table with the pdfFile id
        $user->li01_id = $pdfFile->id;
        $user->save();

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Letter created successfully');
    }


    //get value checkboxes and upload to database
    public function uploadPDFall(Request $request)
    {
        $ids = $request->input('check_item');
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            // check if user already has a pdf_id
            if (!!$user->li01_id) {
                return response('Letter already generated for this user');
            } else {
                continue;
            }

            // check if user has li02 or li03 id
            if ($user->li02_id || $user->li03_id) {
                // Save li01 file within the same id as li02_id or li03_id
                $pdfFile = PdfFile::find($user->li02_id ?? $user->li03_id);
            } else {
                // create new pdffile id
                $pdfFile = new PdfFile();
            }

            $pdf = FacadePdf::loadView('coordinator.pdfbli01', compact('user'));
            $binaryData = $pdf->output();

            $pdfFile->li01 = $binaryData;
            $pdfFile->save();

            $user->li01_id = $pdfFile->id;
            $user->save();
        }

        return response('Letter created successfully');
    }

    //BLI02 page
    public function BLI02page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();

        return view('coordinator.bli02', compact('students', 'programs', 'semesters'));
    } // end mehtod

    //BLI02 page stream (view)
    public function viewbli02(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li02, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="pdfview.pdf"',
        ]);

        return $response;
    }

    //BLI02 download
    public function downloadbli02(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li02, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="pdfview.pdf"',
        ]);

        return $response;
    }

    //BLI03 page
    public function BLI03page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();

        return view('coordinator.bli03', compact('students', 'programs', 'semesters'));
    } // end mehtod

    //BLI03 view details (belum ada)
    public function viewbli03()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf', 'interndata')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();
        $interndata = Interndata::all();

        return view('coordinator.viewbli03', compact('students', 'programs', 'semesters', 'interndata'));
    } // end mehtod

    //BLI03 generate
    public function uploadBLI03single(User $user)
    {
        // check if user already has a pdf_id
        if ($user->li03_id) {
            return redirect()->route('coordinator.dashboard')
                ->with('success', 'Letter already generated for this user');
        }

        // check if user has li02 or li03 id
        if ($user->li02_id || $user->li01_id) {
            // Save li01 file within the same id as li02_id or li03_id
            $pdfFile = PdfFile::find($user->li02_id ?? $user->li01_id);
        } else {
            // create new pdffile id
            $pdfFile = new PdfFile();
        }

        $pdf = FacadePdf::loadView('coordinator.pdfbli03', compact('user'));

        // Convert the PDF file to binary data
        $binaryData = $pdf->output();

        // Save the binary data to the database
        $pdfFile->li03 = $binaryData;
        $pdfFile->save();

        // Update the user table with the pdfFile id
        $user->li03_id = $pdfFile->id;
        $user->save();

        return redirect()->route('coordinator.bli03')
            ->with('success', 'Letter created successfully');
    }

    // public function uploadBLI03single(User $user)
    // {
    //     $pdf = FacadePdf::loadView('coordinator.pdfbli03', compact('user'));
    //     return $pdf->stream();
    // }


    //get value checkboxes and upload to database
    public function uploadBLI03all(Request $request)
    {
        $ids = $request->input('check_item');
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            // check if user already has a pdf_id
            if (!!$user->li03_id) {
                return response('Letter already generated for this user');
            } else {
                continue;
            }

            $pdf = FacadePdf::loadView('coordinator.pdfbli03', compact('user'));
            $binaryData = $pdf->output();

            $pdfFile = new PdfFile();
            $pdfFile->li03 = $binaryData;
            $pdfFile->save();

            $user->li03_id = $pdfFile->id;
            $user->save();
        }

        return response('Letter created successfully');
    }

    //BLI04 page
    public function BLI04page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::all();
        $semesters = Semester::all();

        return view('coordinator.bli04', compact('students', 'programs', 'semesters'));
    } // end mehtod

    //document upload page
    public function uploadDocument()
    {
        return view('coordinator.uploadDocument');
    } // end mehtod

    //BLI04 upload files (start)

    public function BLI04upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $folder = 'bli04'; // Specify the folder name here
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $folder . '/' . $filename;

        // Check if the folder exists, otherwise create it
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        // Save the PDF file to storage/app/public/your-folder-name
        Storage::disk('public')->put($filePath, file_get_contents($file));

        // Find an existing instance of Emaildocs model
        $emailDoc = Emaildocs::first();
        if ($emailDoc) {
            // Update the existing instance's file_path1
            $emailDoc->file_path1 = $filePath;
            $emailDoc->save();
        } else {
            // Create a new instance if no existing instance is found
            $emailDoc = new Emaildocs();
            $emailDoc->file_path1 = $filePath;
            $emailDoc->save();
        }

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'File uploaded successfully');
    }

    public function Lampiran1upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $folder = 'lampiran1'; // Specify the folder name here
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $folder . '/' . $filename;

        // Check if the folder exists, otherwise create it
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        // Save the PDF file to storage/app/public/your-folder-name
        Storage::disk('public')->put($filePath, file_get_contents($file));

        // Find an existing instance of Emaildocs model
        $emailDoc = Emaildocs::first();
        if ($emailDoc) {
            // Update the existing instance's file_path2
            $emailDoc->file_path2 = $filePath;
            $emailDoc->save();
        } else {
            // Create a new instance if no existing instance is found
            $emailDoc = new Emaildocs();
            $emailDoc->file_path2 = $filePath;
            $emailDoc->save();
        }

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'File uploaded successfully');
    }

    //BLI04 upload files (end)

    //BLI04 email
    public function sendbli04Email($id)
    {
        // Retrieve the user data from the database
        $user = User::find($id);
        $emaildocs = Emaildocs::find($id);

        // Retrieve the file paths from different columns of the database
        $filePath1 = $emaildocs->file_path1;
        $filePath2 = $emaildocs->file_path2;
        $pdfFile = PdfFile::find($user->li03_id);

        // Build the email message from a Blade template
        $emailMessage = view('coordinator.emailbli04', ['user' => $user])->render();

        // Create an array of file paths for the attachments
        $attachments = [];
        if ($filePath1) {
            $attachments[] = storage_path('app/public/' . $filePath1);
        }
        if ($filePath2) {
            $attachments[] = storage_path('app/public/' . $filePath2);
        }
        if ($pdfFile) {
            $attachments[] = [
                'name' => 'Attachment3.pdf', // Set a desired name for the attachment
                'data' => $pdfFile->li03,
                'options' => [
                    'mime' => 'application/pdf',
                ],
            ];
        }

        // Send the email with attachments
        Mail::send([], [], function ($message) use ($user, $emailMessage, $attachments) {
            $message->from($user->program->coordinator->email,  $user->program->coordinator->name);
            $message->to($user->interndata->companyEmail)->subject('PENGESAHAN PENERIMAAN PENEMPATAN LATIHAN INDUSTRI');
            $message->setBody($emailMessage, 'text/html');
            foreach ($attachments as $attachment) {
                if (is_array($attachment)) {
                    $message->attachData($attachment['data'], $attachment['name'], $attachment['options']);
                } else {
                    $message->attach($attachment);
                }
            }
        });

        // Return a response
        // return response()->json(['message' => 'Email sent'], 200);
        return redirect()->back()->with('success', 'Email sent successfully.');
    }


    // public function sendbli04Email()
    // {
    //     Mail::send('welcome', [], function ($message) {
    //         $message->to('admin@example.com')->subject('Testing MailHog');
    //         $message->from('sender@example.com', 'Sender Name');
    //     });
    // }

    /* Search Section Start */

    public function searchli01(Request $request)
    {
        $name = $request->input('name');
        $ic = $request->input('ic');
        $studentNumber = $request->input('student_number');
        $programCode = $request->input('program_code');
        $semester = $request->input('semester');

        $students = User::when($name, function ($query) use ($name) {
            $query->where('fullname', 'like', '%' . $name . '%');
        })
            ->when($ic, function ($query) use ($ic) {
                $query->where('ic', 'like', '%' . $ic . '%');
            })
            ->when($studentNumber, function ($query) use ($studentNumber) {
                $query->where('student_number', 'like', '%' . $studentNumber . '%');
            })
            ->when($programCode, function ($query) use ($programCode) {
                $query->whereHas('programs', function ($query) use ($programCode) {
                    $query->where('code', 'like', '%' . $programCode . '%');
                });
            })
            ->when($semester, function ($query) use ($semester) {
                $query->whereHas('semesters', function ($query) use ($semester) {
                    $query->where('session', 'like', '%' . $semester . '%');
                });
            })
            ->with('program', 'semester')
            ->get();

        // Render the partial view with the filtered students
        $html = view('coordinator.new-tables.student_tableli01', compact('students'))->render();

        return response()->json(['html' => $html]);
    }

    public function searchli02(Request $request)
    {
        $name = $request->input('name');
        $ic = $request->input('ic');
        $studentNumber = $request->input('student_number');
        $programCode = $request->input('program_code');
        $semester = $request->input('semester');

        $students = User::when($name, function ($query) use ($name) {
            $query->where('fullname', 'like', '%' . $name . '%');
        })
            ->when($ic, function ($query) use ($ic) {
                $query->where('ic', 'like', '%' . $ic . '%');
            })
            ->when($studentNumber, function ($query) use ($studentNumber) {
                $query->where('student_number', 'like', '%' . $studentNumber . '%');
            })
            ->when($programCode, function ($query) use ($programCode) {
                $query->whereHas('programs', function ($query) use ($programCode) {
                    $query->where('code', 'like', '%' . $programCode . '%');
                });
            })
            ->when($semester, function ($query) use ($semester) {
                $query->whereHas('semesters', function ($query) use ($semester) {
                    $query->where('session', 'like', '%' . $semester . '%');
                });
            })
            ->with('program', 'semester')
            ->get();

        // Render the partial view with the filtered students
        $html = view('coordinator.new-tables.student_tableli02', compact('students'))->render();

        return response()->json(['html' => $html]);
    }

    public function searchli03(Request $request)
    {
        $name = $request->input('name');
        $ic = $request->input('ic');
        $studentNumber = $request->input('student_number');
        $programCode = $request->input('program_code');
        $semester = $request->input('semester');

        $students = User::when($name, function ($query) use ($name) {
            $query->where('fullname', 'like', '%' . $name . '%');
        })
            ->when($ic, function ($query) use ($ic) {
                $query->where('ic', 'like', '%' . $ic . '%');
            })
            ->when($studentNumber, function ($query) use ($studentNumber) {
                $query->where('student_number', 'like', '%' . $studentNumber . '%');
            })
            ->when($programCode, function ($query) use ($programCode) {
                $query->whereHas('programs', function ($query) use ($programCode) {
                    $query->where('code', 'like', '%' . $programCode . '%');
                });
            })
            ->when($semester, function ($query) use ($semester) {
                $query->whereHas('semesters', function ($query) use ($semester) {
                    $query->where('session', 'like', '%' . $semester . '%');
                });
            })
            ->with('program', 'semester')
            ->get();

        // Render the partial view with the filtered students
        $html = view('coordinator.new-tables.student_tableli03', compact('students'))->render();

        return response()->json(['html' => $html]);
    }

    public function searchli04(Request $request)
    {
        $name = $request->input('name');
        $ic = $request->input('ic');
        $studentNumber = $request->input('student_number');
        $programCode = $request->input('program_code');
        $semester = $request->input('semester');

        $students = User::when($name, function ($query) use ($name) {
            $query->where('fullname', 'like', '%' . $name . '%');
        })
            ->when($ic, function ($query) use ($ic) {
                $query->where('ic', 'like', '%' . $ic . '%');
            })
            ->when($studentNumber, function ($query) use ($studentNumber) {
                $query->where('student_number', 'like', '%' . $studentNumber . '%');
            })
            ->when($programCode, function ($query) use ($programCode) {
                $query->whereHas('programs', function ($query) use ($programCode) {
                    $query->where('code', 'like', '%' . $programCode . '%');
                });
            })
            ->when($semester, function ($query) use ($semester) {
                $query->whereHas('semesters', function ($query) use ($semester) {
                    $query->where('session', 'like', '%' . $semester . '%');
                });
            })
            ->with('program', 'semester')
            ->get();

        // Render the partial view with the filtered students
        $html = view('coordinator.new-tables.student_tableli04', compact('students'))->render();

        return response()->json(['html' => $html]);
    }

    /* Search Section End */

    public function li01allStudents()
    {
        $students = User::all();
        $html = view('coordinator.new-tables.student_tableli01', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li01generatedStudents()
    {
        $students = User::whereNotNull('li01_id')->get();
        $html = view('coordinator.new-tables.student_tableli01', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li01notGeneratedStudents()
    {
        $students = User::whereNull('li01_id')->get();
        $html = view('coordinator.new-tables.student_tableli01', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li02allStudents()
    {
        $students = User::all();
        $html = view('coordinator.new-tables.student_tableli02', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li02generatedStudents()
    {
        $students = User::whereNotNull('li02_id')->get();
        $html = view('coordinator.new-tables.student_tableli02', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li02notGeneratedStudents()
    {
        $students = User::whereNull('li02_id')->get();
        $html = view('coordinator.new-tables.student_tableli02', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li03allStudents()
    {
        $students = User::all();
        $html = view('coordinator.new-tables.student_tableli03', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li03generatedStudents()
    {
        $students = User::whereNotNull('li03_id')->get();
        $html = view('coordinator.new-tables.student_tableli03', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li03notGeneratedStudents()
    {
        $students = User::whereNull('li03_id')->get();
        $html = view('coordinator.new-tables.student_tableli03', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li04allStudents()
    {
        $students = User::all();
        $html = view('coordinator.new-tables.student_tableli04', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li04generatedStudents()
    {
        $students = User::whereNotNull('li04_id')->get();
        $html = view('coordinator.new-tables.student_tableli04', compact('students'))->render();
        return response()->json(['html' => $html]);
    }

    public function li04notGeneratedStudents()
    {
        $students = User::whereNull('li04_id')->get();
        $html = view('coordinator.new-tables.student_tableli04', compact('students'))->render();
        return response()->json(['html' => $html]);
    }
}
