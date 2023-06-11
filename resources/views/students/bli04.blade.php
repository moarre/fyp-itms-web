@extends('students.student_master')
@section('students')
    <div class="container-fluid px-4">
        <h1 class="mt-4">BLI-04</h1>

        <form method="POST" action="{{ route('bli04.upload') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="pdf">Choose a PDF file:</label>
                <input type="file" name="pdf" id="pdf">
                @error('pdf')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit">Upload</button>
            </div>
        </form>

    </div>
@endsection
