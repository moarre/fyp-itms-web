@extends('students.student_master')
@section('students')
    <div class="container-fluid px-4">
        @if (isset($errors) && count($errors))
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="mt-4 px-4">
            <h1>BLI-04</h1>
            <br>
            <form method="POST" action="{{ route('bli04.upload') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group" x-data="{ fileName: '' }">
                    <div class="input-group">
                        <span class="input-group-text px-3 text-muted"><i class="fas fa-file fa-lg"></i></span>
                        <input type="file" x-ref="file1" @change="fileName = $refs.file1.files[0].name" name="pdf"
                            class="d-none">
                        <input type="text" class="form-control form-control-lg" placeholder="BLI04" x-model="fileName"
                            readonly>
                        <div class="input-group-append ms-2">
                            <button class="btn btn-purple px-4 mt-1" type="button" x-on:click.prevent="$refs.file1.click()"
                                style="height: 80%;">
                                Browse
                            </button>
                            <button type="submit" class="btn btn-purple mt-1" style="height: 80%;">
                                Upload
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    @error('file')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>
    </div>
@endsection
