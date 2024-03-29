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
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <div class="tabSection">
                    <a class="active" href="{{route('superAdminUsers')}}">
                        Users
                    </a>
                    <a href="{{route('adminsList')}}">
                        Admins
                    </a>
                </div>
                <a href="{{route('addNewUser', ['type'=>'user'])}}">
                    <button class="add_user_btn"><i class="fa-solid fa-user-plus mr-3"></i> Add New User</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-3">

                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && count($users)>0)
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$user['name']}}</th>
                                <td class="">{{$user['email']}}</td>
                                <td>{{$user['admins']['name']}}</td>
                                <td class="d-flex flex-column">
                                    <div style="line-height: 0.8;">{{date('M d, Y', strtotime($user['created_at']))}}</div><small style="color: #17a2b8;">{{date('l', strtotime($user['created_at']))}}</small>
                                </td>
                                <td>{{date('h:i A', strtotime($user['created_at']))}}</td>
                                <td class="d-flex align-items-center">
                                    <a class="tableIcons editIcon" href="{{ route('editUser', ['userId' => $user['id'], 'type' => 'user']) }}"><i class="fa-solid fa-pencil"></i></a>
                                    <a class="tableIcons deleteIcon ml-3" href="javascript:void(0)"><i class="fa-solid fa-trash"></i></a>
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
    <div class="modal fade" id="FilterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Apply</button>
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

        });
    </script>
</body>

</html>
