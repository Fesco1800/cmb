<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginHistory;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
{
    if (auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning', 'Unauthorized action.');
        }
    $fromDate = $request->input('from');
    $toDate = $request->input('to');

    $selectedDate = $request->input('selectedDate');

    $activity_logs_query = LoginHistory::query();

    if ($selectedDate) {
        $activity_logs_query->whereDate('created_at', $selectedDate);
    }

    if ($fromDate && $toDate) {
        $activity_logs_query->whereBetween('created_at', [$fromDate, $toDate]);
    }

    $activity_logs = $activity_logs_query->orderBy('created_at', 'desc')->get();
    $message = "No activity logs found.";

    return view('admin.activity-logs.index', compact('activity_logs', 'message'));
}

}