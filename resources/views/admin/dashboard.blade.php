<!doctype html>
<html lang="en">

<head>
    <title>Super Admin Dashboard</title>
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
            height: 60px;
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
    </style>
</head>

<body>
    @include('admin.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue d-flex justify-content-between align-items-center pr-3" style="padding-left:100px;">
            <h1 class="text-center text-white">Admin Dashboard</h1>
            <?php $img = env('APP_URL') . "/public/" . auth()->user()->profile_img; ?>
            <img style="width:40px; height:40px; border-radius:50%;border:1px solid white;" src="{{$img}}" alt="">
        </div>
        <div class="container-fluid my-5" style="padding-left: 80px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="card widgets px-3 py-2">
                        <h4>Total Users</h4>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <i class="fa-solid fa-user" style="color: #17a2b8;font-size:30px"></i>
                            <h1 class="m-0" style="font-weight: 700;">{{$users}}</h1>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h3 style="color: #17a2b8;">Recent Check Logs</h3>
                            <a href="{{route('admin.timeLogs')}}">View all</a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
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
                                    <td>{{$clock['user']['name']}}</td>
                                    <td><span class="badge {{$badge}}">{{$clock['type']}}</span></td>

                                    <td class="d-flex flex-column">
                                        <div style="line-height: 0.8;">{{ \Carbon\Carbon::parse($clock['time'])->format('M d, Y') }}</div><small style="color: #17a2b8;">{{ \Carbon\Carbon::parse($clock['time'])->format('l') }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($clock['time'])->format('h:i:s A') }}</td>
                                    <td>
                                        @if($clock['memo'] != null)
                                        <div class="d-none getMemo">{{$clock['memo']}}</div>
                                        <div style="width: 150px; ">
                                            <span style="line-height: 0.8;display: inline-block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$clock['memo']}}</span>
                                        </div>
                                        <a style="line-height: 1; font-size: 14px;" class="viewMemo" data-toggle="modal" data-target="#checkDetailsModal" href="javascript:void">View memo</a>
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
                    <form id="filterForm" action="{{ route('timeLogs') }}" method="POST">
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

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".viewMemo").click(function() {
                var memo = $(this).parent().find(".getMemo").text();
                $("#showMemo").text(memo);
            })
        });
    </script>

</body>

</html>
