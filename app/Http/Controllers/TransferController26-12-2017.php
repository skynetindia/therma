<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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

    public function transferaddedit(Request $request)
    {
        $action = 'add';

        $arrRecords = [
            'action'=>'add',

        ];


        if(isset($request->transfer_id))
        {

            $action = 'edit';
            $arrDetails = DB::table('transfer as t')->select('t.*', 'u.name')
                ->leftJoin('users as u', 't.user_id' , '=', 'u.id')
                ->where(['t.id'=>$request->transfer_id,'t.is_deleted'=>'0'])->first();


            $arrRecords['action'] = 'edit';
            $arrRecords['transfer'] = $arrDetails;
        }

        return view('transfer.transfer_add_edit', $arrRecords);
    }

    public function savetransfer(Request $request)
    {



        if(isset($request->transfer_id) && !empty($request->transfer_id) && $request->action == 'edit') {
		
            $data = [
                'client_name' => toUcWord($request->client_name),
                'client_phone' => $request->client_phone,
                'direction' => $request->direction,
                'type' => $request->type,
                'pax' => $request->pax,
                'start' => $request->start,
                'destination' => $request->destination,
                'client_status' => $request->client_status,
                'flight_time' => date('Y-m-d H:i:s',strtotime($request->flight_time)),
                'flight' => $request->flight,
                'pickup_time' => date('Y-m-d H:i:s',strtotime($request->pickup_time)),
                'arrival' => date('Y-m-d',strtotime($request->arrival)),
                'departure' => date('Y-m-d',strtotime($request->departure)),
                'price' => $request->price,
                'notes' => $request->notes,
            ];


            //dd($data);
            DB::table('transfer')->where('id', $request->transfer_id)->update($data);


            $logs = 'Transfer Updated -> (ID:'.$request->transfer_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_transfer_updated_successfully').'</div>';


        }else{
			
            $data = [
                'unique_transfer_id' => $request->unique_transfer_id,
                'client_name' => toUcWord($request->client_name),
                'client_phone' => $request->client_phone,
                'direction' => $request->direction,
                'type' => $request->type,
                'pax' => $request->pax,
                'start' => $request->start,
                'destination' => $request->destination,
                'client_status' => $request->client_status,
               'flight_time' => date('Y-m-d H:i:s',strtotime($request->flight_time)),
                'flight' => $request->flight,
                'pickup_time' => date('Y-m-d H:i:s',strtotime($request->pickup_time)),
                'arrival' => date('Y-m-d',strtotime($request->arrival)),
                'departure' => date('Y-m-d',strtotime($request->departure)),
                'price' => $request->price,
                'notes' => $request->notes,
            ];
            $lastID  = DB::table('transfer')->insertGetId($data);

            $logs = 'Transfer Added -> (ID:'.$lastID.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_transfer_added_successfully').'</div>';

        }

        return Redirect::back()->with('msg', $msg);

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
			$data->direction=($data->direction==1)?trans('messages.keyword_arrival'):trans('messages.keyword_departure');
			$data->type=($data->type==1)?trans('messages.keyword_group'):trans('messages.keyword_individual');
            if($data->send_info_status == '0'){
                $data->send_info_status = '<i class="fa fa-envelope-o" style="color:red;"></i>';
            }else{
                $data->send_info_status = '<i class="fa fa-envelope-o" style="color:green;"></i>';
            }

            $cur = getActiveCurrency();
            $data->price = $data->price.$cur['symbol'];

            $data->flight_time = Carbon::parse($data->flight_time)->format('d/m/y H:i A');
            $data->pickup_time = Carbon::parse($data->pickup_time)->format('d/m/y H:i A');

            $data->checkbox = "<input type='checkbox' data-id='".$data->id."' class='checkbox-inline child_checkbox'>";
            $transferArray[] = $data;
        }
        return json_encode($transferArray);
    }

    public function confirmTransfer(Request $request)
    {
        $update = DB::table('transfer')->where('id', $request->id)->update(array('is_active' => '0'));
        return ($update) ? 'true' : 'false';
    }

    public function deletetransfer(Request $request)
    {
        $countRec = DB::table('transfer')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if($countRec > 0){
            DB::table('transfer')->where('id',$request->id)->update(array('is_deleted' =>'1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_transfer_removed_successfully').'</div>');
        }
        else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_transfer_not_exist').'</div>');
        }
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
        $transfer  = DB::table('transfer as t')->select('t.*')
            ->where('t.id', '!=', '0')->where('t.is_deleted', '=', '0');


        if(isset($request->search))
        {
            $transfer->where('t.unique_transfer_id', '=' ,$request->search);
        }

        // what to do with client status ? client status not found in table
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
            $transfer->where('t.arrival','>=', dateToSql($request->arrival));
            $transfer->where('t.departure','<=', dateToSql($request->departure));
        }





        $arrayData['filtered_transfer'] = $transfer->get();
        $arrayData['oldform_data'] = [
            'search' => $request->search,
            'client_status' => $request->client_status,
            'arrival' => $request->arrival,
            'departure' => $request->departure,
            'admin_subject' => $request->admin_subject,
            'type' => $request->type
        ];

        //dd($arrayData);
        return view('transfer.transfer_search', $arrayData);
    }
}
