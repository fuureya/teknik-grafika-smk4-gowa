<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccessLogController extends Controller
{
    public function index()
    {
        $logs = PageView::latest()->paginate(30);

        return Inertia::render('AccessLogPage', [
            'logs' => $logs,
        ]);
    }
}
