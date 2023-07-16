<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Lecturer;
use App\Models\PdfFile;
use App\Models\Program;
use App\Models\Semester;
use App\Models\User;
use App\Models\Interndata;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::with('program', 'semester', 'coordinator', 'lecturer', 'pdf')
            ->get();
        $locations = Location::all();

        return view('students.index', compact('students','locations'));
    }

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

        return view('students.create', compact('student', 'programs', 'semesters', 'coordinators', 'lecturers'));
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

        return redirect()->route('students.index')
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
        return view('students.show', compact('student'));
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

        return view('students.edit', compact('student', 'programs', 'semesters', 'coordinators', 'lecturers'));
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

        return redirect()->route('students.index')
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

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully');
    }

    //open bli-02
    public function bli02()
    {
        return view('students.bli02');
    }

    //open bli-03
    public function bli03()
    {
        return view('students.bli03');
    }

    //open bli-04
    public function bli04()
    {
        return view('students.bli04');
    }

    //edit bli03
    public function updatebli03(Request $request)
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();

        // Retrieve the existing Interndata record associated with the user, if it exists
        $interndata = $user->interndata;

        // If no existing Interndata record is found, create a new one
        if (!$interndata) {
            $interndata = new Interndata;
        }

        // Update the Interndata record with the new form data
        $interndata->fill($request->all());
        $interndata->save();

        // Update the interndata_id attribute of the user
        $user->interndata_id = $interndata->id;
        $user->save();

        return redirect()->route('students.bli03')
            ->with('success', 'Intern information updated successfully');
    }

    //download sli03
    public function downloadsli03(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li03, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="SLI03.pdf"',
        ]);

        return $response;
    }

    //function for pdf sli01 student download
    public function downloadPdf(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li01, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="SLI01.pdf"',
        ]);

        return $response;
    }

    //function for pdf bli02 student download
    public function downloadbli02(PdfFile $pdfFile)
    {
        $response = response($pdfFile->li02, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="BLI02.pdf"',
        ]);

        return $response;
    }

    //function upload BLI02 file
    public function uploadBLI02(Request $request)
    {
        $user = auth()->user();
        $pdfFile = null;

        // Check if user already has an id
        if ($user->li01_id || $user->li03_id || $user->li04_id) {
            // Get the PdfFile record with the same ID as li01_id or li03_id
            $pdfFile = PdfFile::find($user->li01_id ?? $user->li03_id ?? $user->li04_id);

            if ($pdfFile) {
                // Update the binary data in the PdfFile record
                $pdfFile->li02 = file_get_contents($request->file('pdf'));
                $pdfFile->save();
            }
        }

        if (!$pdfFile) {
            // If the user does not have an li01_id or li03_id, create a new PdfFile record
            $request->validate([
                'pdf' => 'required|mimes:pdf|max:2048',
            ]);

            $pdfFile = new PdfFile();
            $pdfFile->li02 = file_get_contents($request->file('pdf'));
            $pdfFile->save();
        }

        // Update the user's li02_id field with the ID of the PdfFile record
        $user->li02_id = $pdfFile->id;
        $user->save();

        return redirect()->back()->with('success', 'PDF file uploaded successfully.');
    }

    //function upload BLI04 file
    public function uploadBLI04(Request $request)
    {
        $user = auth()->user();
        $pdfFile = null;

        // Check if user already has an id
        if ($user->li01_id || $user->li02_id || $user->li03_id) {
            // Get the PdfFile record with the same ID as li01_id or li03_id
            $pdfFile = PdfFile::find($user->li01_id ?? $user->li02_id ?? $user->li03_id);

            if ($pdfFile) {
                // Update the binary data in the PdfFile record
                $pdfFile->li04 = file_get_contents($request->file('pdf'));
                $pdfFile->save();
            }
        }

        if (!$pdfFile) {
            // If the user does not have an li01_id or li03_id, create a new PdfFile record
            $request->validate([
                'pdf' => 'required|mimes:pdf|max:2048',
            ]);

            $pdfFile = new PdfFile();
            $pdfFile->li04 = file_get_contents($request->file('pdf'));
            $pdfFile->save();
        }

        // Update the user's li02_id field with the ID of the PdfFile record
        $user->li04_id = $pdfFile->id;
        $user->save();

        return redirect()->back()->with('success', 'PDF file uploaded successfully.');
    }


    public function updateInputValue(Request $request)
    {
        $inputValue = $request->input('input_value');
        $updatedValue = Coordinator::pluck('name', 'id'); // Your logic for updating the input value based on the first input's value

        return response()->json(['updated_value' => $updatedValue]);
    }
}
