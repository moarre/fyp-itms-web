@extends('students.student_master')
@section('students')
<div class="container-fluid px-4">
    <h1 class="mt-4">Students</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Show Students</li>
    </ol>
    <div class="row px-2">
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

        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Username">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" class="form-control" name="email"
                            placeholder="Email">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input type="text" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Full Name:</strong>
                        <input type="text" class="form-control" name="fullname"
                            placeholder="Full Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>IC:</strong>
                        <input type="text" name="ic" class="form-control" placeholder="IC">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Address:</strong>
                        <input type="text" class="form-control" name="address"
                            placeholder="Address">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Parent's name:</strong>
                        <input type="text" name="nama_penjaga" class="form-control" placeholder="Parent's name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Parent's address:</strong>
                        <input type="text" class="form-control" name="alamat_penjaga"
                            placeholder="Parent's address">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Parent's phone:</strong>
                        <input type="text" name="phone_penjaga" class="form-control" placeholder="Parent's phone">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Program:</strong>
                        <input type="text" class="form-control" name="numSemester"
                            placeholder="Semester">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Semester:</strong>
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12">
                    <div class="form-group">
                        <strong>Session:</strong>
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>

                    <a class="btn btn-primary" href="{{ route('students.index') }}"> Back</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
