<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(){
        $titulo = 'Dashboard';

        return view('modules.dashboard.home', compact('titulo'));
    }

    public function indexDocente(){
        $titulo = 'Dashboard';

        return view('modules.dashboard.indexDocente', compact('titulo'));
    }
}
