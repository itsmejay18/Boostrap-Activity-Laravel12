<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileRecord;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::query()->count(),
            'totalFiles' => FileRecord::query()->count(),
            'activeFiles' => FileRecord::query()->where('status', 'Active')->count(),
            'pendingFiles' => FileRecord::query()->where('status', 'Pending')->count(),
        ]);
    }
}
