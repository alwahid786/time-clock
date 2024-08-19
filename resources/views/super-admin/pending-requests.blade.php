<!doctype html>
<html lang="en">

<head>
    <title>All Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('layouts.header')
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
    </style>
</head>

<body>
    @include('super-admin.layouts.sidebar')
    <div class="container-fluid px-0">
        <div class="bg-blue position-relative" style="height: 60px;padding-left: 80px;">
            <h1 class="text-center text-white" style="position: absolute;">Super Admin</h1>
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


    <div class="container-fluid mt-3 mb-5" style="padding-left: 80px;">
        <div class="container-fluid mt-3 mb-5">
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card p-3">
                        <h4 class="px-3 text-center" style="color: #17a2b8;">All Pending Requests</h4>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Date</th>
                                    <th>Total Minutes</th>
                                    <th>Pending Minutes</th>
                                    <th>Memo</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->user_name }}</td>
                                        <td>{{ date('M d, Y', strtotime($request->time)) }}</td>
                                        <td>{{ $request->minutes }}</td>
                                        <td>{{ $request->pending_minutes ?? 'N/A' }}</td>
                                        <td>{{ $request->memo }}</td>
                                        <td>
                                            @if ($request->status == 'pending')
                                                <span class="text-warning">Pending</span>
                                            @elseif($request->status == 'approved')
                                                <span class="text-success">Approved</span>
                                            @elseif($request->status == 'rejected')
                                                <span class="text-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Approve/Reject buttons -->
                                            @if ($request->is_approved == 1)
                                                <a href="{{ route('super-admin.approveRequest', $request->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                <a href="{{ route('super-admin.rejectRequest', $request->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No pending requests</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        

                    </div>
                </div>
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
            new DataTable('#example');
            $("#dt-search-0").attr('placeholder', 'Search here')

        });
    </script>
</body>

</html>
