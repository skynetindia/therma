<?php

namespace App\Http\Controllers;


use Redirect;
use Session;

class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function submit()
    {
        return Redirect::back()->with('msg', 'working flash');
    }
}
