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

use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(isset($request->typeid) && !empty($request->typeid))
        {
            $data['typeid'] = $request->typeid;
        }
        $data['users'] = DB::table('users')->where(['is_delete' => '0'])->where('id', '!=', $request->user()->id)->get();
        return view('user.index', $data);
    }

    public function add_edit_user(Request $request)
    {
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];
        if (isset($request->typeid)) {
            $arrRecords['typeid'] = $request->typeid;
        }

        if (isset($request->userid)) {

            $action = 'edit';
            $arrDetails = DB::table('users')->where(['id' => $request->userid, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['user'] = $arrDetails;
        }

        return view('user.add_edit_user', $arrRecords);
    }


    public function user_update(Request $request)
    {
        if (isset($request->userid) && !empty($request->userid) && $request->action == 'edit') {


            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($request->userid),
                ],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }



            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/user'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }

            $user = User::find($request->userid);
            $user->name = $request->name;
            $user->image= $imageName;
            $user->language_key = strtolower(str_replace(" ", "_", $request->name));
            $user->phone= $request->phone;
            $user->profile_id = $request->profile_id;
            $user->address= $request->address;
            $user->email = $request->email;
            $user->save();

            /*Permission update code*/
            DB::table('users')->where('id', $request->userid)->update(['permissions' => null]);


            $writing = $request->writing;
            $reading = $request->reading;

            $permission_array = [];
            if(count($writing) > 0){
                foreach($writing as $key => $write){
                    $permission_array[] = $write;
                }
            }

            if(count($reading) > 0){
                foreach($reading as $key => $read){
                    $permission_array[] = $read;
                }
            }

            $json_format = json_encode($permission_array);

            DB::table('users')->where('id', $request->userid)->update(['permissions' => $json_format]);
            /*Permission update code*/

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'User Updated -> (ID:'.$request->userid.')';
            storelogs($request->user()->id,$logs);


            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>User Updated successfully!</div>';
            return Redirect::to('users')->with('msg', $msg);

        }
        else{

            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    Rule::unique('users'),
                ],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/user'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }

            $user = new User;
            $user->name = $request->name;
//            $user->image= ($imageName != '') ? $imageName : 'default.png';
            $user->image= $imageName;
            $user->password = bcrypt($request->password);
            $user->profile_id = $request->profile_id;
            $user->language_key = strtolower(str_replace(" ", "_", $request->name));
            $user->phone= $request->phone;
            $user->address= $request->address;
            $user->email = $request->email;
            $user->save();


            /*Permission update code*/
            DB::table('users')->where('id', $user->id)->update(['permissions' => null]);

            $writing = $request->writing;
            $reading = $request->reading;

            $permission_array = [];
            if(count($writing) > 0){
                foreach($writing as $key => $write){
                    $permission_array[] = $write;
                }
            }

            if(count($reading) > 0){
                foreach($reading as $key => $read){
                    $permission_array[] = $read;
                }
            }

            $json_format = json_encode($permission_array);

            DB::table('users')->where('id', $user->id)->update(['permissions' => $json_format]);
            /*Permission update code*/


            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);

            $logs = 'User Created -> (ID:'.$user->id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>User Created successfully!</div>';
            return Redirect::to('users')->with('msg', $msg);
        }
    }

    public function user_json(Request $request)
    {

        $user_details = array();

        $users = DB::table('users')->select('users.id', 'users.name', 'user_type.type', 'users.email', 'users.image', 'users.is_active', 'users.profile_id')
            ->leftJoin('user_type', 'users.profile_id', '=', 'user_type.id')
            ->where('users.id', '!=', 0)->where('users.id', '!=', $request->user()->id)->where('users.is_delete', '=', 0)->get();


        if(isset($request->typeid) && !empty($request->typeid)) {

            $users = DB::table('users')->select('users.id', 'users.name', 'user_type.type', 'users.email', 'users.image','users.is_active', 'users.profile_id')
                ->leftJoin('user_type', 'users.profile_id', '=', 'user_type.id')
                ->where('users.id', '!=', 0)->where('users.profile_id', $request->typeid)->where('users.id', '!=', $request->user()->id)->where('users.is_delete', '=', 0)->get();
        }

        foreach ($users as $key =>  $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateUsersStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $data->access = '<a href="'.url('user/access')."/".encodehelper($data->id).'" >'.trans('messages.keyword_extranet').'</a>';

            if($data->image != '')
            {
                $data->image = '<img src="'.asset('public/images/user')."/".$data->image.'" style="width:60px;"></i>';
            }
            else{
                $data->image = '<img src="'.asset('public/images/default/default_user.png').'" style="width:60px;"></i>';
            }

            $data->profile_id = $data->profile_id." | ". (!empty($data->type) ? $data->type : '-');
            $user_details[] = $data;
        }
        return json_encode($user_details);
    }

    public function delete_user(Request $request)
    {
        $countRec = DB::table('users')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('users')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_not_exist').'</div>');
        }
    }

    public function profile(Request $request)
    {
        $user = DB::table('users')->where('id', $request->user()->id)->get()->first();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('users')->ignore($request->userid),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if($request->hasFile('image'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/user'), $imageName);
        }
        else{
            $imageName = $request->old_image;
        }



        $user = User::find($request->userid);
        $user->name = $request->name;
        $user->image= $imageName;
        $user->phone= $request->phone;
        $user->email = $request->email;
        $user->save();

        $logs = 'Profile Updated -> (ID:'.$request->userid.')';
        storelogs($request->user()->id,$logs);


        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Profile Updated successfully!</div>';
        return Redirect::back()->with('msg', $msg);
    }

    public function user_changeactivestatus(Request $request)
    {
        $update = DB::table('users')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function changepassword(Request $request)
    {


        $user = DB::table('users')->where('id', $request->user()->id)->get()->first();
        return view('user.change_password', compact('user'));
    }

    public function update_password(Request $request) {
        $user = new User();
        $user = User::find($request->userid);
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill(['password' => Hash::make($request->password)])->save();
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password changed successfully!</div>';
        }
        else {
            $request->session()->flash('error', 'Password does not match');
            $msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password does not match!</div>';
        }
        return Redirect::back()->with('msg', $msg);
    }

    /*
     *   User Types Coding
     */

    public function user_type()
    {
        return view('user.user_type');
    }

    public function user_type_json(Request $request)
    {
        $user_details = array();
        $users = DB::table('user_type')->select('*')->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($users as $data) {
            $user_details[] = $data;
        }
        return json_encode($user_details);
    }

    public function add_edit_user_type(Request $request)
    {
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];
        if (isset($request->typeid)) {

            $action = 'edit';
            $arrDetails = DB::table('user_type')->where(['id'=> $request->typeid, 'is_delete' => '0'])->get()->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['user_type'] = $arrDetails;
        }

        return view('user.add_edit_user_type', $arrRecords);
    }

    public function update_user_type(Request $request)
    {
        $type_key = str_replace(" ", "_", strtolower($request->type));

        if (isset($request->typeid) && !empty($request->typeid) && $request->action == 'edit') {

            $validator = Validator::make($request->all(), [
                'type' => [
                    'required',
                    Rule::unique('user_type')->ignore($request->typeid),
                ],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'type' => $request->type,
                'language_key' => 'keyword_'.$type_key
            ];
            Db::table('user_type')->where('id', $request->typeid)->update($data);

            /*Permission update code*/
            DB::table('user_type')->where('id', $request->typeid)->update(['permissions' => null]);

            $writing = $request->writing;
            $reading = $request->reading;

            $permission_array = [];
            if(count($writing) > 0){
                foreach($writing as $key => $write){
                    $permission_array[] = $write;
                }
            }

            if(count($reading) > 0){
                foreach($reading as $key => $read){
                    $permission_array[] = $read;
                }
            }

            $json_format = json_encode($permission_array);

            DB::table('user_type')->where('id', $request->typeid)->update(['permissions' => $json_format]);
            /*Permission update code*/

            $lang_data = [
                'type' => $request->type,
            ];
            language_keyword_add($lang_data);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>User Type Updated successfully!</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else{


            $validator = Validator::make($request->all(), [
                'type' => [
                    'required',
                    Rule::unique('user_type'),
                ],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'type' => $request->type,
                'language_key' => 'keyword_'.$type_key
            ];
            $last_inserted_id = Db::table('user_type')->insertGetId($data);


            /*Permission update code*/
            DB::table('user_type')->where('id', $last_inserted_id)->update(['permissions' => null]);

            $writing = $request->writing;
            $reading = $request->reading;

            $permission_array = [];
            if(count($writing) > 0){
                foreach($writing as $key => $write){
                    $permission_array[] = $write;
                }
            }

            if(count($reading) > 0){
                foreach($reading as $key => $read){
                    $permission_array[] = $read;
                }
            }

            $json_format = json_encode($permission_array);

            DB::table('user_type')->where('id', $last_inserted_id)->update(['permissions' => $json_format]);
            /*Permission update code*/

            $lang_data = [
                'type' => $request->type,
            ];
            language_keyword_add($lang_data);


            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_type_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function user_type_delete(Request $request)
    {
        $countRec = DB::table('user_type')->select('*')->where('id', $request->id)->count();

        //dd($countRec);
        if ($countRec > 0) {
            DB::table('user_type')->where('id', $request->id)->update(array('is_delete' => '1'));
            DB::table('users')->where('profile_id', $request->id)->update(array('is_delete' => '2'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_type_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_user_type_not_exist').'</div>');
        }
    }

    /*
     * Access
     */
    protected function access(Request $request) {
        $userid  = decodehelper($request->userid);
        $user = DB::table('users')->where('id', $userid)->first();
        $request->session()->put('isAdmin', 1);
        $request->session()->put('adminID', Auth::id());

        if (Auth::loginUsingId($user->id)) {
            return redirect('/');
        }
    }
    /* end Access */


    public function members_activity(Request $request)
    {
        $arrData = [];
        if(isset($request->type_id))
        {
            $arrData['type_id'] = $request->type_id;
        }


        return view('user.members_activity', $arrData);
    }

    public function activity_json(Request $request)
    {

        $activity_details = array();

        if(isset($request->type_id))
        {
            $logs = DB::table('member_activity_log as mal')
                ->select('mal.id as mal_id','mal.log_date','mal.user_id as mal_user_id','mal.logs','mal.ip_address','u.name as u_name','ut.type as ut_type','u.id as u_id','u.profile_id as u_profile_id', 'ut.id as ut_id', 'mal.is_delete as mal_is_delete' ,'u.is_delete as u_is_delete', 'u.is_active as u_is_active')
                ->leftJoin('users as u', 'mal.user_id', '=', 'u.id')
                ->leftJoin('user_type as ut', 'u.profile_id', '=', 'ut.id')
                ->where('ut.id', $request->type_id)
                ->where('u.is_delete', '0')
                ->where('mal.is_delete', '0')
                ->where('u.is_active', '0')->get();
        } else{
            $logs = DB::table('member_activity_log as mal')
                ->select('mal.id as mal_id','mal.log_date','mal.user_id as mal_user_id','mal.logs','mal.ip_address','u.name as u_name','ut.type as ut_type','u.id as u_id','u.profile_id as u_profile_id', 'ut.id as ut_id', 'mal.is_delete as mal_is_delete' ,'u.is_delete as u_is_delete', 'u.is_active as u_is_active')
                ->leftJoin('users as u', 'mal.user_id', '=', 'u.id')
                ->leftJoin('user_type as ut', 'u.profile_id', '=', 'ut.id')
                ->where('u.is_delete', '0')
                ->where('mal.is_delete', '0')
                ->where('u.is_active', '0')->get();
        }



        foreach ($logs as $data) {
            //pre($data);
            //$data->user_id = $data->user_id." | ".getNameByUserID($data->user_id);
            $data->id = $data->mal_id;
            $data->user_id = $data->mal_user_id." | ".$data->u_name;
            $data->type = $data->ut_type;
            $activity_details[] = $data;
        }
        return json_encode($activity_details);
    }


    public function activity_delete(Request $request)
    {
        $countRec = DB::table('member_activity_log')->select('*')->where('id', $request->id)->count();

        //dd($countRec);
        if ($countRec > 0) {
            DB::table('member_activity_log')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_logs_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_log_not_exist').'</div>');
        }
    }



    /*permission Section*/

    public function user_roles(Request $request)
    {
        return view('user.user_roles');
    }

    public function user_modules(Request $request)
    {
        $typeid = $request->typeid;
        return view('user.user_modules', compact('typeid'));
    }

    public function user_modules_update(Request $request)
    {
        $typeid =  $request->typeid;

        /*this will clear old permission on specific user_type's permission column before updating new permission*/
        DB::table('user_type')->where('id', $typeid)->update(['permissions' => null]);

        $writing = $request->writing;
        $reading = $request->reading;

        $permission_array = [];
        if(count($writing) > 0){
            foreach($writing as $key => $write){
                $permission_array[] = $write;
            }
        }

        if(count($reading) > 0){
            foreach($reading as $key => $read){
                $permission_array[] = $read;
            }
        }

        $json_format = json_encode($permission_array);

        DB::table('user_type')->where('id', $typeid)->update(['permissions' => $json_format]);

        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_permissions_updated_successfully').'</div>';
        return Redirect::back()->with('msg', $msg);

    }
    /*permission Section*/

}
