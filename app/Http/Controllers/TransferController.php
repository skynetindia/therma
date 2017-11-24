<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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

class TransferController extends Controller
{
    public function transfer_list()
    {
        return view('transfer.list');
    }

    public function getjsontransferproperty()
    {
        $transferArray= [];
        $transfer = DB::table('transfer as t')->select('t.*', 'u.name as username', 'u.phone as user_phone')
            ->leftJoin('users as u','t.user_id' ,'=', 'u.id')
            ->where('t.id', '!=', 0)->where('t.is_deleted', '=', 0)->get();
        foreach($transfer as $data) {
//            $checked = ($data->is_active==0) ? 'checked' : '';
//            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTransferStatus('.$data->id.')" id="activestatus_'.$data->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$data->id.'"></label></div>';

            if($data->is_active == '0')
            {
                $data->status = '<i class="fa fa-check" style="color:green;"></i>';
            }else{
                $data->status = '<i class="fa fa-times" style="color:red;"></i>';
            }

            if($data->send_info_status == '0'){
                $data->send_info_status = '<i class="fa fa-envelope-o" style="color:red;"></i>';
            }else{
                $data->send_info_status = '<i class="fa fa-envelope-o" style="color:green;"></i>';
            }

            $cur = getActiveCurrency();
            $data->price = $data->price.$cur['symbol'];
            $data->client_name = $data->username;
            $data->client_phone = $data->user_phone;

            $data->checkbox = "<input type='checkbox' data-id='{{ $data->id }}' onchange='clearCheckall(this)' class='checkbox-inline child_checkbox'>";
            $transferArray[] = $data;
        }
        return json_encode($transferArray);
    }

    public function confirmTransfer(Request $request)
    {
        $update = DB::table('transfer')->where('id', $request->id)->update(array('is_active' => '0'));
        return ($update) ? 'true' : 'false';
    }


    public function updatetransferstatus(Request $request)
    {
        $update = DB::table('transfer')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function sendInfoToHotel(Request $request)
    {

        /*
         *  In this function in $data
         *  'name' is static which is hotel_manager &
         *   'type' is taxonomies alert's id number 2 please change accordingly.
         */

       if(isset($request->id))
       {
           $transfer = DB::table('transfer')->where('id', $request->id)->first();
           $user_id =  $transfer->user_id;

           $data = [
               'user_id' => $user_id,
               'name' => trans('messages.keyword_hotel_manager'),
               'type' => 2,
               'description' => $request->description
           ];

           $insert = DB::table('message_alert_send')->insert($data);
           if($insert)
           {
               DB::table('transfer')->where('id', $request->id)->update(['send_info_status' => 1]);
           }
       }

    }

    public function transfer_search(Request $request)
    {
        $transfer  = DB::table('transfer as t')->select('t.*', 'u.name as username', 'u.phone as user_phone')
            ->leftJoin('users as u','t.user_id' ,'=', 'u.id')
            ->where('t.id', '!=', '0')->where('t.is_deleted', '=', '0');


        if(isset($request->search))
        {
            $transfer->where('t.unique_transfer_id', '=' ,$request->search);
        }

        if(isset($request->client_status))
        {
            $transfer->where('t.client_status', '=' ,$request->client_status);
        }

        if(isset($request->type))
        {
            $transfer->where('t.type', '=' ,$request->type);
        }

        if(isset($request->admin_subject))
        {
            $transfer->where('t.is_active', '=' ,$request->admin_subject);
        }


        if(isset($request->arrival) && isset($request->departure))
        {
            $transfer->where('t.arrival','>=', $request->arrival);
            $transfer->where('t.departure','<=', $request->departure);
        }





        $arrayData['filtered_transfer'] = $transfer->get();

        //dd($arrayData);
        return view('transfer.transfer_search', $arrayData);
    }
}
