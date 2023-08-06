@extends('coordinator.coordinator_master')
@section('coordinator')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Coordinator Profile</h1>
        <br><br>

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

        <form action="{{ route('coordinator.coordupdate', Auth::guard('coordinator')->user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Full Name:</strong>
                        <input type="text" name="fullname" value="{{ Auth::guard('coordinator')->user()->fullname }}"
                            class="form-control uppercase-input" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="name" value="{{ Auth::guard('coordinator')->user()->name }}"
                            class="form-control" placeholder="Userame">
                    </div>
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="email" value="{{ Auth::guard('coordinator')->user()->email }}"
                            class="form-control" placeholder="Email" readonly>
                    </div>
                    <div class="form-group">
                        <strong>Position:</strong>
                        <input type="text" name="position" value="{{ Auth::guard('coordinator')->user()->position }}"
                            class="form-control" placeholder="Position" readonly>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-purple">Submit</button>
                    <a class="btn btn-purple" href="{{ route('coordinator.dashboard') }}"> Back</a>
                </div>
            </div>

        </form>
    </div>

@endsection
