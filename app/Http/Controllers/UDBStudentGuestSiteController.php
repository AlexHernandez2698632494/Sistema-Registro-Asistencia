<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UDBStudentGuestSiteController extends Controller
{
    //
    public function studentUDB(){
        return view('UDBStudentGuestSite.index');
    }
}
