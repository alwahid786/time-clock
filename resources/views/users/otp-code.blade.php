<!doctype html>
<html lang="en">

<head>
    <title>OTP Verification</title>
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
                        <h1 class="text-center"><i class="fa-solid fa-asterisk px-1" style="color: #17a2b8"></i><i class="fa-solid fa-asterisk px-1" style="color: #17a2b8"></i><i class="fa-solid fa-asterisk px-1" style="color: #17a2b8"></i></h1>
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Enter OTP Code</h3>
                            </div>
                        </div>
                        <form action="#" id="otpForm" class="otp-form">
                            @csrf
                            <div class="form-group d-flex" style="gap: 2px;">
                                <input type="text" class="form-control rounded-left otp-input" name="otp1" maxlength="1" required autofocus>
                                <input type="text" class="form-control rounded-left otp-input" name="otp2" maxlength="1" required>
                                <input type="text" class="form-control rounded-left otp-input" name="otp3" maxlength="1" required>
                                <input type="text" class="form-control rounded-left otp-input" name="otp4" maxlength="1" required>
                            </div>

                            <div class="form-group d-flex align-items-center">
                                <div class="w-100 d-flex justify-content-end">
                                    <button type="button" id="submitButton" class="btn btn-primary rounded">Verify</button>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <div class="w-100 text-center">
                                    <p><a href="{{url('forget-password')}}">Change Email</a></p>
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
            const otpForm = document.getElementById('forgetPasswordForm');
            const submitButton = document.getElementById('submitButton');

            submitButton.addEventListener('click', function() {
                const otpInputs = document.querySelectorAll('.otp-input');
                let otpValue = '';

                otpInputs.forEach(function(input) {
                    otpValue += input.value;
                });

                if (otpValue.length !== 4) {
                    Swal.fire({
                        icon: 'error',
                        title: 'OTP Error',
                        text: 'Please fill in all 4 OTP fields',
                    });
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: `{{url('/otp-verification')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        otp: otpValue,
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                            window.location.href = `{{route('resetPasswordView')}}`
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
    <script>
        // Automatically move to next input when typing OTP
        document.querySelectorAll('.otp-input').forEach(function(input, index) {
            input.addEventListener('input', function() {
                if (input.value.length >= 1) {
                    if (index < 3) {
                        document.querySelectorAll('.otp-input')[index + 1].focus();
                    } else {
                        document.querySelectorAll('.otp-input')[index].blur();
                    }
                }
            });

            // Move to previous input on backspace if current input is empty
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value.length === 0) {
                    if (index > 0) {
                        document.querySelectorAll('.otp-input')[index - 1].focus();
                    }
                }
            });
        });
    </script>

</body>

</html>
