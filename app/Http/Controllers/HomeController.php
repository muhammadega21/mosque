<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'title' => "Dashboard",
            'main_page' => '',
            'page' => 'Dashboard',
        ]);
    }
}
