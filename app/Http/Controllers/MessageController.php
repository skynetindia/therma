<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Redirect;
use Validator;
use Mail;
use File;
use Hash;
use Auth;
use DB;
use DateTime;
use Cookie;
use Carbon\Carbon;


class MessageController extends Controller
{
    public function __construct(Request $request){
        
        parent::__construct();
        $this->middleware('auth');
        
    }

    /*alert section*/
    public function alert(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        
        return view('message.alert');
    }

    public function message_add_edit(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 1))
        {
            return redirect('/unauthorized');
        }
        
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->message_id)) {

            $action = 'edit';
            $arrDetails = DB::table('message_alert')->where(['id' => $request->message_id, 'is_deleted' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['alert'] = $arrDetails;
        }

        return view('message.alert_add_edit', $arrRecords);
    }

    public function message_alert_update(Request $request)
    {
        /*
         * $request->user_type_id
         * implode to get all user ids [  all + user_type1 + user_type2 etc]
         *  But it contains user id twice if we set all and other user type
         *  So i will implode all user id to get comma seperated string and explode it again to get array
         *  and i will filter unique array to get rid of this problem
         *
       */
        $implode_ids = implode(",", $request->user_type_id);
        $explode_ids = explode(",", $implode_ids);

        $user_type_ids_array = array_unique($explode_ids);
        $user_type_ids_string = implode(",", $user_type_ids_array);


        if(isset($request->alert_id) && !empty($request->alert_id) && $request->action == 'edit')
        {

            //dd("Update");
            $alert_data = [
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'user_type_id' => $user_type_ids_string,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table("message_alert")->where('id', $request->alert_id)->update($alert_data);

            DB::table('message_alert_send')->where('alert_id', $request->alert_id)->delete();
            foreach($user_type_ids_array as $user_type_id)
            {
                foreach(getUsersByUserType($user_type_id) as $key => $user)
                {
                    $alert_send_data = [
                        'user_id' => $user->id,
                        'alert_id' => $request->alert_id,
                        'name' => $request->name,
                        'type' => $request->type,
                        'description' => $request->description,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    DB::table("message_alert_send")->insert($alert_send_data);
                }

            }

            DB::table("message_alert")->where('id', $request->alert_id)->update(['is_sent' => 1]);

            $lang_data = [
                'name' => $request->name,
            ];
            language_keyword_add($lang_data);

            $logs = 'Alert Updated -> (ID:'.$request->alert_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_alert_updated_successfully').'</div>';

        }
        else{

            $alert_data = [
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'user_type_id' => $user_type_ids_string,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $last_inserted_alert = DB::table("message_alert")->insertGetId($alert_data);

            foreach($user_type_ids_array as $user_type_id)
            {
                foreach(getUsersByUserType($user_type_id) as $key => $user)
                {
                    $alert_send_data = [
                        'user_id' => $user->id,
                        'alert_id' => $last_inserted_alert,
                        'name' => $request->name,
                        'type' => $request->type,
                        'description' => $request->description,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    DB::table("message_alert_send")->insert($alert_send_data);
                }

            }

            DB::table("message_alert")->where('id', $last_inserted_alert)->update(['is_sent' => 1]);

            $lang_data = [
                'name' => $request->name,
            ];
            language_keyword_add($lang_data);

            $logs = 'New Alert Created -> (ID:'.$last_inserted_alert.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_alert_created_successfully').'</div>';
        }

        return Redirect::back()->with('msg', $msg);
    }

    public function get_alert_json(Request $request)
    {
        $message_options = array();
        $options = DB::table('message_alert as m_a')->select('m_a.*')
            ->where('m_a.id', '!=', 0)->where('m_a.is_deleted', '=', 0)->get();
        foreach ($options as $data) {
            $user_type_id = explode(",", $data->user_type_id);

            $user_types = getUserTypes();

            $radio_html = '';
            foreach($user_types as $key => $value)
            {
                $checked = in_array($value->id, $user_type_id) ? 'checked' : '';
//                $radio_html .= '<div class="radio    round-checkbox inline-block"> <input value="'.$value->id.'" id="'.$value->type."_".$value->id.'" name="'.$value->type."_".$value->id.'" type="radio" '.$checked.' disabled><label for="'.$value->type."_".$value->id.'">'.$value->type.'</label><div class="check"><div class="inside"></div></div></div>';
                $radio_html .= '<input value="'.$value->id.'" id="'.$value->type."_".$value->id.'" name="'.date('dmYHis').$value->type."_".$value->id.'" type="checkbox" '.$checked.' disabled> '.$value->type."<br>";

            }

            $data->user_type_id = $radio_html;
    
            $checked = ($data->is_active == 0) ? 'checked' : '';
            if(checkpermission($this->module_id,$this->parent_id, 1)) {
                $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateAlertStatus(' . (!empty($data->id) ? $data->id : '0') . ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0') . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            }else{
                $data->status = '<div class="switch"><input disabled="disabled" name="status" class="currencytogal" onchange="updateAlertStatus(' . (!empty($data->id) ? $data->id : '0') . ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0') . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            }

            $taxonomies_alert = getAlertTaxonomiesById($data->type);
            $data->type = $data->type." | ".$taxonomies_alert->name;

            $message_options[] = $data;
        }
        return json_encode($message_options);
    }

    public function message_alert_changeactivestatus(Request $request)
    {
        $update = DB::table('message_alert')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function message_alert_delete(Request $request)
    {
        $countRec = DB::table('message_alert')->select('*')->where('id', $request->id)->count();
        if ($countRec > 0) {
            DB::table('message_alert')->where('id', $request->id)->update(array('is_deleted' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_message_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_message_not_exist').'</div>');
        }
    }
    /*alert section*/


    /*support section*/
    public function support(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        
        return view('message.support');
    }

    public function support_add_edit(Request $request)
    {
        
        if(!checkpermission($this->module_id,$this->parent_id, 1))
        {
            return redirect('/unauthorized');
        }
        
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->support_id)) {

            $action = 'edit';
            $arrDetails = DB::table('message_support as ms')->select('ms.*', 'u.name as user_name', 'u.image as user_image')
                ->leftJoin('users as u', 'ms.user_id', '=', 'u.id')
                ->where(['ms.id' => $request->support_id, 'ms.is_deleted' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['support'] = $arrDetails;
        }

        return view('message.support_add_edit' , $arrRecords);
    }

    public function message_support_update(Request $request)
    {
        if(isset($request->support_id) && !empty($request->support_id) && $request->action == 'edit')
        {
            $imageName = '';
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/support'), $imageName);
            }

            $reply_table_data = [
                'replied_by_admin' => '1',
                'description' => $request->description,
                'support_id' => $request->support_id,
                'image' => $imageName,
                'user_id' => $request->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $last_inserted_id = DB::table('message_support_reply')->insertGetId($reply_table_data);

            /*Update support table updated at field when updating replies*/
            DB::table('message_support')->where('id', $request->support_id)->update(['updated_at' => date('Y-m-d H:i:s')]);


            $logs = 'Reply in support -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);
        }

        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_you_replied_successfully').'</div>';
        return Redirect::back()->with('msg', $msg);
    }

    public function get_support_json(Request $request)
    {
        $support_options = array();
        $options = DB::table('message_support')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0)->get();

        foreach ($options as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->created_at = Carbon::parse($data->created_at)->diffForHumans();
            $data->updated_at = Carbon::parse($data->updated_at)->diffForHumans();
    
    
            if(checkpermission($this->module_id,$this->parent_id, 1))
            {
                $data->is_active = '<div class="switch"><input  name="status" class="currencytogal" onchange="updateSupportStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            }else{
                $data->is_active = '<div class="switch"><input disabled="disabled" name="status" class="currencytogal" onchange="updateSupportStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            }
            
            $support_options[] = $data;
        }
        return json_encode($support_options);
    }

    public function message_support_changeactivestatus(Request $request)
    {
        $update = DB::table('message_support')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function message_support_delete(Request $request)
    {
        $countRec = DB::table('message_support')->select('*')->where('id', $request->id)->count();
        if ($countRec > 0) {
            DB::table('message_support')->where('id', $request->id)->update(array('is_deleted' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_support_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_support_not_exist').'</div>');
        }
    }
    /*support section*/


    /*
     *  Front Side functions for ticket test
     *  Ticket create demo from front side
     *  Remove below function after testing done
     *  Remove Route::get('ticket/create', 'MessageController@ticket_create');
     *  Remove message.ticket_create_front menu
     */
    public function ticket_create(Request $request)
    {
        return view('message.ticket_create_front');
    }

    public function ticket_store(Request $request)
    {
        //dd($request->all());

        $imageName = '';
        if($request->hasFile('image'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/support'), $imageName);
        }


        $support_table_data = [
            'unique_ticket' => $request->unique_ticket,
            'url' => $request->url,
            'subject' => $request->subject,
            'module_id' => '1', // static module id make it dynamic from front side and change here
            'user_id' => $request->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $last_inserted_support_id = DB::table('message_support')->insertGetId($support_table_data);

        $reply_table_data = [
            'support_id' => $last_inserted_support_id,
            'user_id' => $request->user()->id,
            'image' => $imageName,
            'replied_by_admin' => '0',
            'description' => $request->description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        DB::table('message_support_reply')->insert($reply_table_data);

        return Redirect::back();
    }

    public function mytickets(Request $request)
    {
        return view('message.myticket');
    }

    public function get_my_ticket_json(Request $request)
    {
        $support_options = array();
        $options = DB::table('message_support')->select('*')->where('user_id', $request->user_id)->where('id', '!=', 0)->where('is_deleted', '=', 0)->where('is_active','=', '0')->get();

        foreach ($options as $data) {
            $data->created_at = Carbon::parse($data->created_at)->diffForHumans();
            $data->updated_at = Carbon::parse($data->updated_at)->diffForHumans();
            $support_options[] = $data;
        }
        return json_encode($support_options);
    }

    public function ticket_edit(Request $request)
    {

        if (isset($request->support_id)) {

            $action = 'edit';
            $arrDetails = DB::table('message_support as ms')->select('ms.*', 'u.name as user_name', 'u.image as user_image')
                ->leftJoin('users as u', 'ms.user_id', '=', 'u.id')
                ->where(['ms.id' => $request->support_id, 'ms.is_deleted' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['support'] = $arrDetails;
        }

        return view('message.ticket_edit' , $arrRecords);
    }

    public function myticket_update(Request $request)
    {

        if(isset($request->support_id) && !empty($request->support_id) && $request->action == 'edit')
        {
            $imageName = '';
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/support'), $imageName);
            }


            $reply_table_data = [
                'replied_by_admin' => '0',
                'description' => $request->description,
                'support_id' => $request->support_id,
                'image' => $imageName,
                'user_id' => $request->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $last_inserted_id = DB::table('message_support_reply')->insertGetId($reply_table_data);

            /*Update support table updated at field when updating replies*/
            DB::table('message_support')->where('id', $request->support_id)->update(['updated_at' => date('Y-m-d H:i:s')]);


            $logs = 'Reply in support -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);
        }

        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> You posted successfully</div>';
        return Redirect::back()->with('msg', $msg);
    }

    /*Front side function for ticket test*/
}
