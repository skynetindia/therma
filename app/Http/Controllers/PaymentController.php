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
use App\Classes\PdfWrapper as PDF;

class PaymentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    
    /* Group Invoices */
    /*====================================================================================*/
    public function group_invoices(Request $request)
    {
        if(!checkpermission($this->module_id,$this->parent_id, 0))
        {
            return redirect('/unauthorized');
        }
        
        DB::enableQueryLog();
        $month=date('m');
		$year=date('Y');
		  $hotel_main = DB::table('hotel_main as h')
                ->select('h.*','p.invoiceid');
        if(isset($request->startdate)  && $request->search == '1'){
            //this function will run with search filter, uses pose routes with filter
            $daterange='13-'.$request->startdate;
            $month=date('m',strtotime($daterange));
			$year=date('Y',strtotime($daterange));
        }
		if(isset($request->country)  && $request->search == '1'){
			$hotel_main=$hotel_main->where('h.country',$request->country);
		}
		if(isset($request->state)  && $request->search == '1'){
			$hotel_main=$hotel_main->where('h.state',$request->state);
		}
		if(isset($request->city)  && $request->search == '1'){
			$hotel_main=$hotel_main->where('h.city',$request->city);
		}
		if(isset($request->hotelid)  && $request->search == '1'){
			$hotel_main=$hotel_main->where('h.id',$request->hotelid);
		}
		if(isset($request->invoiceid)  && $request->search == '1'){
			$hotel_main=$hotel_main->where('p.invoiceid',$request->invoiceid);
		}
		 $hotel_main=$hotel_main->leftjoin('payment_generate_invoice as p', function($join)use($month,$year){
			 						$duration=$month.'-'.$year;
									$join->on('h.id','p.hotel_id')
										->where('p.duration',$duration);
			 					})
		 						->where('h.id', '!=', 0)
								->where('h.is_deleted', '=', 0)
								->whereYear('created_dt','<=',$year)
								->whereMonth('created_dt','<=',$month);
		if (Auth::user()->profile_id == 1) {
			$hotel_main = $hotel_main->where('h.id', Auth::user()->hotel_id);
		}
		$data['hotels'] = $hotel_main->get();
		
		
		$country = DB::table('countries')->where('e_status', 1)->get();
        $states=DB::table('states')->where('e_status',1);
		 if(isset($request->country)){
			 $states=$states->where('i_country_id',$request->country);
		 }
		 $states=$states->offset(0)->limit(1000)->get();
         $city=DB::table('cities')->where('e_status',1);
		  if(isset($request->state)){
			 $city=$city->where('i_state_id',$request->state);
		 }
		 $city=$city->offset(0)->limit(1000)->get();
         $data["post"] = $request->all();
         $data["state"] = $states;
         $data["city"] = $city;
         $data["country"] = $country;

        return view('payment.group_payment_invoice', $data);
    }
    public function payment_confirm(Request $request)
    {
		DB::enableQueryLog();
		
        if(isset($request->booking_id)){
            $booking_order = DB::table('booking_order as b')->select('b.*', 'h.commission as hotel_commission')
                            ->leftJoin('hotel_main as h','b.hotel_id','=','h.id')
                            //->leftJoin('payment_group_invoice as p','b.temp_booking_id','=','p.booking_id')
                            ->where(['b.id' => $request->booking_id])->first();
            if(count($booking_order)>0)
            {
                $commission_price = ((int) $booking_order->total_fare * (int) $booking_order->hotel_commission ) / 100;
                $commission_price = round($commission_price);
                $payable_commission_price = round($request->payable_commission_price);
                $full_payment = ($payable_commission_price < $commission_price) ? '0' : '1'; // where 1 = Yes && 0 = No
                
                $remaining_price = ($full_payment == '0') ? (int)$commission_price - (int)$payable_commission_price : 0;
                
                $data = [
                    'booking_id' => $request->booking_id, // this will store temp_booking_id in table
                    'hotel_id' => $booking_order->hotel_id,
                    'requester_id' => Auth::user()->id,
                    'booking_price' => $booking_order->total_fare,
                    'commission' => $booking_order->hotel_commission,
                    'commission_price' => $commission_price,
                    'commission_paid' => $payable_commission_price,
                    'full_payment' => $full_payment,
                    'confirm' => 1,
                    'is_requested' => '2',
                    'reason_incomplete_payment' => ($full_payment == '0') ? $request->reason_incomplete_payment : null,
                    'remaining_price' => $remaining_price,
                   
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $last_inserted_id = DB::table('payment_group_invoice')->where('booking_id', $request->booking_id)->update($data);
    
                // generate Invoice data
                $invoicedata = DB::table('payment_generate_invoice')->where('hotel_id', $booking_order->hotel_id)->first();
                
                if(isset($invoicedata->id)){
                	$booking_id_for_invoice = $invoicedata->booking_id;
                  
                  
                    $array = (isset($booking_id_for_invoice))?json_decode($booking_id_for_invoice, true):[];
                    if( !in_array($request->booking_id, $array) ){
                        $array[] = $request->booking_id;
                    }
                    
                    $booking_ids = json_encode($array);
                    
                    
                    $gererate_data = [
                        'booking_id' => $booking_ids,
                        'status' => '1',
						'invoiceid'=>generateInvoiceNumber($invoicedata->id),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
        			
                    DB::table('payment_generate_invoice')->where(['hotel_id'=> $booking_order->hotel_id,'id'=>$invoicedata->id])->increment('commission',$payable_commission_price,$gererate_data);
                }
                
            }
        }else{ return false; }
    
        $logs = 'Booking Payment Confirmed -> (ID:'.$last_inserted_id.')';
        storelogs($request->user()->id,$logs);
    
    
        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_payment_confirmed').'</div>';
        return Redirect::back()->with('msg', $msg);
    }
    /*
     *  Below method will call when save button with multiple records is clicked
     */
    public function payment_confirm_multiple(Request $request)
    {
		
        $user_type = Auth::user()->profile_id;
        $book= DB::table('booking_order as b')->select('b.*', 'h.commission as hotel_commission')
                            ->leftJoin('hotel_main as h','b.hotel_id','=','h.id')
                            ->leftJoin('payment_group_invoice as p','b.id','=','p.booking_id')
                            ->where(['b.id' => $request->id])->first();
        //$query = 'select id from booking_order where id = '.$request->id.' and id not in(select booking_id from payment_group_invoice)';    	
        if(isset($book->id)){
            $booking_id = $book->id;
    
            $booking_order = DB::table('booking_order as b')->select('b.*', 'h.commission as hotel_commission')
                ->leftJoin('hotel_main as h','b.hotel_id','=','h.id')
                //->leftJoin('payment_group_invoice as p','b.temp_booking_id','=','p.booking_id')
                ->where(['b.id' => $booking_id])->first();
    
            if(count($booking_order)>0)
            {
                $commission_price = ((int) $booking_order->total_fare * (int) $booking_order->hotel_commission ) / 100;
                $commission_price = round($commission_price);
                $payable_commission_price = round($request->payable_commission_price);
                $full_payment = ($payable_commission_price < $commission_price) ? '0' : '1'; // where 1 = Yes && 0 = No
        
                $remaining_price = ($full_payment == '0') ? (int)$commission_price - (int)$payable_commission_price : 0;
        
                $data = [
                    'booking_id' => $booking_id, // this will store temp_booking_id in table
                    'hotel_id' => $booking_order->hotel_id,
                    'requester_id' => Auth::user()->id,
                    'booking_price' => $booking_order->total_fare,
                    'commission' => $booking_order->hotel_commission,
                    'commission_price' => $commission_price,
                    'commission_paid' => $commission_price,
                    'full_payment' => 1,
                    'confirm' => 1,
                    'reason_incomplete_payment' => ($full_payment == '0') ? $request->reason_incomplete_payment : null,
                    'remaining_price' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
               $last_inserted_id = DB::table('payment_group_invoice')->where('booking_id', $request->id)->update($data);
    
              
                $invoicedata = DB::table('payment_generate_invoice')->where('hotel_id', $booking_order->hotel_id)->first();
    
                if(isset($invoicedata->id)){
                    $booking_id_for_invoice = $invoicedata->booking_id;
        			$array=[];
                    $array = json_decode($booking_id_for_invoice, true);
                    if(!in_array($request->id, $array)){
                        $array[] = $request->id;
                    }
                    $booking_ids = json_encode($array);
                    $gererate_data = [
                        'booking_id' => $booking_ids,
                        'status' => '1',
						'invoiceid'=>generateInvoiceNumber($invoicedata->id),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    DB::table('payment_generate_invoice')->where(['hotel_id'=> $booking_order->hotel_id,'id'=>$invoicedata->id])->increment('commission',$commission_price,$gererate_data);
                }
                
            }
        }else{ return Redirect::back()->with('msg', ''); }
    
        $logs = 'Booking Payment Confirmed -> (ID:'.$last_inserted_id.')';
        storelogs($request->user()->id,$logs);
    
        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_payment_confirmed').'</div>';
        return Redirect::back()->with('msg', $msg);
    }
    
    
    public function payment_send_multiple(Request $request)
    {
        $user_type = Auth::user()->profile_id;        
        $query = "select id from booking_order where id = ".$request->id." and id not in(select booking_id from payment_group_invoice)";
        $id = DB::select($query);
        if(count($id) >0){
            $booking_id = $id[0]->id;
            
            $booking_order = DB::table('booking_order as b')->select('b.*', 'h.commission as hotel_commission')
                ->leftJoin('hotel_main as h','b.hotel_id','=','h.id')
                //->leftJoin('payment_group_invoice as p','b.temp_booking_id','=','p.booking_id')
                ->where(['b.id' => $booking_id])->first();
			$range=$request->range;
			$month=date('m',strtotime('13-'.$range));
			$year=date('Y',strtotime('13-'.$range));
            if(count($booking_order)>0)
            {
                $commission_price = ((int) $booking_order->total_fare * (int) $booking_order->hotel_commission ) / 100;
                $commission_price = round($commission_price);
                $payable_commission_price = round($request->payable_commission_price);
                $full_payment = ($payable_commission_price < $commission_price) ? '0' : '1'; // where 1 = Yes && 0 = No
                
                $remaining_price = ($full_payment == '0') ? (int)$commission_price - (int)$payable_commission_price : 0;
				 $invoicerecord = DB::table('payment_generate_invoice')->where(['hotel_id'=>$booking_order->hotel_id,
																			   'duration' => $range,
																			   'month' => $month,
																			   'year' =>$year 
																			]);
                    if($invoicerecord->count() == 0){
                        $bookingarr[]=$booking_order->id;
                        $gererate_data = [
                            'hotel_id' => $booking_order->hotel_id,
							'booking_id' => json_encode($bookingarr),
							'duration' => $request->range,
							'month' => date('m',strtotime('13-'.$request->range)),
							'year' => date('Y',strtotime('13-'.$request->range)),
                            'status' => '0',
							'user_id'=>Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
							'issued_dt'	=>	date('Y-m-d'),
							'due_dt'	=>	date('Y-m-d',strtotime('+14days')),
							'vat_dt'	=>	date('Y-m-d', strtotime('last day of previous month')),
                        ];
    
                        $invoiceid=DB::table('payment_generate_invoice')->insertGetId($gererate_data);
                    }
					else{
						$invoicedata=$invoicerecord->first();
						 $bookingarr=json_decode($invoicedata->booking_id,true);
						 $bookingarr[]=$booking_order->id;
						  $gererate_data = [
                           
							'booking_id' => json_encode($bookingarr),
                           'user_id'=>Auth::user()->id,
                      
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
    
                        DB::table('payment_generate_invoice')->where('id',$invoicedata->id)->update($gererate_data);
						$invoiceid=$invoicedata->id;
					}
				
                $data = [
                    'booking_id' => $booking_id, // this will store temp_booking_id in table
                    'hotel_id' => $booking_order->hotel_id,
                    'requester_id' => Auth::user()->id,
                    'booking_price' => $booking_order->total_fare,
                    'commission' => $booking_order->hotel_commission,
                    'commission_price' => $commission_price,
                    'commission_paid' => null,
                    'full_payment' => '0',
                    'confirm' => '0',
					'invoiceid'=>$invoiceid,
					'duration'=>$range,
                    'reason_incomplete_payment' => null,
                    'remaining_price' => null,
                    'is_requested' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $last_inserted_id = DB::table('payment_group_invoice')->insertGetId($data);
                // generate Invoice data
               
                
            }
        }else{ return false; }
        
        $logs = 'Booking Payment Confirmed -> (ID:'.$last_inserted_id.')';
        storelogs($request->user()->id,$logs);
        
        $msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_booking_payment_confirmed').'</div>';
        return Redirect::back()->with('msg', $msg);
    }
    
    /* Group Invoices */
    /*====================================================================================*/
    
    
    /* request send receive */
    /*====================================================================================*/
    public function payment_request_send_list(Request $request){
        
        $data['hotels'] =  (Auth::user()->profile_id == '0') ? getHotels() : getHotels(Auth::user()->hotel_id);
        return view('payment.payment_request_send', $data);
    }
    public function payment_request_receive_list(Request $request){
        $data['hotels'] =  (Auth::user()->profile_id == '0') ? getHotels() : getHotels(Auth::user()->hotel_id);
        return view('payment.payment_request_receive', $data);
    }
    /* request send receive */
    /*====================================================================================*/
    
    
    /* request send receive */
    /*====================================================================================*/
    public function payment_request_invoices(Request $request){
        $data['hotel'] = DB::table('hotel_main as h')->select('h.*', 'b.contract_no as contract_number','b.vat_id as vat_number')
                        ->leftJoin('billing_address as b','h.id','=','b.hotel_id')
						->join('payment_generate_invoice as in','in.hotel_id', 'h.id')
                        ->where('in.invoiceid', $request->invoiceid)->first();
        
        
        $invoice = DB::table('payment_generate_invoice')->where('invoiceid', $request->invoiceid)->first();
        $data['booking_invoice_ids'] = json_decode($invoice->booking_id, true);
    
        
        
        $data['invoice'] = $invoice;
        return view('payment.payment_invoice', $data);
    }

    public function payment_invoices_save_note(Request $request){
        
        $data = [
            'note' => $request->note,
        ];
        DB::table('payment_generate_invoice')->where('hotel_id', $request->hotel_id)->update($data);
        return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_comment_saved_successfully').'</div>');
    }
    /* request send receive */
    /*====================================================================================*/
	
	public function invoicepdfgenrate(Request $request){
		
		$invoicerecord=DB::table('payment_generate_invoice as p')
								->leftjoin('hotel_main as h','h.id','p.hotel_id')
								->leftjoin('billing_address as b','h.id','b.hotel_id')
								->where('p.id',$request->id)
								->first();
		$bookingid=json_decode($invoicerecord->booking_id,true);
		
		$invoice = DB::table('payment_group_invoice')->where('invoiceid', $request->invoiceid)->get();
        $data['booking_invoice_ids'] = json_decode($invoicerecord->booking_id, true);		
		
		$user = DB::table('users')->where('id', $invoicerecord->user_id)->first();
		

			
		$pdf = new PDF('utf-8');
		$pdf->shrink_tables_to_fit = 1;
		//$pdf->tableMinSizePriority = false;
		//$pdf->mirrorMargins(1);
						
		 $header = \View::make('pdf.invoice_header',[
			])->render();			
						
		$footer = \View::make('pdf.invoice_footer')->render();
		
		$title= $invoicerecord->name.'-'.$invoicerecord->invoiceid.'_'.$invoicerecord->duration;
		$pdf->SetTitle($title);
		$pdf->SetHTMLHeader($header, 'O');
		$pdf->SetHTMLHeader($header, 'E');
		$pdf->SetHTMLFooter($footer, 'O');
		$pdf->SetHTMLFooter($footer, 'E');
		
		/*$pdf->AddPage('Portrait', margin-left, margin-right, margin-top, margin-bottom, margin-header, margin-footer, 'A4');*/
		$pdf->AddPage('P', 0, 0, 26, 15, 0, 0, 'Letter');
		/*echo $header;
		echo view('pdf.invoice', [
			'invoice' =>$invoice,
			'invoicerecord'=>$invoicerecord,										
			'user' => $user,
			]);
		echo $footer;
		exit;*/
		
		
		$pdf->loadView('pdf.invoice', [
			'invoice' =>$invoice,
			'invoicerecord'=>$invoicerecord,										
			'user' => $user,
			]);
		
		$logs = $this->logmainsection.' -> Generate pdf for Quote -> (ID: '. $quote->id .')';
		storelogs($request->user()->id, $logs);
		
		/*$pdf->download('test.pdf');*/
		$filenamepdf = $preventivo->id.'-'.$preventivo->anno.'_'.$preventivo->oggetto.'.pdf';
		$pdf->stream($filenamepdf);				
	
	}
    
}
