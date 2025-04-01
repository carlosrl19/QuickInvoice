<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemLogsRequest;
use App\Http\Requests\UpdateSystemLogsRequest;
use App\Models\SystemLogs;

class SystemLogsController extends Controller
{
    public function index()
    {
        $logs = SystemLogs::get();
        return view('modules.system_logs.index', compact('logs'));
    }
}
