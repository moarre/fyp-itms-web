@extends('programs.program_master')
@section('programs')
<div class="container-fluid px-4">
    <h1 class="mt-4">Programs</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Show Programs</li>
    </ol>
    <div class="row px-2 mt-4">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Code:</strong>
                    {{ $program->code }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $program->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                    <strong>Registered On:</strong>
                    {{ $program->created_at }}
                </div>
            </div>
            <div class="pull-right mt-4">
                    <a class="btn btn-primary" href="{{ route('programs.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
