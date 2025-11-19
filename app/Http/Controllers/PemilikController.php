<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pemilik']);
    }

    public function index()
    {
        return view('pemilik.dashboard');
    }
}
