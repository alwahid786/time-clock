<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clock;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use PDF;

class PDFController extends Controller
{
    public function generatePdf(Request $request)
    {
        $query = Clock::query();
        $startDate = date('m/d/Y', strtotime($request->reportstartdate));
        $endDate = date('m/d/Y', strtotime($request->reportenddate));
        $startDateq = date('Y-m-d', strtotime($request->reportstartdate));
        $endDateq = date('Y-m-d', strtotime($request->reportenddate));
        if ($request->has('reportnames') && $request->reportnames != null) {
            $query->wherein('user_id', $request->reportnames);
        }

        if ($request->has('reportstartdate') && $request->reportstartdate != null) {
            $query->whereDate('created_at', '>=', $startDateq);
        }

        if ($request->has('reportenddate') && $request->reportenddate != null) {
            $query->whereDate('created_at', '<=', $endDateq);
        }
        if (auth()->user()->user_type == 'admin') {
            $userIds = User::where('admin_id', auth()->user()->id)->pluck('id')->toArray();
            $clocks = $query->with('user')->orderBy('created_at', 'DESC')->wherein('user_id', $userIds)->get();
        } else {
            $clocks = $query->with('user')->orderBy('created_at', 'DESC')->get();
        }
        // Group the clocks by user name and date
        $groupedClocks = [];
        foreach ($clocks as $clock) {
            $userName = $clock->user->name;
            $date = $clock->created_at->toDateString();
            if (!isset($groupedClocks[$userName])) {
                $groupedClocks[$userName] = [];
            }
            if (!isset($groupedClocks[$userName][$date])) {
                $groupedClocks[$userName][$date] = [
                    'clocks' => [],
                    'total_hours' => 0,
                ];
            }
            $groupedClocks[$userName][$date]['clocks'][] = $clock;
        }
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'groupedClocks' => $groupedClocks
        ];
        $name = $startDate . '-' . $endDate . ' Clock Reports.pdf';
        // return view('pdf.reportPdfView', compact('startDate', 'endDate', 'groupedClocks'));
        $pdf = PDF::loadView('pdf.reportPdfView', $data);
        return $pdf->download($name);
    }
}
