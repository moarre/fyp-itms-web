@extends('programs.program_master')
@section('programs')
<div class="container-fluid px-4">
    <h1 class="mt-4">Programs</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Edit Programs</li>
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

        <form action="{{ route('programs.update',$program->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <input type="hidden" name="id" value="{{ $program->id }}"> <br/>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Code:</strong>
                        <input type="text" name="code" value="{{ $program->code }}" class="form-control" placeholder="Code">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Program Name:</strong>
                        <input type="type" class="form-control" name="name" value="{{ $program->name }}" placeholder="Program Name"></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <strong>Coordinator:</strong>
                        <select class="form-control" name="coordinator_id">
                            <option value="">-- Choose Coordinator --</option>
                            @foreach ($coordinators as $id => $name)
                                <option value="{{ $id }}"
                                    {{ isset($program['coordinator_id']) && $program['coordinator_id'] == $id ? ' selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-primary" href="{{ route('programs.index') }}"> Back</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
