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



class WizardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function categorylist()
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        
        return view('wizard.category_list');
    }

    public function categoryaddedit(Request $request)
    {
    
        if(!checkpermission($this->module_id,$this->parent_id, 1))
        {
            return redirect('/unauthorized');
        }
        
        $action = 'add';
        $categories = DB::table('wizard_categories')->where('is_deleted','0')->orderby('name','asc')->get()->toArray();
        //dd($categories);

        $arrRecords = [
            'action'=>'add',
            'categories'=>$categories,
        ];


        if(isset($request->category_id))
        {

            $action = 'edit';
            $arrDetails = DB::table('wizard_categories')->where(['id'=>$request->category_id,'is_deleted'=>'0'])->first();


            $arrRecords['action'] = 'edit';
            $arrRecords['categorydetails'] = $arrDetails;
        }

        return view('wizard.categoryaddedit', $arrRecords);
    }

    public function savecategory(Request $request)
    {
        if(isset($request->parent_category_id) && !empty($request->parent_category_id) && $request->action == 'edit'){
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
            ]);
        }
        else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50|unique:wizard_categories',
            ]);
        }

        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }


        if(isset($request->parent_category_id) && !empty($request->parent_category_id) && $request->action == 'edit') {
            $categorydetails = DB::table('wizard_categories')->select('*')->where('id', $request->parent_category_id)->first();

            $cat_data = [
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'parent_id' => isset($request->parent_id) ? $request->parent_id : '',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            //dd($cat_data);
            DB::table('wizard_categories')->where('id', $request->parent_category_id)->update($cat_data);


            /*update level*/
            $get_level = DB::table('wizard_categories')->select('level')->where('id', $request->parent_id)->get()->first();
            //dd($get_level);
            $level = 0;
            if($get_level == null)
            {
                $level = 1;
            }  else{
                $level = $get_level->level + 1;
            }

            $level_data = [
                'level' => $level
            ];

            DB::table('wizard_categories')->where('id', $request->parent_category_id )->update($level_data);



            /* Store the log details */
            $logs = 'Category Updated -> (ID:'.$request->parent_category_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_category_updated_successfully').'</div>';

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);

        }
        else {

            $cat_data = [
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'parent_id' => isset($request->parent_id) ? $request->parent_id : '',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $last_added_id = DB::table('wizard_categories')->insertGetId($cat_data);


            /*update level*/
            $get_level = DB::table('wizard_categories')->select('level')->where('id', $request->parent_id)->get()->first();
            $level = 0;
            if ($get_level == null) {
                $level = 1;
            } else {
                $level = $get_level->level + 1;
            }

            $level_data = [
                'level' => $level
            ];
            DB::table('wizard_categories')->where('id', $last_added_id)->update($level_data);


            /* Store the log details */
            $logs = 'Category Added -> (ID:' . $last_added_id . ')';
            storelogs($request->user()->id, $logs);
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_category_added_successfully').'</div>';

            //update in language table
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);
        }
        return Redirect::back()->with('msg', $msg);

    }

    public function deletecategory(Request $request) {
        $countRec = DB::table('wizard_categories')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if($countRec > 0){
            DB::table('wizard_categories')->where('id',$request->id)->update(array('is_deleted' =>'1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_category_removed_successfully').'</div>');
        }
        else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_category_not_exist').'</div>');
        }
    }


    public function updatecategorystatus(Request $request)
    {
        $update = DB::table('wizard_categories')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function getjsoncategoryproperty(Request $request) {
        $categoryDetails = array();
        $category = DB::table('wizard_categories')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0)->get();
        foreach($category as $data) {
            $checked = ($data->is_active==0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateCategoryStatus('.$data->id.')" id="activestatus_'.$data->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$data->id.'"></label></div>';
            $get = DB::table('wizard_categories')->select('*')
                ->where(['id'=>$data->parent_id,'is_deleted'=>0])
                ->first();
            $data->parent_id = isset($get->name) ? $data->parent_id." | ".$get->name   : '-';
            $data->preference = '0';
            $data->commissions = '0';
            /*if($data->icon != ""){
                $data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';
            }*/
            $categoryDetails[] = $data;
        }
        return json_encode($categoryDetails);
    }


    /*
     *  Options Section
    */
    public function optionslist($category_id = '') {
        $categoryitem = DB::table('wizard_categories')->select('*')
            ->where('id',$category_id)
            ->where('is_deleted', '=', 0)->first();

        return view('wizard.options_list', ['category'=>$categoryitem]);
    }

    public function getjsonoptions(Request $request)
    {
        $optionsDetails = array();
        $options = array();
        if (isset($request->category_id)) {
            $options = DB::table('wizard_options')->select('*')->where('id', '!=', '0')->where('category_id', '=', $request->category_id)->where('is_deleted', '=', 0)->get();
        }

        foreach ($options as $data) {
            //pre($data);
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->icon = '<i class="'.$data->icon.'"></i>';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateoptionsStatus(' . $data->id . ')" id="activestatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';

            $optionsDetails[] = $data;
        }
        return json_encode($optionsDetails);
    }


    public function optionsaddedit(Request $request)
    {
        $categories = DB::table('wizard_categories')->where(['is_deleted'=>'0','id'=>$request->category_id])->orderby('name','asc')->first();

        $action='add';
        $optionType = array();
        if(isset($request->id)) {
            $option = DB::table('wizard_options')->where(['id'=>$request->id,'is_deleted'=>'0'])->first();
            if(isset($option->id)) {
                $optionType = DB::table('wizard_options_type')->where(['option_id'=>$option->id,'is_deleted'=>'0'])->get();
            }
            $arrRecords['optionsdetails'] = $option;
            $action = 'edit';
        }

        $arrRecords['optionstype'] = $optionType;
        $arrRecords['categories'] =$categories;
        $arrRecords['action'] = $action;
        return view('wizard.optionsaddedit', $arrRecords);
    }

    public function saveoptions(Request $request)
    {
        if (isset($request->options_id) && !empty($request->options_id) && $request->action == 'edit') {
            $icon = $request->old_icon;
            if(isset($request->icon) && $request->icon != '') {
                $icon = $request->icon;
            }


            $name = $request->options;
            $wizardoptions['user_id'] = $request->user()->id;
            if(isset($request->category_id) && $request->category_id != null)
            {
                $wizardoptions['category_id'] = $request->category_id;
            }
            else{
                $wizardoptions['category_id'] = $request->parent_category;
            }
            $wizardoptions['title'] = $name;
            $wizardoptions['icon'] = $icon;
            $wizardoptions['description'] = $request->description;
            $wizardoptions['is_language'] = isset($request->is_language) ? '1' : "0";

            //$name_key = str_replace(" ", "_", $name);
            $name_key = str_replace(" ", "_", strtolower($name));

            $wizardoptions['language_key'] = 'keyword_' . $name_key;
            DB::table('wizard_options')->where('id',$request->options_id)->update($wizardoptions);

            //update in language table
            $lang_data = [
                'title' => $name,
            ];

            language_keyword_add($lang_data);

            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_options_updated_successfully').'</div>';

        }
        else{

            $name = $request->options;


            $wizardoptions['user_id'] = $request->user()->id;
            if(isset($request->category_id) && $request->category_id != null)
            {
                $wizardoptions['category_id'] = $request->category_id;
            }
            else{
                $wizardoptions['category_id'] = $request->parent_category;
            }

            $wizardoptions['title'] = $name;
            $wizardoptions['icon'] = $request->icon;
            $wizardoptions['description'] = $request->description;
            $wizardoptions['is_language'] = isset($request->is_language) ? '1' : "0";

            //$name_key = str_replace(" ", "_", $name);
            $name_key = str_replace(" ", "_", strtolower($name));


            $wizardoptions['language_key'] = 'keyword_' . $name_key;
            DB::table('wizard_options')->insertGetId($wizardoptions);

            //update in language table
            $lang_data = [
                'title' => $name,
            ];

            language_keyword_add($lang_data);

            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_options_added_successfully').'</div>';
        }


        //return Redirect('wizard/options/'.$request->category_id);
        return Redirect::back()->with('msg', $msg);

    }




    public function deleteoptions(Request $request)
    {


        $countRec = DB::table('wizard_options')->select('*')->where('id', $request->id)->count();

        if($countRec > 0){
            $test = DB::table('wizard_options')->where('id',$request->id)->update(array('is_deleted' =>'1'));

            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_options_removed_successfully').'</div>');
        }
        else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_options_not_exist').'</div>');
        }
    }


    public function updateoptionsstatus(Request $request)
    {
        $update = DB::table('wizard_options')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function fetch_subcategory(Request $request)
    {
        $category_id = $request->category_id;

        $sub_categories = DB::table('wizard_categories')
            ->select('id', 'name')
            ->where(array('parent_id' => $category_id, 'is_active'=> 0, 'is_deleted'=>0))
            ->orderBy('name', 'asc')->get();

        pre($sub_categories);

        if(count($sub_categories) > 0)
        {
            echo "<option value=''>".trans('messages.keyword_--select--')."</option>";
            foreach($sub_categories as $key => $value)
            {
                echo "<option value='".$value->id."' ".((isset($request->subcategory_id) &&$value->id == $request->subcategory_id) ? 'selected' : '').">".$value->name."</option>";
            }
        } else {
            echo "<option value=''>-- ".trans('messages.keyword_no_subcategories')."</option>";
        }

    }


}
