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
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Log;
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

    public function coordinatorProfile(Coordinator $coordinator)
    {
        return view('coordinator.coordprofile', compact('coordinator'));
    }

    public function profileupdate(Request $request, Coordinator $coordinator)
    {

        $coordinator->update($request->all());

        return redirect()->route('coordinator.dashboard')
            ->with('success', 'Profile updated successfully');
    }

    //BLI01 page
    public function BLI01page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::pluck('code', 'id');
        $semesters = Semester::pluck('session', 'id', 'numSemester');

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
            // Check if user already has an li01_id
            if ($user->li01_id) {
                return response('Letter already generated for this user');
            }

            // Check if user has li02 or li03 id
            if ($user->li02_id || $user->li03_id) {
                // Save li01 file within the same id as li02_id or li03_id
                $pdfFile = PdfFile::find($user->li02_id ?? $user->li03_id);
            } else {
                // Create new PdfFile
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
        $programs = Program::pluck('code', 'id');
        $semesters = Semester::pluck('session', 'id', 'numSemester');

        return view('coordinator.bli02', compact('students', 'programs', 'semesters'));
    } // end mehtod

    //BLI02 page stream (view)
    public function viewbli02(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li02, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="BLI02.pdf"',
        ]);

        return $response;
    }

    //BLI02 download
    public function downloadbli02(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li02, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="BLI02.pdf"',
        ]);

        return $response;
    }

    //BLI03 page
    public function BLI03page()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $programs = Program::pluck('code', 'id');
        $semesters = Semester::pluck('session', 'id', 'numSemester');

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

    //get value checkboxes and upload to database
    public function uploadBLI03all(Request $request)
    {
        $ids = $request->input('check_item');
        $users = User::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            // Check if user already has an li03_id
            if ($user->li03_id) {
                return response('Letter already generated for this user');
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
        $programs = Program::pluck('code', 'id');
        $semesters = Semester::pluck('session', 'id', 'numSemester');

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
        // Check if BLI04 is filled or not
        $emailDoc = Emaildocs::find(1); // Assuming you want to find the record with id=1, modify this accordingly.

        // If filled, then replace the file
        if ($emailDoc) {
            $request->validate([
                'file' => 'required|mimes:pdf|max:2048',
            ]);

            $emailDoc->BLI04 = file_get_contents($request->file('file'));
            $emailDoc->save();

            return redirect()->back()->with('success', 'PDF file replaced successfully.');
        }

        // If not filled, then create a new id
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $emailDoc = new Emaildocs();
        $emailDoc->BLI04 = file_get_contents($request->file('file'));
        $emailDoc->save();

        return redirect()->back()->with('success', 'PDF file uploaded successfully.');
    }

    public function Lampiran1upload(Request $request)
    {
        // Check if BLI04 is filled or not
        $emailDoc = Emaildocs::find(1); // Assuming you want to find the record with id=1, modify this accordingly.

        // If filled, then replace the file
        if ($emailDoc) {
            $request->validate([
                'file' => 'required|mimes:pdf|max:2048',
            ]);

            $emailDoc->Lampiran1 = file_get_contents($request->file('file'));
            $emailDoc->save();

            return redirect()->back()->with('success', 'PDF file replaced successfully.');
        }

        // If not filled, then create a new id
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $emailDoc = new Emaildocs();
        $emailDoc->BLI04 = file_get_contents($request->file('file'));
        $emailDoc->save();

        return redirect()->back()->with('success', 'PDF file uploaded successfully.');
    }

    //BLI04 upload files (end)

    //BLI04 email
    public function sendbli04Email($id)
    {
        // Retrieve the user data from the database
        $user = User::find($id);
        $emaildocs = Emaildocs::find($id);
        $bli04Binary = $emaildocs->BLI04;
        $pdfFile = PdfFile::find($user->li03_id);

        // Assuming you have a 'Lampiran1' attribute in the Emaildocs model, adjust this accordingly.
        $lampiran1Binary = $emaildocs->Lampiran1;

        // Build the email message from a Blade template
        $emailMessage = view('coordinator.emailbli04', ['user' => $user])->render();

        // Create an array of file paths for the attachments
        $attachments = [];

        if ($bli04Binary) {
            $attachments[] = [
                'name' => 'BLI04.pdf', // Set a desired name for the attachment
                'data' => base64_encode($bli04Binary), // Convert binary data to base64
                'options' => [
                    'mime' => 'application/pdf',
                ],
            ];
        }

        if ($lampiran1Binary) {
            $attachments[] = [
                'name' => 'Lampiran1.pdf', // Set a desired name for the attachment
                'data' => base64_encode($lampiran1Binary), // Convert binary data to base64
                'options' => [
                    'mime' => 'application/pdf',
                ],
            ];
        }

        if ($pdfFile) {
            $attachments[] = [
                'name' => 'SLI03.pdf', // Set a desired name for the attachment
                'data' => base64_encode($pdfFile->li03), // Convert binary data to base64
                'options' => [
                    'mime' => 'application/pdf',
                ],
            ];
        }

        // Convert the attachments array to a JSON string
        $attachmentsJson = json_encode($attachments);

        // Dispatch the email job to the database queue with the JSON-encoded attachments
        SendEmailJob::dispatch($user->toArray(), $emailMessage, $attachmentsJson);

        // Return a response
        return redirect()->back()->with('success', 'Email sending job dispatched.');
    }


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
                if (!empty($programCode)) {
                    $query->whereHas('program', function ($query) use ($programCode) {
                        $query->where('code', 'like', '%' . $programCode . '%');
                    });
                }
            })
            ->when($semester, function ($query) use ($semester) {
                if (!empty($semester)) {
                    $query->whereHas('semester', function ($query) use ($semester) {
                        $query->where('session', 'like', '%' . $semester . '%');
                    });
                }
            })
            ->with(['program', 'semester'])
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
                if (!empty($programCode)) {
                    $query->whereHas('program', function ($query) use ($programCode) {
                        $query->where('code', 'like', '%' . $programCode . '%');
                    });
                }
            })
            ->when($semester, function ($query) use ($semester) {
                if (!empty($semester)) {
                    $query->whereHas('semester', function ($query) use ($semester) {
                        $query->where('session', 'like', '%' . $semester . '%');
                    });
                }
            })
            ->with(['program', 'semester'])
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
                if (!empty($programCode)) {
                    $query->whereHas('program', function ($query) use ($programCode) {
                        $query->where('code', 'like', '%' . $programCode . '%');
                    });
                }
            })
            ->when($semester, function ($query) use ($semester) {
                if (!empty($semester)) {
                    $query->whereHas('semester', function ($query) use ($semester) {
                        $query->where('session', 'like', '%' . $semester . '%');
                    });
                }
            })
            ->with(['program', 'semester'])
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
                if (!empty($programCode)) {
                    $query->whereHas('program', function ($query) use ($programCode) {
                        $query->where('code', 'like', '%' . $programCode . '%');
                    });
                }
            })
            ->when($semester, function ($query) use ($semester) {
                if (!empty($semester)) {
                    $query->whereHas('semester', function ($query) use ($semester) {
                        $query->where('session', 'like', '%' . $semester . '%');
                    });
                }
            })
            ->with(['program', 'semester'])
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
