@extends('coordinator.coordinator_master')
@section('coordinator')
    <div class="container-fluid px-4">
        @if (isset($errors) && count($errors))
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} </li>
                @endforeach
            </ul>
        @endif
        <div class="mt-4 px-4">
            <h1>Upload Document</h1>
            <br>
            <form method="POST" action="{{ route('Cbli04.upload') }}" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="file">BLI04 file:</label>
                    <input type="file" name="file" id="file">
                    @error('file')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit">Upload</button>
                </div>
            </form>
            <br>
            <form method="POST" action="{{ route('lampiran1.upload') }}" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="file">Lampiran 1 file:</label>
                    <input type="file" name="file" id="file">
                    @error('file')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection
