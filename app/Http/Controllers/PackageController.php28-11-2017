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

class PackageController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    /*Package Section*/
    public function packages()
    {
        return view('package.packages');
    }

    public function package_add_edit(Request $request)
    {

        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->package_id)) {

            $action = 'edit';
            $arrDetails = DB::table('package')->where(['id' => $request->package_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['package'] = $arrDetails;
        }

        return view('package.package_add_edit', $arrRecords);
    }

    public function package_update(Request $request)
    {
        if (isset($request->package_id) && !empty($request->package_id) && $request->action == 'edit')
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/package'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }
            /*array to insert in package table*/
            $data = [
                'code' => $request->code,
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'image' => $imageName,
                'discount' => $request->discount,
                'price' => $request->price,
                'min_individual' => $request->min_individual,
                'max_individual' => $request->max_individual,
                'description' => $request->description,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if(isset($request->list_of_room_status) && $request->list_of_room_status == 1)
            {
                $data['list_of_room_status'] = $request->list_of_room_status;
                $data['list_of_room' ] = $request->list_of_room;
            }
            else{
                $data['list_of_room_status'] = '0';
                $data['list_of_room' ] = '0';
            }
            if(isset($request->list_of_individual_status) && $request->list_of_individual_status == 1)
            {
                $data['list_of_individual_status'] = $request->list_of_individual_status;
                $data['list_of_individual'] = $request->list_of_individual;
            }
            else{
                $data['list_of_individual_status'] = '0';
                $data['list_of_individual'] = '0';
            }
            if(isset($request->list_of_days_status) && $request->list_of_days_status == 1)
            {
                $data['list_of_days_status'] = $request->list_of_days_status;
                $data['list_of_days'] = $request->list_of_days;
            }
            else{
                $data['list_of_days_status'] = '0';
                $data['list_of_days'] = '0';
            }

            if(isset($request->on_hotel) && $request->on_hotel == 1)
            {
                $data['on_hotel'] = $request->on_hotel;
            }
            else{
                $data['on_hotel'] = '0';
            }

            /*Update into package table*/
            Db::table('package')->where('id',$request->package_id)->update($data);

            $options_array_id = array();
            $options_array_price = array();
            if(isset($request->options_id) && count($request->options_id) > 0)
            {
                $options_array_id = $request->options_id;
            }
            if(isset($request->base_price) && count($request->base_price) > 0)
            {
                $options_array_price = $request->base_price;
            }
            $options_array = array_combine($options_array_id, $options_array_price);

            if(count($options_array) > 0)
            {
                Db::table('selected_package_options')->where('package_id', $request->package_id)->delete();

                foreach($options_array as $options_id => $options_price)
                {
                    $options_data = [
                        'package_id' => $request->package_id,
                        'options_id' => $options_id,
                        'price' => $options_price
                    ];
                    Db::table('selected_package_options')->insertGetId($options_data);
                }
            }

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Package Updated-> (ID:'.$request->package_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/package'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }
            /*array to insert in package table*/
            $data = [
                'code' => $request->code,
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'image' => $imageName,
                'discount' => $request->discount,
                'price' => $request->price,
                'min_individual' => $request->min_individual,
                'max_individual' => $request->max_individual,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if(isset($request->list_of_room_status) && $request->list_of_room_status == 1)
            {
                $data['list_of_room_status'] = $request->list_of_room_status;
                $data['list_of_room' ] = $request->list_of_room;
            }
            if(isset($request->list_of_individual_status) && $request->list_of_individual_status == 1)
            {
                $data['list_of_individual_status'] = $request->list_of_individual_status;
                $data['list_of_individual'] = $request->list_of_individual;
            }
            if(isset($request->list_of_days_status) && $request->list_of_days_status == 1)
            {
                $data['list_of_days_status'] = $request->list_of_days_status;
                $data['list_of_days'] = $request->list_of_days;
            }
            if(isset($request->on_hotel) && $request->on_hotel == 1)
            {
                $data['on_hotel'] = $request->on_hotel;
            }

            /*Insert into package table*/
            $last_inserted_id = Db::table('package')->insertGetId($data);


            if(isset($request->options_id) && count($request->options_id) > 0)
            {
                $options_array_id = $request->options_id;
            }
            if(isset($request->base_price) && count($request->base_price) > 0)
            {
                $options_array_price = $request->base_price;
            }
            $options_array = array_combine($options_array_id, $options_array_price);

            if(count($options_array) > 0)
            {
                foreach($options_array as $options_id => $options_price)
                {
                    $options_data = [
                        'package_id' => $last_inserted_id,
                        'options_id' => $options_id,
                        'price' => $options_price
                    ];
                    Db::table('selected_package_options')->insertGetId($options_data);
                }
            }

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Package added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function get_package_json(Request $request)
    {
        $package_options = array();
        $options = DB::table('package')->select('*')->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($options as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';

            if($data->image != ''){
                $data->image = '<img src="'.asset('public/images/package')."/".$data->image.'" style="width:60px;"></i>';
            }
            else{
                $data->image = '<img src="'.asset('public/images/default/default_package.jpg').'" style="width:60px;"></i>';
            }

            $cur = getActiveCurrency();
            $data->price = $data->price." ".$cur['symbol'];
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updatePackageStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $package_options[] = $data;
        }
        return json_encode($package_options);
    }

    public function package_changeactivestatus(Request $request)
    {
        $update = DB::table('package')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function package_delete(Request $request)
    {
        $countRec = DB::table('package')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('package')->where('id', $request->id)->update(array('is_delete' => '1'));
            DB::table('selected_package_options')->where('package_id', $request->id)->delete();
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_not_exist').'</div>');
        }
    }
    /*Package Section*/

    /*Package Options Section*/
    public function package_options(Request $request)
    {
        return view('package.package_options');
    }

    public function package_options_add_edit(Request $request)
    {

        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->options_id)) {

            $action = 'edit';
            $arrDetails = DB::table('package_options')->where(['id' => $request->options_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['options'] = $arrDetails;
        }

        return view('package.package_options_add_edit', $arrRecords);
    }

    public function package_options_update(Request $request)
    {
        //pre($request->all()); exit;


        if (isset($request->options_id) && !empty($request->options_id) && $request->action == 'edit')
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/package'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }

            $data = [
                'short_name' => $request->short_name,
                'name' => $request->name,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'language_key' => strtolower(str_replace(" ", "_", $request->short_name)),
                'discount' => $request->discount,
                'quick_description' => $request->quick_description,
                'image' => $imageName,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Db::table('package_options')->where('id', $request->options_id)->update($data);


            $lang_data = [
                'short_name' => $request->short_name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Package options updated -> (ID:'.$request->options_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_options_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/package'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }

            $data = [
                'short_name' => $request->short_name,
                'name' => $request->name,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'language_key' => strtolower(str_replace(" ", "_", $request->short_name)),
                'discount' => $request->discount,
                'quick_description' => $request->quick_description,
                'image' => $imageName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $last_inserted_id = Db::table('package_options')->insertGetId($data);

            $lang_data = [
                'short_name' => $request->short_name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Package options added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_options_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function get_package_options_json(Request $request)
    {
        $package_options = array();
        $options = DB::table('package_options')->select('*')->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($options as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $cur = getActiveCurrency();
            $data->base_price = $data->base_price." ".$cur['symbol'];

            if($data->image != ''){
                $data->image = '<img src="'.asset('public/images/package')."/".$data->image.'" style="width:60px;"></i>';
            }
            else{
                $data->image = '<img src="'.asset('public/images/default/default_option.png').'" style="width:60px;"></i>';
            }

            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updatePackageOptionsStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $package_options[] = $data;
        }
        return json_encode($package_options);
    }

    public function package_options_delete(Request $request)
    {
        $countRec = DB::table('package_options')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('package_options')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_option_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>user not Exist!</div>');
        }
    }

    public function package_options_changeactivestatus(Request $request)
    {
        $update = DB::table('package_options')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }
    /*Package Options Section*/

    /*promotions Section*/
    public function promotions()
    {
        return view('package.promotions');
    }

    public function promotion_add_edit(Request $request)
    {

        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->promotion_id)) {

            $action = 'edit';
            $arrDetails = DB::table('promotions')->where(['id' => $request->promotion_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['promotion'] = $arrDetails;
        }

        return view('package.promotion_add_edit', $arrRecords);
    }

    public function promotion_update(Request $request)
    {
        if (isset($request->promotion_id) && !empty($request->promotion_id) && $request->action == 'edit')
        {
            /*array to insert in package table*/
            $data = [
                'code' => $request->code,
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'price' => $request->price,
                'description' => $request->description,
                'updated_at' => $request->updated_at,
                'is_active' => isset($request->is_active) ? $request->is_active : '1'
            ];

            Db::table('promotions')->where('id', $request->promotion_id)->update($data);
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Promotions updated -> (ID:'.$request->promotion_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_promotion_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {

            /*array to insert in package table*/
            $data = [
                'code' => $request->code,
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'price' => $request->price,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => $request->updated_at,
                'is_active' => isset($request->is_active) ? $request->is_active : '1'
            ];

            $last_inserted_id = Db::table('promotions')->insertGetId($data);
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Promotions added -> (ID:'.$request->promotion_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_promotion_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function get_promotion_json(Request $request)
    {
        $package_options = array();
        $options = DB::table('promotions')->select('*')->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($options as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $cur = getActiveCurrency();
            $data->price = $data->price." ".$cur['symbol'];
            $data->is_active = '<div class="switch"><input name="status" class="currencytogal" onchange="updatePromotionStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $package_options[] = $data;
        }
        return json_encode($package_options);
    }

    public function promotion_changeactivestatus(Request $request)
    {
        $update = DB::table('promotions')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function promotion_delete(Request $request)
    {
        $countRec = DB::table('promotions')->select('*')->where('id', $request->id)->count();
        if ($countRec > 0) {
            DB::table('promotions')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_promotion_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>');
        }
    }
    /*promotions Section*/


    /*Package Discount offer Section*/
    public function package_discount(Request $request)
    {
        return view('package.package_discount');
    }

    public function package_discount_add_edit(Request $request)
    {

        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->discount_id)) {

            $action = 'edit';
            $arrDetails = DB::table('discount_offer')->where(['id' => $request->discount_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['discount'] = $arrDetails;
        }

        return view('package.package_discount_add_edit', $arrRecords);
    }

    public function package_discount_update(Request $request)
    {

        if (isset($request->discount_id) && !empty($request->discount_id) && $request->action == 'edit')
        {
            $rooms = implode(',', $request->rooms_id);
            $data = [
                'tax_discount_id' => $request->tax_discount_id,
                'accommodation_type' => $request->accommodation_type,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'days_before_arrival' => $request->days_before_arrival,
                'apply_the_discount' => $request->apply_the_discount,
                'discount' => $request->discount,
                'rooms' => $rooms,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Db::table('discount_offer')->where('id', $request->discount_id)->update($data);

            $logs = 'Discount offer updated -> (ID:'.$request->discount_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_discount_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {
            $rooms = implode(',', $request->rooms_id);
            $data = [
                'tax_discount_id' => $request->tax_discount_id,
                'accommodation_type' => $request->accommodation_type,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
                'days_before_arrival' => $request->days_before_arrival,
                'apply_the_discount' => $request->apply_the_discount,
                'discount' => $request->discount,
                'rooms' => $rooms,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];


            $last_inserted_id = Db::table('discount_offer')->insertGetId($data);



            $logs = 'Discount offer added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_discount_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function get_package_discount_json(Request $request)
    {
        $package_options = array();
        $options = DB::table('discount_offer as d_o')->select('d_o.*', 't_d.name as discount_type')
            ->leftJoin('taxonomies_discount as t_d', 't_d.id', '=', 'd_o.tax_discount_id')
            ->where('d_o.id', '!=', 0)->where('d_o.is_delete', '=', 0)->get();
        foreach ($options as $data) {
            $data->tax_discount_id  = $data->discount_type;
            $checked = ($data->is_active == 0) ? 'checked' : '';

            if($data->discount !=0 && $data->discount != null)            {
                $data->discount = $data->discount." % ";            }
            else{
                $data->discount = '--';
            }


            $rooms_ids = explode(',', $data->rooms);
            //pre($rooms_ids);
            $room_names = '';
            if(count($rooms_ids) > 0)
            {
                $key = 1;
                foreach($rooms_ids as $room_id)
                {

                    if($room_id != '' && $room_id != null){

                        if(getRoomNameWithRoomId($room_id) != '')
                        {
                            $room_names .= $key.") ".getRoomNameWithRoomId($room_id)."<br>";
                            $key++;
                        }

                    }
                    else{
                        $room_names .= "--";
                    }

                }
            }
            $data->rooms = $room_names;

            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updatePackageDiscountStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $package_options[] = $data;
        }
        return json_encode($package_options);
    }

    public function package_discount_delete(Request $request)
    {
        $countRec = DB::table('discount_offer')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('discount_offer')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_discount_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>');
        }
    }

    public function package_discount_changeactivestatus(Request $request)
    {
        $update = DB::table('discount_offer')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }
    /*Package Discount offer Section*/


    /*Cure and treatment Section*/
    public function cure_treatment(Request $request)
    {

        $data['cures'] = DB::table('cure_treatment')->select('*')->where('id', '!=', 0)->where('type', 1)->where('is_delete', '=', 0)->get();
        $data['treatments'] = DB::table('cure_treatment')->select('*')->where('id', '!=', 0)->where('type', 0)->where('is_delete', '=', 0)->get();

        return view('package.cure_treatment', $data);
    }

    public function cure_treatment_add_edit(Request $request)
    {

        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->options_id)) {

            $action = 'edit';
            $arrDetails = DB::table('cure_treatment')->where(['id' => $request->options_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['cure_treatment'] = $arrDetails;
        }

        return view('package.cure_treatment_add_edit', $arrRecords);
    }

    public function cure_treatment_update(Request $request)
    {
        if (isset($request->options_id) && !empty($request->options_id) && $request->action == 'edit')
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/cure_treatment'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }


            $sale = getPercentage($request->price, $request->discount);
            $net_price = getPercentage($sale, $request->commission);

            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'price' => $request->price,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'discount' => $request->discount,
                'sale' => $sale,
                'commission' => $request->commission,
                'net_price' => $net_price,
                'image' => $imageName,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Db::table('cure_treatment')->where('id', $request->options_id)->update($data);


            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Cure and treatment updated -> (ID:'.$request->options_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_cure_treatment_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/cure_treatment'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }


            $sale = $request->price  - getPercentage($request->price, $request->discount);
            $net_price = $sale - getPercentage($sale, $request->commission);

            $data = [
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'type' => $request->type,
                'description' => $request->description,
                'price' => $request->price,
                'discount' => $request->discount,
                'sale' => $sale,
                'commission' => $request->commission,
                'net_price' => $net_price,
                'image' => $imageName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $last_inserted_id = Db::table('cure_treatment')->insertGetId($data);

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Cure and treatment added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_cure_treatment_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function get_cure_treatment_json(Request $request)
    {

        $cure_treatment = array();
        $options = DB::table('cure_treatment')->select('*')->where('id', '!=', 0)->where('type', $request->type_id)->where('is_delete', '=', 0)->get();
        foreach ($options as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $cur = getActiveCurrency();
            $data->price = $data->price." ".$cur['symbol'];
            $data->discount = $data->discount."%";
            $data->commission = $data->commission."%";
            $data->net_price = $data->net_price." ".$cur['symbol'];

            if($data->image != ''){
                $data->image = '<img src="'.asset('public/images/cure_treatment')."/".$data->image.'" style="width:60px;">';
            }
            else{
                $data->image = '<img src="'.asset('public/images/default/default_cure_treatment.jpg').'" style="width:60px;">';
            }

            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updatePackageOptionsStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $cure_treatment[] = $data;
        }
        return json_encode($cure_treatment);
    }

    public function cure_treatment_delete(Request $request)
    {
        $countRec = DB::table('cure_treatment')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('cure_treatment')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_package_option_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>user not Exist!</div>');
        }
    }

    public function cure_treatment_changeactivestatus(Request $request)
    {
        $update = DB::table('cure_treatment')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }
    /*Cure and treatment Section*/

}