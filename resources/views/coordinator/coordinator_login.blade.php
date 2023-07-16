@extends('layouts.loginNav')
@section('content')

<div class="mt-5">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h3 class="fs-2">Sistem LI</h3>
                        <h6 class="mb-5">Coordinator</h6>

                        @if (Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong> {{ session::get('error') }} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('coordinator.login') }}">
                            @csrf

                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email"
                                    class="form-control form-control" placeholder="Email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password"
                                    class="form-control form-control" placeholder="Password" />
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="remember_me" />
                                <label class="form-check-label ms-2" for="remember_me"> Remember password </label>
                            </div>

                            <!-- Login -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" style="background-color: blue"
                                    type="submit">LOGIN</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        {{-- <div class="d-grid gap-2">
                            <button class="btn btn-block btn-primary" style="background-color: #dd4b39;"
                                type="submit"><i class="fab fa-google me-2"></i> SIGN IN WITH GOOGLE</button>
                        </div> --}}

                        <div class="flex items-center justify-center mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <a href="{{ route('coordinator.register') }}">Register</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
