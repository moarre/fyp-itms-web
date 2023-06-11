@extends('semesters.semester_master')
@section('semesters')
<div class="container-fluid px-4">
    <h1 class="mt-4">Semesters</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Show Semesters</li>
    </ol>
    <div class="row px-2 mt-4">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Session:</strong>
                    {{ $semester->session }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Semester:</strong>
                    {{ $semester->numSemester }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                    <strong>Created On:</strong>
                    {{ $semester->created_at }}
                </div>
            </div>
            <div class="pull-right mt-4">
                    <a class="btn btn-primary" href="{{ route('semesters.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
