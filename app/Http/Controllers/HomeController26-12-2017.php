<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Storage;
use Redirect;
use Validator;
use Mail;
use File;
use Hash;
use Auth;
use DateTime;
use Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    /*Dashboard Drag and drop section*/
    public function widgetupdate(Request $request) {

        $wherecount = array('user_type'=>Auth::user()->profile_id,'user_id' => Auth::user()->id,'module_id'=>$request->module_id);

        $count = DB::table('dashboard_widgets')->where($wherecount)->count();

        if($count == 0){

            $id = DB::table('dashboard_widgets')->insert([

                'module_id' => $request->module_id,

                'user_type' => Auth::user()->profile_id,

                'type' => $request->size_type,

                'user_id' => Auth::user()->id,

                'date' => date('Y-m-d')

            ]);

            $response = ($id) ? 'success' : 'fail';

            $msg = ($id) ? '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_addsuccessmsg").'!</div>' : '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Add not successfully!</div>' ;

        }


        return $response;

    }

    public function removewidget(Request $request)
    {
        $deleted = DB::table('dashboard_widgets')->where(['module_id'=> $request->module_id,'user_type' => Auth::user()->profile_id,'user_id' => Auth::user()->id])->delete();
        $response = ($deleted) ? 'success' : 'fail';
        $msg = ($deleted) ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans("messages.keyword_deletesuccessmsg").'!</div>' : '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Delete not successfully!</div>' ;

    }
    /*Dashboard Drag and drop section*/
}
