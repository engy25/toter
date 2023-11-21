<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view("layouts.index");
    }

    public function index_dashboard()
    {
        
        return view("dashboards.index");
    }

}
