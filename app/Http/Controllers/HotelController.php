<?php

namespace App\Http\Controllers;
use App\User;
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



class HotelController extends Controller
{	
	public function __construct(Request $request){ 
        $this->middleware('auth');
    }
	public function index(Request $request) {		
         return view('hotel/hotel_property');
    }

    public function getjsonhotelproperty(Request $request) {
    	$hotelDetails = array();
		$hotel_main = DB::table('hotel_main')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0)->get();            		

		foreach($hotel_main as $data) {							
			$checked = ($data->is_active==0) ? 'checked' : '';
			$data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateHotelStatus('.$data->id.')" id="activestatus_'.$data->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$data->id.'"></label></div>';   	

			$categorydetails = DB::table('hotel_category')->where('id',$data->category_id)->first(); 
			$countrydetails = DB::table('countries')->where('i_id',$data->country)->first(); 
			$data->category = isset($categorydetails->title) ? $categorydetails->title : '*'; 
			$data->country = isset($countrydetails->v_name) ? $countrydetails->v_name : '-'; 
			/*if($data->icon != ""){					
				$data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';			
			}*/
			$hotelManagerdetails = DB::table('users')->where(['hotel_id'=>$data->id,'profile_id'=>'1'])->first();			 						
			if(isset($hotelManagerdetails->id)){
				$data->access_user = '<a class="btn btn-default" href="'.url('user/access')."/".encodehelper($hotelManagerdetails->id).'" >'.trans('messages.keyword_go').'</a>';
			}
			else {
				$data->access_user = '<a class="btn btn-default" href="javascript:void(0)" >'.trans('messages.keyword_go').'</a>';	
			}
			$hotelDetails[] = $data;	
		}
		return json_encode($hotelDetails);    
    }   
    public function updatehotelstatus(Request $request) {						
		$update = DB::table('hotel_main')->where('id', $request->id)->update(array('is_active' => $request->status));
		return ($update) ? 'true' : 'false';		
	}
	public function hoteledit(Request $request){
		$type = isset($request->type) ? $request->type : 'basic';
		if($type == 'basic'){
			return $this->basicinforedit($request);
		}
		else if($type == 'detail'){
			return $this->detailedit($request);
		}
		else if($type == 'billinginfo') {
			return $this->billinginfo($request);
		}
		else if($type == 'contactdetail'){
			return $this->contactdetail($request);
		}
		else if($type == 'media')
        {
            return $this->media($request);
        }
		else if($type == 'amenities')
        {
            return $this->amenities($request);
        }
        else if($type == 'policies')
        {
            return $this->hotelpolicies($request);
        }
		else if($type == 'other') {
			return $this->otherdetail($request);
		}	
		
		else if($type == 'room-details')
        {        	
            return $this->roomdetails($request);
        }
        else if($type == 'room-options')
        {
            return $this->roomoptions($request);
        }       
        else if($type == 'extra')
        {
            return $this->extra($request);
        }
        else if($type == 'media')
        {
            return $this->media($request);
        }
        else if($type == 'policies')
        {
            return $this->paymentpolicies($request);
        }
        else if($type == 'agreement')
        {
            return $this->agreement($request);
        }
	}
	 /* add/edit form details */
	public function basicinforedit(Request $request) {    
        $action = 'add';
        $arrDetails = array();
        //$hotelstatus = getTaxonomies('emotional_status');
        $hotelstatus = getTaxonomies('emotional_status');
        $hotel_category = DB::table('hotel_category')->where('is_deleted','0')->orderby('hotel_star','asc')->get()->toArray();
		$currency=DB::table('currency')->get();
		$country=DB::table('countries')->where('e_status',1)->get();
		$states=DB::table('states')->where('e_status',1)->offset(0)->limit(1000)->get();
		$city=DB::table('cities')->where('e_status',1)->offset(0)->limit(1000)->get();
        $arrRecords = [
			'action'=>'add',
			'hotelstatus'=>$hotelstatus,
			'hotel_category'=>$hotel_category,
			'currency'=>$currency,
			'country'=>$country,
			'states'=>$states,
			'city'=>$city,
			];

        if(isset($request->hotelid)){
			$action = 'edit';			
			$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();
			
			$hotel_detail = DB::table('hotel_detail')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0'])->first();
			$userdetail = DB::table('users')->where(['hotel_id'=>$arrDetails->id,'is_delete'=>'0'])->first();
			
			$arrRecords['action'] = 'edit';
			$arrRecords['hoteldetails'] = $arrDetails;
			$arrRecords['states'] = DB::table('states')->where('e_status',1)->where('i_country_id',$arrDetails->country)->get();
			$arrRecords['city'] =  DB::table('cities')->where('e_status',1)->where('i_state_id',$arrDetails->state)->get();;
			$arrRecords['hotel_detail'] = $hotel_detail;
			$arrRecords['userdetail'] = $userdetail;
			
			
        }
		return view('hotel.hotelbasicinfoedit',$arrRecords);        
    }
	
	/* add/edit form details */
	public function detailedit(Request $request) {    
        $action = 'add';
        $arrDetails = array();
        /*$hotelstatus = array('0'=>'Off, unavailable','1'=>'Hidden, not sold','2'=>'Viewed, sold');*/
        $hotelstatus = getTaxonomies('emotional_status');
        $hotel_category = DB::table('hotel_category')->where('is_deleted','0')->orderby('hotel_star','asc')->get()->toArray();
        $arrRecords = [
			'action'=>'add',
			'hotelstatus'=>$hotelstatus,
			'hotel_category'=>$hotel_category];
		 //media section
		$hotelid = $request->hotelid;
        $arrRecords['hotelid'] = $request->hotelid;        
        $query = "SELECT * FROM media_files WHERE master_id=$request->hotelid AND master_type=0 order by id desc";		
		$arrecords['holetdetail'] = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();		
       	$arrRecords['holetmedia'] = DB::select($query);

	
        $arrRecords['users']=DB::table('users')->where(['id'=>$request->user()->id])->first();
        //return view('media', $arrdata);
        if(isset($request->hotelid)){
			$action = 'edit';			
			$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();
			//dd($arrDetails);
			/*$billing_address = DB::table('billing_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'0'])->first();
			$operator_billing_address = DB::table('billing_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'1'])->first();
			$invoice_address = DB::table('invoice_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'0'])->first();
			$operator_invoice_address = DB::table('invoice_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'1'])->first();

			$text_information = DB::table('text_information')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0'])->first();
			$languagetranslations = DB::table('language_transalation')->get();
			$arrtextlanguageval = array();
			foreach ($languagetranslations as $key => $value) {
				$arrtextlanguageval[$value->code][$value->language_key] = $value->language_value;
			}
			/*print_r($arrtextlanguageval);
			exit;
			$arrRecords['action'] = 'edit';
			
			$arrRecords['billing_address'] = $billing_address;
			$arrRecords['invoice_address'] = $invoice_address;
			$arrRecords['operator_billing_address'] = $operator_billing_address;
			$arrRecords['operator_invoice_address'] = $operator_invoice_address;
			$arrRecords['text_information'] = $text_information;
			$arrRecords['text_information_language'] = $arrtextlanguageval;*/
			$arrRecords['hoteldetails'] = $arrDetails;
        }

		return view('hotel.hoteldetailedit',$arrRecords);        
    }

   


    /* add/edit form Contact Details */
	public function contactdetail(Request $request) {    
        $action = 'add';
        $arrDetails = array();                        
		$arrcontactdetail = array();
        if(isset($request->hotelid)) {
			$action = 'edit';			
			$arrcontactdetail = DB::table('hotel_conatct_details')->where('hotel_id',$request->hotelid)->first();
			$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();			
        }
        $arrRecords['action'] = $action;
		$arrRecords['hoteldetails'] = $arrDetails;			
		$arrRecords['contactdetail'] = $arrcontactdetail;
		return view('hotelcontactedit',$arrRecords);        
    }

     /* === Save the Hotel Basic infomation === */
    public function savehotelbasicinfo(Request $request) {
		
			$arrhotelmail = array(
									'name' 								=> $request->name,
									'category_id' 						=> $request->hotel_category,
									//'status' 							=> $request->status,
									'saved_level' 						=> '1',
									'contact_person'					=>$request->contact_person,
									'address'							=>isset($request->address) ? $request->address : '',
									'priority'							=>isset($request->priority) ? $request->priority : '0',
									'country'							=>isset($request->hotel_country) ? $request->hotel_country : '',
									'state'								=>isset($request->hotel_state) ? $request->hotel_state : '',
									'city'								=>isset($request->hotel_city) ? $request->hotel_city : '',
									'contact_no'						=>isset($request->contact_number) ? $request->contact_number : '',
									'fax'								=>isset($request->hotel_fax)?$request->hotel_fax:'',
									'phone'								=>isset($request->hotel_phone) ? $request->hotel_phone : '',
									'general_email'						=>isset($request->general_email) ? $request->general_email : '',
									'communication_lang'				=>isset($request->communication_lang)?implode(',',$request->communication_lang):'',
									//'email'								=>isset($request->email) ? $request->email : '',
									'reservation_email'					=>isset($request->reservation_email) ? $request->reservation_email : '',
									'billing_email'						=>isset($request->billing_email) ? $request->billing_email : '',
									'transfer_email'					=>isset($request->transfer_email) ? $request->transfer_email : '',
									'sold_out_email'					=>isset($request->sold_out_email) ? $request->sold_out_email : '',
									'city_tax'							=>isset($request->city_tax) ? $request->city_tax : '',
									'web_url'							=>isset($request->hotel_website) ? $request->hotel_website : '',
									/*'min_price'						=>isset($request->min_price) ? $request->min_price : '',
									'commission'						=>isset($request->commission) ? $request->commission : '',
									'standard_reserve'					=>isset($request->standard_reserve) ? $request->standard_reserve : 0,
									'refundable'						=>isset($request->refundable) ? $request->refundable :0,
									'check_in'							=>isset($request->check_in) ? $request->check_in : '',
									'check_out'							=>isset($request->check_out) ? $request->check_out : '',
									'is_vat'							=>isset($request->is_vat) ? $request->is_vat : '',
									'vat_number'						=>isset($request->vat_number) ? $request->vat_number : '',
									'location_ids'						=>$locations*/
			);
			if(isset($request->treatment_commission)) $arrhotelmail['treatment_commission']=$request->treatment_commission;
			if(isset($request->hotel_commission)) $arrhotelmail['commission']=$request->hotel_commission ;
			if(isset($request->hotel_id)){
				DB::table('hotel_main')->where('id', $request->hotel_id)->update($arrhotelmail);
				$hotelid=$request->hotel_id;
			}
			else
			$hotelid=DB::table('hotel_main')->insertGetId($arrhotelmail);
			//Create User section//
			$userdetail = User::where('email',$request->general_email)->first();
			$userrecord = [	'name'=>$request->contact_person,
							'email'=>$request->general_email,
							'username'=>$request->username,
							'hotel_id'=>$hotelid,
							'profile_id'=>1,
							'address'=>$request->address,
							'phone'=>$request->contact_number,
							'updated_at'=>date('Y-m-d H:i:s'),
						];
			if(isset($request->password))
				$userrecord['password']=bcrypt($request->password);
			if(isset($userdetail)) {
				User::where('email',$request->general_email)->update($userrecord);
			}
			else {
				$role=DB::table('user_type')->where('id',1)->first();
				$userrecord['permissions']=$role->permissions;
				$userrecord['created_at']=date('Y-m-d H:i:s');
				User::create($userrecord);
			}
			//End Of user section
			
			//Add other detail of hotel	
			$updateData['user_id']=$request->user()->id;
			//$updateData['currency_id']=$request->currency;
			if(isset($request->hotel_commission))
			$updateData['portal_commision']=$request->hotel_commission;
			/*$updateData['price_increase']=$request->min_price;
			$updateData['currency_id']=$request->currency;
			$updateData['vat_invoicing']=$request->vat_number;
			$updateData['billing_language']=$request->billing_language;*/
			$updateData['contract_number']=$request->contact_number;
			/*$updateData['sale_reservation']=isset($request->standard_reserve) ? $request->standard_reserve : 0;
			$updateData['resale_non_refund_boking']=isset($request->refundable) ? $request->refundable :0;
			$updateData['is_vat']=$request->is_vat;
			$updateData['work_with_credit_card']=$request->work_with_credit_card;
			$updateData['credit_card_amount']=$request->credit_card_amount;			
			$updateData['credit_card_options'] = isset($request->credit_cards) ? implode(",", $request->credit_cards) : "";*/
			$updateData['created_date'] = date('Y-m-d H:i:s');
			$updateData['hotel_id'] = $hotelid;
			$counter=DB::table('hotel_detail')->where('hotel_id',$hotelid)->count();
			if($counter!=0)
			DB::table('hotel_detail')->where('hotel_id',$hotelid)->update($updateData);
			else
			DB::table('hotel_detail')->insertGetId($updateData);	
			$msg =  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel Detail Saved successfully!</div>';
			$logs = 'Hotel Detail Info Updated -> (ID:'.$request->hotel_id.')';
			storelogs($request->user()->id,$logs);
			return redirect('hotel/edit/detail/'.$hotelid)->with('msg', $msg);  
	}



    /* Save the Hotel Details */
	public function savehoteldetail(Request $request) {
			$nome='';$feature='';
			//dd($request->all());
			if ($request->logo != null) {
			Storage::put('images/hotel/' .(time().$request->file('logo')->getClientOriginalName()), file_get_contents($request->file('logo')->getRealPath()));
			$nome = (time().$request->file('logo')->getClientOriginalName());
				}
			if ($request->feature != null) {
			Storage::put('images/hotel/' .(time().$request->file('feature')->getClientOriginalName()), file_get_contents($request->file('feature')->getRealPath()));
			$feature = (time().$request->file('feature')->getClientOriginalName());
				}
			$arrhotelmail = array(
			//'name' => $request->name,
			'description'=>isset($request->description) ? $request->description : '',
			'summary'=>isset($request->summary) ? $request->summary : '',
			'opinion'=>isset($request->opinion) ? $request->opinion : '',
			'check_in'=>isset($request->checkin) ? implode('-',$request->checkin) : '',
			'check_out'=>isset($request->checkout) ? implode('-',$request->checkout) : '',
			'updated_user_id'=>$request->user()->id,
			'wifi'=>isset($request->wifi) ? $request->wifi:'',
			'updated_dt'=>date('Y-m-d H:i:s'),
			);
			if($feature!=='')
			$arrhotelmail['feature']=$feature;
			if($nome!=='')
			$arrhotelmail['logo']=$nome;
		if(isset($request->hotel_id)) {
			
			$hotelid=DB::table('hotel_main')->where('id',$request->hotel_id)->first()->id;
			DB::table('hotel_main')->where('id',$hotelid)->update($arrhotelmail);
			$msg =  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_hotel_info_saved_sucessfully').'</div>';
			}
			
			$logs = 'Hotel Info Updated -> (ID:'.$hotelid.')';
			storelogs($request->user()->id,$logs);
			return redirect('hotel/edit/billinginfo/'.$hotelid)->with('msg', $msg); 
			
    }

    /* === Save the Hotel Contact Details === */
    public function savehotelcontactdetail(Request $request) {
		if(isset($request->hotel_id)) {
			$oldDetails = DB::table('hotel_conatct_details')->where('id',$request->contactid)->get();

			$updateData['hotel_id']=$request->hotel_id;
			$updateData['hotel_name']=$request->contact_hotel_name;
			$updateData['phone']=$request->hotel_phone;
			$updateData['fax']=$request->hotel_fax;
			$updateData['zip_code']=$request->zip_code;
			$updateData['web']=$request->hotel_weburl;
			$updateData['identifications']=$request->identifications;
			$updateData['vat_id']=$request->vat_id;
			$updateData['address']=isset($request->address) ? $request->address : "";
			$updateData['contact_person']=$request->contact_person;

			if(count($oldDetails) > 0) {				
				DB::table('hotel_conatct_details')->where('id',$request->contactid)->update($updateData);	
			}
			else {								
				DB::table('hotel_conatct_details')->insertGetId($updateData);		
			}		
			$msg =  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Contact Detail Saved successfully!</div>';
			return redirect('hotel/edit/amenities/'.$request->hotel_id)->with('msg', $msg);     
		}
    }

    /* === Save the Hotel Policy Details === */
   

    
    /* === Save the Hotel Contract Agreement Details === */
    public function savehotelcontract(Request $request) {
		if(isset($request->hotel_id)) {
			$oldDetails = DB::table('hotel_contract_details')->where('hotel_id',$request->hotel_id)->get();

			$updateData['contact_person'] = $request->contact_person;
			$updateData['bussiness_name'] = $request->bussiness_name;
			$updateData['address'] = $request->office_address;
			$updateData['is_terms_agreed'] = isset($request->is_terms_agreed) ? $request->is_terms_agreed : "0";

			if(count($oldDetails) > 0) {				
				DB::table('hotel_contract_details')->where('hotel_id',$request->hotel_id)->update($updateData);	
			}
			else {
				$updateData['hotel_id']=$request->hotel_id;								
				DB::table('hotel_contract_details')->insertGetId($updateData);		
			}		
			$msg =  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Contract Saved successfully!</div>';
			return redirect('hotel/edit/agreement/'.$request->hotel_id)->with('msg', $msg);     
		}
    }


    /* This function is used to delete languages */
	public function deletehotel(Request $request) {
        $countRec = DB::table('hotel_main')->select('*')->where('id', $request->id)->count();
		if($countRec > 0){
			DB::table('hotel_main')->where('id',$request->id)->update(array('is_deleted' =>'1'));
			return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel deleted successfully</div>');			
		}
		else {        
        	return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel not Exist!</div>');
		}        
    }
	
	/* this function is used to write the lanague file/dir */
	public function writelanguagefile($type=''){
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);		
		$arrLanguages = $collection->toArray();		
		/*$numItems = count($arrLanguages);
		$i = 0;*/
		foreach($arrLanguages as $key => $val){
			$path = './resources/lang/'.$val->code;
			if(!is_dir($path)) {
				mkdir($path, 0775, true);				
			}
			$file = $path.'/messages.php';
			if(is_file($file)){
				unlink($file);				
			}
			if(!is_file($file)){
				$content = "<?php return [";
				$phases =  DB::table('language_transalation')
                        ->select('*')
                        ->where('code', $val->code)                        
                        ->get();		
				$numItems = count($phases);
				$i = 0;
				foreach($phases as $phase){
					if($phase->language_value != "" && !empty($phase->language_value)) {
						if(++$i === $numItems) {
							$content .= '
							"'.$phase->language_key.'" => "'.htmlspecialchars($phase->language_value).'"';
						}
						else {
							$content .= '
							"'.$phase->language_key.'" => "'.htmlspecialchars($phase->language_value).'",';
						}					
					}
				}
				$content .= "]; ?>";
				$fp = fopen($file,"wb");
				fwrite($fp,$content);
				fclose($fp);		
			}			
		}
		/* Write the php file for the js variables  */	
		$jsfile = './resources/views/common/languagesjs.blade.php';
		if(is_file($jsfile)){
			unlink($jsfile);				
		}
		if(!is_file($jsfile)){
			$jscontent = "<script> ";
			$jsphases =  DB::table('language_transalation')->select('*')->where('is_cmspage', 0)->whereNotNull('language_value')->groupBy('language_key')->get();		
			$jsnumItems = count($jsphases);			
			foreach($jsphases as $jsphase) {				
				$jskey = preg_replace('/[^A-Za-z0-9\_]/', '', $jsphase->language_key);
				$jscontent .= ' var jslang_'.$jskey.' = "<?php echo nl2br(trans("messages.'.$jsphase->language_key.'")); ?>";'. PHP_EOL;
			}
			$jscontent .= "</script>";
			
			$jsfp = fopen($jsfile,"wb");
			fwrite($jsfp,$jscontent);
			fclose($jsfp);	
			
		}
	}
	
	public function saveage(Request $request){
		DB::table('hotel_agediscount')
				->where('hotel_id',$request->hotelid)
				->update(['status'=>0]);
		foreach($request->age_from as $akey=>$aval){
			$agelist=DB::table('hotel_agediscount')
				->where('hotel_id',$request->hotelid)
				->where('age_from',$aval)
				->where('age_to',$request->age_to[$akey])
				->first();
			if(isset($agelist->id)){
				//echo ($agelist->id);
				DB::table('hotel_agediscount')
				->where('id',$agelist->id)
					->update([
					'discount'		=>$request->age_discount[$akey],
					'hotel_id'		=>$request->hotelid,
					'age_from'		=>$aval,
					'age_to'		=>$request->age_to[$akey],
					'display_name'	=>$request->display_name[$akey],
					'is_adult'		=>($aval>=18)?1:0,
					'status'		=>1
					]);
					
			}
			else{
				$insertid=DB::table('hotel_agediscount')
					->insertGetId([
					'discount'		=>$request->age_discount[$akey],
					'hotel_id'		=>$request->hotelid,
					'age_from'		=>$aval,
					'age_to'		=>$request->age_to[$akey],
					'display_name'	=>$request->display_name[$akey],
					'is_adult'		=>($aval>=18)?1:0
					]);

			}
		}
		  $logs = 'Age Group Updated -> (hotel ID:'.$request->hotelid.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">Hotel Age Group Updated</div>';
		 return Redirect('hotel/room/room-details/'.$request->hotelid)->with('msg',$msg);
	}

/*================================================================= ROOM SECTION ================================================================= */
	/* Hotel Room Options */
    public function roomdetails(Request $request) {
		$hotelid=(isset($request->hotel_id))?$request->hotel_id:Auth::user()->hotel_id;
		$hotelagedetail=DB::table('hotel_agediscount')
							->where('hotel_id',$hotelid)
							->where('status',1)
							->where('is_delete',0)
							->get();
		$arraydetail=['hotelid'=>$hotelid,'age_detail'=>$hotelagedetail];
        return view('room/room_details',$arraydetail);
    }

    public function roomdetailsaddedit(Request $request)
    {
        $action = 'add';        
        if(isset($request->room_id)) {
            $action = 'edit';
            $arrDetails = DB::table('room_details')->where(['id'=>$request->room_id,'is_deleted'=>'0'])->first();            
            $arrRecords['room_details'] = $arrDetails;
			$arrRecords['roomid'] = $request->room_id; 
			$arrRecords['roomFeatures'] = DB::table('room_amenities')->where(['room_id'=>$arrDetails->id])->first();        
				
			$query = "SELECT * FROM media_files WHERE master_id = $request->room_id AND master_type=1 order by id desc";		
			$arrRecords['roommedia'] = DB::select($query);
	
			$arrRecords['users']=DB::table('users')->where(['id'=>$request->user()->id])->first();
			}
        $arrRecords['action'] = $action;

        //return view('room_details_add_edit', $arrRecords);
        return view('room/room_info', $arrRecords);
    }

    public function saveroom(Request $request)
    {
		//dd($request->all());
		$hotelid=(isset($request->select_hotel))?$request->select_hotel:Auth::user()->hotel_id;
    	$room_data = [
                'type_of_rooms'				=> $request->select_room,
                'hotelid'				 	=> $hotelid,
                'personal_name' 			=> $request->personal_name,
                'qt_same_name' 				=> $request->how_many_room,
				'standard_bed' 				=> $request->standard_bed,
				'extra_bed' 				=> $request->extra_bed,
                'weight' 					=> $request->weight,
				'can_sleep'					=>$request->can_sleep,
                'height' 					=> $request->height,
				'size_extra' 				=> $request->size_extra,
				'size_standard' 			=> $request->size_standard,
				'summary' 					=> $request->summary,
				'description' 				=> $request->description,
			];
        if(isset($request->room_id) && !empty($request->room_id) && $request->action == 'edit') { 
				
            $room_data['updated_user_id'] = $request->user()->id;
            $room_data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('room_details')->where('id', $request->room_id)->update($room_data);
            $last_added_id = $request->room_id;
            $sub_cat = getWizardSubCategory(54);            
            /* Store the log details */
            $logs = 'Room Updated -> (ID:'.$request->room_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Room updated successfully!</div>';
            //update in language table
            $lang_data = ['personal_name' => $request->personal_name];            
        }
        else {
        	$room_data['user_id'] = $request->user()->id;
        	$room_data['created_at'] = date('Y-m-d H:i:s');
            $last_added_id = DB::table('room_details')->insertGetId($room_data);
			//echo $request->mediaCode;
			DB::table('media_files')->where('code',$request->mediaCode)->where('master_type',1)->update(['master_id'=>$last_added_id]);	
            /* Store the log details */
            $logs = 'Room Added -> (ID:'.$last_added_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Room information added successfully!</div>';
            $lang_data = ['personal_name' => $request->personal_name];
            
        }
		$ids = fetch_room_from_hotel_main($hotelid, 'array');
		if(!in_array($request->select_room, $ids))
		{
			$ids[]=$request->select_room;
			
		
		}
		$ids = implode(",", $ids);
	
		$room_ids_data = [
			'room_id' =>  $ids
		];
		$this->saveroomaminities($request);
		DB::table('hotel_main')->where('id', $hotelid)->update($room_ids_data);
        language_keyword_add($lang_data);
        return Redirect('hotel/room/room-details/'.$hotelid)->with('msg',$msg);

    }

    public function getjsonroomdetail(Request $request) {
        $roomDetails = array();
        $room_main = DB::table('room_details')->select('room_details.*')
        	->Join('hotel_main', 'hotel_main.id', '=', 'room_details.hotelid')
		
        	->where('room_details.id', '!=', 0)
        	->where('room_details.is_deleted', '=', 0);
		if(isset($request->hotelid))
			$room_main=$room_main->where('hotelid',$request->hotelid);
        $room_main=$room_main->get();
        foreach($room_main as $data) {
            $checked = ($data->is_active==0) ? 'checked' : '';

            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateRoomStatus('.$data->id.')" id="activestatus_'.$data->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$data->id.'"></label></div>';
            $hotel = DB::table('hotel_main')->where('id',$data->hotelid)->first();
			$data->category= DB::table('taxinomies_room_type')->where('id',$data->type_of_rooms)->first()->name;
            $data->hotel = isset($hotel->name) ? $hotel->name : '-';
            $data->size = (isset($data->height) && $data->height != "0") ? ($data->height.'X'.$data->weight.' '.$data->unit_of_measurement) : '-';
			$data->action='<a href="#" class="btn btn-default" onClick="fun_modal('.$data->id.')" data-toggle="modal" data-target="#myModal"><i class="fa fa-th-large" aria-hidden="true"></i></a>';
            /*if($data->icon != ""){
                $data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';
            }*/
            $roomDetails[] = $data;
        }
        return json_encode($roomDetails);
    }

    public function updateroomstatus(Request $request) {
        $update = DB::table('room_details')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }
    public function deleteroom(Request $request) {
        $countRec = DB::table('room_details')->select('*')->where('id', $request->id)->count();
        if($countRec > 0) {
            DB::table('room_details')->where('id',$request->id)->update(array('is_deleted' =>'1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Room deleted successfully</div>');
        }
        else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Room not Exist!</div>');
        }
    }    
    /* End : Hotel Room Options */


    /* Hotel Room Options */
    public function roomoptions(Request $request)
    {
        $hotelid = $request->hotelid;
        return view('hotel_room_options', compact('hotelid'));
    }
    /* End : Hotel Room Options */
	
	public function roompricelistaddedit(Request $request)
    {

        $arrDetails = DB::table('room_details')->where(['id'=>$request->room_id,'is_deleted'=>'0'])->first();
		$extrabed = DB::table('room_detail_extra_bed')->where(['room_id'=>$request->room_id])->get();
        $arrRecords['room_details'] = $arrDetails;
		$arrRecords['extrabed'] = $extrabed;
        return view('price_listing', $arrRecords);
    }
	public function savepricelist(Request $request) {
    
        if(isset($request->room_id) && !empty($request->room_id)) {
            $room_data = ['price_per_night' => $request->at_night,
                'is_fare_lower' => $request->fare_lower,
                'discount_type' => $request->discount_type,
				 'discount' => $request->discount,
                'user_id' => $request->user()->id,
                'fare_amount' => $request->total_price,
                'updated_user_id' => $request->user()->id,
                'updated_at' => date('Y-m-d H:i:s')];
           $quantity=0;
            if(isset($request->extra_bed)){
	           	foreach ($request->extra_bed as $key => $value) {	           		
	           		$checkcount = DB::table('room_detail_extra_bed')->where(['room_id'=>$request->room_id,'bed_type'=>$value])->count();
	           		
	           		$arrdataam['base_price']= $request->extra_bed_base_price[$key];
	           		$arrdataam['quantity']= $request->extra_bed_quantity[$key];
	           		$arrdataam['total_fare']= $request->extra_bed_total_fare[$key];	  
					$quantity+=$request->extra_bed_quantity[$key] ;     		
	           		if($checkcount > 0) {
						DB::table('room_detail_extra_bed')->where(['room_id'=>$request->room_id,'bed_type'=>$value])->update($arrdataam);
					}
					else {												
						$arrdataam['bed_type'] = $value;
						$arrdataam['room_id'] = $request->room_id;
						DB::table('room_detail_extra_bed')->insertGetId($arrdataam);		
					}
	           	}
       		}
			$room_data['extra_bed']=$quantity;
			 DB::table('room_details')->where('id', $request->room_id)->update($room_data);

            /* Store the log details */
            $logs = 'Room Updated -> (ID:'.$request->room_id.')';
            storelogs($request->user()->id,$logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Room updated successfully!</div>';
            //update in language table
            $lang_data = ['personal_name' => $request->personal_name];
            language_keyword_add($lang_data);
        }
        return Redirect('hotel/room/amenities/'.$request->room_id);

    }
	function room_amenities(Request $request) {			
		if(isset($request->room_id)){
			$arrData['room_details'] = DB::table('room_details')->where(['id'=>$request->room_id])->first();
	    	return view('room_amenities',$arrData);
		}
    }
	 /* media */    
    public function room_media(Request $request) {        
        $arrdata['roomid'] = $request->room_id;         
        $arrdata['roomdetail'] = DB::table('room_details')->where(['id'=>$request->room_id,'is_deleted'=>'0'])->first();		
       	$query = "SELECT * FROM media_files WHERE master_id = $request->room_id AND master_type=1 order by id desc";		
		$arrdata['roommedia'] = DB::select($query);

        $arrdata['users']=DB::table('users')->where(['id'=>$request->user()->id])->first();
        return view('room_media', $arrdata);
    }

     public function fileuploadroom(Request $request){		
		 $nome = $request->file('file')->getClientOriginalName();	
		Storage::put('images/room/'.$nome,file_get_contents($request->file('file')->getRealPath()));		
			DB::table('media_files')->insert([
			'name' => $nome,
			'code' => $request->code,
			'master_type' => 1,
			'type'=>'0',
			'master_id' => isset($request->master_id) ? $request->master_id : 0,
			'user_id'=>$request->user()->id,
			'date_time'=>time()
		]);	
	}
		
	public function filegetroom(Request $request){	
		DB::enableQueryLog();
		$where = 'code='.$request->code;
		if(isset($request->master_id)){
			$where .= ' or master_id ='.$request->master_id;
		} 
		$query = "SELECT * FROM media_files WHERE $where order by id desc";		
		$mediadata = DB::select($query);
		foreach($mediadata as $prev) {
			$imagPath = url('/storage/app/images/room/'.$prev->name);
			$downloadlink = url('/storage/app/images/room/'.$prev->name);
			$filename = $prev->name;			
			$arrcurrentextension = explode(".", $filename);
			$extention = end($arrcurrentextension);
							
			$arrextension['docx'] = 'docx-file.jpg';
			$arrextension['pdf'] = 'pdf-file.jpg';
			$arrextension['xlsx'] = 'excel.jpg';
			if(isset($arrextension[$extention])){
				$imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);			
			}
			
			$html = '<li data-thumb="'.$imagPath.'"><img src="'.$imagPath.'" ></li>';
            echo $html ;            
		}
		exit;			
	}
	public function updatemediaCommentroom(Request $request){		 		
		$updateData = DB::table('media_files')->where('code', $request->code)->orderBy('id', 'desc')->first();										
		$title = $request->title;
		$descriptions = $request->descriptions;		
		$response = DB::table('media_files')->where('date_time', $updateData->date_time)->update(array('description' => $descriptions,'title'=>$title));	    
		echo ($response) ? 'success' :'fail';   				
		exit;
	}
		
	public function filedeleteroom(Request $request){		
	    $response = DB::table('media_files')->where('id', $request->id)->delete();
	    echo ($response) ? 'success' :'fail';   				
		exit;
	}
	
	public function filetypeupdateroom(Request $request){		 
		$request->ids = isset($request->ids) ? implode(",",$request->ids) : "";
		$response = DB::table('media_files')->where('id', $request->fileid)->update(array('type' => $request->ids));	    
		echo ($response) ? 'success' :'fail';   				
		exit;
	}

    /*Save Room Aminities */
    public function saveroomaminities(Request $request){
    	$newlang=[];
		if(isset($request->language)){
		$language=$request->language;
		foreach($language as $key=>$lang):
			$string='';
				foreach($lang as $keylang=>$vallang)
				{
					if(isset($vallang))
					$string.=$key.'->'.$vallang;
				}
			if($string!='')
			$newlang[$key]=$string;
			endforeach;
		}
		$setoption=implode(',',$request->set_option);
		$langval=implode(',',$newlang);
		$arraydetail=array(
							'set_option'=>$setoption,
							'language_key'=>$langval,
							'room_id'=>$request->room_id,
							);
		$hoteldetail=DB::table('room_amenities')->where('room_id',$request->hotel_id)->first();				
		if(isset($hoteldetail->hotel_id))
		{
			DB::table('room_amenities')->where('room_id',$request->hotel_id)->update($arraydetail);
		}
		else
		{
			DB::table('room_amenities')->insert($arraydetail);
			
		}
		return true;   	
    }
/*============================================ ROOM SECTION END ================================================================== */


    /*  Amenities */
    public function amenities(Request $request)
    {
        $hotelid = $request->hotelid;
        if(!isset($request->hotelid)) {
			return redirect('hotel/edit/basic'); 
		}
        
        $hotelstatus = getTaxonomies('emotional_status');
		$action = 'edit';
		$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();
		$defaultCurrency = DB::table('currency')->where('is_active','0')->first();
		$hotelDetails = DB::table('hotel_detail')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0'])->first();
		$wizard_category = DB::table('wizard_categories')->where(['is_deleted'=>'0','is_active'=>'0','parent_id'=>1])->get();
		$hotelFeatures = DB::table('hotel_feature')->where(['hotel_id'=>$arrDetails->id])->first();

		$arrRecords['action'] = 'edit';
		$arrRecords['wizard_category'] = $wizard_category;
		$arrRecords['defaultCurrency'] = $defaultCurrency;
		$arrRecords['hoteldetails'] = $arrDetails;
		//$arrRecords['hotel_category'] = $hotel_category;
		$arrRecords['hotelFeatures'] = $hotelFeatures;

        return view('hotel/amenities', $arrRecords);
    }
	public function saveamenities(Request $request)
	{
		$newlang=[];
		if(isset($request->language)){
		$language=$request->language;
		foreach($language as $key=>$lang):
			$string='';
				foreach($lang as $keylang=>$vallang)
				{
					if(isset($vallang))
					$string.=$key.'->'.$vallang;
				}
			if($string!='')
			$newlang[$key]=$string;
			endforeach;
		}
		$setoption=implode(',',$request->set_option);
		$langval=implode(',',$newlang);
		$arraydetail=array(
							'set_option'=>$setoption,
							'language_key'=>$langval,
							'hotel_id'=>$request->hotel_id,
							);
		$hoteldetail=DB::table('hotel_feature')->where('hotel_id',$request->hotel_id)->first();				
		if(isset($hoteldetail->hotel_id))
		{
			DB::table('hotel_feature')->where('hotel_id',$request->hotel_id)->update($arraydetail);
		}
		else
		{
			DB::table('hotel_feature')->insert($arraydetail);
			
		}
		/*$query=	DB::getQueryLog();
		dd(end($query));*/
		$msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel Amenities Updated Successfully!</div>';
		return redirect('hotel')->with('msg', $msg);    
	}
    /* End : Amenities */

    /* extra */
    public function extra(Request $request)
    {
        $hotelid = $request->hotelid;
        return view('extra', compact('hotelid'));
    }
    /* End : extra */

    /* media */
    public function media(Request $request)
    {
        $hotelid = $request->hotelid;
        $arrdata['hotelid'] = $request->hotelid;        
        $arrdata['holetdetail'] = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();		
       	$query = "SELECT * FROM media_files WHERE master_id=$request->hotelid AND master_type=0 order by id desc";		
		$arrdata['holetmedia'] = DB::select($query);

	
        $arrdata['users']=DB::table('users')->where(['id'=>$request->user()->id])->first();
        return view('media', $arrdata);
    }

    public function fileupload(Request $request){		
		 $nome = $request->file('file')->getClientOriginalName();	
		Storage::put('images/hotel/'.$nome,file_get_contents($request->file('file')->getRealPath()));		
			DB::table('media_files')->insert([
			'name' => $nome,
			'code' => $request->code,
			'master_type' => 0,
			'type'=>'0',
			'master_id' => isset($request->master_id) ? $request->master_id : 0,
			'user_id'=>$request->user()->id,
			'date_time'=>time()
		]);	
	}
		
	public function fileget(Request $request){	
		DB::enableQueryLog();
		$where = 'code='.$request->code;
		if(isset($request->master_id)){
			$where .= ' or master_id ='.$request->master_id;
		} 
		$query = "SELECT * FROM media_files WHERE $where order by id desc";		
		$mediadata = DB::select($query);
		foreach($mediadata as $prev) {
			$imagPath = url('/storage/app/images/hotel/'.$prev->name);
			$downloadlink = url('/storage/app/images/hotel/'.$prev->name);
			$filename = $prev->name;			
			$arrcurrentextension = explode(".", $filename);
			$extention = end($arrcurrentextension);
							
			$arrextension['docx'] = 'docx-file.jpg';
			$arrextension['pdf'] = 'pdf-file.jpg';
			$arrextension['xlsx'] = 'excel.jpg';
			if(isset($arrextension[$extention])){
				$imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);			
			}
			$titleDescriptions = (!empty($prev->title)) ? '<div class="hey-content"><div class="hey-heading"><strong>'.$prev->title.'</strong></div><div class="hey-description"><p>'.$prev->description.'</p></div></div>' : "";
			$title = (!empty($prev->title)) ? '<strong>'.$prev->title.'</strong>' : "";
            $Descriptions = (!empty($prev->description)) ? '<p>'.$prev->description.'</p>' : "";
			
			$html = '<li data-thumb="'.$imagPath.'"><img src="'.$imagPath.'" /></li>';
            echo $html ;	
		}
		exit;			
	}
	public function updatemediaComment(Request $request){		 		
		$updateData = DB::table('media_files')->where('code', $request->code)->orderBy('id', 'desc')->first();										
		$title = $request->title;
		$descriptions = $request->descriptions;		
		$response = DB::table('media_files')->where('date_time', $updateData->date_time)->update(array('description' => $descriptions,'title'=>$title));	    
		echo ($response) ? 'success' :'fail';   				
		exit;
	}
		
	public function filedelete(Request $request){		
	    $response = DB::table('media_files')->where('id', $request->id)->delete();
	    echo ($response) ? 'success' :'fail';   				
		exit;
	}
	
	public function filetypeupdate(Request $request){		 
		$request->ids = isset($request->ids) ? implode(",",$request->ids) : "";
		$response = DB::table('media_files')->where('id', $request->fileid)->update(array('type' => $request->ids));	    
		echo ($response) ? 'success' :'fail';   				
		exit;
	}
	
	
    /* End : media*/

    /* media */
    public function paymentpolicies(Request $request)
    {
        $hotelid = $request->hotelid;
        $arrdata['hotelid'] = $request->hotelid;
        $arrdata['arrivaldays'] = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4');
        $arrdata['policy_details'] = DB::table('hotel_plolicies')->where('hotel_id',$hotelid)->first();
        return view('payment_policy', $arrdata);
    }
    /* End : media*/

    /* agreement */
    public function agreement(Request $request)
    {
        $hotelid = $request->hotelid;        
        $arrdata['hotelid'] = $request->hotelid;
        
        $arrdata['hoteldetails'] = DB::table('hotel_main')->where(['id'=>$request->hotelid])->first();		
        $arrdata['contract_details'] = DB::table('hotel_contract_details')->where(['hotel_id'=>$request->hotelid,'is_deleted'=>'0'])->first();		
        
        $arrdata['users']=DB::table('users')->where(['id'=>$request->user()->id])->first();
        return view('agreement', $arrdata);
    }
    /* End : agreement*/
	
	 public function billinginfo(Request $request) {            
        if(isset($request->hotelid)){
			$action = 'edit';			
			$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();
			
			$billing_address = DB::table('billing_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'0'])->first();
			$operator_billing_address = DB::table('billing_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'1'])->first();
			$invoice_address = DB::table('invoice_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'0'])->first();
			$operator_invoice_address = DB::table('invoice_address')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0','type'=>'1'])->first();

			$text_information = DB::table('text_information')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0'])->first();
			$languagetranslations = DB::table('language_transalation')->get();
			$arrtextlanguageval = array();
			foreach ($languagetranslations as $key => $value) {
				$arrtextlanguageval[$value->code][$value->language_key] = $value->language_value;
			}
			/*print_r($arrtextlanguageval);
			exit;*/
			$arrRecords['action'] = 'edit';
			$arrRecords['hoteldetails'] = $arrDetails;
			$arrRecords['billing_address'] = $billing_address;
			$arrRecords['invoice_address'] = $invoice_address;
			$arrRecords['operator_billing_address'] = $operator_billing_address;
			$arrRecords['operator_invoice_address'] = $operator_invoice_address;			        
			return view('hotel/billinginfo',$arrRecords);        
		}
    }
	 /* add/edit form details */
	public function otherdetail(Request $request) {    
        $action = 'add';
        $arrDetails = array();
        if(isset($request->hotelid)){
			$action = 'edit';			
			$arrDetails = DB::table('hotel_main')->where(['id'=>$request->hotelid,'is_deleted'=>'0'])->first();			
			$text_information = DB::table('text_information')->where(['hotel_id'=>$arrDetails->id,'is_deleted'=>'0'])->first();

			$languagetranslations = DB::table('language_transalation')->get();
			$arrtextlanguageval = array();
			foreach ($languagetranslations as $key => $value) {
				$arrtextlanguageval[$value->code][$value->language_key] = $value->language_value;
			}
			$arrRecords['action'] = 'edit';
			$arrRecords['hoteldetails'] = $arrDetails;			
			$arrRecords['text_information'] = $text_information;
			$arrRecords['text_information_language'] = $arrtextlanguageval;
        }
		return view('hotelotheredit',$arrRecords);        
    }
	 /* Save the Hotel Other Details */
	public function savehotelotherinfo(Request $request) {		     		
			/* Update Case */
			if(isset($request->hotel_id) && !empty($request->hotel_id) && $request->hotel_id != null && $request->action == 'edit') {			
				$hotelDetails = DB::table('hotel_main')->select('*')->where('id', $request->hotel_id)->first();								
				/* Store the log details */
				$logs = 'Hotel Other Detail Updated -> (ID:'.$request->hotel_id.')';
				storelogs($request->user()->id,$logs);
				$msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel Other Details saved successfully!</div>';
			}			
			$arrlanguages = getlanguages();			
			$hotelnamelang = str_replace(" ", "_", $hotelDetails->name);
			$name_key = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_name';
						$language_name_key = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_language_name_key';
						$lang_supplement_name = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_supplement_name';
						$short_description = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_short_description';
						$full_description = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_full_description';
						$exceptionality_dec = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_exceptionality_dec';
						$expert_evalution_desc = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_expert_evalution_desc';
						$special_offer = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_special_offer';
						$video_url = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_video_url';
						$video_assement = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_video_assement';
						$seo_title = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_title';
						$seo_keywords = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_keywords';
						$seo_desc = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_desc';						
						$seo_title_ref = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_title_ref';
						$seo_desc_ref = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_desc_ref';
						$seo_keyword_ref = 'keyword_'.$hotelnamelang.$hotelDetails->id.'_seo_keyword_ref';

				$text_information = array(
							'name'=>$name_key,
							'language_name'=>$language_name_key,
							'supplement_name'=>$lang_supplement_name,
							'short_description'=>$short_description,
							'full_description'=>$full_description,
							'exceptionality_dec'=>$exceptionality_dec,
							'expert_evalution_desc'=>$expert_evalution_desc,
							'special_offer'=>$special_offer,
							'video_url'=>$video_url,
							'video_assement'=>$video_assement,
							'seo_title'=>$seo_title,
							'seo_desc'=>$seo_desc,
							'seo_keywords'=>$seo_keywords,
							'seo_title_ref'=>$seo_title_ref,
							'seo_desc_ref'=>$seo_desc_ref,
							'seo_keyword_ref'=>$seo_keyword_ref);										
				
			$checkisExist = DB::table('text_information')->where(['hotel_id'=>$request->hotel_id])->count();	
			if($checkisExist > 0) {			
				/* Update Text Information with language translations */				
				DB::table('text_information')->where(['hotel_id'=>$request->hotel_id])->update($text_information);	
			}
			else {
				/* Insert Text Information with language translations */
				$text_information['hotel_id']=$request->hotel_id;
				DB::table('text_information')->insertGetId($text_information);
			}			

			foreach ($arrlanguages as $keylang => $valuelang) {
				$arrResponsevalue = array('name'=>$request['text_name_'.$valuelang->code],
					'language_name'=>$request['language_name_'.$valuelang->code],
					'supplement_name'=>$request['supplement_name_'.$valuelang->code],
					'short_description'=>$request['desc_short_'.$valuelang->code],
					'full_description'=>$request['desc_full_'.$valuelang->code],
					'exceptionality_dec'=>$request['desc_exception_'.$valuelang->code],
					'expert_evalution_desc'=>$request['desc_experteval_'.$valuelang->code],
					'special_offer'=>$request['special_offer_'.$valuelang->code],
					'video_url'=>$request['videos_'.$valuelang->code],
					'video_assement'=>$request['video_expert_'.$valuelang->code],
					'seo_title'=>$request['seo_title_'.$valuelang->code],
					'seo_desc'=>$request['seo_desc_'.$valuelang->code],
					'seo_keywords'=>$request['seo_keywords_'.$valuelang->code],
					'seo_title_ref'=>$request['seo_titleref_'.$valuelang->code],
					'seo_desc_ref'=>$request['seo_descref_'.$valuelang->code],
					'seo_keyword_ref'=>$request['seo_keywordsref_'.$valuelang->code]);
				if(isset($text_information['hotel_id'])){
					$removearr = array_pull($text_information, 'hotel_id');
				}				
				foreach ($text_information as $keyl => $valuel) {
					$language_transalation = DB::table('language_transalation')
					->where(['language_key'=>$valuel,'code'=>$valuelang->code])					
					->first();
					$label = str_replace("_", " ", $valuel);
					$language_value = $arrResponsevalue[$keyl];
					$arrlang=['language_label'=>$label,
						'language_value' => $language_value,					
						'code' => $valuelang->code];
					/*if(strpos($language_value,"</div>")||strpos($language_value,"</p>")) {
						$arrlang['is_cmspage']=1;
					}*/
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
		return redirect('hotel')->with('msg', $msg);     		
    }
	 public function savehotelpolicy(Request $request) {
		
		if(isset($request->hotel_id)) {
			$updateData['work_with_credit_card']=$request->work_with_credit_card;
			$updateData['credit_card_amount']=$request->credit_card_amount;			
			$updateData['credit_card_options'] = isset($request->credit_cards) ? implode(",", $request->credit_cards) : "";
		
			$updateData['hotel_id'] = $request->hotel_id;
			$counter=DB::table('hotel_detail')->where('hotel_id',$request->hotel_id)->count();
			if($counter!=0)
			DB::table('hotel_detail')->where('hotel_id',$request->hotel_id)->update($updateData);
			unset($updateData);
			
			if(isset($request->policy_day) && $request->policy_day){
				foreach ($request->policy_day as $key => $value) {
					$oldDetails = DB::table('hotel_cancelation_policy')->where(['hotel_id'=>$request->hotel_id,'policy_day'=>$value])->count();
					$updateData['percentage'] = isset($request->percentage[$key]) ? $request->percentage[$key] : '0';					
					if($oldDetails > 0) {
						DB::table('hotel_cancelation_policy')->where(['hotel_id'=>$request->hotel_id,'policy_day'=>$value])->update($updateData);	
					}
					else {
						$updateData['policy_day'] = $value;
						$updateData['hotel_id']= $request->hotel_id;					 	
						DB::table('hotel_cancelation_policy')->insertGetId($updateData);		
					}
				}
			}
			$msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Policy Detail Saved successfully!</div>';
			return redirect('hotel/edit/amenities/'.$request->hotel_id)->with('msg', $msg);     
		}
    }
	public function hotelpolicies(Request $request)
    {
        $hotelid = $request->hotelid;
        $arrdata['hotelid'] = $request->hotelid;
		$arrdata['hotel_detail']=DB::table('hotel_detail')->where('hotel_id',$request->hotelid)->first();
        /*$arrdata['arrivaldays'] = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4');
        $arrdata['policy_details'] = DB::table('hotel_plolicies')->where('hotel_id',$hotelid)->first();*/
        $arrdata['cancelation_policy'] = DB::table('hotel_cancelation_policy')->where('hotel_id',$hotelid)->get();
        return view('hotel/hotel_policy', $arrdata);
    }
	public function savehotelbillinfo(Request $request)
	{
		//dd($request->all());
		$nome='';
		if(isset($request->hotel_id)) {
			if ($request->filetype != null) {
			Storage::put('images/hotel/' .(time().$request->file('filetype')->getClientOriginalName()), file_get_contents($request->file('filetype')->getRealPath()));
			$nome = (time().$request->file('filetype')->getClientOriginalName());
			}
			if(!isset($request->contract_no)){
				$request->contract_no=generateCode(10);
			}
		 $arrbilling_address = array(
						'company'				=>$request->billing_company_name,						
						'contact_person'		=>isset($request->billing_contact_person) ? $request->billing_contact_person : '',
						'address'				=>isset($request->billing_address) ? $request->billing_address : '',
						'zip_code'				=>isset($request->billing_zipcode) ? $request->billing_zipcode : '',
						'phone'					=>isset($request->billing_phone) ? $request->billing_phone : '',
						'fax'					=>isset($request->billing_fax) ? $request->billing_fax : '',
						'billing_lang'			=>isset($request->billing_lang) ? implode(',',$request->billing_lang) : '',
						'iban'					=>isset($request->IBAN) ? $request->IBAN : '',
						'debit_iban'			=>isset($request->debit_iban) ? $request->debit_iban : '',
						'holder_name'			=>isset($request->holder_name) ? $request->holder_name : '',
						'ivan'					=>isset($request->iva) ? $request->iva : '',
						'vat_id'				=>isset($request->vat) ? $request->vat : '',
						'hotel_id'				=>$request->hotel_id,
						'contract_no'			=>isset($request->contract_no) ? $request->contract_no : '',
						'filename'				=>$nome
						);

           /* $arrbilling_address_operator = array(
						'type'=>'1',
						'hotel_id'=>$request->hotel_id,
						'company'=>$request->billing_opert_company_name,						
						'contact_person'=>isset($request->billing_opert_contact_person) ? $request->billing_opert_contact_person : "",					
						'address'=>isset($request->billing_opert_address) ? $request->billing_opert_address : '',
						'zip_code'=>isset($request->billing_opert_zipcode) ? $request->billing_opert_zipcode : '');
          	
          	$arrinvoice_address = array(
						'type'=>'0',
						'hotel_id'=>$request->hotel_id,
						'company'=>isset($request->invoice_hotel_name) ? $request->invoice_hotel_name : "",						
						'address'=>isset($request->invoice_address) ? $request->invoice_address : '',
						'zip_code'=>isset($request->invoice_zip_code) ? $request->invoice_zip_code : '',
						'IBAN'=>isset($request->IBAN) ? $request->IBAN : '');

          	$arrinvoice_address_operator = array(
						'type'=>'1',
						'hotel_id'=>$request->hotel_id,
						'company'=>isset($request->invoice_hotel_name_op) ? $request->invoice_hotel_name_op : "",						
						'address'=>isset($request->invoice_address_op) ? $request->invoice_address_op : '',
						'zip_code'=>isset($request->invoice_opert_zip_code) ? $request->invoice_opert_zip_code : '',
						'IBAN'=>isset($request->iban_op) ? $request->iban_op : '');	*/
						
			/* Update Billing Address */
			$billaddress=DB::table('billing_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'0'])->first();
			if(isset($billaddress))						
			DB::table('billing_address')->where(['hotel_id'=>$request->hotel_id])->update($arrbilling_address);	
			else
			DB::table('billing_address')->insert($arrbilling_address);						
			/*$billaddress=DB::table('billing_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'1'])->first();
			if(isset($billaddress))							
			DB::table('billing_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'1'])->update($arrbilling_address_operator);
			else
			DB::table('billing_address')->insert($arrbilling_address_operator);						
			
			$invoice=DB::table('invoice_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'0'])->first();
			if(isset($invoice))			
			DB::table('invoice_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'0'])->update($arrinvoice_address);
			else
			DB::table('invoice_address')->insert($arrinvoice_address);
			$invoice=DB::table('invoice_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'1'])->first();
			if(isset($invoice))			
			DB::table('invoice_address')->where(['hotel_id'=>$request->hotel_id,'type'=>'1'])->update($arrinvoice_address_operator);
			else
			DB::table('invoice_address')->insert($arrinvoice_address_operator);*/
			$logs = 'Hotel Billing Info Updated -> (ID:'.$request->hotel_id.')';
			storelogs($request->user()->id,$logs);
			$msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Hotel Basic Info updated successfully!</div>';
		}
		return redirect('hotel/edit/policies/'.$request->hotel_id)->with('msg', $msg);    
	}
	
 public function savewizard(Request $request)
    {
		$name = $request->name;
		$wizardoptions['user_id'] = $request->user()->id;
		$wizardoptions['category_id'] = $request->catid;
		$wizardoptions['title'] = $name;
		$wizardoptions['is_active'] = 0;
	
		DB::table('wizard_options')->where('id',$request->options_id)->update($wizardoptions);
	
		$msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Options Updated successfully!</div>';
	
	
	
	return $msg;

    }

	 /*
	  * =================================================== Hotel Prices Section =====================================================
	 */
    public function hotel_prices(Request $request) {
        $hotels = DB::table('hotel_main')->select('*')
            ->where('is_deleted', '=', 0);
        return view('hotel_prices', compact('hotels'));
    }

    public function getjsonpricelist()
    {
        $optionsDetails = array();
        $options = array();
        DB::enableQueryLog();
        $options = DB::table('hotel_main')
            ->leftJoin('hotel_season', 'hotel_main.id', '=', 'hotel_season.hotel_id')
            ->select('hotel_main.*','hotel_season.name as seasonName','hotel_season.category as searsonCategory','hotel_season.season_publish_at','season_from','season_to')
            ->where('hotel_main.id', '!=', '0')
            ->where('hotel_main.is_active', '0')
            ->where('hotel_main.is_deleted', '=', 0)->get();

         /*$queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);
                    exit;*/
        foreach ($options as $data) {
            $data->actions = '<a href="' . url('hotel/season/') ."/". $data->id . '"><i class="fa fa-eur" aria-hidden="true"></i></a>';
            $optionsDetails[] = $data;
        }
        return json_encode($optionsDetails);
    }


 /*============================================ Hotel Season section ========================================= */
    public function hotel_season(Request $request) {
    	$hotelid = $request->user()->hotel_id;
    	if(isset($request->hotel_id)){
    		$hotelid = $request->hotel_id;
   	 	}
        /*$seasons = DB::table('hotel_season')->where('hotel_id', $request->hotelid)->get();
        $arrdata['seasons'] = $seasons;*/
        //$arrdata['hotel_id'] = $request->hotelid;
        $arrdata['hotel_id'] =  $hotelid;                
        return view('hotel.hotel_seasons', $arrdata);
    }

    public function getjsonseasons(Request $request) {
        $optionsDetails = array();
        $options = array();
        $options = DB::table('hotel_season')->where('is_deleted','0')->get();
        /*->where('hotel_id', $request->hotelid)*/
        foreach ($options as $data) {
        	$data->season_from = dateFormate($data->season_from,'d.m.Y');
        	$data->season_to = dateFormate($data->season_to,'d.m.Y');        	
        	/*<a class="btn btn-xs btn-default" onclick="confermfun(event);" href="'.url('hotel/season/remove')."/".$data->id.'"><i class="fa fa-times" area-hidden="true"></i></a>&nbsp;*/
            $data->actions = '<a href="'.url('hotel/season/manage')."/".$data->id.'" class="btn btn-xs btn-default"><i class="fa fa-eur" aria-hidden="true"></i></a>';
            $optionsDetails[] = $data;
        }
        return json_encode($optionsDetails);
    }
    /* Hotel season section add/edit forms */
    public function hotelseasonaddedit(Request $request) {    	    	
    	$arrdata['action'] = 'add';
    	//$arrdata['countries'] = DB::table('countries')->where('flag_image','!=',"")->where('e_status','enable')->get();    	
    	$arrdata['countries'] = DB::table('countries')->where('e_status','enable')->get();    	
    	if(isset($request->season_id)) {
    		$arrdata['action'] = 'edit';
			$arrdata['seasonDetails'] = DB::table('hotel_season')->where('id',$request->season_id)->first();
    	}
        return view('hotel.seasons_add_edit', $arrdata);
    }

    public function hotelseasonsave(Request $request) {
    	$allcategory = implode($request->category, ",");
    	if(in_array("ALL", $request->category)) {
    		$allcategory = 'ALL';
    	}
        $season_data = [
            'name' => $request->name,
            'category' => $allcategory,           
            'hotel_id' => $request->hotel_id,
            'season_publish_at' => date('Y-m-d H:i:s'),
            'season_from' => date('Y-m-d H:i:s',strtotime($request->season_from)),
            'season_to' => date('Y-m-d H:i:s',strtotime($request->season_to))
        ];
        if(isset($request->season_id) && $request->season_id != "" && $request->action == 'edit'){
			DB::table('hotel_season')->where(['id'=>$request->season_id])->update($season_data);
			$seasonID = $request->season_id;
        }
        else {
        	$seasonID = DB::table('hotel_season')->insertGetId($season_data);        
    	}
        $lang_data = ['name' => $request->name];
        language_keyword_add($lang_data);
        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Season added successfully!</div>';        
        return redirect('hotel/season/edit/'.$seasonID)->with('msg', $msg);
    }

    public function hotelseasonremove(Request $request) {
        DB::table('hotel_season')->where('id', $request->seasonid)->update(array('is_deleted' => '1'));
        return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Season removed successfully</div>');
    }

    public function hotelseasonmanage(Request $request) {
    	$seessionData = DB::table('hotel_season')->where('id', $request->seasonid)->first();        	
    	$hotelRooms = array();
    	$hotelDetails = array();
    	$meals = array();
    	$agetype = DB::table('taxinomies_age_type')->get();
    	$room_net_prices = array();
		DB::enableQueryLog();
    	if(isset($seessionData->hotel_id)) {
    		$hotelRooms = DB::table('room_details')
    		->select('room_details.*','taxinomies_room_type.name as typename','taxinomies_room_type.code as typeCode','taxinomies_room_type.language_key as typelanguagekey')
    		->leftJoin('taxinomies_room_type', 'taxinomies_room_type.id', '=', 'room_details.type_of_rooms')
    		->where('hotelid',$seessionData->hotel_id)->get();
         	/* $queries = DB::getQueryLog();
                $last_query = end($queries);
                print_r($last_query);
                exit;*/ 
    		
    		$hotelDetails = DB::table('hotel_main')->where('id', $seessionData->hotel_id)->first();    
    		$hotelDetails->meals = trim($hotelDetails->meals,",");
    		$arrmealsid = explode(",", $hotelDetails->meals); 
    		/*$meals = DB::table('taxinomies_meals')->whereIn('id',$arrmealsid)->get();*/
    		$meals = DB::table('taxinomies_meals')->where('is_deleted','0')->get();
    		$room_net_prices = DB::table('room_net_prices')->where(['hotel_id'=>$seessionData->hotel_id])->get()->toArray();
    		$room_sale_prices = DB::table('room_sale_prices')->where(['hotel_id'=>$seessionData->hotel_id])->get()->toArray();
    	}  
    	
    	$allPersonType = array();  	
    	foreach ($agetype as $key => $value) {
    		$allPersonType[$value->id] = $value->name;
    	}
    	$arrData['seasons'] = $seessionData;
    	$arrData['hotelRooms'] = $hotelRooms;
    	$arrData['hotelDetails'] = $hotelDetails;    	
    	$arrData['hotelMeals'] = $meals;
    	$arrData['allPersonType'] = $allPersonType;
    	$arrData['room_net_prices'] = $room_net_prices;
    	$arrData['room_sale_prices'] = $room_sale_prices;
    	return view('hotel.hotel_seasons_manage', $arrData);
    }

  	/* Save the Room Net/Sale Prices */
	public function roomnetpricessave(Request $request) {			
	/* =============================================== Save Net Price Details ================================================= */
		$allmeals = isset($request->meals) ?  $request->meals : array();
		$allextrameals = isset($request->extrameals) ?  $request->extrameals : array();
		foreach ($allmeals as $kroomid => $vmeals) {
			$prices= (is_array($vmeals)) ? json_encode($vmeals) : $vmeals;				
			$oldata = DB::table('room_net_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>'0'])->get();
			$arrData['room_id']=$kroomid;
			$arrData['hotel_id']=$request->hotel_id;
			$arrData['season_id']=$request->season_id;

			$arrData['prices']=$prices;
			$arrData['is_extra_id']=0;
			if(count($oldata) > 0) {
				$arrData['update_user_id']=$request->user()->id;
				$arrData['updated_dt']=date('Y-m-d H:i:s');	
				DB::table('room_net_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>'0'])->update($arrData);
			}
			else {
				$arrData['user_id']=$request->user()->id;
				$recordid=DB::table('room_net_prices')->insertGetId($arrData);
			}
		}
		/*======================== Save Extra Meals Details =================================== */
		foreach ($allextrameals as $kroomid => $vextrameals) {
			foreach($vextrameals as $kpersontype => $valmeals){
				$pricesex= (is_array($valmeals)) ? json_encode($valmeals) : $valmeals;				
				$oldataEx = DB::table('room_net_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>$kpersontype])->get();
				$arrDataEx['room_id']=$kroomid;
				$arrDataEx['hotel_id']=$request->hotel_id;
				$arrDataEx['season_id']=$request->season_id;

				$arrDataEx['prices']=$pricesex;
				$arrDataEx['is_extra_id']=$kpersontype;
				if(count($oldataEx) > 0) {
					$arrDataEx['update_user_id']=$request->user()->id;
					$arrDataEx['updated_dt']=date('Y-m-d H:i:s');	
					DB::table('room_net_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>$kpersontype])->update($arrDataEx);
				}
				else {
					$arrDataEx['user_id']=$request->user()->id;
					$recordid=DB::table('room_net_prices')->insertGetId($arrDataEx);
				}
			}
		}
	/* =================================================== Save Sale Price Details ================================================= */
		$saleallmeals = isset($request->salemeals) ?  $request->salemeals : array();
		$saleallextrameals = isset($request->saleextrameals) ?  $request->saleextrameals : array();
		foreach ($saleallmeals as $kroomid => $vmeals) {
			$prices= (is_array($vmeals)) ? json_encode($vmeals) : $vmeals;				
			$oldata = DB::table('room_sale_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>'0'])->get();
			$arrData['room_id']=$kroomid;
			$arrData['hotel_id']=$request->hotel_id;
			$arrData['season_id']=$request->season_id;
			$arrData['discount']=$request->discount;
			$arrData['prices']=$prices;
			$arrData['is_extra_id'] = 0;
			if(count($oldata) > 0) {
				$arrData['update_user_id']=$request->user()->id;
				$arrData['updated_dt']=date('Y-m-d H:i:s');	
				DB::table('room_sale_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>'0'])->update($arrData);
			}
			else {
				$arrData['user_id']=$request->user()->id;
				$recordid=DB::table('room_sale_prices')->insertGetId($arrData);
			}
		}
		/*======================== Save Extra Meals Details =================================== */
		foreach ($saleallextrameals as $kroomid => $vextrameals) {
			foreach($vextrameals as $kpersontype => $valmeals){
				$pricesex= (is_array($valmeals)) ? json_encode($valmeals) : $valmeals;				
				$oldataEx = DB::table('room_sale_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>$kpersontype])->get();
				$arrDataEx['room_id']=$kroomid;
				$arrDataEx['hotel_id']=$request->hotel_id;
				$arrDataEx['season_id']=$request->season_id;
				$arrData['discount']=$request->discount;

				$arrDataEx['prices']=$pricesex;
				$arrDataEx['is_extra_id']=$kpersontype;
				if(count($oldataEx) > 0) {
					$arrDataEx['update_user_id']=$request->user()->id;
					$arrDataEx['updated_dt']=date('Y-m-d H:i:s');	
					DB::table('room_sale_prices')->where(['room_id'=>$kroomid,'season_id'=>$request->season_id,'is_extra_id'=>$kpersontype])->update($arrDataEx);
				}
				else {
					$arrDataEx['user_id']=$request->user()->id;
					$recordid=DB::table('room_sale_prices')->insertGetId($arrDataEx);
				}
			}
		}
		$msg =  '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Price updated successfully!</div>';
		$logs = 'Room Prices Updated -> (Hotel ID:'.$request->hotel_id.')';
		storelogs($request->user()->id,$logs);
		return redirect('hotel/season/manage/'.$request->season_id)->with('msg', $msg); 		
    }


 /*=================================== Hotel Options Sections ========================================================== */

 	public function hotel_options()
    {
        $hotels = DB::table('hotel_main')->select('*')->where('is_deleted', '=', 0);
        
        $max_room_places = DB::table('room_details')->max('can_sleep');              

        $max_room_extra_places = DB::table('room_detail_extra_bed')
        ->select(DB::raw('quantity as quantity'), DB::raw('sum(quantity) as total'))
        ->groupBy(DB::raw('quantity'))
        ->orderBy('total', 'desc')
        ->first();

        $arrData['hotels'] = $hotels;
        $arrData['max_room_places'] = $max_room_places;
        $arrData['max_room_extra_places'] = isset($max_room_extra_places->total) ? $max_room_extra_places->total : 0;
        return view('hotel_options', $arrData);
    }
	
     public function getjsonoptionslist()
    {

        $optionsDetails = array();
        $options = array();

        $options = DB::table('hotel_main')
        ->select('*')->where('id', '!=', '0')->where('is_active', '0')->where('is_deleted', '=', 0)->get();

        foreach ($options as $data) {
            $data->actions = '<a class="btn btn-xs btn-default tooltips" title="rooms" data-toggle="tooltip" href="#" onclick="showRoomsModal('.$data->id.')"><i class="fa fa-home"></i></a>&nbsp; &nbsp; &nbsp;<a class="btn btn-xs btn-default" href="#" onclick="showPlacementModal('.$data->id.')"><i class="fa fa-th-large"></i></a>&nbsp; &nbsp; &nbsp;<a class="btn btn-xs btn-default" title="meals" data-toggle="tooltip" href="#" onclick="showMealsModal('.$data->id.')"><i class="fa fa-cutlery"></i></a>&nbsp; &nbsp; &nbsp;<a class="btn btn-xs btn-default" title="meals combination" data-toggle="tooltip" href="#" onclick="showMealsCombinationModal('.$data->id.')"><i class="fa fa-list"></i></a>&nbsp; &nbsp; &nbsp;<a class="btn btn-xs btn-default" title="Penalty" data-toggle="tooltip" href="#" onclick="showPenaltyModal('.$data->id.')"><i class="fa fa-exclamation-circle"></i></a>';

            $optionsDetails[] = $data;
        }
        return json_encode($optionsDetails);
    }
	
    public function get_room_placement_modal(Request $request) { 
	       
        $roomDetails = DB::table('room_details')->where('id', $request->room_id)->where('is_deleted', '=', 0)->first(); 
		
		if(!empty($roomDetails)&&isset($roomDetails->id)){
			
		$maxroomdetail = DB::table('room_details')
						->where('hotelid', $roomDetails->hotelid)
						->where('is_deleted', '=', 0)
						->select(DB::raw('max(standard_bed) as maxstandard, max(extra_bed) as maxextra'))
						->first(); 
		
		$placecount=isset($maxroomdetail->maxstandard)?$maxroomdetail->maxstandard:0;
      	$extraplacecount = isset($maxroomdetail->maxextra) ? $maxroomdetail->maxextra : 0;     
        $ids = array(); // ids to be checked from all ids
        $html = '<table class="table table-striped"> <thead><tr><th>Room</th>' ;                           
       for($placesi=1;$placesi <= $placecount;$placesi++){
        $html .='<th>Place '.$placesi.'</th>';
	   }
       for($placesEx=1;$placesEx <= $extraplacecount;$placesEx++){
           $html .='<th>Extra Place '.$placesEx.'</th>';
	   }                         
           $html .= '</tr></thead><tbody>';
		
       $standcount=($placecount>2)?2:$placecount;
        $ageType = DB::table('hotel_agediscount')->where('hotel_id',$roomDetails->hotelid)->where('status',1)->orderBy('age_from','desc')->get();
		$counter=pow($ageType->count(),$standcount);$inside=0;$last=0;$insidex=0;$lastx=0;
		$places=json_decode($roomDetails->room_places,true);
		$extra_places=json_decode($roomDetails->room_extra_places,true);
		//dd($extra_places);
        while($counter>0){  	
             $counter--;   
           $nameroom = isset($roomDetails->personal_name) ? $roomDetails->personal_name : "-";
           $html .='<tr class="placement'.$counter.'"><td><div class="ryt-chk"><input id="placement'.$counter.'" class="checkremove" type="checkbox"><label for="placement'.$counter.'">'.$nameroom.'</label></div></td>';
           //$html .='<td>'.$nameroom.'</td>';                                                                    

           $i = 0;
           for($placesi=1;$placesi <= $placecount;$placesi++) {
			  $disablepc=($roomDetails->standard_bed<$placesi)?'disabled="disabled"':'';
			  $html .='<td><div class="form-group">';
			  if((($placesi + $standcount) > $roomDetails->standard_bed ) && ($placesi<=$roomDetails->standard_bed)){
					if(($placesi+$standcount)==$roomDetails->standard_bed+1)
					{
						//$html.= "<span>inside".$inside.$placesi.$roomDetails->standard_bed."</span>";
						$markey=$inside;
					}
					else
					{
						$markey=$last;
						$last++;
						if($last==$ageType->count()){
							$last=0;
							$inside++;
						}
					}
				}
				else{
					$markey=0;
				}
	          $html .='<select class="form-control" name="place['.$counter.'][]" '.$disablepc.'>';	          
	          foreach($ageType as $agekey => $ageval) {
	          	//$select = (isset($places[$i]) && $places[$i] == $ageval->id) ? 'selected' : '';
				$select =  '';	
				if(isset($places))
				{
					$select=(isset($places[$counter][$placesi-1]) && $places[$counter][$placesi-1]==$ageval->id) ? 'selected' :$select;
					//$name=(isset($places[$counter][$placesi]) && $places[$counter][$placesi]==$ageval->id) ? $places[$counter][$placesi] :'blank';
				}else{
					$select = (isset($ageType[$markey]->id) && $ageType[$markey]->id == $ageval->id) ? 'selected' : '';
				}
	          	$html .='<option value="'.$ageval->id.'" '.$select.'>'.$ageval->display_name.'</option>';
	       	  }
	       	  $html .='</select>';
			  //$html.=(isset($places[$counter][$placesi]) && $places[$counter][$placesi]==$ageval->id) ? $places[$counter][$placesi] :'no record';
			  $html.='</div></td>';
	       	  $i++;
	       }
	       $j=0;
			for($placesi=1;$placesi <= $extraplacecount;$placesi++) {
				$disableex=($roomDetails->extra_bed < $placesi)?"disabled='disabled'":'';
	            $html .='<td><div class="form-group">';
			    $html.='<select class="form-control" name="extraplace['.$counter.'][]" '.$disableex.'>';
			    if((($placesi + $standcount) > $roomDetails->extra_bed ) && ($placesi<=$roomDetails->extra_bed)){
				   if(($placesi+$standcount)==$roomDetails->extra_bed+1){
							$markey=$insidex;
						}
						else
						{
							$markey=$lastx;
							$lastx++;
							if($lastx==$ageType->count()){
								$lastx=0;
								$insidex++;
							}
						}
				}
				else{
					$markey=0;
				}
	          foreach($ageType as $agekey => $ageval) {	          	
	          	$selectex =  '';
				if(isset($extra_places))
				{
					$selectex=(isset($extra_places[$counter][$placesi-1]) && $extra_places[$counter][$placesi-1]==$ageval->id) ?'selected':$selectex;
				}
				else{
					$selectex = (isset($ageType[$markey]->id) && $ageType[$markey]->id == $ageval->id) ? 'selected' : '';
				}
	           	$html .='<option value="'.$ageval->id.'" '.$selectex.'>'.$ageval->display_name.'</option>';
	       	  }
	       	  $html .'</select></div></td>';
	       	  $j++;
	       }
	       $html .='</tr>';      
        }
		$html.='</tbody></table>';
        echo $html;  
		}
		else
		{
			echo "No Record Found";
		}
    }

    public function update_hotel_placement_options(Request $request)
    {    
	
    	$roomDetails = DB::table('room_details')->where('id', $request->room_id)->where('is_deleted', '=', 0)->first();        
    	  	$roomPlaces=  json_encode($request->place); 
			$room_extra_places=  json_encode($request->extraplace); 
					
    		$options_data = ['room_places' => $roomPlaces,'room_extra_places'=>$room_extra_places];
    		DB::table('room_details')->where('id', $roomDetails->id)->update($options_data);
    	
        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Options updated successfully!</div>';
        return Redirect::back()->with('msg', $msg);
    }


    public function get_room_list_modal(Request $request)
    {
        //getting room type from table to for checked
        $type_of_rooms = DB::table('room_details')->select('type_of_rooms')
            ->where('hotelid', $request->hotel_id)
            ->where('options_status', '1')
            ->get();

        $ids = []; // ids to be checked from all ids
        foreach($type_of_rooms as $key=> $value)
        {
            $ids[] =  $value->type_of_rooms;
        }

        $hotel_room_ids = fetch_room_from_hotel_main($request->hotel_id,'array');

        echo '<ul class="list-unstyled">';

        echo "<input type='hidden' name='hotel_id' value='".$request->hotel_id."'>";
        if(count($hotel_room_ids) > 0)
        {
            foreach($hotel_room_ids as $key => $value)
            {
                $room_details = DB::table('taxinomies_room_type')->select('*')->where('id', $value)->get()->first();
                if(count($room_details) > 0)
                {
                    $checked = in_array($room_details->id, $ids) ? 'checked' : '';
                    echo "<li><div class='ryt-chk'><input id='".$room_details->id."' name='room_options[]' value='".$room_details->id."' type='checkbox' ".$checked."><label for='".$room_details->id."'>".ucwords(strtolower($room_details->name))."</label></div></li>";
                }
                else{
                    echo "<li>No rooms available</li>";
                }
            }

        }

        echo '</ul>';
    }


     public function update_hotel_options(Request $request)
    {
        //dd($request->all());

        $update_all_status = [
            'options_status' => '0'
        ];
        DB::table('room_details')->where('hotelid', $request->hotel_id)->update($update_all_status);


        if(count($request->room_options) > 0)
        {
            foreach($request->room_options as $key => $value)
            {

                $array = Db::table('room_details')->select('hotelid', 'type_of_rooms')
                    ->where('hotelid', $request->hotel_id)
                    ->where('type_of_rooms', $value)->get()->first();

                $options_data = [
                    'hotelid' => $request->hotel_id,
                    'type_of_rooms' => $value,
                    'user_id' => $request->user()->id,
                    'updated_user_id' => $request->user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'options_status' => '1'
                ];

                if(count($array) > 0)
                {
                    DB::table('room_details')->where('type_of_rooms', $value)->update($options_data);
                }
                else{
                    DB::table('room_details')->insert($options_data);
                }
            }
        }


        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Options updated successfully!</div>';

        return Redirect::back()->with('msg', $msg);
    }
    /*Hotel Options*/
	
	     /*Meals section*/
    public function get_meals_list_modal(Request $request)
    {

        $selected_meals = DB::table('hotel_main')->select('meals')->where('id', $request->hotel_id)->get()->first();

        $ids_in_array = explode(',', $selected_meals->meals);

        echo '<ul class="list-unstyled">';

        echo "<input type='hidden' name='hotel_id' value='".$request->hotel_id."'>";

        $meals = DB::table('taxinomies_meals')->select('*')->get();

        if(count($meals) > 0)
        {
            foreach($meals as $key => $meals_details)
            {

                $checked = in_array($meals_details->id, $ids_in_array) ? 'checked' : '';
                echo "<li><div class='ryt-chk'><input id='".$meals_details->id."' name='meals_options[]' value='".$meals_details->id."' type='checkbox' ".$checked."><label for='".$meals_details->id."'>".$meals_details->name."</label></div></li>";
            }

        }else
        {
            echo "<li>No meals availabe</li>";
        }


        echo '</ul>';
    }

    public function update_meals_options(Request $request)
    {
        $meals = $request->meals_options;
        $meals_ids = implode(',', $meals);
        echo $meals_ids;

            $meals_data = [
                'meals' => $meals_ids,
                'updated_user_id' => $request->user()->id,
                'updated_dt' => date('Y-m-d H:i:s'),
            ];

            DB::table('hotel_main')->where('id', $request->hotel_id)->update($meals_data);

        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Meals updated successfully!</div>';

        return Redirect::back()->with('msg', $msg);
    }
    /*Meals section*/


    /*Meals combination section*/
    public function get_meals_combination_list_modal(Request $request)
    {

        $selected_meals = DB::table('hotel_main')->select('meals_combination')->where('id', $request->hotel_id)->get()->first();

        $ids_in_array = explode(',', $selected_meals->meals_combination);


        echo '<ul class="list-unstyled">';

        echo "<input type='hidden' name='hotel_id' value='".$request->hotel_id."'>";

        $meals_combinations = DB::table('taxinomies_meals_combination')->select('*')->get();

        if(count($meals_combinations) > 0)
        {
            foreach($meals_combinations as $key => $meals_combination_details)
            {

                $checked = in_array($meals_combination_details->id, $ids_in_array) ? 'checked' : '';
                echo "<li><div class='ryt-chk'><input id='".$meals_combination_details->id."' name='meals_combination_options[]' value='".$meals_combination_details->id."' type='checkbox' ".$checked."><label for='".$meals_combination_details->id."'>".getMealCombinationName($meals_combination_details->id)."</label></div></li>";
            }

        }else
        {
            echo "<li>No meals combination availabe</li>";
        }


        echo '</ul>';
    }

    public function update_meals_combination_options(Request $request)
    {
        $meals_combinations = $request->meals_combination_options;
        $meals_combinations_ids = implode(',', $meals_combinations);
        echo $meals_combinations_ids;


        $meals_combinations_data = [
            'meals_combination' => $meals_combinations_ids,
            'updated_user_id' => $request->user()->id,
            'updated_dt' => date('Y-m-d H:i:s'),
        ];
        DB::table('hotel_main')->where('id', $request->hotel_id)->update($meals_combinations_data);




        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Meals Combination successfully!</div>';

        return Redirect::back()->with('msg', $msg);
    }
    /*Meals combination section*/

 /*Penalty Section*/
    public function get_penalty_list_modal(Request $request)
    {
        $selected_penalties = DB::table('hotel_cancelation_policy')->select('*')->where('hotel_id', $request->hotel_id)->get();
        $selected = [];
        $selected_percentage = [];
        foreach($selected_penalties as $k => $v) {
            $selected[] = $v->policy_id;
            $selected_percentage[$v->policy_id] = $v->percentage;
        }
        //pre($selected);
        echo '<ul class="list-unstyled">';
        echo "<input type='hidden' name='hotel_id' value='".$request->hotel_id."'>";
        $penalty = DB::table('taxinomies_cancellation_policy')->select('*')->get();
        if(count($penalty) > 0) {
            foreach($penalty as $key => $penalty_details) {
                $checked = in_array($penalty_details->id, $selected) ? 'checked' : '';
                $percentage_value = isset($selected_percentage[$penalty_details->id]) ? $selected_percentage[$penalty_details->id] : '';
                echo "<li><div class='ryt-chk'><input id='".$penalty_details->id."' onclick='percentageActive(this)' name='penalty_options[]' value='".$penalty_details->id."' type='checkbox' ".$checked."><label for='".$penalty_details->id."'>".$penalty_details->name."</label></div><div class='pull-right'><input type='text' value='".$percentage_value."' class='form-control pull-left percentage_".$penalty_details->id."' style='width:50px;' name='percentage[]'  id=''><span> &nbsp; &nbsp; &nbsp; % of the price per person</span></div><div class='clearfix'></div></li>";
            }
//            echo "<li><div class='ryt-chk'><input id='extra_checkbox' onclick='percentageActive(this)' name='extra_checkbox' value='".$penalty_details->id."' type='checkbox' ".$checked."><label for='extra_checkbox'></label><input type='text' class='form-control extra_name' name='extra_name' id=''></div><div class='pull-right'><input type='text' class='form-control pull-left extra_percentage' style='width:50px;' name='extra_percentage'  id=''><span> &nbsp; &nbsp; &nbsp; % of the price per person</span></div><div class='clearfix'></div></li>";

        }
        else {
            echo "<li>No panelty availabe</li>";
        }
        echo '</ul>';
    }

	public function update_penalty_options(Request $request) {

        if(count($request->penalty_options) > 0) {
            foreach($request->penalty_options as $key=> $value) {
                $penalty_data = [
                    'hotel_id' => $request->hotel_id,
                    'percentage' => $request->percentage[$key],
                    'policy_id' => $value,
                    'date' => date('Y-m-d H:i:s')
                ];
                $check = DB::table('hotel_cancelation_policy')->select('*')
                    ->where('hotel_id', $request->hotel_id)
                    ->where('policy_id',$value)->get();
                /*test*/
                $ids_for_delete = DB::table('hotel_cancelation_policy')->select('*')
                    ->where('hotel_id', $request->hotel_id)->get();
                foreach($ids_for_delete as $k => $v) {
                    if(!in_array($v->policy_id, $request->penalty_options)){
                        DB::table('hotel_cancelation_policy')->where('hotel_id', $request->hotel_id)->where('policy_id', $v->policy_id)->delete();
                    }
                }
                /*test*/
                if(count($check) > 0) {
                    DB::table('hotel_cancelation_policy')
                        ->where('hotel_id', $request->hotel_id)
                        ->where('policy_id', $value)
                        ->update($penalty_data);
                }
                else {
                    DB::table('hotel_cancelation_policy')->insert($penalty_data);
                }
            }
        }        
        $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Penalty updated successfully!</div>';
        return Redirect::back()->with('msg', $msg);
    }
    /* Penalty Section */



}
