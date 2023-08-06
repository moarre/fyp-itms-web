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

            <form action="{{ route('programs.update', $program->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <input type="hidden" name="id" value="{{ $program->id }}"> <br />

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Code:</strong>
                            <select name="code" class="form-control" onchange="updateProgramName(this)">
                                <option value="{{ $program->code }}">{{ $program->code }}</option>
                                <option value="CS251">CS251</option>
                                <option value="CS255">CS255</option>
                                <option value="CS253">CS253</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Program Name:</strong>
                            <input type="text" class="form-control" id="program_name" name="name"
                                value="{{ $program->name }}" placeholder="Program Name" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <strong>Coordinator:</strong>
                            <select class="form-control" name="coordinator_id">
                                <option value="">Choose Coordinator</option>
                                @foreach ($coordinators as $id => $fullname)
                                    <option value="{{ $id }}"
                                        {{ isset($program['coordinator_id']) && $program['coordinator_id'] == $id ? ' selected' : '' }}>
                                        {{ $fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                        <button type="submit" class="btn btn-purple">Submit</button>
                        <a class="btn btn-purple" href="{{ route('programs.index') }}"> Back</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        function updateProgramName(selectElement) {
            const programNameInput = document.getElementById('program_name');
            const selectedValue = selectElement.value;

            if (selectedValue === 'CS251') {
                programNameInput.value = 'NETCENTRIC COMPUTING';
            } else if (selectedValue === 'CS255') {
                programNameInput.value = 'COMPUTER NETWORK';
            } else if (selectedValue === 'CS253') {
                programNameInput.value = 'MULTIMEDIA COMPUTING';
            } else {
                programNameInput.value = '';
            }
        }

        // Populate the Program Name input field when the page loads
        window.onload = function() {
            const codeSelectElement = document.querySelector('select[name="code"]');
            updateProgramName(codeSelectElement);
        };
    </script>
@endsection
