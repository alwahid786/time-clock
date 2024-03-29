<!doctype html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <h1 class="text-center"><i class="fa-solid fa-key" style="color: #17a2b8"></i></h1>
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Reset Password</h3>
                            </div>
                        </div>
                        <form action="#" id="resetPasswordForm" class="reset-pass-form">
                            @csrf
                            <div class="form-group">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa-solid fa-lock"></span></div>
                                <input type="password" class="form-control rounded-left" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa-solid fa-lock"></span></div>
                                <input type="password" class="form-control rounded-left" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <div class="w-100 d-flex justify-content-end">
                                    <button id="submitButton" type="button" class="btn btn-primary rounded">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetForm = document.getElementById('resetPasswordForm');
            const submitButton = document.getElementById('submitButton');

            submitButton.addEventListener('click', function() {
                const password = resetForm.querySelector('input[name="password"]').value;
                const cpassword = resetForm.querySelector('input[name="password_confirmation"]').value;

                if (password == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Error',
                        text: 'Password is required',
                    });
                    return;
                } else if (cpassword == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Confirmation Error',
                        text: 'Password Confirmation is required',
                    });
                    return;
                } else if (password != cpassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Confirmation Error',
                        text: 'Password Confirmation does not match Password',
                    });
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: `{{url('/update-password')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        password: password,
                        password_confirmation: cpassword,
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                            window.location.href = `{{route('loginView')}}`
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            });

            function validateEmail(email) {
                // Regular expression for email validation
                const re = /\S+@\S+\.\S+/;
                return re.test(email);
            }
        });
    </script>
</body>

</html>
