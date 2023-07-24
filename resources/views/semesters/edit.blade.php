@extends('semesters.semester_master')
@section('semesters')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Semesters</h1>
        <ol class="breadcrumb mb-4 px-1">
            <li class="breadcrumb-item active">Edit Semesters</li>
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

            <form action="{{ route('semesters.update', $semester->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <input type="hidden" name="id" value="{{ $semester->id }}"> <br />

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Session:</strong>
                            <input type="text" name="session" value="{{ $semester->session }}" class="form-control"
                                placeholder="Session">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Semester:</strong>
                            <input type="type" class="form-control" name="numSemester"
                                value="{{ $semester->numSemester }}" placeholder="Semester"></input>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Year:</strong>
                            <input type="text" name="yearSemester" value="{{ $semester->yearSemester }}"
                                class="form-control" placeholder="Year">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <strong>Coordinator:</strong>
                            <select class="form-control" name="coordinator_id">
                                <option value="">-- Choose Coordinator --</option>
                                @foreach ($coordinators as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ isset($semester['coordinator_id']) && $semester['coordinator_id'] == $id ? ' selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                        <button type="submit" class="btn btn-purple">Submit</button>
                        <a class="btn btn-purple" href="{{ route('semesters.index') }}"> Back</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
