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
use Carbon\Carbon;

class BookingController extends Controller
{

    public function __construct(Request $request){
        $this->middleware('auth');
    }
/* ======================================  Bookings Section ==========================================================*/
    public function bookings(Request $request)
    {
        return view('booking.bookings');
    }

    public function bookingdetail(Request $request)
    {
        $booking  = DB::table('bookings as b')->select('b.*', 'h_m.name as hotel_name', 'h_c.title as category_title', 'e_s.name as hotel_status_name', 'c.symbol as symbol', 't.unique_transfer_id as transfer_id')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('currency as c', 'b.currency_id', '=', 'c.id')
            ->leftJoin('transfer as t', 'b.id', '=', 't.booking_id')
            ->leftJoin('emotional_status as e_s', 'e_s.id', '=', 'b.hotel_status')
            ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id')
            ->where('b.id', '=', $request->booking_id)->where('b.is_deleted', '=', 0)->first();

        $arrayData['booking'] = $booking;

        return view('booking.booking_detail', $arrayData);
    }

    public function getjsonbookingsproperty(Request $request)
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

            /*Notes*/
            $data->notes = '<a class="" href="#" onclick="getNotesIdToModal(this)" data-unique-id="'.$uniqueToSendInModal.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#notesModal">'.trans('messages.keyword_views').'</a>';
            /*Notes*/

            /*Reviews*/
            $data->reviews = '<a class="" href="#" data-toggle="modal" data-target="#reviewModal">'.trans('messages.keyword_reviews').'</a>';
            /*Reviews*/


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

    public function bookingdelete(Request $request)
    {
        $countRec = DB::table('bookings')->select('*')->where('id', $request->id)->count();
        if ($countRec > 0) {
            DB::table('bookings')->where('id', $request->id)->update(array('is_deleted' => '1'));
            DB::table('bookings_notes')->where('booking_id', $request->id)->delete();
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_not_exist').'</div>');
        }
    }

    public function bookings_search(Request $request)
    {

        $booking  = DB::table('bookings as b')->select('b.*','b.id as booking_id','h_m.name as hotel_name', 'h_c.title as category_title', 'e_s.name as hotel_status_name')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('hotel_category as h_c', 'h_m.category_id', '=', 'h_c.id')
            ->leftJoin('currency as c', 'b.currency_id', '=', 'c.id')
            ->leftJoin('emotional_status as e_s', 'e_s.id', '=', 'h_m.status')
            ->where('b.id', '!=', '0')->where('b.is_deleted', '=', '0');


        if(isset($request->client_status))
        {
            $booking->where('b.client_status', '=' ,$request->client_status);
        }


        if(isset($request->hotel_status))
        {
            $booking->where('b.hotel_status', '=' ,$request->hotel_status);
        }

        if(isset($request->arrival) && isset($request->departure))
        {
            $booking->where('b.arrival','>=', $request->arrival);
            $booking->where('b.departure','<=', $request->departure);
        }

        if(isset($request->booking_country))
        {
            $booking->where('b.country', '=' ,$request->booking_country);
        }

        if(isset($request->transfer))
        {
            $booking->where('b.transfer', '=' ,$request->transfer);
        }


        if(isset($request->currency))
        {
            $booking->where('c.id', '=' ,$request->currency);
        }




        if(isset($request->cart_guarantee))
        {
            $booking->where('b.cart', '=' ,$request->cart_guarantee);
        }

        if(isset($request->user_type))
        {
            $booking->where('b.who_booked', '=' ,$request->user_type);
        }

        if(isset($request->hotel_list))
        {
            $booking->where('b.hotel_id', '=' ,$request->hotel_list);
        }



//        if(isset($request->hotel_name)){
//            $booking->where('h_m.name', 'like', '%'.$request->hotel_name.'%' );
//        }
//
//        if(isset($request->status_filter)){
//            $booking->where('h_m.status', $request->status_filter);
//        }
        $arrayData['filtered_booking'] = $booking->get();




        //dd($arrayData);
        return view('booking.bookings_search', $arrayData);
    }

    public function getNotes(Request $request)
    {
        $notes = DB::table('bookings_notes as bn')->select('bn.*', 'u.name as username', 'b.unique_booking_id as unique_booking_id')
            ->leftJoin('users as u', 'bn.user_id', '=', 'u.id')
            ->leftJoin('bookings as b', 'bn.booking_id', '=', 'b.id')
            ->where('bn.booking_id', $request->booking_id)->get();

        if(count($notes) > 0)
        {
            foreach($notes as $note) {

                $time = Carbon::parse($note->created_at)->diffForHumans();
                echo "<div class=''>";
                    echo "<p><b>".$note->username."</b><span class='pull-right'>".$time."</span></p>";
                    echo "<p>".$note->description."</p>";
                echo "</div>";
            }
        }else{
            echo trans('messages.keyword_no_notes_found');
        }


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

        if(count($notes) > 0)
        {
            foreach($notes as $note) {

                $time = Carbon::parse($note->created_at)->diffForHumans();
                echo "<div class=''>";
                echo "<p><b>".$note->username."</b><span class='pull-right'>".$time."</span></p>";
                echo "<p>".$note->description."</p>";
                echo "</div>";
            }
        }else{
            echo trans('messages.keyword_no_notes_found');
        }
    }

    public function getHotelList(Request $request)
    {

        $hotels = DB::table('hotel_main')->select('name', 'id')->where('address', 'like', '%'.$request->location.'%')->get();


        if(count($hotels) > 0)
        {
            echo "<option>".trans('messages.keyword_--select--')."</option>";
            foreach($hotels as $hotel)
            {
                echo '<option value="'.$hotel->id.'">'.$hotel->name.'</option>';
            }
        }
        else{
            echo "<option>".trans('messages.keyword_--select--')."</option>";
        }

    }

    public function booking_conversations_update(Request $request)
    {
        if(isset($request->booking_id) && !empty($request->booking_id))
        {

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


            $logs = 'Replied in Booking Conversations -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);
        }

        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_you_replied_successfully').'</div>';
        return Redirect::back()->with('msg', $msg);
    }

    public function sendBookingEmail($message,$subject,$toEmail) {
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

        Mail::send(['html' => 'layouts.mail_content'], ['content' => $message], function ($m) use ($subject,$toEmail,$fromemail,$fromename) {
            $m->from($fromemail, $fromename);
            $m->to($toEmail)->subject($subject);
        });
        return (count(Mail::failures()) > 0) ? false : true;
    }

    public function send_confirmation_email(Request $request)
    {

        $emailtemplate = DB::table('email_template')->where(['is_active'=>0,'id'=>1])->first();

        //dd($emailtemplate);

    //        $otheruser = isset($entity->user_id) ? (DB::table('users')->where('id', $entity->user_id)->first()):array();
    //        if(isset($otheruser->email)){
    //            array_push($toEmail,$otheruser->email);
    //        }
    //        if(isset($supperadmindetails->email)){
    //            array_push($toEmail,$supperadmindetails->email);
    //        }


        if(isset($emailtemplate->language_key)){
            //$name = isset($otheruser->name) ? $otheruser->name : $entity->nomereferente;
            //$link ='<a href="'.url('progetti/modify/project/'.$valp->id).'">'.url('progetti/modify/project/'.$valp->id).'</a>';

            $tags = [];
            foreach(getEmailTags() as $tag)
            {
                $tags[] = "[".$tag->tag."]";
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

            $findReplace = [ $tags[0] => $name, $tags[1] => $useremail, $tags[3] => '', $tags[4] => '', $tags[5] => '', $tags[6] => '', $tags[7] => '',$tags[8] => '',$tags[9] => '',$tags[10] => '' ];
//            $findReplace = array("[Name]"=>$name,"[Module]"=>'Project',"[ModuleTitle]"=>$valp->nomeprogetto,"[ModuleId]"=>$valp->id,"[UserName]"=>$createruser->name,
//                "[UserEmail]"=>$createruser->email,"[Content]"=>'',"[AlertTitle]"=>'',"[FirstName]"=>$createruser->name,"[LastName]"=>$createruser->name,
//                "[SiteUrl]"=>url('/'),"[Email]"=>$createruser->email,"[Signature]"=>'Regards, Langa Team',"[Link]"=>$link,"[Title]"=>'',"[SiteTitle]"=>'Easy Langa');

            $subject = trans('messages.'.$emailtemplate->subject_language_key);
            $message = trans('messages.'.$emailtemplate->language_key);
            $subject = replace_charcter($findReplace,$subject);
            $message = replace_charcter($findReplace,$message);

            $message = html_entity_decode($message);
            $mailResponse=$this->sendBookingEmail($message,$subject,$request->email);

            if($mailResponse)
            {
                echo "working";
            }

        }
    }

    public function bookingaddedit(Request $request)
    {
        $action = 'add';
        $bookings = DB::table('bookings')->where('is_deleted','0')->get()->toArray();


        $arrRecords = [
            'action'=>'add'
        ];


        if(isset($request->booking_id))
        {

            $action = 'edit';
            $arrDetails = DB::table('bookings')->where(['id'=>$request->booking_id,'is_deleted'=>'0'])->first();


            $arrRecords['action'] = 'edit';
            $arrRecords['booking'] = $arrDetails;
        }

        return view('booking.booking_add_edit', $arrRecords);
    }

    public function bookingupdate(Request $request)
    {
        if(isset($request->booking_id) && !empty($request->booking_id) && $request->action == 'edit'){
            dd('update');
        }
        else{

            pre($request->all());

            $data = [

            ];


        }
    }

    public function getHotelWiseRooms(Request $request)
    {
        $rooms = DB::table('room_details')->where('hotelid', $request->hotel_id)->get();

        if(count($rooms))
        {
            $currency = getActiveCurrency();
            $symbol = $currency['symbol'];
            echo "<table class='table table-striped table-bordered'>";
            echo "<tr>";
            echo "<th>".trans('messages.keyword_room_type')."</th>";
            echo "<th>".trans('messages.keyword_price_per_night')."</th>";
            echo "<th>".trans('messages.keyword_discount')."(%)</th>";
            echo "<th>".trans('messages.keyword_fare_amount')."</th>";
            echo "<th>".trans('messages.keyword_booking')."</th>";
            echo "<tr>";
            foreach($rooms as $room)
            {
                echo "<tr>";
                echo "<td>".$room->personal_name."</td>";
                echo "<td>".number_format($room->price_per_night, 2).$symbol."</td>";
                echo "<td>".$room->discount."%</td>";
                echo "<td>".number_format($room->fare_amount, 2).$symbol."</td>";
                echo "<td><button type='button' data-toggle='modal' data-target='#room_booking_modal'><i class='fa fa-eye'</i></button></td>";
                echo "<tr>";
            }
            echo "</table>";
        }
        else{

        }
    }

    public function getHotelRoomDetails(Request $request)
    {
        $rooms = DB::table('room_details')->where('id', $request->room_id)->first();

        if(count($rooms) > 0)
        {
            echo $rooms->personal_name;
        }
    }

/* ======================================  Bookings Section End ======================================================*/

/* ======================================  Calendar Section ======================================================*/
    public function allotment()
    {
        return view('booking.allotment');
    }

    public function availability()
    {
        return view('booking.availability');
    }


    /*price closing*/
    public function price_closing()
    {
        return view('booking.price_closing');
    }

    public function getBookings(Request $request)
    {
        $booking = DB::table('bookings')->select('arrival', 'departure', 'client')->where('is_deleted','0')->get()->toArray();

        $calendar_json = array();

        foreach($booking as $k=> $value)
        {
            $calendar_json[] = ['start' => $value->arrival, 'end'=> $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }

        return json_encode($calendar_json);
    }

    public function price_closing_search(Request $request)
    {
        $booking = DB::table('bookings as b')->select('b.*', 'b.id as booking_id', 'h_m.room_id as room_ids', 'r_d.type_of_rooms as rooms')
                    ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
                    ->leftJoin('room_details as r_d', 'b.hotel_id', '=', 'r_d.hotelid')
                    ->whereBetween('b.created_at',array($request->start_date,$request->end_date));

        if(isset($request->price))
        {
            $booking->where('b.price', '<=', $request->price);
        }

        if(isset($request->discount))
        {
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

        foreach($booking_filtered_data as $k=> $value)
        {
            $calendar_json[] = ['start' => $value->arrival, 'end'=> $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }

        $calendar_json = json_encode($calendar_json);
        return view('booking.price_closing_search', ['filter_calendar'=> $calendar_json, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }


    public function backup_price_closing_search(Request $request)
    {

        $booking = DB::table('bookings as b')->select('b.*', 'b.id as booking_id', 'h_m.room_id as room_ids', 'r_d.type_of_rooms as rooms')
            ->leftJoin('hotel_main as h_m', 'h_m.id', '=', 'b.hotel_id')
            ->leftJoin('room_details as r_d', 'b.hotel_id', '=', 'r_d.hotelid')
            ->whereBetween('b.created_at',array($request->start_date,$request->end_date));

        if(isset($request->price))
        {
            $booking->where('b.price', '<=', $request->price);
        }

        if(isset($request->discount))
        {
            $booking->where('b.discount', '>=', $request->discount);
        }

        if(isset($request->room_type))
        {
            $booking->whereIn('r_d.type_of_rooms', $request->room_type);
        }


        $booking_filtered_data = $booking->get()->toArray();

        //pre($booking_filtered_data); exit;

        $calendar_json = array();

        foreach($booking_filtered_data as $k=> $value)
        {
            $calendar_json[] = ['start' => $value->arrival, 'end'=> $value->departure, 'title' => $value->client, 'url' => url('bookings')];
        }

        $calendar_json = json_encode($calendar_json);
        return view('booking.price_closing_search', ['filter_calendar'=> $calendar_json, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }
    /*price closing*/

/* ======================================  Calendar Section End======================================================*/
}
