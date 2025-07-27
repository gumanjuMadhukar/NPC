<?php

namespace App\Http\Controllers\Council;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $data['nav'] = 'dashboard';
        $data['sub_nav'] = '';
        $data['page_title'] = "Dashboard";
        return view('council.dashboard.index', $data);
    }
}
