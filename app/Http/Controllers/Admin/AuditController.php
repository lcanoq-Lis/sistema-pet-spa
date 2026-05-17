<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;

class AuditController extends Controller
{
    public function index()
    {
        $logs = AuthLog::with('usuario')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.auditoria.index', compact('logs'));
    }
}