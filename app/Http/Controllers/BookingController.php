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
use DateInterval;
use DatePeriod;
use DateTime;
use Cookie;
use Carbon\Carbon;

class BookingController extends Controller
{
    private $minstay = 0;
    private $release = 0;    
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('auth');
    }
    
    /* ======================================  Bookings Section ==========================================================*/
    public function bookings(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        return view('booking.bookings');
    }
    
    public function bookingdetail(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        
        $booking = DB::table('booking_order as b')
            ->select('b.*', 'h_m.name as hotel_name', 'h_m.id as hotel_id', 'h_c.title as category_title', 't.unique_transfer_id as transfer_id', 'bd.client_name as client_name', 'bd.details_of_members', 'h_m.commission as commission', 'h_m.treatment_commission as treatment_commission', 'rd.personal_name as room_name', 'bd.note as note')
            ->leftJoin('booking_detail as bd', 'bd.booking_id', '=', 'b.id')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('room_details as rd', 'rd.id', '=', 'b.room_id')
            ->leftJoin('transfer as t', 'b.id', '=', 't.booking_id')
            ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id');
        if (Auth::user()->profile_id != 0) {
            $booking = $booking->where('h_m.id', Auth::user()->hotel_id);
        }
        $booking = $booking->where('b.id', '=', $request->booking_id)->where('b.is_deleted', '=', 0)->first();
        
        $arrayData['booking'] = $booking;
        
        return view('booking.booking_detail', $arrayData);
    }
    
    public function getjsonbookingsproperty(Request $request)
    {
        $orderlist = getClientStatus();
        $bookingDetails = array();
        $booking = DB::table('booking_order as b')->select('b.*', 'h_m.name as hotel_name', 'h_c.title as category_title', 'h_m.commission')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id');
        $hotelEmotionalStatus = getEmotionalStatus();
        
        if (Auth::user()->profile_id != 0) {
            $booking = $booking->where('h_m.id', Auth::user()->hotel_id);
        }
        $booking = $booking->where('b.id', '!=', 0)->where('b.is_deleted', '=', 0)->get();
        foreach ($booking as $data) {
            $cur = getActiveCurrency();
            $uniqueToSendInModal = $data->temp_booking_id;
            
            $data->temp_booking_id = '<a href="' . url('booking/detail') . '/' . $data->id . '" style="cursor: pointer">' . $data->temp_booking_id . '</a>';
            
            $hotel_id = $data->hotel_id;
            $data->hotel_id = $data->hotel_name . " <br> " . $data->category_title;
            $checked = ($data->hotel_status == 1) ? 'checked' : '';
            $classhotel_status = 'red';
            /*$q = DB::table('emotional_status')->where('id',$data->hotel_status)->first();
            $classhotel_status = isset($q->color) ? $q->color : '';*/
            $classhotel_status = 'yellow';
            if ($data->hotel_status == 0) {
                $classhotel_status = 'red';
            } elseif ($data->hotel_status == 1) {
                $classhotel_status = 'green';
            }
            
            $HotelStatus = '<div class="radio-btn-custom">';
            foreach ($hotelEmotionalStatus as $keyHStatus => $valHStatus) {

                $selectedHStatus = ($data->hotel_status == $valHStatus->id) ? 'checked' : '';
    
                
                    $HotelStatus .= '<div class="radio-inline">
                            <input id="logincheck' . $data->id . '_' . $valHStatus->id . '" name="radio-group-' . $data->id . '" ' . $selectedHStatus . ' type="radio" value="' . $valHStatus->id . '" onclick="return updatehotelStatus(' . (!empty($data->id) ? $data->id : '0') . ',this)">
							<label for="logincheck' . $data->id . '_' . $valHStatus->id . '" title="' . trans("messages." . $valHStatus->language_key) . '" class="' . $classhotel_status . '"  style="background:' . $valHStatus->color . ';box-shadow: ' . $valHStatus->color . ' 0px 0px 5px 1px;"></label>
                                </div>';
                
    
                $HotelStatus .= '<div class="radio-inline">
                            <input id="logincheck' . $data->id . '_' . $valHStatus->id . '" name="radio-group-' . $data->id . '" ' . $selectedHStatus . ' type="radio" value="' . $valHStatus->id . '" onclick="return updatehotelStatus(' . (!empty($data->id) ? $data->id : '0') . ',this)">
							<label for="logincheck' . $data->id . '_' . $valHStatus->id . '" title="' . trans("messages." . $valHStatus->language_key) . '" class="' . $classhotel_status . '"  style="background:' . $valHStatus->color . ';box-shadow: ' . $valHStatus->color . ' 0px 0px 5px 1px;"></label>
                                </div>';
            }
            $HotelStatus .= '</div>';
            $data->hotel_status = $HotelStatus;
            
            /*$data->hotel_status = '<div class="switch"><input name="hotel_status" class="currencytogal" onclick="updatehotelStatus(' .(!empty($data->id) ? $data->id : '0' ). ')" id="hotel_status_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="hotel_status_' . $data->id . '"></label></div>';*/
            $data->arrival = date("Y-m-d", strtotime($data->arrival));
            $data->departure = date("Y-m-d", strtotime($data->departure));
            $data->name = $data->name . " (" . countrycode($data->country) . ")";
            $data->commission = round((($data->total_fare * $data->commission) / 100), 2);
            //$data->city = $data->city . ", " . $data->country;
            if ($data->cart == 1) {
                $data->cart = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
							<label for="logincheck1"></label>                    
                                </div>';
            } else {
                $data->cart = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
							<label for="logincheck2" class="red"></label>                    
                                </div>';
            }
            if ($data->is_transfer == 1) {
                $data->transfer = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
								<label for="logincheck1"></label>                    
                                </div>';
            } else {
                $data->transfer = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
                              <label for="logincheck2" class="red"></label>                    
                                </div>';
            }
            if ($data->order_status == 1 || $data->order_status == 3) {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
							<label for="logincheck1">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            } else if ($data->order_status == 2) {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
								<label for="logincheck2" class="red">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            } else {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
								<label for="logincheck2" class="yellow">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            }
            
            $data->who_booked = getUserTypesById(getUserTypeIDFromUserID($data->user_id)); //getUserTypesById($data->who_booked);
            /* Notes */
            $data->notes = '<a class="" href="#" onclick="getNotesIdToModal(this)" data-unique-id="' . $uniqueToSendInModal . '" data-id="' . $data->id . '" data-toggle="modal" data-target="#notesModal">' . trans('messages.keyword_view') . '</a>';
            /* Notes */
            /* Reviews */
            $data->reviews = '<a class="" href="#" data-toggle="modal" data-hotel-id="' . $hotel_id . '" data-booking-id="' . $data->id . '" onclick="getBookingId(this)" data-target="#reviewModal">' . trans('messages.keyword_view') . '</a>';
            /* Reviews */
            $data->price = $data->price . " " . $cur['symbol'];
            $checked = ($data->checked == 1) ? 'checked' : '';
            //$data->confirm = '<div class="switch"><input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label></div>';
            $data->checked = '<input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label>';
            $bookingDetails[] = $data;
            
        }
        
        return json_encode($bookingDetails);
        
    }
    
    public function updatebookingconfirmstatus(Request $request)
    {
        
        $update = DB::table('booking_order')->where('id', $request->id)->update(array('checked' => $request->status));
        
        return ($update) ? 'true' : 'false';
        
    }
    
    public function changeconfirmhotel(Request $request)
    {
        
        $update = DB::table('booking_order')->where('id', $request->id)->update(array('hotel_status' => $request->status));
        
        return ($update) ? 'true' : 'false';
        
    }
    /* public function getjsonbookingsproperty(Request $request)
     {
         $bookingDetails = array();
         $booking  = DB::table('bookings as b')->select('b.*', 'h_m.name as hotel_name', 'h_c.title as category_title', 'e_s.name as hotel_status_name')
             ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
             ->leftJoin('emotional_status as e_s', 'e_s.id', '=', 'b.hotel_status')
             ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id')
             ->where('b.id', '!=', 0)->where('b.is_deleted', '=', 0)->get();
 
 
         foreach ($booking as $data) {
             $cur = getActiveCurrency();
 
             $uniqueToSendInModal = $data->unique_booking_id;
             $data->unique_booking_id = '<a href="'.url('booking/detail').'/'.$data->id.'" style="cursor: pointer">'.$data->unique_booking_id.'</a>';
             $data->hotel_status = $data->hotel_status." | ".$data->hotel_status_name;
             $data->hotel_id = $data->hotel_name." <br> ".$data->category_title;
             $data->client_name = $data->client_name." (".$data->country.")";
             $data->city = $data->city.", ".$data->country;
 
 
             if($data->cart == '0')
             {
                 $data->cart = '<div class="radio-btn-custom">
                             <input id="logincheck1" name="radio-group" type="radio">
                             <label for="logincheck1"></label>
                         </div>';
             }
             else{
                 $data->cart = '<div class="radio-btn-custom">
                             <input id="logincheck2" name="radio-group" type="radio">
                             <label for="logincheck2" class="red"></label>
                         </div>';
             }
 
             if($data->transfer == '0')
             {
                 $data->transfer = '<div class="radio-btn-custom">
                             <input id="logincheck1" name="radio-group" type="radio">
                             <label for="logincheck1"></label>
                         </div>';
             }
             else{
                 $data->transfer = '<div class="radio-btn-custom">
                             <input id="logincheck2" name="radio-group" type="radio">
                             <label for="logincheck2" class="red"></label>
                         </div>';
             }
 
 
             if($data->client_status == '1' || $data->client_status == '2')
             {
                 $data->client_status = '<div class="radio-btn-custom">
                             <input id="logincheck1" name="radio-group" type="radio">
                             <label for="logincheck1"></label>
                         </div>';
             }
             else{
                 $data->client_status = '<div class="radio-btn-custom">
                             <input id="logincheck2" name="radio-group" type="radio">
                             <label for="logincheck2" class="red"></label>
                         </div>';
             }
 
 
             $data->who_booked = getUserTypesById($data->who_booked);
 
             /*Notes
             $data->notes = '<a class="" href="#" onclick="getNotesIdToModal(this)" data-unique-id="'.$uniqueToSendInModal.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#notesModal">'.trans('messages.keyword_views').'</a>';
             /*Notes
 
             /*Reviews
             $data->reviews = '<a class="" href="#" data-toggle="modal" data-target="#reviewModal">'.trans('messages.keyword_reviews').'</a>';
             /*Reviews
 
 
             $data->price = $data->price." ".$cur['symbol'];
             $checked = ($data->confirm == 1) ? 'checked' : '';
             //$data->confirm = '<div class="switch"><input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label></div>';
             $data->confirm = '<input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label>';
             $bookingDetails[] = $data;
         }
         return json_encode($bookingDetails);
     }
 
     public function updatebookingconfirmstatus(Request $request)
     {
         $update = DB::table('bookings')->where('id', $request->id)->update(array('confirm' => $request->status));
         return ($update) ? 'true' : 'false';
     }
     */
    
    /* public function bookingdelete(Request $request)
     {
         $countRec = DB::table('bookings')->select('*')->where('id', $request->id)->count();
         if ($countRec > 0) {
             DB::table('bookings')->where('id', $request->id)->update(array('is_deleted' => '1'));
             DB::table('bookings_notes')->where('booking_id', $request->id)->delete();
             return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_removed_successfully').'</div>');
         } else {
             return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_not_exist').'</div>');
         }
     }*/
    public function bookingdelete(Request $request)
    {
        $orderlist = getClientStatus();
        $countRec = DB::table('booking_order')->select('*')->where('id', $request->id)->count();
        if ($countRec > 0) {
            DB::table('booking_order')->where('id', $request->id)->update(array('is_deleted' => '1'));
            //DB::table('bookings_detail')->where('booking_id', $request->id)->delete();
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_booking_removed_successfully') . '</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_booking_not_exist') . '</div>');
        }
    }
    
    public function bookings_search(Request $request)
    {
        DB::enableQueryLog();
        $orderlist = getClientStatus();
        /*	          $booking = DB::table('booking_order as b')->select('b.*', 'h_m.name as hotel_name', 'h_c.title as category_title','h_m.commission')
                                ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
                                ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id')
                                ->where('b.id', '!=', 0)->where('b.is_deleted', '=', 0)->get();*/
        $hotelEmotionalStatus = getEmotionalStatus();
        $booking = DB::table('booking_order as b')->select('b.*', 'b.id as booking_id', 'h_m.name as hotel_name', 'h_c.title as category_title', 'e_s.name as hotel_status_name', 'h_m.commission', 'h_m.status as hotel_status_id')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id')
            /*->leftJoin('currency as c', 'b.currency_id', '=', 'c.id')*/
            ->leftJoin('emotional_status as e_s', 'e_s.id', '=', 'h_m.status')
            ->where('b.id', '!=', '0')->where('b.is_deleted', '=', '0');
        
        
        if (isset($request->general_search) && $request->general_search != "") {
            /*$booking = $booking->where('b.temp_booking_id', '=' ,$request->general_search);*/
            $find = $request->general_search;
            $booking = $booking->where(function ($query) use ($find) {
                $query->orWhere('b.temp_booking_id', $find)
                    ->orwhere('b.name', 'like', '%' . $find . '%')
                    ->orwhere('b.phone', 'like', '%' . $find . '%')
                    ->orwhere('b.email', 'like', '%' . $find . '%');
            });
            
        }
        if (isset($request->client_status)) {
            $booking = $booking->where('b.order_status', '=', $request->client_status);
        }
        if (isset($request->hotel_status)) {
            $booking = $booking->where('b.hotel_status', '=', $request->hotel_status);
        }
        if (isset($request->arrival) && isset($request->departure)) {
            $booking = $booking->where('b.arrival', '>=', Carbon::parse($request->arrival)->toDateString('y-m-d'));
            $booking = $booking->where('b.departure', '<=', Carbon::parse($request->departure)->toDateString('y-m-d'));
        }
        if (isset($request->booking_status)) {
            $booking = $booking->where('b.is_active', '=', $request->booking_status);
        }
        if (isset($request->booking_country)) {
            $booking = $booking->where('b.country', '=', $request->booking_country);
        }
        if (isset($request->transfer)) {
            $booking = $booking->where('b.is_transfer', '=', $request->transfer);
        }
        if (isset($request->currency)) {
            $booking = $booking->where('b.currency_code', '=', $request->currency);
        }
        if (isset($request->cart_guarantee)) {
            $booking = $booking->where('b.cart', '=', $request->cart_guarantee);
        }
        
        /*if(isset($request->user_type))
        {
            $booking->where('b.who_booked', '=' ,$request->user_type);
        }*/
        if (isset($request->hotel_list)) {
            $booking = $booking->where('b.hotel_id', '=', $request->hotel_list);
        }
        
        $booking = $booking->get();
        //dd(DB::getQueryLog());
        $bookingDetails = array();
        foreach ($booking as $data) {
            $cur = getActiveCurrency();
            $uniqueToSendInModal = $data->temp_booking_id;
            
            $data->temp_booking_id = '<a href="' . url('booking/detail') . '/' . $data->id . '" style="cursor: pointer">' . $data->temp_booking_id . '</a>';
            
            $data->hotel_id = $data->hotel_name . " <br> " . $data->category_title;
            /*$checked = ($data->hotel_status == 1) ? 'checked' : '';
			$data->hotel_status = '<div class="switch"><input name="hotel_status" class="currencytogal" onclick="updatehotelStatus(' .(!empty($data->id) ? $data->id : '0' ). ')" id="hotel_status_' . (!empty($data->id) ? $data->id : '0' ). '" ' . $checked . ' value="1"  type="checkbox"><label for="hotel_status_' . $data->id . '"></label></div>';
*/
            $classhotel_status = 'red';
            $HotelStatus = '<div class="radio-btn-custom">';
            foreach ($hotelEmotionalStatus as $keyHStatus => $valHStatus) {
                $selectedHStatus = ($data->hotel_status == $valHStatus->id) ? 'checked' : '';
                $HotelStatus .= '<div class="radio-inline">
                            <input id="logincheck' . $data->id . '_' . $valHStatus->id . '" name="radio-group-' . $data->id . '" ' . $selectedHStatus . ' type="radio" value="' . $valHStatus->id . '" onclick="return updatehotelStatus(' . (!empty($data->id) ? $data->id : '0') . ',this)">
							<label for="logincheck' . $data->id . '_' . $valHStatus->id . '" title="' . trans("messages." . $valHStatus->language_key) . '" class="' . $classhotel_status . '" style="background:' . $valHStatus->color . ';box-shadow: ' . $valHStatus->color . ' 0px 0px 5px 1px;"></label>
                                </div>';
            }
            $HotelStatus .= '</div>';
            $data->hotel_status = $HotelStatus;
            
            $data->arrival = date("Y-m-d", strtotime($data->arrival));
            $data->departure = date("Y-m-d", strtotime($data->departure));
            $data->name = $data->name . " (" . countrycode($data->country) . ")";
            $data->commission = round((($data->total_fare * $data->commission) / 100), 2);
            //$data->city = $data->city . ", " . $data->country;
            if ($data->cart == 1) {
                $data->cart = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
							<label for="logincheck1"></label>                    
                                </div>';
            } else {
                $data->cart = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
							<label for="logincheck2" class="red"></label>                    
                                </div>';
            }
            if ($data->is_transfer == 1) {
                $data->transfer = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
								<label for="logincheck1"></label>                    
                                </div>';
            } else {
                $data->transfer = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
                              <label for="logincheck2" class="red"></label>                    
                                </div>';
            }
            if ($data->order_status == 1 || $data->order_status == 3) {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck1" name="radio-group" type="radio">
							<label for="logincheck1">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            } else if ($data->order_status == 0 || $data->order_status == 2) {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
								<label for="logincheck2" class="red">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            } else {
                $data->order_status = '<div class="radio-btn-custom">
                            <input id="logincheck2" name="radio-group" type="radio">
								<label for="logincheck2" class="yellow">' . $orderlist[$data->order_status] . '</label>
                                </div>';
            }
            
            $data->who_booked = getUserTypesById(getUserTypeIDFromUserID($data->user_id)); //getUserTypesById($data->who_booked);
            /* Notes */
            $data->notes = '<a class="" href="#" onclick="getNotesIdToModal(this)" data-unique-id="' . $uniqueToSendInModal . '" data-id="' . $data->id . '" data-toggle="modal" data-target="#notesModal">' . trans('messages.keyword_views') . '</a>';
            /* Notes */
            /* Reviews */
            $data->reviews = '<a class="" href="#" data-toggle="modal" data-target="#reviewModal">' . trans('messages.keyword_reviews') . '</a>';
            /* Reviews */
            $data->price = $data->price . " " . $cur['symbol'];
            $checked = ($data->checked == 1) ? 'checked' : '';
            //$data->confirm = '<div class="switch"><input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label></div>';
            $data->checked = '<input name="confirm" class="currencytogal" onchange="updateBookingConfirmStatus(' . $data->id . ')" id="confirmstatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="confirmstatus_' . $data->id . '"></label>';
            $bookingDetails[] = $data;
            
        }
//        if(isset($request->hotel_name)){
//            $booking->where('h_m.name', 'like', '%'.$request->hotel_name.'%' );
//        }
//
//        if(isset($request->status_filter)){
//            $booking->where('h_m.status', $request->status_filter);
//        }
        /* $arrayData['filtered_booking'] = $booking->get();*/
        
        $arrayData['filtered_booking'] = $bookingDetails;
        $arrayData['post_data'] = $request;
        return view('booking.bookings_search', $arrayData);
    }
    
    public function getNotes(Request $request)
    {
        $notes = DB::table('bookings_notes as bn')->select('bn.*', 'u.name as username', 'b.unique_booking_id as unique_booking_id')
            ->leftJoin('users as u', 'bn.user_id', '=', 'u.id')
            ->leftJoin('bookings as b', 'bn.booking_id', '=', 'b.id')
            ->where('bn.booking_id', $request->booking_id)->get();
        
        if (count($notes) > 0) {
            foreach ($notes as $note) {
                
                $time = Carbon::parse($note->created_at)->diffForHumans();
                echo "<div class=''>";
                echo "<p><b>" . $note->username . "</b><span class='pull-right'>" . $time . "</span></p>";
                echo "<p>" . $note->description . "</p>";
                echo "</div>";
            }
        } else {
            echo trans('messages.keyword_no_notes_found');
        }
        
        
    }
    
    
    public function getReviews(Request $request)
    {
        
        $reviews_table = DB::table('reviews')->where(['booking_id' => $request->booking_id])->first();
        
        if (count($reviews_table) > 0) {
            $reviews = DB::table("reviews_score as r")->select('r.*', 'wo.title as option_name')
                ->leftJoin('wizard_options as wo', 'r.option_id', '=', 'wo.id')
                ->where('r.review_id', $reviews_table->id)->where('r.is_deleted', '0')->get();
            
            $total = 0;
            $review_title = '';
            $review_description = '';
            if (count($reviews) > 0) {
                foreach ($reviews as $review) {
                    $total += (int)$review->review_score;
                    
                }
            }
            
            $avg = (count($reviews) > 0) ? $total / count($reviews) : '0';
        } else {
            $reviews = '0';
            $avg = 0;
        }
        
        
        // displaying modal body and footer dynamically
        
        echo '<div class="modal-body">';
        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="revie-score">';
        
        
        if (count($reviews_table) > 0):
            $avg = is_int($avg) ? $avg : number_format($avg, 1);
            echo '<blockquote><h3>' . $reviews_table->title . '</h3><p>' . $reviews_table->description . '</p></blockquote>';
            
            echo '<p class="revie-head">your review score</p>
                            <div class="total-revie-score"><span>' . $avg . '</span>based on your review</div>';
            
            foreach ($reviews as $review):
                echo '<div class="score-point">
                                        <p>' . $review->option_name . '</p>
                                        <div class="panel panel-default">
                                            <div class="point-middle">
                                                <div class="point">' . $review->review_score . '</div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                                         aria-valuemin="0" aria-valuemax="100" style="width:' . ($review->review_score * 10) . '%;">
                                                        <span class="sr-only"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            endforeach;
        
        else:
            echo "<p>No reviews for this bookings</p>";
        endif;
        
        
        echo '</div></div></div>'; // over class modal-body, review-score, col-md-12
        
        // modal footer
        echo '<div class="clearfix"></div>';
        
        echo '<div class="modal-footer">';
        if (count($reviews_table) == '0'):
            echo '<button type="button" class="btn btn-primary" data-toggle="modal" onclick="clearModalBody(this)" data-target="#addReviewModal"><i class="fa fa-plus"></i> Add Review</button>';
        endif;
        echo '<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearModalBody(this)">Close</button>';
        echo '</div>';
    }
    
    public function getAddReviews(Request $request)
    {
        //dd($request->all());
        
        if (isset($request->review_id) && $request->action == 'edit') {
            //this function will run when editing review fron review section
            $edit_review_data = DB::table('reviews')->where('id', $request->review_id)->first();
            $edit_review_score_data = DB::table('reviews_score')->where('review_id', $edit_review_data->id)->get();
            $data['edit_review_data'] = $edit_review_data;
            $data['edit_review_score_data'] = $edit_review_score_data;
        }
        
        
        /* This will get single hotel by its id */
        $data['single_hotel'] = DB::table('hotel_main as hm')->select('hm.*', 'hf.set_option as options')
            ->leftJoin('hotel_feature as hf', 'hf.hotel_id', '=', 'hm.id')
            ->where('hm.id', '!=', '0')->where(['hm.id' => $request->hotel_id, 'hm.is_active' => '0', 'hm.is_deleted' => '0'])->first();
        /* This will get single hotel by its id */
        
        
        /*Categories and options drop down*/
        $selected_options = (!empty($data['single_hotel']->options)) ? $data['single_hotel']->options : '';
        if (!empty($selected_options)) {
            $query = 'SELECT wo.id,wo.icon, wo.title, wo.category_id, c.name as category_name FROM wizard_options as wo LEFT JOIN wizard_categories as c ON wo.category_id = c.id WHERE wo.id IN(' . $selected_options . ') GROUP BY c.name ORDER BY c.name';
            $data['categories'] = DB::select($query);
            $data['hotel_id'] = $request->hotel_id;
            $data['booking_id'] = $request->booking_id;
            $data['action'] = $request->action;
            $data['selected_options'] = $selected_options;
        }
        
        return view('booking.modal_add_review', $data);
    }
    
    public function save_reviews(Request $request)
    {
        
        if ($request->action == 'add') {
            /* Using Static User Id now */
            
            $review_data = [
                'hotel_id' => $request->hotel_id,
                //'user_id' => Auth::user()->id,
                'user_id' => 1,
                'booking_id' => $request->booking_id,
                'title' => $request->review_title,
                'description' => $request->review_description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $last_inserted_id = Db::table('reviews')->insertGetId($review_data);
            
            
            if (isset($request->option_id) && isset($request->review_score)) {
                
                
                $reviews_non_json = array_combine($request->option_id, $request->review_score);
                
                
                foreach ($reviews_non_json as $option_id => $score) {
                    $data = [
                        'review_id' => $last_inserted_id,
                        'option_id' => $option_id,
                        'review_score' => $score / 10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    DB::table('reviews_score')->insert($data);
                }
            }
            
            
            $logs = 'reviews added -> (ID:' . $last_inserted_id . ')';
            storelogs(1, $logs);
            
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_review_added_successfully') . '</div>';
        } else {
            
            
            DB::table('reviews_score')->where('review_id', $request->review_id)->delete();
            
            $review_data = [
                'title' => $request->review_title,
                'description' => $request->review_description,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            Db::table('reviews')->where('id', $request->review_id)->update($review_data);
            
            
            if (isset($request->option_id) && isset($request->review_score)) {
                $reviews_non_json = array_combine($request->option_id, $request->review_score);
                
                
                foreach ($reviews_non_json as $option_id => $score) {
                    $data = [
                        'review_id' => $request->review_id,
                        'option_id' => $option_id,
                        'review_score' => $score / 10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    DB::table('reviews_score')->insert($data);
                }
            }
            
            $logs = 'reviews updated -> (ID:' . $request->review_id . ')';
            storelogs(1, $logs);
            
            $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_review_updated_successfully') . '</div>';
        }
        
        
        return Redirect::back()->with('msg', $msg);
    }
    
    
    public function submitNote(Request $request)
    {
        
        $data = [
            'booking_id' => $request->booking_id,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        DB::table('bookings_notes')->insert($data);
        
        $notes = DB::table('bookings_notes as bn')->select('bn.*', 'u.name as username', 'b.unique_booking_id as unique_booking_id')
            ->leftJoin('users as u', 'bn.user_id', '=', 'u.id')
            ->leftJoin('bookings as b', 'bn.booking_id', '=', 'b.id')
            ->where('bn.booking_id', $request->booking_id)->get();
        
        if (count($notes) > 0) {
            foreach ($notes as $note) {
                
                $time = Carbon::parse($note->created_at)->diffForHumans();
                echo "<div class=''>";
                echo "<p><b>" . $note->username . "</b><span class='pull-right'>" . $time . "</span></p>";
                echo "<p>" . $note->description . "</p>";
                echo "</div>";
            }
        } else {
            echo trans('messages.keyword_no_notes_found');
        }
    }
    
    public function getHotelList(Request $request)
    {
        
        $hotels = DB::table('hotel_main')->select('name', 'id')->where('address', 'like', '%' . $request->location . '%')->get();
        
        
        if (count($hotels) > 0) {
            echo "<option>" . trans('messages.keyword_--select--') . "</option>";
            foreach ($hotels as $hotel) {
                echo '<option value="' . $hotel->id . '">' . $hotel->name . '</option>';
            }
        } else {
            echo "<option>" . trans('messages.keyword_--select--') . "</option>";
        }
        
    }
    
    public function booking_conversations_update(Request $request)
    {
        if (isset($request->booking_id) && !empty($request->booking_id)) {
            
            $reply_table_data = [
                'reply_by_admin' => '1',
                'description' => $request->description,
                'booking_id' => $request->booking_id,
                'user_id' => $request->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $last_inserted_id = DB::table('bookings_conversations')->insertGetId($reply_table_data);
            
            /*Update support table updated at field when updating replies*/
            DB::table('bookings')->where('id', $request->bookings_id)->update(['updated_at' => date('Y-m-d H:i:s')]);
            
            
            $logs = 'Replied in Booking Conversations -> (ID:' . $last_inserted_id . ')';
            storelogs($request->user()->id, $logs);
        }
        
        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_you_replied_successfully') . '</div>';
        return Redirect::back()->with('msg', $msg);
    }
    
    public function sendBookingEmail($message, $subject, $toEmail)
    {
        /*echo $message;
        echo '<br>';
        echo $subject;
        echo '<br>';*/
        $toEmail = array_unique($toEmail);
        //print_r($toEmail);
        $toEmail = array('developer3@skynettechnologies.com');
        //echo "======================================================================================";
        //return true;
        $fromemail = config('mail.from.address');
        $fromename = config('mail.from.name');
        
        Mail::send(['html' => 'layouts.mail_content'], ['content' => $message], function ($m) use ($subject, $toEmail, $fromemail, $fromename) {
            $m->from($fromemail, $fromename);
            $m->to($toEmail)->subject($subject);
        });
        return (count(Mail::failures()) > 0) ? false : true;
    }
    
    public function send_confirmation_email(Request $request)
    {
        
        $emailtemplate = DB::table('email_template')->where(['is_active' => 0, 'id' => 1])->first();
        
        //dd($emailtemplate);
        
        //        $otheruser = isset($entity->user_id) ? (DB::table('users')->where('id', $entity->user_id)->first()):array();
        //        if(isset($otheruser->email)){
        //            array_push($toEmail,$otheruser->email);
        //        }
        //        if(isset($supperadmindetails->email)){
        //            array_push($toEmail,$supperadmindetails->email);
        //        }
        
        
        if (isset($emailtemplate->language_key)) {
            //$name = isset($otheruser->name) ? $otheruser->name : $entity->nomereferente;
            //$link ='<a href="'.url('progetti/modify/project/'.$valp->id).'">'.url('progetti/modify/project/'.$valp->id).'</a>';
            
            $tags = [];
            foreach (getEmailTags() as $tag) {
                $tags[] = "[" . $tag->tag . "]";
            }
            pre($tags);
            /* Array
            (
                [0] => [Name]
                [1] => [UserEmail]
                [2] => [Content]
                [3] => [AlertTitle]
                [4] => [FirstName]
                [5] => [LastName]
                [6] => [SiteUrl]
                [7] => [Email]
                [8] => [Signature]
                [9] => [Link]
                [10] => [Title]
            ) */
            
            $name = 'Test';
            $useremail = 'test@gmail.com';
            
            $findReplace = [$tags[0] => $name, $tags[1] => $useremail, $tags[3] => '', $tags[4] => '', $tags[5] => '', $tags[6] => '', $tags[7] => '', $tags[8] => '', $tags[9] => '', $tags[10] => ''];
//            $findReplace = array("[Name]"=>$name,"[Module]"=>'Project',"[ModuleTitle]"=>$valp->nomeprogetto,"[ModuleId]"=>$valp->id,"[UserName]"=>$createruser->name,
//                "[UserEmail]"=>$createruser->email,"[Content]"=>'',"[AlertTitle]"=>'',"[FirstName]"=>$createruser->name,"[LastName]"=>$createruser->name,
//                "[SiteUrl]"=>url('/'),"[Email]"=>$createruser->email,"[Signature]"=>'Regards, Langa Team',"[Link]"=>$link,"[Title]"=>'',"[SiteTitle]"=>'Easy Langa');
            
            $subject = trans('messages.' . $emailtemplate->subject_language_key);
            $message = trans('messages.' . $emailtemplate->language_key);
            $subject = replace_charcter($findReplace, $subject);
            $message = replace_charcter($findReplace, $message);
            
            $message = html_entity_decode($message);
            $mailResponse = $this->sendBookingEmail($message, $subject, $request->email);
            
            if ($mailResponse) {
                echo "working";
            }
            
        }
    }
    
    public function bookingaddedit(Request $request)
    {
        $action = 'add';
        $bookings = DB::table('bookings')->where('is_deleted', '0')->get()->toArray();
        
        
        $arrRecords = [
            'action' => 'add'
        ];
        $country = DB::table('countries')->where('e_status', 1)->get();
        $states = DB::table('states')->where('e_status', 1)->offset(0)->limit(1000)->get();
        if (isset($request->booking_id)) {
            
            $action = 'edit';
            $arrDetails = DB::table('bookings')->where(['id' => $request->booking_id, 'is_deleted' => '0'])->first();
            
            
            $arrRecords['action'] = 'edit';
            $arrRecords['booking'] = $arrDetails;
        }
        $arrRecords['country'] = $country;
        $arrRecords['states'] = $states;
        return view('booking.booking_add_edit', $arrRecords);
    }
    
    public function bookingupdate(Request $request)
    {
        if (isset($request->booking_id) && !empty($request->booking_id) && $request->action == 'edit') {
            dd('update');
        } else {
            
            pre($request->all());
            
            $data = [
            
            ];
            
            
        }
    }
    
    /***********************search Booking Result query*************************************/
    public function getHotelWiseRooms(Request $request)
    {
        if (empty($request->extra_bed))
            $request->extra_bed = 0;
        if (isset($request->arrival))
            $startdate = Carbon::parse($request->arrival)->toDateString('Y-m-d');
        if (isset($request->departure))
            $enddate = Carbon::parse($request->departure)->toDateString('Y-m-d');
        if (empty($request->children))
            $request->children = 0;
        /***********************search Booking Result query*************************************/
        DB::connection()->enableQueryLog();
        $roomdetail = DB::table('room_details as r')->select(DB::raw('r.id,standard_bed,extra_bed,r.hotelid,.p.prices,h.name as hotelname,r.type_of_rooms,personal_name,a.id as aid,a.date as adate,s.season_from,season_to,s.hotel_id as seasonhotel')
            , DB::raw('(r.standard_bed + r.extra_bed) as total_bed'))
            ->join('hotel_main as h', 'h.id', 'r.hotelid')
            ->join('allotment_detail as a', function ($join) use ($request, $startdate, $enddate) {
                $join->on('a.room_id', 'r.id')
                    ->on('a.hotel_id', 'r.hotelid')
                    ->where('a.open', '1');
                if (isset($request->arrival) && isset($request->departure))
                    $join->whereBetween('a.date', array(
                        $startdate,
                        $enddate
                    ));
                
            })
            ->join('hotel_season as s', function ($join1) use ($request, $startdate, $enddate) {
                $join1->on('s.hotel_id', 'r.hotelid');
                if (isset($request->arrival) && isset($request->departure)) {
                    $join1->where('s.season_from', '<=', date('Y-m-d', strtotime($startdate . ' -1days')))
                        ->where('s.season_to', '>=', $enddate);
                    $join1->where('s.is_deleted', 0)
                        ->whereRaw('a.date >= s.season_from')
                        ->whereRaw('a.date <=s.season_to');
                }
            })
            ->join('room_sale_prices as p', function ($join2) {
                $join2->on('p.room_id', 'r.id')
                    ->on('p.hotel_id', 'h.id')
                    ->on('p.season_id', 's.id');
            });
    
    
        if (Auth::user()->profile_id != 0) {
            $roomdetail = $roomdetail->where('h.id', Auth::user()->hotel_id);
        }
        $roomdetail = $roomdetail->where(['h.country' => $request->hotel_country])->where('min_stay', '<=', ($request->adults + $request->children))
            ->groupBy('p.room_id')
            ->havingRaw('total_bed >=' . ($request->adults + $request->children))->get();

        $html = '';
        $childage = [];
        if ($request->children > 0) {
            for ($c = 1; $c <= $request->children; $c++) {
                $varchild = "childage" . $c;
                $childage[] = $request->$varchild;
            }
        }
        if (isset($roomdetail) && count($roomdetail)) {
            $currency = getActiveCurrency();
            $symbol = $currency['symbol'];
            $html .= "<table class='table table-striped table-bordered'>";
            $html .= "<thead><tr>";
            $html .= "<th>" . trans('messages.keyword_hotel_name') . "</th>";
            $html .= "<th>" . trans('messages.keyword_room_name') . "</th>";
            $html .= "<th>" . trans('messages.keyword_price_per_bed') . "</th>";
            $html .= "<th>" . trans('messages.keyword_price_per_night') . "</th>";
            $html .= "<th>" . trans('messages.keyword_discounted_price') . "</th>";
            $html .= "<th>" . trans('messages.keyword_fare_amount') . "</th>";
            $html .= "<th>" . trans('messages.keyword_booking') . "</th>";
            $html .= "<tr></thead><tbody>";
            foreach ($roomdetail as $room) {
                $pricearr = json_decode($room->prices, true);
                $first_key = key($pricearr);
                $price = $pricearr[$first_key];
                $agediscount = DB::table('hotel_agediscount')->where('hotel_id', $room->hotelid)->get();
                $discount = [];
                $totalprice = 0;
                foreach ($agediscount as $akey => $aval) {
                    if ($request->children > 0) {
                        foreach ($childage as $cakey => $caval):
                            if ($aval->age_from <= $caval && $aval->age_to >= $caval)
                                $discount[$caval] = $aval->discount;
                        endforeach;
                    }
                    if ($room->standard_bed < $request->adults && $aval->is_adult == 1)
                        $discount['adult'] = $aval->discount;
                }
                $totalprice = ($room->standard_bed * $price);//($request->adults * $price)
                $discountprice = 0;
                if ($room->standard_bed < $request->adults) {
                    $diff = $request->adults - $room->standard_bed;
                    $discountprice = $diff * (($price * $discount['adult']) / 100);
                    $totalprice += (($diff * $price) - $discountprice);
                }
                
                if ($request->children > 0) {
                    foreach ($childage as $cakey => $caval):
                        $discountp = ($price * $discount[$caval]) / 100;
                        $discountprice += $discountp;
                        $totalprice += ($price - $discountp);
                    endforeach;
                }
                
                
                $html .= "<tr>";
                $html .= "<td>" . $room->hotelid . " | " . $room->hotelname . "</td>";
                $html .= "<td>" . $room->id . " | " . $room->personal_name . "</td>";
                $html .= "<td>" . $price . "</td>"; //number_format($room->price_per_night, 2) . $symbol
                $html .= "<td>" . (($price * $request->adults) + ($price * $request->children)) . "</td>";  //$room->discount . "%
                $html .= "<td>" . ($discountprice) . "</td>"; // . number_format($room->fare_amount, 2) . $symbol .
                $html .= "<td>" . ($totalprice) . "</td>";
                $html .= "<td>";
                $html .= '<form action="' . url('booking/save/stepone/' . $room->hotelid . '/' . $room->id) . '" method="post" >';
                $html .= "<input type='hidden' name='previousdata' value='" . json_encode((array)$request->all()) . "'>";
                $html .= csrf_field();
                $html .= '<input type="hidden" name="price" value="' . $price . '">';
                $html .= '<input type="hidden" name="hotel_id" value="' . $room->hotelid . '">';
                $html .= '<input type="hidden" name="room_id" value="' . $room->id . '">';
                $html .= '<input type="hidden" name="pricepernight" value="' . (($price * $request->adults) + ($price * $request->children)) . '">';
                $html .= '<input type="hidden" name="discount" value="' . $discountprice . '">';
                $html .= '<input type="hidden" name="finalprice" value="' . $totalprice . '">';
                $html .= "<button type='submit' class='btn btn-success'>Book Now</button></form></td>";
                $html .= "</tr>";;
                
            }
            $html .= "</tbody></table>";
        } else {
            $html .= "<table class='table table-striped table-bordered'>";
            $html .= "<tr>";
            $html .= "<th>" . trans('messages.keyword_hotel_name') . "</th>";
            $html .= "<th>" . trans('messages.keyword_room_type') . "</th>";
            $html .= "<th>" . trans('messages.keyword_price_per_night') . "</th>";
            $html .= "<th>" . trans('messages.keyword_discount') . "(%)</th>";
            $html .= "<th>" . trans('messages.keyword_fare_amount') . "</th>";
            $html .= "<th>" . trans('messages.keyword_booking') . "</th>";
            $html .= "<tr>";
            $html .= "<tr>";
            $html .= "<td colspan='6'>" . trans('messages.keyword_no_hotel_records') . "</th>";
            $html .= "<tr>";
        }
        return $html;
    }
    
    public function saveBooking(Request $request)
    {
        $previousdata = json_decode($request->previousdata);
        
        if (empty($previousdata->extra_bed))
            $previousdata->extra_bed = 0;
        if (isset($previousdata->arrival))
            $startdate = Carbon::parse($previousdata->arrival)->toDateString('Y-m-d');
        if (isset($previousdata->departure))
            $enddate = Carbon::parse($previousdata->departure)->toDateString('Y-m-d');
        if (empty($previousdata->children))
            $previousdata->children = 0;
        $range = $this->generateDateRange(Carbon::parse($previousdata->arrival), Carbon::parse($previousdata->departure));
        $days = count($range);
        $request->finalprice = $days * $request->finalprice;
        foreach ($range as $alkey => $alval) {
            $allotmentval = DB::table('allotment_detail')
                ->where('hotel_id', $request->hotel_id)
                ->where('room_id', $request->room_id)
                ->where('date', $alval)
                ->first();
            $noofroom = $allotmentval->room;
            $noofroom--;
            $allotmentval->room = $noofroom;
            if ($noofroom <= 0) {
                $allotmentval->room = 0;
                $allotmentval->open = 2;
            }
            DB::table('allotment_detail')
                ->where('hotel_id', $request->hotel_id)
                ->where('room_id', $request->room_id)
                ->where('date', $alval)->update((array)$allotmentval);
        }
        $childage = [];
        if ($previousdata->children > 0) {
            for ($c = 1; $c <= $previousdata->children; $c++) {
                $varchild = "childage" . $c;
                $childage[] = $previousdata->$varchild;
            }
        }
        $arrdata = ['country' => $previousdata->hotel_country,
            'state' => $previousdata->hotel_state,
            'children' => $previousdata->children,
            'adults' => $previousdata->adults,
            'arrival' => $startdate,
            'departure' => $enddate,
            'hotel_id' => $request->hotel_id,
            'room_id' => $request->room_id,
            'nodays' => $days,
            'user_id' => Auth::user()->id,
            'childage' => json_encode($childage),
            'price' => $request->price,
            'price_night' => $request->pricepernight,
            'discountedprice' => $request->discount,
            'total_price' => $request->finalprice,
            'total_fare' => $request->finalprice,
            'ip_address' => \Request::ip(),
        ];
        
        $insertid = DB::table('booking_order')->insertGetId($arrdata);
        $bookingid = str_pad($insertid, 10, '0', STR_PAD_LEFT);
        DB::table('booking_order')->where('id', $insertid)->update(['temp_booking_id' => $bookingid]);
        return redirect('booking/managedetail/' . $insertid);
        //return redirect('booking/package/'.$insertid);
    }
    
    public function packageDetail(Request $request)
    {

        $bookingdetail = DB::table('booking_order')->where('id', $request->bookid)->first();
        $departure = Carbon::parse($bookingdetail->departure);
        $arrival = Carbon::parse($bookingdetail->arrival);
        $length = $departure->diffInDays($arrival);
        $arrdetail['bookingdetail'] = $bookingdetail;
        $arrdetail['bookingmember'] = DB::table('booking_detail')->where('booking_id', $request->bookid)->first();
        $arrdetail['roomDetail'] = DB::table('room_details')->where('id', $bookingdetail->room_id)->first();
        $arrdetail['hotelDetail'] = DB::table('hotel_main')->where('id', $bookingdetail->hotel_id)->first();
        $packages = DB::table('package')->where(['is_active' => '0', 'is_delete' => '0', 'hotel_id' => $bookingdetail->hotel_id]);
        $packages = $packages->where(function ($query) use ($length) {
            $query->where(function ($qur) use ($length) {
                $qur->where('list_of_days_status', 1)->where('list_of_days', '<=', $length);
            })->orWhere(['list_of_days_status' => 0]);
        });
        $arrdetail['packages'] = $packages->get();
        return view('booking/bookings_package_selection', $arrdetail);
    }
    
    public function savepackageDetail(Request $request)
    {
        $bookingdetail = DB::table('booking_order')->where('id', $request->bookid)->first();
        $arrdata = [
            'package' => $request->package,
            'total_package' => $request->total_package,
            'is_package' => 1,
            'total_price' => $request->grand_total,
            'total_fare' => ($bookingdetail->total_price + $request->total_package + $bookingdetail->total_transfer),
            'ip_address' => \Request::ip(),
        ];
        DB::table('booking_order')->where('id', $request->bookingid)->update($arrdata);
        return redirect('booking/transfer/' . $request->bookingid);
    }
    
    public function transferaddedit(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 1))
        {
            return redirect('/unauthorized');
        }
        
        $action = 'add';
        $bookingdetail = DB::table('booking_order')->where('id', $request->bookid)->first();
        
        $arrRecords = [
            'action' => 'add',
        
        ];
        $arrRecords['bookingdetail'] = $bookingdetail;
        $arrDetails = DB::table('transfer as t')->select('t.*')
            ->leftJoin('booking_order as b', 'b.id', '=', 't.booking_id');
        if (isset($request->transfer_id)) {
            $arrDetails = $arrDetails->where(['t.id' => $request->transfer_id]);
        }
        $arrDetails = $arrDetails->where(['t.is_deleted' => '0', 'b.id' => $request->bookid])->first();
        
        
        $arrRecords['action'] = 'edit';
        $arrRecords['transfer'] = $arrDetails;
        
        return view('booking.transfer_add_edit', $arrRecords);
    }
    
    
    public function savetransferDetail(Request $request)
    {
        
        $bookingdetail = DB::table('booking_order')->where('id', $request->booking_id)->first();
        $bookingdetail->total_fare = ($bookingdetail->total_price + $request->price + $bookingdetail->total_package);
        $data = [
            'direction' => $request->direction,
            'unique_transfer_id' => $request->unique_transfer_id,
            'type' => $request->type,
            'pax' => $request->pax,
            'hotel_id' => $request->hotel_id,
            'booking_id' => $request->booking_id,
            'start' => $request->start,
            'destination' => $request->destination,
            'client_status' => $request->client_status,
            'flight_time' => Carbon::parse($request->flight_time)->toDateTimeString(),
            'flight' => $request->flight,
            'pickup_time' => Carbon::parse($request->pickup_time)->toDateTimeString(),
            'user_id' => Auth::user()->id,
            'price' => $request->price,
            'notes' => $request->notes,

        ];
        if ($bookingdetail->is_transfer == 0)
            $transferid = DB::table('transfer')->insertGetId($data);
        else {
            $transferdetail = Db::table('transfer')->where('booking_id', $request->booking_id)->first();
            $transferid = DB::table('transfer')->where('id', $transferdetail->id)->update($data);
        }
        $bookingarray = ['name' => $request->client_name,
            'phone' => $request->client_phone,
            'is_transfer' => 1,
            'total_fare' => $bookingdetail->total_fare,
            'total_transfer' => $request->price
        ];
        DB::table('booking_order')->where('id', $request->booking_id)->update($bookingarray);
        $logs = 'Transfer Updated -> (ID:' . $request->transfer_id . ')';
        storelogs($request->user()->id, $logs);
        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . trans('messages.keyword_transfer_updated_successfully') . '</div>';
        
        Redirect::to('bookings')->send('msg', $msg);
        
    }
    
    
    public function bookingdetailstep2(Request $request)
    {
        $bookingdetail = DB::table('booking_order')->where('id', $request->booking_id)->first();
        $bookings = DB::table('booking_detail')->where('booking_id', $request->booking_id)->first();
        $country = DB::table('countries')->where('e_status', 1)->get();
        $states = DB::table('states')->where('e_status', 1);
        if (isset($bookings->country)) {
            $states = $states->where('i_country_id', $bookings->country);
        }
        $states = $states->offset(0)->limit(1000)->get();
        $city = DB::table('cities')->where('e_status', 1);
        if (isset($bookings->state)) {
            $city = $city->where('i_state_id', $bookings->state);
        }
        $city = $city->offset(0)->limit(1000)->get();
        $data["step1"] = $request->all();
        $data["states"] = $states;
        
        $data["city"] = $city;
        
        $data["country"] = $country;
        
        $data['booking'] = $bookings;
        $data['bookingdetail'] = $bookingdetail;
        $data['roomdetail'] = DB::table('room_details')->where('id', $bookingdetail->room_id)->first();;
        return view('booking.booking_add_edit_step3', $data);
        
        
    }
    
    public function updatestep2(Request $request)
    {
        //dd($request->all());
        $arrfound = ['name', 'age', 'meal_type', 'meal_price'];
        $bookingdetail = DB::table('booking_order')->where('id', $request->booking_id)->first();
        $namerecord = [];
        for ($i = 1; $i <= $bookingdetail->adults; $i++) {
            foreach ($arrfound as $arrval) {
                $name = 'adult' . $i . '_' . $arrval;
                $previousrecord[$arrval] = $request->$name;
            }
            $namerecord[] = $previousrecord;
        }
        for ($i = 1; $i <= $bookingdetail->children; $i++) {
            foreach ($arrfound as $arrval) {
                $name = 'child' . $i . '_' . $arrval;
                $previousrecord[$arrval] = $request->$name;
            }
            $namerecord[] = $previousrecord;
        }
        $detailarray = [
            'client_name' => $request->client_name,
            'booking_id' => $request->booking_id,
            'client_email' => $request->client_email,
            'country' => $request->client_country,
            'state' => $request->client_state,
            'city' => $request->client_city,
            'phone' => $request->phone,
            'note' => $request->notes,
            'details_of_members' => json_encode($namerecord),
        ];
        $bookings = DB::table('booking_detail')->where('booking_id', $request->booking_id)->first();
        if (!isset($bookings->id))
            DB::table('booking_detail')->insertGetId($detailarray);
        else
            DB::table('booking_detail')->where('id', $bookings->id)->update($detailarray);
        
        $bookingarray = ['name' => $request->client_name,
            'phone' => $request->phone,
            'email' => $request->client_email,
            'order_status' => $request->order_status,
            'is_payment_online' => $request->is_payment_online,
            'total_fare' => ($bookingdetail->total_package + ($bookingdetail->nodays * $request->total_fare) + $bookingdetail->total_transfer),
            'total_price' => ($bookingdetail->nodays * $request->total_fare),
            'price_night' => $request->total_fare];
        DB::table('booking_order')->where('id', $request->booking_id)->update($bookingarray);
        return redirect('booking/package/' . $request->booking_id);
    }
    
    /* ======================================  Bookings Section End ======================================================*/
    /* ======================================  Calendar Section ======================================================*/
    
    
    /*price closing*/
    public function price_closing()
    {
        return view('booking.price_closing');
    }
    
    public function getBookings(Request $request)
    {
        $booking = DB::table('bookings')->select('arrival', 'departure', 'client')->where('is_deleted', '0')->get()->toArray();
        
        $calendar_json = array();
        
        foreach ($booking as $k => $value) {
            $calendar_json[] = ['start' => $value->arrival, 'end' => $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }
        
        return json_encode($calendar_json);
    }
    
    public function price_closing_search(Request $request)
    {
        $booking = DB::table('bookings as b')->select('b.*', 'b.id as booking_id', 'h_m.room_id as room_ids', 'r_d.type_of_rooms as rooms')->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('room_details as r_d', 'b.hotel_id', '=', 'r_d.hotelid')
            ->whereBetween('b.created_at', array($request->start_date, $request->end_date));
        
        if (isset($request->price)) {
            $booking->where('b.price', '<=', $request->price);
        }
        
        if (isset($request->discount)) {
            $booking->where('b.discount', '>=', $request->discount);
        }

//        if(isset($request->room_type))
//        {

//            $booking->whereIn('r_d.type_of_rooms', $request->room_type);
//            foreach($request->room_type as $type)
//            {
//                    $booking->whereIn($type, 'h_m.room_id');
////                //$booking->where('r_d.type_of_rooms', $type);
////                //$booking->orWhere('r_d.type_of_rooms', $type);
////
//            }
//
//        }


//        $test = $booking->toSql();
//        echo $test;
        
        $booking_filtered_data = $booking->get()->toArray();
        
        //pre($booking_filtered_data); exit;
        
        $calendar_json = array();
        
        foreach ($booking_filtered_data as $k => $value) {
            $calendar_json[] = ['start' => $value->arrival, 'end' => $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }
        
        $calendar_json = json_encode($calendar_json);
        return view('booking.price_closing_search', ['filter_calendar' => $calendar_json, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }
    
    
    public function backup_price_closing_search(Request $request)
    {
        
        $booking = DB::table('bookings as b')->select('b.*', 'b.id as booking_id', 'h_m.room_id as room_ids', 'r_d.type_of_rooms as rooms')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('room_details as r_d', 'b.hotel_id', '=', 'r_d.hotelid')
            ->whereBetween('b.created_at', array($request->start_date, $request->end_date));
        
        if (isset($request->price)) {
            $booking->where('b.price', '<=', $request->price);
        }
        
        if (isset($request->discount)) {
            $booking->where('b.discount', '>=', $request->discount);
        }
        
        if (isset($request->room_type)) {
            $booking->whereIn('r_d.type_of_rooms', $request->room_type);
        }
        
        
        $booking_filtered_data = $booking->get()->toArray();
        
        //pre($booking_filtered_data); exit;
        
        $calendar_json = array();
        
        foreach ($booking_filtered_data as $k => $value) {
            $calendar_json[] = ['start' => $value->arrival, 'end' => $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }
        
        $calendar_json = json_encode($calendar_json);
        return view('booking.price_closing_search', ['filter_calendar' => $calendar_json, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }
    /*price closing*/
    
    /* ======================================  Calendar Section End======================================================*/

#########################################  Allotment Section Start####################################################	
    public function availability()
    {
        return view('booking.availability');
    }
    
    public function allotment(Request $request)
    {
        
        $allotment_status = DB::table('taxinomies_allotment_status')->where('is_delete', '0')->get();
        
        if (Auth::user()->profile_id == 0) {
            $country = DB::table('countries')->where('e_status', 1)->get();
            $hotel = DB::table('hotel_main')->where('is_deleted', 0)->where('is_active', 0)->get();
            $hotel_category = DB::table('hotel_category')->where('is_deleted', '0')->orderby('hotel_star', 'asc')->get();
            $daysdetail = [trans('messages.keyword_sunday'), trans('messages.keyword_monday'), trans('messages.keyword_tuesday'), trans('messages.keyword_wednesday'), trans('messages.keyword_thrusday'), trans('messages.keyword_friday'), trans('messages.keyword_saturday')];
            $arrsend = [
                'hotel' => $hotel,
                'category' => $hotel_category,
                'country' => $country,
                'allotment_status' => $allotment_status,
                'daysdetail' => $daysdetail
            ];
            return view('booking.allotment-admin', $arrsend);
        } else {
            $country = DB::table('countries')->where('e_status', 1)->get();
            $room = DB::table('room_details')->where(['hotelid' => Auth::user()->hotel_id, 'is_deleted' => 0, 'is_active' => 0])->get();
            $daysdetail = [trans('messages.keyword_sunday'), trans('messages.keyword_monday'), trans('messages.keyword_tuesday'), trans('messages.keyword_wednesday'), trans('messages.keyword_thrusday'), trans('messages.keyword_friday'), trans('messages.keyword_saturday')];
            $arrsend = ['room' => $room,
                'country' => $country,
                'allotment_status' => $allotment_status,
                'daysdetail' => $daysdetail
            ];
            
            return view('booking.allotment', $arrsend);
        }
    }
    
    public function allotmentlist(Request $request)
    {
        //$request->from=date('Y-m-d H:i:s',strtotime($request->from));
        //$request->to=date('Y-m-d H:i:s',strtotime($request->to));
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        //$startdate=$from;
        $interval = $this->generateDateRange($from, $to, $request->days);
        
        $startdate = Carbon::parse($request->from);
        $month = $this->generateMonthRange($startdate, $to);
        
        $wherecondition = ['is_deleted' => 0, 'is_active' => 0];
        if (isset($request->country)) {
            $wherecondition['country'] = $request->country;
        }
        if (isset($request->hotel)) {
            $wherecondition['id'] = $request->hotel;
        }
        if (isset($request->category)) {
            $wherecondition['category_id'] = $request->category;
        }
        $hotel_detail = DB::table('hotel_main')->where($wherecondition)->get();
        $html = '';
        /*Hotel Section */
        foreach ($hotel_detail as $hkey => $hval) {
            $html .= '<h1 class="cst-datatable-heading">' . ucwords($hval->name) . '</h1>';
            $html .= '<div class="table-responsive"><table id="" class="table table-striped table-bordered" width="100%" cellspacing="0"><thead><tr><th rowspan="2"></th>';
            /*Month Section */
            foreach ($month as $mkey => $mval):
                $result = preg_grep('~' . $mval . '~', $interval);
                $tdcolspan = count($result);
                $html .= '<th colspan="' . $tdcolspan . '">' . $mval . '</th>';
            endforeach;
            $html .= '</tr><tr>';
            /*Days Section */
            foreach ($interval as $ikey => $ival):
                $html .= '<th>' . date('d', strtotime($ival)) . '</th>';
            endforeach;
            $html .= '</tr></thead><tbody>';
            $room_detail = DB::table('room_details')->where('hotelid', $hval->id)->where(['is_deleted' => 0, 'is_active' => 0])->get();
            /*Room Section */
            foreach ($room_detail as $rkey => $rval) {
                /*Two tr required in room Section */
                
                for ($i = 1; $i <= 2; $i++) {
                    $html .= '<tr>';
                    if ($i == 1)
                        $html .= '<th rowspan="2">' . ucwords($rval->personal_name) . '</th>';
                    /*Days Section with room section*/
                    foreach ($interval as $ikey => $ival):
                        $arrayelement = ['hotel_id' => $hval->id, 'room_id' => $rval->id, 'date' => $ival, 'is_delete' => 0, 'status' => 1];
                        $allotmentcount = DB::table('allotment_detail')->where($arrayelement)->get();
                        $arrayelement['open'] = $request->status;
                        $arrayelement['room'] = (isset($rval->qt_same_name)) ? $rval->qt_same_name : 0;
                        $arrayelement['user_id'] = Auth::user()->id;
                        
                        /*if($allotmentcount->count()==0){
                            $insertid=DB::table('allotment_detail')->insertGetId($arrayelement);
                            $allotment=DB::table('allotment_detail')->where('id',$insertid)->first();
                            
                        }
                        else
                        {
                            $allotment=$allotmentcount[0];
                            //DB::table('allotment_detail')->where('id',$allotment->id)->update($arrayelement);
                            */
                        if ($allotmentcount->count() > 0) {
                            $allotment = $allotmentcount[0];
                            $allotment = DB::table('allotment_detail')->where('id', $allotment->id)->first();
                        } else {
                            $html .= '<td></td>';
                            continue;
                        }
                        
                        //}
                        //}
                        $typeselected = isset($allotment->open) ? $allotment->open : 0;
                        $rval->qt_same_name = isset($allotment->room) ? $allotment->room : 0;
                        $colorclass = ($typeselected == 3) ? 'red-bg' : (($typeselected == 2) ? "yellow-bg" : "green-bg");
                        $allowselected = ($typeselected == 1) ? "selected" : "";
                        $closelected = ($typeselected == 3) ? "selected" : "";
                        if ($i == 1)
                            
                            $html .= '<td class="' . $colorclass . ' type_' . $rval->id . '_' . $ival . '">
									<select name="type[' . $rval->id . '][' . $ival . ']" id="type_' . $rval->id . '_' . $ival . '" data-value="' . $rval->id . '_' . $ival . '" class="allow form-control" onchange="fun_typechange(this);fun_allotment(this)">
									<option value="1" ' . $allowselected . '>✔</option>
									<option value="3" ' . $closelected . '>✖</option>
									</select>
									<input type="hidden" name="room_id[]" value="' . $rval->id . '" id="roomid_' . $rval->id . '_' . $ival . '">
									<input id="hotelid_' . $rval->id . '_' . $ival . '" type="hidden" name="hotel_id[]" value="' . $hval->id . '">
									<input id="date_' . $rval->id . '_' . $ival . '" type="hidden" name="date[]" value="' . $ival . '">
									</td>';
                        else
                            $html .= '<td class="' . $colorclass . ' type_' . $rval->id . '_' . $ival . '">
						<input type="number" class="form-control" name="room[' . $rval->id . '][' . $ival . ']" id="room_' . $rval->id . '_' . $ival . '" data-value="' . $rval->id . '_' . $ival . '" value="' . $rval->qt_same_name . '" onchange="fun_typechange(this);fun_allotment(this)">
						<input type="hidden" name="date[]" value="' . $ival . '"></td>';
                    endforeach;
                    $html .= '</tr>';
                }
                
            }
            $html .= '</tbody></table></div>';
        }
        return $html;
        
    }
    
    private function generateDateRange($start_date, $end_date, $dayranges = 'all')
    {
        $dates = [];
        $daterange = explode(',', $dayranges);
        $isarray = is_array($daterange);
        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if ($isarray) {
                foreach ($daterange as $days) {
                    if ($date->format('w') == $days || $days == 'all')
                        $dates[] = $date->format('Y-m-d');
                }
            } else {
                $days = $daterange;
                if ($date->format('w') == $days || $days == 'all')
                    $dates[] = $date->format('Y-m-d');
            }
        }
        
        return $dates;
    }
    
    private function generateMonthRange($start_date, $end_date)
    {
        
        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);
        
        $interval = new DateInterval('P1D'); // 1 month interval
        $period = new DatePeriod($begin, $interval, $end); // Get a set of date beetween the 2 period
        $months = array();
        
        foreach ($period as $dt) {
            if (!in_array($dt->format("Y-m"), $months))
                $months[] = $dt->format("Y-m");
        }
        
        return $months;
    }
    
    public function allotmentupdatemain(Request $request)
    {
        $arrayelement = ['hotel_id' => $request->hotel, 'room_id' => $request->roomid, 'date' => $request->date];
        $allotment = DB::table('allotment_detail')->where($arrayelement)->first();
        $arrayelement['open'] = $request->type;
        $arrayelement['room'] = (isset($request->room)) ? $request->room : 0;
        $arrayelement['refund'] = (isset($request->refund)) ? $request->refund : 0;
        $arrayelement['min_day'] = (isset($request->min_day)) ? $request->min_day : 0;
        $arrayelement['released'] = (isset($request->released)) ? $request->released : 0;
        $arrayelement['paper'] = (isset($request->paper)) ? $request->paper : 0;
        $arrayelement['user_id'] = Auth::user()->id;
        if (isset($allotment)) {
            DB::table('allotment_detail')->where('id', $allotment->id)->update($arrayelement);
        } else
            DB::table('allotment_detail')->insert($arrayelement);
        $msg = "Updated Successfully";
        return $msg;
    }
    
    public function allotmentlistmanager(Request $request)
    {
        
        //$request->from=date('Y-m-d H:i:s',strtotime($request->from));
        //$request->to=date('Y-m-d H:i:s',strtotime($request->to));
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        $days = $request->days;
        
        if (($key = array_search('all', $days)) !== false) {
            unset($days[$key]);
            if (count($days) == 0) {
                unset($days);
            }
        }
        
        //$startdate=$from;
        $interval = $this->generateDateRange($from, $to);
        
        $startdate = Carbon::parse($request->from);
        $month = $this->generateMonthRange($startdate, $to);
        
        $wherecondition = ['is_deleted' => 0, 'is_active' => 0, 'hotelid' => Auth::user()->hotel_id];
        $room_detail = DB::table('room_details')->where($wherecondition);
        if (isset($request->room))
            $room_detail = $room_detail->whereIn('id', $request->room);
        $room_detail = $room_detail->get();
        $html = '';
        /*Hotel Section */
        $insertarray = [];
        foreach ($room_detail as $hkey => $hval) {
            $html .= '<h1 class="cst-datatable-heading">' . ucwords($hval->personal_name) . '</h1>';
            $html .= '<div class="table-responsive"><table id="" class="table table-striped table-bordered" width="100%" cellspacing="0"><thead><tr><th rowspan="2"></th>';
            /*Month Section */
            foreach ($month as $mkey => $mval):
                $result = preg_grep('~' . $mval . '~', $interval);
                $tdcolspan = count($result);
                $html .= '<th colspan="' . $tdcolspan . '">' . date('F/Y', strtotime($mval)) . '</th>';
            endforeach;
            $html .= '</tr><tr>';
            /*Days Section */
            foreach ($interval as $ikey => $ival):
                $html .= '<th>' . date('d', strtotime($ival)) . '</th>';
            endforeach;
            $html .= '</tr></thead><tbody>';
            $allotment_type = DB::table('taxinomies_allotment_type')->where(['is_delete' => 0, 'status' => 1])->get();
            /*Room Section */
            
            foreach ($allotment_type as $rkey => $rval) {
                /*Two tr required in room Section */
                
                $html .= '<tr>';
                $html .= '<th >' . ucwords($rval->name) . '</th>';
                /*Days Section with room section*/
                foreach ($interval as $ikey => $ival):
                    $arrayelement = ['hotel_id' => Auth::user()->hotel_id, 'room_id' => $hval->id, 'date' => $ival];
                    $allotmentcount = DB::table('allotment_detail')->where($arrayelement)->get();
                    
                    $arrayelement['open'] = (isset($request->status)) ? $request->status : 1;
                    
                    $arrayelement['room'] = (isset($hval->qt_same_name)) ? $hval->qt_same_name : 0;
                    $arrayelement['user_id'] = Auth::user()->id;
                    
                    if ($allotmentcount->count() == 0) {
                        if (!isset($days) || (in_array(date('w', strtotime($ival)), $days))) {
                            $insertid = DB::table('allotment_detail')->insertGetId($arrayelement);
                            $insertarray[$hval->id][] = $insertid;
                            $allotment = DB::table('allotment_detail')->where('id', $insertid)->first();
                        }
                    } else {
                        
                        $allotment = $allotmentcount[0];
                        $arrayelement['refund'] = isset($request->refund) ? $request->refund : $allotment->refund;
                        $arrayelement['room'] = isset($request->rooms) ? $request->rooms : $allotment->room;
                        if ($arrayelement['room'] == 0 && ($arrayelement['open'] == 1)) {
                            $arrayelement['open'] = 2;
                        };
                        $arrayelement['min_day'] = isset($request->min_stay) ? $request->min_stay : $allotment->min_day;
                        $arrayelement['released'] = isset($request->released) ? $request->released : $allotment->released;
                        $arrayelement['paper'] = isset($request->paper) ? $request->paper : $allotment->paper;
                        //$arrayelement['room']=isset($request->rooms)?$request->rooms:$allotment->room;
                        if ($request->counter != 0 && (!isset($days) || (in_array(date('w', strtotime($ival)), $days))) && (!in_array_r($allotment->id, $insertarray))) {
                            DB::table('allotment_detail')->where('id', $allotment->id)->update($arrayelement);
                            $insertarray[$hval->id][] = $allotment->id;
                            $allotment = DB::table('allotment_detail')->where('id', $allotment->id)->first();
                        }
                        
                    }
                    
                    $typeselected = $allotment->open;
                    $hval->qt_same_name = $allotment->room;
                    $this->minstay = $allotment->min_day;
                    $this->release = $allotment->released;
                    $colorclass = ($typeselected == 3) ? 'red-bg' : (($typeselected == 2) ? "yellow-bg" : "green-bg");
                    
                    switch ($rval->id) {
                        case '1':
                            $allowselected = ($typeselected == 1) ? "selected" : "";
                            $closelected = ($typeselected == 3) ? "selected" : "";
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
										<select name="open[' . $hval->id . '][' . $ival . ']" id="open_' . $hval->id . '_' . $ival . '"
										 data-value="' . $hval->id . '_' . $ival . '" class="allow form-control" onchange="fun_typechange(this);fun_saveallotment(this)">
										<option value="1" ' . $allowselected . '>✔</option>
									<option value="3" ' . $closelected . '>✖</option>
										</select>
										<input type="hidden" name="room_id[]" value="' . $hval->id . '" id="roomid_' . $hval->id . '_' . $ival . '">
										<input id="hotelid_' . $hval->id . '_' . $ival . '" type="hidden" name="hotel_id[]" value="' . $hval->hotelid . '">
										<input id="date_' . $hval->id . '_' . $ival . '" type="hidden" name="date[]" value="' . $ival . '">
										</td>';
                            break;
                        case '2':
                            
                            $allowselected = ($allotment->refund == 1) ? "selected" : "";
                            $closelected = ($allotment->refund == 0) ? "selected" : "";
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
										<select name="refund[' . $hval->id . '][' . $ival . ']" id="refund_' . $hval->id . '_' . $ival . '"
										 data-value="' . $hval->id . '_' . $ival . '" class="allow form-control" onchange="fun_typechange(this);fun_saveallotment(this)">
										<option value="1" ' . $allowselected . '>Yes</option>
										<option value="0" ' . $closelected . '>No</option>
										</select>
										</td>';
                            break;
                        case '3':
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
								<input type="number" class="form-control" name="room[' . $hval->id . '][' . $ival . ']" id="room_' . $hval->id . '_' . $ival . '"
								 data-value="' . $hval->id . '_' . $ival . '" value="' . $hval->qt_same_name . '" onchange="fun_typechange(this);fun_saveallotment(this)">
								</td>';
                            break;
                        case '4':
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
								<input type="number" class="form-control" name="min_day[' . $hval->id . '][' . $ival . ']" id="min_stay_' . $hval->id . '_' . $ival . '"
								 data-value="' . $hval->id . '_' . $ival . '" value="' . $this->minstay . '" onchange="fun_typechange(this);fun_saveallotment(this)">
								</td>';
                            break;
                        case '5':
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
								<input type="number" class="form-control" name="released[' . $hval->id . '][' . $ival . ']" id="released_' . $hval->id . '_' . $ival . '"
								data-value="' . $hval->id . '_' . $ival . '" value="' . $this->release . '" onchange="fun_typechange(this);fun_saveallotment(this)">
								</td>';
                            break;
                        case '6':
                            $allowselected = ($allotment->paper == 1) ? "selected" : "";
                            $closelected = ($allotment->paper == 0) ? "selected" : "";
                            $html .= '<td class="' . $colorclass . ' type_' . $hval->id . '_' . $ival . '">
										<select name="paper[' . $hval->id . '][' . $ival . ']" id="paper_' . $hval->id . '_' . $ival . '"
										data-value="' . $hval->id . '_' . $ival . '" class="allow form-control" onchange="fun_typechange(this);fun_saveallotment(this)">
										<option value="1" ' . $allowselected . '>Yes</option>
										<option value="0" ' . $closelected . '>No</option>
										</select>
										
										</td>';
                            break;
                        
                    }
                endforeach;
                $html .= '</tr>';
                
            }
            $html .= '</tbody></table></div>';
        }
        return $html;
        
        
    }
    
}
