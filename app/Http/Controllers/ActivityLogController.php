<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::paginate('100');
        return view('modules.system_logs.index', compact('logs'));
    }
}
