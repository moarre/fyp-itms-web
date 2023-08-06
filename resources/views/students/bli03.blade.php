@extends('students.student_master')
@section('students')
    <div class="container-fluid px-4">
        <h1 class="mt-4">BLI-03</h1>
        <br>
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

        <form action="{{ route('bli03.update', Auth::user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Name:</strong>
                        <input type="text" name="companyName" value="{{ Auth::user()->interndata->companyName ?? null }}"
                            class="form-control uppercase-input" placeholder="Company Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Address:</strong>
                        <input type="textarea" class="form-control" name="companyAddress"
                            value="{{ Auth::user()->interndata->companyAddress ?? null }}" placeholder="Company Address">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Email:</strong>
                        <input type="textarea" class="form-control" name="companyEmail"
                            value="{{ Auth::user()->interndata->companyEmail ?? null }}" placeholder="Company Email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Date of Reporting Duty:</strong>
                        <input type="text" name="dateDuty" value="{{ Auth::user()->interndata->dateDuty ?? null }}"
                            class="form-control" placeholder="Date of Reporting Duty">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Period of intern (in date):</strong>
                        <input type="text" name="periodDuty" value="{{ Auth::user()->interndata->periodDuty ?? null }}"
                            class="form-control" placeholder="Period of intern">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Person in Charge (PIC):</strong>
                        <input type="text" name="personinCharge"
                            value="{{ Auth::user()->interndata->personinCharge ?? null }}" class="form-control"
                            placeholder="Person in Charge">
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
