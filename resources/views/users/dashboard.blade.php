<!doctype html>
<html lang="en">

<head>
    <title>User Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
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

        .userIcon i {
            font-size: 30px;
            color: #17a2b8;
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
    </style>
</head>

<body>
    @include('users.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue">
            <h1 class="text-center text-white">Log Time</h1>
        </div>
        <div class="container px-5 my-5">
            <div class="row px-5">
                <div class="col-12 mt-5">
                    <div class="card p-5 position-relative">
                        <div class="userIcon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="checkIcon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="card-content p-3">
                            <h4 class="text-center">Time Clock</h4>
                            <h1 id="currentTime" class="text-center m-0" style="line-height: 0.8; font-weight:700; font-size:50px"></h1>
                            <h4 id="currentTimeAMPM" class="text-center text-secondary"></h4>
                            <div class="memo px-5">
                                <label class="m-0" for="memo" class="text-primary">Memo <span class="" style="font-size: 10px;color:gray">(Optional)</span></label>
                                <br>
                                <textarea class="borders" style="width: 100%;" name="memo" id="memo" rows="5"></textarea>
                            </div>
                            <div class="checks px-5 my-3">
                                <button class="checkinBtn py-1" onclick="checkinFunction()">Clock In</button>
                                <button class="checkoutBtn py-1" onclick="checkoutFunction()">Clock Out</button>
                            </div>
                        </div>
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
    <script>
        function displayCurrentDateTime() {
            const date = new Date();

            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const day = days[date.getDay()];
            const month = months[date.getMonth()];
            const currentDate = date.getDate();
            const year = date.getFullYear();

            let hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;

            const timeString = `${day} - ${month} ${currentDate}, ${year} - ${hours}:${minutes}:${seconds} ${ampm}`;

            // document.getElementById('currentDay').innerText = day;
            // document.getElementById('currentDate').innerText = `${month} ${currentDate}, ${year}`;
            document.getElementById('currentTime').innerText = `${hours}:${minutes}:${seconds}`;
            document.getElementById('currentTimeAMPM').innerText = `${ampm}`;
        }

        displayCurrentDateTime(); // Initial display
        setInterval(displayCurrentDateTime, 1000); // Update every second

        function checkinFunction() {
            Swal.fire({
                title: "Success!",
                text: "Your checkin is applied",
                icon: "success"
            });
        }

        function checkoutFunction() {
            Swal.fire({
                title: "Success!",
                text: "Your checkout is applied",
                icon: "error"
            });
        }
    </script>


</body>

</html>