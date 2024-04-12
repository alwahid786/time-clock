<!doctype html>
<html lang="en">

<head>
    <title>Change Password</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        .loader-overlay {
            position: fixed;
            z-index: 999;
            width: 100vw;
            height: 100vh;
            background-color: #ffffffc9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            font-family: "Roboto", sans-serif;
        }

        .roboto-thin {
            font-weight: 100;
            font-style: normal;
        }

        .bg-blue {
            background-color: #17a2b8;
        }

        .card {
            box-shadow: rgba(136, 165, 191, 0.48) 6px 2px 16px 0px, rgba(255, 255, 255, 0.8) -6px -2px 16px 0px;
        }


        .container {
            max-width: 800px;
        }

        .userIcon {
            width: 80px;
            height: 80px;
            position: absolute;
            top: -40px;
            /* Half of the icon height */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: white;
            /* Adjust as needed */
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            z-index: 1;
        }

        .userIcon img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
        }

        .checkIcon {
            width: 80px;
            height: 80px;
            position: absolute;
            top: 50%;
            left: 0px;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: white;
            /* Adjust as needed */
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            z-index: 1;
        }

        .checkIcon i {
            font-size: 30px;
            color: #7ece5b;
        }

        .borders {
            border: 1px solid gray;
        }

        textarea {
            padding: 5px;
        }

        textarea:active,
        textarea:focus {
            border: 1px solid gray !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .checks {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .checks button {
            flex: 1;
        }

        .checkinBtn {
            background-color: #44a41a;
            color: white;
            border-radius: 5px;
            border: none;
            font-size: 20px;
        }

        .checkoutBtn {
            background-color: #cc3232;
            color: white;
            border-radius: 5px;
            border: none;
            font-size: 20px;
        }

        .disabledCheckin {
            background-color: #44a41a75 !important;
            pointer-events: none !important;
        }

        .disabledCheckout {
            background-color: #cc323275 !important;
            pointer-events: none !important;
        }
    </style>
</head>

<body>
    <div class="loader-overlay d-none">
        <img src="{{asset('assets/images/loader.gif')}}" alt="">
    </div>
    @include('users.layouts.sidebar')
    <div class="container-fluid">
        <div class="bg-blue">
            <h1 class="text-center text-white">Change Password</h1>
        </div>
        <div class="row justify-content-center pt-3">
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
