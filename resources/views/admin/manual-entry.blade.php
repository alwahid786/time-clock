<!doctype html>
<html lang="en">

<head>
    <title>Add Manual Entry</title>
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

        /* Image Upload CSS  */
        .containerr {
            max-width: 960px;
            margin: 30px auto;
            padding: 20px;
        }



        .avatar-upload {
            position: relative;
            max-width: 205px;
            /* margin: 50px auto; */
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        /* Hide the default file input button */
        .avatar-upload .avatar-edit input {
            display: none;
        }

        /* Style the custom button */
        .avatar-upload .avatar-edit label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all .2s ease-in-out;
            line-height: 32px;
            /* Center the icon vertically */
            text-align: center;
        }

        /* Style the icon inside the custom button */
        .avatar-upload .avatar-edit label:after {
            content: "\f040";
            /* FontAwesome upload icon */
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .avatar-upload .avatar-edit+label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all .2s ease-in-out;
        }

        .avatar-upload .avatar-edit+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-upload .avatar-edit+label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }

        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .memoText:focus,
        .memoText:active{
            box-shadow: none !important;
            outline: none !important;
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
            <h1 class="text-center text-white">Add Manual Entry </h1>
        </div>
        <div class="container my-5">
            <div class="card p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="px-3 text-center" style="color: #17a2b8;">Enter Details</h4>
                        </div>
                        <form action="{{route('admin.updateClock')}}" id="addEntryForm" method="POST">
                            @csrf
                            <div class="mt-3 d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-50">
                                    <label class="m-0" for="email">Name</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                        </div>
                                        <input readonly class="form-control" type="text" id="email" value="{{$clock['user']['name']}}" >
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="m-0" for="email">Date</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar"></i></span>
                                        </div>
                                        <input readonly class="form-control" type="text" id="email" value="{{date('M d, Y', strtotime($clock['time']))}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-50">
                                    <label class="m-0" for="password">Clock Out</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-clock"></i></span>
                                        </div>
                                        <input readonly class="form-control" type="text" value="{{date('h:i a', strtotime($clock['time']))}}" id="password" >
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="m-0" for="password_confirmation">Total Minutes</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-clock"></i></span>
                                        </div>
                                        <input class="form-control" type="text" value="{{$clock['minutes']}}" id="password" name="minutes">
                                        <input class="form-control" type="hidden" value="{{$clock['id']}}" id="password" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-lg-flex align-items-center justify-content-between px-3" style="gap: 10px;">
                                <div class="w-100">
                                    <label class="m-0" for="memo" class="text-primary">
                                        Memo
                                        <!-- <span class="" style="font-size: 10px;color:gray">(Optional)</span> -->
                                    </label>
                                    <br>
                                    <textarea class="px-3 py-2 memoText" style="color:gray;width: 100%; border:1px solid lightgray; border-radius:5px;" name="memo" id="memo" rows="5">{{$clock['memo']}}</textarea>

                                </div>
                            </div>

                            <div class="px-3 mt-5 d-flex align-items-center justify-content-end" style="gap: 5px;">
                                <a href="{{route('admin.timeLogs')}}">
                                    <button type="button" class="cancel_user_btn"><i class="fa-solid fa-xmark mr-3"></i> Cancel</button>
                                </a>
                                <button type="submit" id="submitButton" class="save_user_btn"><i class="fa-solid fa-hourglass-start mr-3 "></i> Save</button>
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
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{session('error')}}",
        });
    </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('file').addEventListener('change', function() {
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
                const user_type = loginForm.querySelector('select[name="user_type"]').value;

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
                $('.loader-overlay').removeClass('d-none');

                // var data = {
                //     first_name: first_name,
                //     last_name: last_name,
                //     email: email,
                //     phone: phone,
                //     password: password,
                //     password_confirmation: password_confirmation,
                //     user_type: user_type,
                // }
                // if (user_type === "admin") {
                //     data.img = user_type;
                // }
                var data = new FormData();
                data.append('first_name', first_name);
                data.append('last_name', last_name);
                data.append('email', email);
                data.append('phone', phone);
                data.append('password', password);
                data.append('password_confirmation', password_confirmation);
                data.append('user_type', user_type);
                if (user_type === "admin") {
                    data.append('img', $('#imageUpload')[0].files[0]);
                }
                // Send AJAX request
                $.ajax({
                    url: `{{url('/add-user')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.loader-overlay').addClass('d-none');
                        // Handle successful login
                        // Redirect or show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Successfully registered ' + user_type + '! An email has been sent with credentials to ' + email,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `{{route('superAdminUsers')}}`
                            }
                        });
                    },
                    error: function(xhr) {
                        $('.loader-overlay').addClass('d-none');
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
    </script>

</body>

</html>
