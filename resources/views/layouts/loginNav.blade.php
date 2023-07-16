<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Link FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css">

    <style>
        .card-body {
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>

<body>
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link @if (\Request::is('login')) active @endif"
                        href="{{ route('login') }}">Student</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link @if (\Request::is('lecturer/login')) active @endif"
                        href="{{ route('lecturer_login_from') }}">Lecturer</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link @if (\Request::is('coordinator/login')) active @endif"
                        href="{{ route('coordinator_login_from') }}">Coordinator</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link @if (\Request::is('admin/login')) active @endif"
                        href="{{ route('login_from') }}">Admin</a>
                </li> --}}
            </ul>
        </div>
        <div class="card-body bg-image"
            style="
        background-image: url({{ asset('img/1.jpg') }});
        height: 100vh;
      ">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
