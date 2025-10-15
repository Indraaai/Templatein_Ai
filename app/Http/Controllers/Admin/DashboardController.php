<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\User;
use App\Models\DocumentCheck;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_templates' => Template::count(),
            'active_templates' => Template::where('is_active', true)->count(),
            'total_students' => User::where('role', 'mahasiswa')->count(),
            'total_checks' => DocumentCheck::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
