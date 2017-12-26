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

class ReviewController extends Controller
{
    public function reviews()
    {
        return view('review.index');
    }

    public function review_add_edit(Request $request)
    {
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->review_id)) {

            $action = 'edit';
            $arrDetails = DB::table('reviews')->where(['id' => $request->review_id, 'is_deleted' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['reviews'] = $arrDetails;
        }

        return view('review.review_add_edit', $arrRecords);
    }

    public function get_reviews_json(Request $request)
    {
        $review_options = array();
        $options = DB::table('reviews as r')->select('r.*', 'u.name as user_name', 'hm.name as hotel_name')
                    ->leftJoin('users as u', 'r.user_id' , '=', 'u.id')
                    ->leftJoin('hotel_main as hm', 'hm.id', '=', 'r.hotel_id')
                    ->where('r.id', '!=', 0)->where('r.is_deleted', '=', 0)->get();
        $user_type = getUserTypeByUserID(Auth::user()->id);
        
        
        
        foreach ($options as $data) {
            
            $hotel_id = $data->hotel_id;
            $booking_id = $data->booking_id;
            
            $checked_active = ($data->is_active == 0) ? 'checked' : '';
            $data->is_active = '<div class="switch"><input name="status" class="currencytogal" onchange="updateReviewStatus(' . (!empty($data->id) ? $data->id : '0' ). ')" id="activestatus_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked_active . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';





            $data->edit_review = '<div class="table-btn"><a href="#" data-toggle="modal" data-target="#editReviewModal"  data-hotel-id="'.$hotel_id.'" data-booking-id="'.$booking_id.'" onclick="getHotelAndBookingId(this)" class="btn btn-edit""><i class="fa fa-pencil"></i></a></div>';
            $data->client_name = $data->user_name;

            $data->hotel_id = $data->hotel_id." | ".$data->hotel_name;


            $review_options[] = $data;
        }
        return json_encode($review_options);
    }

    public function getAjaxHotelAndBookingId(Request $request)
    {
        $review = DB::table('reviews')->where('id', $request->id)->first();
        $booking_id = $review->booking_id;
        $hotel_id = $review->hotel_id;
    
        //$data = array('booking_id' => $booking_id, 'hotel_id' => $hotel_id);
        $data = array($booking_id, $hotel_id);
        return json_encode($data);
    }
    
    public function reviews_update(Request $request)
    {
        if (isset($request->review_id) && !empty($request->review_id) && $request->action == 'edit')
        {
            /*array to insert in review table*/
            $data = [
                'code' => $request->code,
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'price' => $request->price,
                'description' => $request->description,
                'updated_at' => $request->updated_at,
                'is_active' => isset($request->is_active) ? $request->is_active : '1'
            ];

            Db::table('reviews')->where('id', $request->review_id)->update($data);
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'reviews updated -> (ID:'.$request->review_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_review_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else
        {

            /*array to insert in review table*/
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

            $last_inserted_id = Db::table('reviews')->insertGetId($data);
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'reviews added -> (ID:'.$request->review_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_review_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
    }

    public function reviews_changeactivestatus(Request $request)
    {
        $update = DB::table('reviews_non_json')->where('id', $request->id)->first();
        $booking_id = $update->booking_id;
        
        $u = DB::table('reviews_non_json')->where('booking_id', $booking_id)->update(array('is_active' => $request->status));
        return ($u) ? 'true' : 'false';
    }

    public function reviews_changeconfirmation(Request $request)
    {
        $update = DB::table('reviews_non_json')->where('id', $request->id)->first();
        $booking_id = $update->booking_id;
    
        $u = DB::table('reviews_non_json')->where('booking_id', $booking_id)->update(array('is_active' => $request->status));
        return ($u) ? 'true' : 'false';
    }

    public function reviews_delete(Request $request)
    {
        $countRec = DB::table('reviews_non_json')->select('*')->where('id', $request->id)->first();
        $booking_id = $countRec->booking_id;
        
        //dd($countRec);
        if (isset($booking_id)) {
            DB::table('reviews_non_json')->where('booking_id', $booking_id)->update(array('is_deleted' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_review_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_review_not_exist').'</div>');
        }
    }

}
