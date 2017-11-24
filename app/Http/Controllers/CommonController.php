<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;

class CommonController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function checkcountry(Request $request)
    {
		
       $states=DB::table('states')
	   		 ->where('e_status',1)
			 ->where('i_country_id',$request->country)
			 ->get();
		
		$html=' <select required class="form-control selecttwoclass" id="hotel_state" name="hotel_state" >
				<option value="">'.trans('messages.keyword_state').'</option>';
				foreach($states as $stkey=>$stval):
				$html.='<option value="'.$stval->i_id.'">'.$stval->v_name.'</option>';
				endforeach;
	   $html.='</select>';
	   echo $html;
	}
##################################################Check State##########################################################################
	public function checkstate(Request $request)
    {
		
       $states=DB::table('cities')
	   		 ->where('e_status',1)
			 ->where('i_state_id',$request->state)
			 ->get();
		$html=' <select required class="form-control selecttwoclass" id="hotel_city" name="hotel_city" >
				<option value="">'.trans('messages.keyword_city').'</option>';
				foreach($states as $stkey=>$stval):
				$html.='<option value="'.$stval->i_id.'">'.$stval->v_name.'</option>';
				endforeach;
	   $html.='</select>';
	   echo $html;
    }
}
