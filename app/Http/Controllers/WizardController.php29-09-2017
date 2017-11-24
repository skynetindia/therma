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
        $this->middleware('auth');
    }

    public function categorylist()
    {
        return view('wizard.category_list');
    }

    public function categoryaddedit(Request $request)
    {
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
        if(isset($request->parent_category_id) && !empty($request->parent_category_id) && $request->action =='edit' ) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50'
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50'
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
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Category updated successfully!</div>';

            //update in language table
            $arrlanguages = getlanguages();
            $categorynamelang = strtolower(str_replace(" ", "_", $request->name));
            $name_key = 'keyword_'.$categorynamelang.$request->parent_category_id.'_name';

            $text_information = array(
                'name'=>$name_key
            );

            foreach ($arrlanguages as $keylang => $valuelang)
            {
                $arrResponsevalue = array('name'=>$request['text_name_'.$valuelang->code]);

                foreach ($text_information as $keyl => $valuel) {
                    $language_transalation = DB::table('language_transalation')
                        ->where(['language_key'=>$valuel,'code'=>$valuelang->code])
                        ->first();

                    $label = str_replace("_", " ", $valuel);
                    $language_value = $arrResponsevalue[$keyl];
                    $arrlang=['language_label'=>$label,
                        'language_value' => $language_value,
                        'code' => $valuelang->code];


                    if(count($language_transalation) > 0) {
                        DB::table('language_transalation')
                            ->where('language_key', $valuel)
                            ->where('code', $valuelang->code)
                            ->update($arrlang);
                        /*print_r($arrlang);
                        echo '<br>';*/

                    }
                    else {
                        $arrlang['language_key'] = $valuel;
                        DB::table('language_transalation')->insert($arrlang);
                    }

                }

            }

        }
        else{

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
            if($get_level == null)
            {
                $level = 1;
            }  else{
                $level = $get_level->level + 1;
            }

            $level_data = [
                'level' => $level
            ];
            DB::table('wizard_categories')->where('id', $last_added_id)->update($level_data);


            /* Store the log details */
            $logs = 'Category Added -> (ID:'.$last_added_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Category added successfully!</div>';

            //update in language table
            $arrlanguages = getlanguages();
            $categorynamelang = strtolower(str_replace(" ", "_", $request->name));
            $name_key = 'keyword_'.$categorynamelang.$last_added_id.'_name';

            $text_information = array(
                'name'=>$name_key
            );

            foreach ($arrlanguages as $keylang => $valuelang)
            {
                $arrResponsevalue = array('name'=>$request['text_name_'.$valuelang->code]);

                foreach ($text_information as $keyl => $valuel) {
                    $language_transalation = DB::table('language_transalation')
                        ->where(['language_key'=>$valuel,'code'=>$valuelang->code])
                        ->first();

                    $label = str_replace("_", " ", $valuel);
                    $language_value = $arrResponsevalue[$keyl];
                    $arrlang=['language_label'=>$label,
                        'language_value' => $language_value,
                        'code' => $valuelang->code];


                    if(count($language_transalation) > 0) {
                        DB::table('language_transalation')
                            ->where('language_key', $valuel)
                            ->where('code', $valuelang->code)
                            ->update($arrlang);
                        /*print_r($arrlang);
                        echo '<br>';*/

                    }
                    else {
                        $arrlang['language_key'] = $valuel;
                        DB::table('language_transalation')->insert($arrlang);
                    }

                }

            }
        }

        return Redirect::back()->with('msg', $msg);

    }

    public function deletecategories(Request $request) {
        $countRec = DB::table('wizard_categories')->select('*')->where('id', $request->id)->count();
        dd($countRec);
        if($countRec > 0){
            DB::table('wizard_categories')->where('id',$request->id)->update(array('is_deleted' =>'1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Category removed successfully</div>');
        }
        else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Category not Exist!</div>');
        }
    }


    public function updatecategorystatus(Request $request)
    {
        $update = DB::table('wizard_categories')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function getjsoncategoryproperty(Request $request) {
        $hotelDetails = array();
        $hotel_main = DB::table('wizard_categories')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0)->get();
        foreach($hotel_main as $data) {
            $checked = ($data->is_active==0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateCategoryStatus('.$data->id.')" id="activestatus_'.$data->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$data->id.'"></label></div>';
            $data->preference = '0';
            $data->commissions = '0';
            /*if($data->icon != ""){
                $data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';
            }*/
            $hotelDetails[] = $data;
        }
        return json_encode($hotelDetails);
    }
}
