<!doctype html>
<html lang="en">

<head>
    <title>Add New User</title>
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
            border-radius: 10px;
        }

        .widgets:hover {
            transform: scale(1.02);
            transition: transform 0.5s ease;
            cursor: pointer;
        }

        .closeModalBtn {
            position: absolute;
            right: 0;
            cursor: pointer;
        }

        .container {
            max-width: 800px;
        }

        .form-control {
            height: 40px;
            padding: 3px 5px;
            font-size: 18px;
            color: gray;
            width: 100%;
        }

        .save_user_btn {
            border-radius: 5px;
            display: flex;
            align-items: center;
            height: 41px;
            border: 1px solid #17a2b8;
            color: #17a2b8;
            font-size: 16px;
            padding: 10px;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .save_user_btn:hover {
            background-color: #17a2b8;
            color: white;
        }

        .cancel_user_btn {
            border-radius: 5px;
            display: flex;
            align-items: center;
            height: 41px;
            border: 1px solid #e22727;
            color: #e22727;
            font-size: 16px;
            padding: 10px;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .cancel_user_btn:hover {
            background-color: #e22727;
            color: white;
        }

        .add_user_btn {
            border-radius: 5px;
            display: flex;
            align-items: center;
            height: 41px;
            border: 1px solid #17a2b8;
            color: #17a2b8;
            font-size: 16px;
            padding: 10px;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .add_user_btn:hover {
            background-color: #17a2b8;
            color: white;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
        }
    </style>
</head>

<body>
    <div class="loader-overlay d-none">
        <img src="{{asset('assets/images/loader.gif')}}" alt="">
    </div>
    @include('admin.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue" style="height: 60px;">
            <h1 class="text-center text-white">Add New <span style="text-transform: capitalize;">{{ request()->input('type') }}</span></h1>
        </div>
        <div class="container my-5">
            <div class="card p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="px-3 text-center" style="color: #17a2b8;">Enter Details</h4>
                            <form id="importForm" action="{{ route('import-users') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="file" class="add_user_btn"><i class="fa-solid fa-file-import mr-3"></i> Import From Excel</label>
                                <input type="file" id="file" name="file" style="display:none;">
                                <button type="submit" id="submitBtn" style="display:none;">Import Users</button>
                            </form>

                        </div>
                        <form action="#" id="addUserForm">
                            @csrf
                            <h4 class="px-3 text-center" style="color: #17a2b8;">Enter Details</h4>
                            <div class="d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-50">
                                    <label class="m-0" for="first_name">First Name</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-file-signature"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="first_name" name="first_name">
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="m-0" for="last_name">Last Name</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-file-signature"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="last_name" name="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-50">
                                    <label class="m-0" for="email">Email</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="email" name="email">
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="m-0" for="phone">Phone Number</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="phone" name="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-50">
                                    <label class="m-0" for="password">Password</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="password" name="password">
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="m-0" for="password_confirmation">Re-type Password</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="password_confirmation" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 mt-5 d-flex align-items-center justify-content-end" style="gap: 5px;">
                                <a href="<?php echo request()->input('type') == 'user' ? route('superAdminUsers') : route('adminsList') ?>">
                                    <button type="button" class="cancel_user_btn"><i class="fa-solid fa-user-minus mr-3"></i> Cancel</button>
                                </a>
                                <button type="button" id="submitButton" class="save_user_btn"><i class="fa-solid fa-user-plus mr-3 "></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "Users Imported Successfully!",
        });
    </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('file').addEventListener('change', function() {
                $('.loader-overlay').removeClass('d-none');
                setTimeout(function() {
                    document.getElementById('importForm').submit();
                }, 100); // Add a small delay (e.g., 100 milliseconds) to ensure the file is fully selected
            });
            const loginForm = document.getElementById('addUserForm');
            const submitButton = document.getElementById('submitButton');

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();
                const email = loginForm.querySelector('input[name="email"]').value;
                const first_name = loginForm.querySelector('input[name="first_name"]').value;
                const last_name = loginForm.querySelector('input[name="last_name"]').value;
                const phone = loginForm.querySelector('input[name="phone"]').value;
                const password = loginForm.querySelector('input[name="password"]').value;
                const password_confirmation = loginForm.querySelector('input[name="password_confirmation"]').value;
                const user_type = "user";

                if (first_name == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'First Name Error',
                        text: 'First Name is required',
                    });
                    return;
                } else if (last_name == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Last Name Error',
                        text: 'Last Name is required',
                    });
                    return;
                } else if (email == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Error',
                        text: 'Email is required',
                    });
                    return;
                } else if (phone == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Phone Error',
                        text: 'Phone is required',
                    });
                    return;
                } else if (password == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Error',
                        text: 'Password is required',
                    });
                    return;
                } else if (password_confirmation == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Confirmation Error',
                        text: 'Password Confirmation is required',
                    });
                    return;
                } else if (password != password_confirmation) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Confirmation Error',
                        text: 'Password Confirmation does not match Password',
                    });
                    return;
                }


                // Send AJAX request
                $.ajax({
                    url: `{{url('/add-user')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        phone: phone,
                        password: password,
                        password_confirmation: password_confirmation,
                        user_type: user_type,
                    },
                    success: function(response) {
                        // Handle successful login
                        // Redirect or show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Successfully registered ' + user_type + '! An email has been sent with credentials to ' + email,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `{{route('admin.users')}}`
                            }
                        });
                    },
                    error: function(xhr) {
                        // Handle login errors
                        let errorMessage = 'Something is wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
