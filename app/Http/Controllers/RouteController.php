<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function explore()
    {
        return view('explore');
    }
    public function saved()
    {
        return view('saved');
    }
    public function chat()
    {
        return view('chat');
    }
    public function notifications()
    {
        return view('notifications');
    }
}
