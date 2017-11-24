<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllotmentController extends Controller
{
    public function allotment()
    {
        return view('allotment.index');
    }
}
