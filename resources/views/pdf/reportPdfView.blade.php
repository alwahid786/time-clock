<!doctype html>
<html lang="en">

<head>
    <title>Time Reports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .table-header {
            background-color: #dcf1f4;
            border-radius: 5px 10px;
            color: black;
            font-weight: bold;
            padding: 5px;
            margin-bottom: 10px;
            display: flex !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-bottom: 1px solid #ddd !;
            border: none;
            padding: 8px;
            text-align: left;
        }

        th {
            /* background-color: #f2f2f2; */
            font-weight: bold;
        }

        td {
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3 mb-5" style="width: 100%;">
        <div class="row">
            <div class="col-12 mt-4">
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
                <div class="card">
                    <div class="table-header" style="display: flex !important; padding:5px 10px">
                        <h2 style="display: flex; justify-content:center;margin:0;">{{ $key }}</h2>
                        <div style="display: flex;justify-content:end; flex-direction:column; align-items:end;color:gray" class="d-flex justify-content-between align-items-center">
                            <div style="color: #17a2b8;font-size:20px;">{{ $totalHours }} mins</div>
                            <div>{{ $startDate }} - {{ $endDate }}</div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Shifts</th>
                                <th>Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user as $dateKey => $date)
                            <tr>
                                <td>{{ date('M d, Y', strtotime($dateKey)) }} <br> <small style="color: #17a2b8;">{{ date('l', strtotime($dateKey)) }}</small></td>
                                <td>
                                    @php
                                    $shifts = 0;
                                    @endphp
                                    @foreach($date['clocks'] as $clock)
                                    @if($clock['type'] == 'clock-in')
                                    @php $shifts++ @endphp
                                    <div style="margin-bottom:10px;">{{ date('h:i:s a', strtotime($clock['time'])) }}</div>
                                    @endif
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                    $minutes=0;
                                    @endphp
                                    @foreach($date['clocks'] as $clock)
                                    @php
                                    $minutes = $minutes + $clock['minutes'];
                                    @endphp
                                    @if($clock['type'] == 'clock-out')
                                    <div style="margin-bottom:10px;">{{ date('h:i:s a', strtotime($clock['time'])) }}</div>
                                    @endif
                                    @endforeach
                                </td>
                                <td>{{ $shifts }}</td>
                                <td>
                                    <div style="color:#28a745; font-weight:600;">{{ $minutes }} mins</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</body>

</html>
