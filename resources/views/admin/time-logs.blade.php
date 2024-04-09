<!doctype html>
<html lang="en">

<head>
    <title>Time Logs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('layouts.header')

    <style>
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
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .add_user_btn:hover {
            background-color: #17a2b8;
            color: white;
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
            border: 1px solid orange;
            background-color: #ffa50021;
            color: orange;
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

        table thead tr th {
            background-color: #17a2b826;
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

        table.dataTable th.dt-type-numeric {
            text-align: center !important;
        }

        .page-item.active .page-link {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }


        .dt-search label {
            display: none !important;
        }

        .dt-length {
            display: none !important;
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
            border: 1px solid #17a2b8;
            background-color: #17a2b826;
            color: #17a2b8 !important;
            cursor: pointer;
        }

        .deleteIcon {
            border: 1px solid orange;
            background-color: #ffa50021;
            color: orange;
        }
    </style>
</head>

<body>
    @include('admin.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue" style="height: 60px;padding-left: 80px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-white" style="margin-top: -5px;">
                    <span>Reports</span>
                    <h4 style="line-height: 0.8;" class="m-0 text-white">Time Logs</h4>
                </div>
                <div class="d-flex align-items-center ml-auto mr-3" style="height: 60px; width:25%;">
                    <div class="search_bar w-100" data-toggle="modal" data-target="#FilterModal">
                        <div>Search By Filters</div>
                        <button class="searchBtn">
                            <i class="fa-solid fa-filter"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-5" style="padding-left: 80px;">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-end">
                <button class="add_user_btn" data-toggle="modal" data-target="#generateReportForm"><i class="fa-solid fa-file-alt mr-3"></i> Generate Report</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-3">

                    <table class="table" id="timeLogs">
                        <thead>
                            <tr>
                                <th scope="col" style="border-top-left-radius: 10px;">User ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Memo</th>
                                <th scope="col" style="border-top-right-radius: 10px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($clocks))
                            @foreach($clocks as $clock)
                            @php
                            $badge = 'badge-success';
                            if($clock['type'] == 'clock-out'){
                            $badge = 'badge-danger';
                            }
                            @endphp
                            <tr>
                                <th>{{$clock['user_id']}}</th>
                                <td>{{$clock['user']['name']}}</td>
                                <td><span class="badge {{$badge}}">{{$clock['type']}}</span></td>

                                <td class="d-flex flex-column">
                                    <div style="line-height: 0.8;">{{ \Carbon\Carbon::parse($clock['time'])->format('M d, Y') }}</div><small style="color: #17a2b8;">{{ \Carbon\Carbon::parse($clock['time'])->format('l') }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($clock['time'])->format('h:i:s A') }}</td>
                                <td>
                                    @if($clock['memo'] != null)
                                    <div id="getMemo" class="d-none">{{$clock['memo']}}</div>
                                    <div style="width: 150px; ">
                                        <span style="line-height: 0.8;display: inline-block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$clock['memo']}}</span>
                                    </div>
                                    <a style="line-height: 1; font-size: 14px;" id="viewMemo" data-toggle="modal" data-target="#checkDetailsModal" href="javascript:void">View memo</a>
                                    @else
                                    <div class="">- -</div>
                                    @endif
                                </td>
                                <td class="">
                                    @if($clock['type'] == 'clock-out')
                                    @php
                                    $clockId = $clock['id'];
                                    @endphp
                                    <a class="tableIcons deleteIcon" href="{{ route('admin.manualEntries', ['clockId' => $clockId])}}"><i class="fa-solid fa-pencil"></i></a>
                                    @else
                                    <div class="">- -</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="checkDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- <div class="user_img text-center">
                        <img src="{{asset('assets/images/programmer.png')}}" alt="">
                        <h5 style="color: #17a2b8;"><b>Mervin Holmes</b></h5>
                    </div>
                    <hr class="m-1 mt-3">
                    <div class="d-flex align-items-center justify-content-between px-3">
                        <h6 class="m-0 text-secondary" style="font-weight: 600;">Type</h6>
                        <h5 class="m-0"><span class="badge badge-danger">Clock Out</span></h5>
                    </div>
                    <hr class="m-1">
                    <div class="d-flex align-items-center justify-content-between px-3">
                        <h6 class="m-0 text-secondary" style="font-weight: 600;">Time</h6>
                        <h5 class="m-0"><b>Wednesday, 12:46:03 PM</b></h5>
                    </div>
                    <hr class="m-1 mb-3"> -->
                    <h6 class="m-0 px-3 mt-3" style="font-weight: 600; color:#17a2b8">Memo:</h6>
                    <p class="px-3" id="showMemo">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid assumenda maiores alias dolor adipisci quod laborum unde error quia vero exercitationem voluptate, minus aliquam eos, ex quas? Eos, praesentium corporis.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="FilterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Select Date Range</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm" action="{{ route('admin.timeLogs') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ request('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="{{ request('startDate') }}">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" value="{{ request('endDate') }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="generateReportForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #17a2b8;">
                    <h5 class="modal-title" id="exampleModalCenterTitle" style="color:white"><i class="fas fa-sliders-h mr-3 "></i>Preferences</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="reportForm" action="{{ route('generateReport') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Select Users</label>
                            <select class="form-control w-100" name="reportnames[]" multiple="multiple" id="multiple-names">
                                <option disabled>Select one or more names</option>
                                @if(isset($users) && count($users) > 0)
                                @foreach($users as $user)
                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="reportemail" placeholder="Enter email">
                        </div> -->
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="reportstartdate">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="reportenddate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        $(document).ready(function() {
            $('.tabSection a').click(function() {
                $('.tabSection a').removeClass('active');
                $(this).addClass('active');
            });

            $(document).ready(function() {
                $('#multiple-names').select2({
                    tags: true
                });
            });
            $(document).ready(function() {
                $("#viewMemo").click(function() {
                    var memo = $("#getMemo").text();
                    $("#showMemo").text(memo);
                })
            });
            new DataTable('#timeLogs');
            $("#dt-search-0").attr('placeholder', 'Search here')
        });
    </script>

</body>

</html>
