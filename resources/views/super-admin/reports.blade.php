<!doctype html>
<html lang="en">

<head>
    <title>Time Reports</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .search_bar {
            border: 1px solid gray;
            padding: 2px 2px 2px 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
        }

        .search_bar div {
            width: 88%;
            border: none !important;
            background-color: white;
            cursor: pointer;
        }

        .search_bar input:focus,
        .search_bar input:active {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .search_bar button {
            border: none !important;
            background-color: #17a2b8;
            color: white;
            width: 12%;
            border-radius: 5px;
            font-size: 20px;
        }

        .tabSection {
            border: 1px solid gray;
            border-radius: 5px;
            display: flex;
            align-items: center;
            overflow: hidden;
            width: fit-content;
            height: 41px;
        }


        .tabSection a {
            font-size: 16px;
            padding: 1px 10px;
            height: 100%;
            display: flex;
            align-items: center;
            color: gray;
        }

        .tabSection a.active {
            background-color: #17a2b8;
            color: white;
            font-weight: 600;
            padding: 1px 10px;

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
            background-color: white;
            transition: background-color 0.3s, color 0.3s;
        }


        .tableIcons {
            border-radius: 5px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .editIcon {
            border: 1px solid orange;
            background-color: #ffa50021;
            color: orange;
        }

        .deleteIcon {
            border: 1px solid red;
            background-color: #ff00002e;
            color: red;
        }

        .editIcon:hover {
            border: 1px solid orange;
            background-color: #ffa50021;
            color: orange;
        }

        .deleteIcon:hover {
            border: 1px solid red;
            background-color: #ff00002e;
            color: red;
        }

        table tr td,
        table tr th {
            vertical-align: middle !important;
            border: none !important;
        }

        table tr {
            border-bottom: 1px solid lightgray !important;
        }

        .form-control {
            padding: 10px;
        }

        .select2 {
            height: 48px;
            background: #fff;
            color: #000;
            font-size: 16px;
            border-radius: 5px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.1);
            width: 100% !important;
        }

        .select2-selection {
            height: 48px;
            background: #fff;
            color: #000;
            font-size: 16px;
            border-radius: 5px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            width: 100% !important;
        }

        .table-header {
            background-color: #17a2b826;
            border-radius: 5px 10px;
            display: flex;
            justify-content: center;
            padding: 5px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="loader-overlay d-none">
        <img src="{{asset('assets/images/loader.gif')}}" alt="">
    </div>
    @php
    function convertMinutesToTime($minutes) {
    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;

    $time = '';
    if ($hours > 0) {
    $time = "$hours hrs ";
    }

    if ($remainingMinutes > 0) {
    $time .= "$remainingMinutes mins";
    }

    return $time;
    }
    @endphp
    @include('super-admin.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue" style="height: 60px;padding-left: 80px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-white" style="margin-top: -5px;">
                    <span>Reports</span>
                    <h4 style="line-height: 0.8;" class="m-0 text-white">Generate</h4>
                </div>
                <div class="d-flex align-items-center ml-auto mr-3" style="height: 60px;">
                    <button class="add_user_btn" id="generatePDFBtn"><i class="fa-solid fa-file-alt mr-3"></i> Generate PDF</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-5" style="padding-left: 80px;">

        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-3">
                    @if(isset($groupedClocks))
                    @foreach($groupedClocks as $key => $user)

                    <?php
                    $totalHours = 0;
                    $min = 0;
                    foreach ($user as $date) {
                        foreach ($date['clocks'] as $clock) {
                            $min = $min + $clock['minutes'];
                        }
                    }
                    $totalHours = $min + $totalHours;
                    ?>
                    <div>
                        <div class="d-flex align-items-center justify-content-between table-header px-2">
                            <h5 class="m-0"><strong>{{$key}}</strong></h5>
                            <div class="d-flex flex-column align-items-end">
                                <div style="line-height: 1; color: #17a2b8;font-size:18px;">{{convertMinutesToTime($totalHours) == '' ? '0 min' : convertMinutesToTime($totalHours)}}</div><small><strong>{{$startDate}} - {{$endDate}}</strong></small>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                    <th scope="col">Shifts</th>
                                    <th scope="col">Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $key=>$date)
                                <tr>
                                    <td class="d-flex flex-column">
                                        <div style="line-height: 0.8;">{{date('M d, Y', strtotime($key))}}</div><small style="color: #17a2b8;">{{date('l', strtotime($key))}}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            @php
                                            $shifts = 0;
                                            @endphp
                                            @foreach($date['clocks'] as $clock)
                                            @if($clock['type'] == 'clock-in')
                                            @php $shifts++ @endphp
                                            <div>{{date('h:i:s a', strtotime($clock['time']))}}</div>
                                            @endif
                                            @endforeach

                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            @php
                                            $minutes=0;
                                            @endphp
                                            @foreach($date['clocks'] as $clock)
                                            @php
                                            $minutes = $minutes + $clock['minutes'];
                                            @endphp
                                            @if($clock['type'] == 'clock-out')
                                            <div>{{date('h:i:s a', strtotime($clock['time']))}}</div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{$shifts}}</td>
                                    <td><span class="badge badge-success">{{convertMinutesToTime($minutes) == '' ? '0 min' : convertMinutesToTime($minutes)}}</span></td>
                                </tr>
                                @endforeach
                                <!-- <tr>
                                    <td class="d-flex flex-column">
                                        <div style="line-height: 0.8;">Dec 30, 2023</div><small style="color: #17a2b8;">Thursday</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                        </div>
                                    </td>
                                    <td>2</td>
                                    <td><span class="badge badge-success">5 hrs 25 min</span></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @endif
                    <!-- <div>
                        <div class="d-flex align-items-center justify-content-between table-header px-2">
                            <h5 class="m-0"><strong>Don Williams</strong></h5>
                            <div class="d-flex flex-column align-items-end">
                                <div style="line-height: 1; color: #17a2b8;font-size:18px;">123 hrs 43 mins</div><small><strong>12/02/24 - 12/03/24</strong></small>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                    <th scope="col">Shifts</th>
                                    <th scope="col">Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="d-flex flex-column">
                                        <div style="line-height: 0.8;">Dec 29, 2023</div><small style="color: #17a2b8;">Wednesday</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ">
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                            <div>10:25:46 AM</div>
                                        </div>
                                    </td>
                                    <td>3</td>
                                    <td><span class="badge badge-success">5 hrs 25 min</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <form id="pdfForm" method="POST" action="{{ route('generatePdf') }}" target="_blank">
        @csrf
        <input type="hidden" name="reportstartdate" value="{{$startDate}}">
        <input type="hidden" name="reportenddate" value="{{$endDate}}">
    </form>


    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('assets/js/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.tabSection a').click(function() {
                $('.tabSection a').removeClass('active');
                $(this).addClass('active');
            });
            $('input[name="dates"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $(document).ready(function() {
                $('#multiple-names').select2({
                    tags: true
                });
            });
        });
        pdfBtn = document.getElementById('generatePDFBtn');
        pdfBtn.addEventListener('click', function(e) {
            // debugger;
            // $('.loader-overlay').removeClass('d-none');
            const names = JSON.parse(`{!! json_encode($names) !!}`);
            const startDate = `{{$startDate}}`;
            const endDate = `{{$endDate}}`;

            // Add the names to the form
            if (names != null) {
                names.forEach(name => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'reportnames[]';
                    input.value = name;
                    document.getElementById('pdfForm').appendChild(input);
                });
            }

            // Submit the form
            document.getElementById('pdfForm').submit();
        });
    </script>

</body>

</html>
