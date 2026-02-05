<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Semestres extends Controller
{
    public function index(){
        $titulo = 'Semestres';

        return view('modules.semestres.index', compact('titulo'));
    }
    public function create(){
        $titulo = 'Semestres';

        return view('modules.semestres.create', compact('titulo'));
    }
    
}
