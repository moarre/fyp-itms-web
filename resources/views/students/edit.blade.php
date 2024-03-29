@extends('students.student_master')
@section('students')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Students</h1>
        <ol class="breadcrumb mb-4 px-1">
            <li class="breadcrumb-item active">Personal Information</li>
        </ol>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Fill Information</h2>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.update', Auth::user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <strong>Semester:</strong>
                        <select class="form-control" name="semester_id" id="docNo">
                            <option value="">-- Choose Semester --</option>
                            @foreach ($semesters as $id => $name)
                                <option value="{{ $id }}"
                                    {{ isset($student['semester_id']) && $student['semester_id'] == $id ? ' selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>Program:</strong>
                    <select class="form-control" name="program_id" id="input1">
                        <option value="">-- Choose Program --</option>
                        @foreach ($programs as $id => $code)
                            <option value="{{ $id }}"
                                {{ isset($student['program_id']) && $student['program_id'] == $id ? ' selected' : '' }}>
                                {{ $code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Full Name:</strong>
                        <input type="text" name="fullname" value="{{ Auth::user()->fullname }}"
                            class="form-control uppercase-input" placeholder="Full Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                            placeholder="Email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Number:</strong>
                        <input type="text" name="student_number" value="{{ Auth::user()->student_number }}"
                            class="form-control" placeholder="Student Number">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>IC:</strong>
                        <input type="text" name="ic" value="{{ Auth::user()->ic }}" class="form-control"
                            placeholder="IC">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Address:</strong>
                        <input type="textarea" class="form-control" name="address" value="{{ Auth::user()->address }}"
                            placeholder="Address">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's Name:</strong>
                        <input type="text" class="form-control uppercase-input" name="nama_penjaga"
                            value="{{ Auth::user()->nama_penjaga }}" placeholder="Parent's Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's Phone:</strong>
                        <input type="text" name="phone_penjaga" value="{{ Auth::user()->phone_penjaga }}"
                            class="form-control" placeholder="Parent's Phone">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's address:</strong>
                        <input type="textarea" class="form-control" name="alamat_penjaga"
                            value="{{ Auth::user()->alamat_penjaga }}" placeholder="Parent's address">
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-purple">Submit</button>
                    <a class="btn btn-purple" href="{{ route('students.index') }}"> Back</a>
                </div>
            </div>

        </form>
    </div>

@endsection
