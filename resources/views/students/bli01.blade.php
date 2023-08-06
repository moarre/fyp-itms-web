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
                        <input type="text" name="session" value="{{ Auth::user()->semester->session }}" class="form-control"
                            placeholder="Semester" readonly>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>Program:</strong>
                    <input type="text" name="program" value="{{ Auth::user()->program->code }}" class="form-control"
                        placeholder="Program" readonly>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Full Name:</strong>
                        <input type="text" name="fullname" value="{{ Auth::user()->fullname }}" class="form-control"
                            placeholder="Full Name" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                            placeholder="Email" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Number:</strong>
                        <input type="text" name="student_number" value="{{ Auth::user()->student_number }}"
                            class="form-control" placeholder="Student Number" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>IC:</strong>
                        <input type="text" name="ic" value="{{ Auth::user()->ic }}" class="form-control"
                            placeholder="IC" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Address:</strong>
                        <input type="textarea" class="form-control" name="address" value="{{ Auth::user()->address }}"
                            placeholder="Address" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's Name:</strong>
                        <input type="text" class="form-control" name="nama_penjaga"
                            value="{{ Auth::user()->nama_penjaga }}" placeholder="Parent's Name" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's Phone:</strong>
                        <input type="text" name="phone_penjaga" value="{{ Auth::user()->phone_penjaga }}"
                            class="form-control" placeholder="Parent's Phone" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Parent's address:</strong>
                        <input type="textarea" class="form-control" name="alamat_penjaga"
                            value="{{ Auth::user()->alamat_penjaga }}" placeholder="Parent's address" readonly>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <a class="btn btn-purple" href="{{ route('students.index') }}"> Back</a>
                </div>
            </div>

        </form>
    </div>

@endsection
