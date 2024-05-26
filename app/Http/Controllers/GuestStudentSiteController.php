<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestStudentSiteController extends Controller
{
    //
    public function index(){
        return view('student.index');
    }

    public function guest(){
        return view('student.guest');
    }
}
