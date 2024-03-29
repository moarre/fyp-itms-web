<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="{{ asset('panel/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" name="name"
                                                placeholder="Enter your username" />
                                            <label for="name">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email"
                                                placeholder="name@example.com" />
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputPassword" type="password"
                                                        name="password" placeholder="Create a password" />
                                                    <label for="password">Password</label>
                                                </div>
                                                <div class="progress">
                                                    <div id="password-strength-bar" class="progress-bar"
                                                        role="progressbar" style="width: 0%;"></div>
                                                </div>
                                                <div id="password-strength-text" class="text-center mt-2"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation"
                                                        placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                    <div id="passwordMatchError" class="text-danger mt-1" style="display: none;">
                                                        Passwords do not match.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-primary" style="background-color: blue"
                                                type="submit">Create Account</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="{{ route('login') }}">Have an account? Go to
                                            login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('panel/js/scripts.js') }}"></script>
    <script>
        // Function to update the password strength indicator and text
        function updatePasswordStrengthIndicator(password) {
            const bar = document.getElementById("password-strength-bar");
            const text = document.getElementById("password-strength-text");
            const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
            const moderateRegex = new RegExp("^(?=.*[a-zA-Z])(?=.*[0-9])(?=.{6,})");

            if (strongRegex.test(password)) {
                bar.style.width = "100%";
                bar.style.backgroundColor = "green";
                text.innerText = "Strong";
                text.style.color = "green";
            } else if (moderateRegex.test(password)) {
                bar.style.width = "60%";
                bar.style.backgroundColor = "orange";
                text.innerText = "Moderate";
                text.style.color = "orange";
            } else {
                bar.style.width = "30%";
                bar.style.backgroundColor = "red";
                text.innerText = "Weak";
                text.style.color = "red";
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById("inputPassword").value;
            const confirmPassword = document.getElementById("inputPasswordConfirm").value;

            if (password !== confirmPassword) {
                const passwordMatchError = document.getElementById("passwordMatchError");
                passwordMatchError.style.display = "block";
                return false;
            }

            return true;
        }

        // Add event listener to the form submit event
        const form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            if (!checkPasswordMatch()) {
                event.preventDefault(); // Prevent form submission if passwords don't match
            }
        });

        // Add event listener to the password input field
        const passwordInput = document.getElementById("inputPassword");
        passwordInput.addEventListener("input", function() {
            const password = this.value;
            updatePasswordStrengthIndicator(password);
        });
    </script>
</body>

</html>
