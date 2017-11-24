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


class AdminController extends Controller
{	
	public function __construct(Request $request){ 
        $this->middleware('auth');
    }
	public function index(Request $request) {		
        if ($request->user()->id != 0 && $request->user()->dipartimento != 0) {
	 	      return redirect('/unauthorized');
        }
        else {        	
		    return $this->show($request);
        }
    }
    public function show(Request $request) {
		return view('admin', [
			'logo' =>  base64_encode(Storage::get('images/logo.png')),
			'adminsettings'=> DB::table('admin_settings')->select('*')->first(),
            'profilazioni' => DB::table('ruolo_utente')->select('*')->where('is_delete',0)->get(),
		]);
	}
	
	// Language details
    public function language(Request $request) {
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {*/
			    return view('language', [
                    'language' => DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_deleted', '=', 0)
                        ->paginate(10),
            ]);
        //}
    }
	
	
	// Language details
    public function getjsonlanguage(Request $request) {
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {*/ 
			$data = DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->where('is_deleted', '=', 0)
                        ->get();            
			foreach($data as $data) {				
				if($data->icon != ""){					
					$data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';			
				}
				$ente_return[] = $data;	
			}
			return json_encode($ente_return);
        //}
    	}

    public function modifylanguage(Request $request) {    
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {*/
			$language = array();
            if($request->languageid){
                $language = DB::table('languages')->select('*')
                        ->where('id', $request->languageid)
                        ->first();
			}  			
			/*Insert Into Logs */
			return view('modifylanguage', ['language' => $language]);
        //}
    }
	/* Save the lanuage*/
	public function saveLanguage(Request $request) {		
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {*/
			if(isset($request->languageid) && !empty($request->languageid)){
				$validator = Validator::make($request->all(), [
					'code' => 'required|max:3|min:2|unique:languages,code,'.$request->languageid.',id',
					'name' => 'required|max:50',
					'icon'=>'mimes:jpeg,jpg,png|max:1000'
				]);
			}
			else {
				$validator = Validator::make($request->all(), [
					'code' => 'required|max:3|min:2|unique:languages,code',
					'name' => 'required|max:50',
					'icon'=>'mimes:jpeg,jpg,png|max:1000'
				]);
			}

            if ($validator->fails()) {            	
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
			/* Update Case */
			if(isset($request->languageid) && !empty($request->languageid) && $request->languageid != null){				
				$logo = DB::table('languages')
						->select('icon')
						->where('id', $request->languageid)
						->first();
				
				$arr = json_decode(json_encode($logo), true);
				$nome = $arr['icon'];
				
				if ($request->icon != null) {
					// Memorizzo l'immagine nella cartella public/imagesavealpha
					Storage::put('images/languageicon/' . $request->file('icon')->getClientOriginalName(), file_get_contents($request->file('icon')->getRealPath())
					);
					$nome = $request->file('icon')->getClientOriginalName();
				}
				DB::table('languages')
						->where('id', $request->languageid)
						->update(array(
							'code' => $request->code,
							'icon' => $nome,
							'name' => $request->name,
							'original_name' => $request->original_name,
							'is_default'=>isset($request->is_default) ? $request->is_default : '0'
				));
				if(isset($request->is_default) && $request->is_default == '1'){
					DB::table('languages')
						->where('id', '!=', $request->languageid)
						->update(array('is_default'=>'0'));
				}
				/* Store the log details */
				$logs = 'Update Langauge -> (ID:'.$request->languageid.')';
				/*storelogs($request->user()->id,$logs);*/
				return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language updated successfully!</div>');
			}
			else {				
				$nome = "";
				if ($request->icon != null) {					
					Storage::put('images/languageicon/' . $request->file('icon')->getClientOriginalName(), file_get_contents($request->file('icon')->getRealPath()));
					$nome = $request->file('icon')->getClientOriginalName();
				}				
				if(isset($request->is_default) && $request->is_default == '1'){
					DB::table('languages')
						->where('id', '!=', 0)
						->update(array('is_default'=>'0'));
				}
				DB::table('languages')->insert(array(
							'code' => $request->code,
							'icon' => $nome,
							'name' => $request->name,
							'original_name' => $request->original_name,
							'is_default'=>isset($request->is_default) ? $request->is_default : '0'
				));
				return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language added successfully!</div>');
			}
       // }
    }
	
	/* This function is used to delete languages */
	public function destroylanguage(Request $request) {
        /*if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
		else {*/
			    $countRec = DB::table('languages')
                        ->select('*')
                        ->where('id', $request->languageid)
						->where('is_default','1')
                        ->count();
			if($countRec > 0){
				return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Default Language not destroyed!</div>');
				
			}
			else {
            DB::table('languages')
						->where('id', $request->languageid)
						->update(array(
							'is_deleted' =>'1'
				));
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language deleted successfully!</div>');
			}
        //}
    }
	
	
	public function translation(Request $request){
		$re = DB::table('languages')->where('id',$request->code)->first();
		return view('language_translation', [
            'language_transalation' => DB::table('language_transalation')->where('code',$re->code)->get(),
            'language' => DB::table('languages')->where('is_deleted','0')->where('code',$re->code)->first(),
			'code' => $re->code,
        ]);		
	}
	
	
	public function destroytranslation(Request $request) {
		  DB::table('language_transalation')
            ->where('id', $request->id)
            ->delete();
			
			return Redirect::back()
		  ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Phase deleted successfully!</div>');
	}
	public function getjsontranslation(Request $request)
	{
		
		$data = DB::table('language_transalation')				
				->select('*')
				->where('code',$request->code)				
				->get();
			
			$data_return= array();
			/*foreach($data as $data) {				
				$data_return[] = $data->language_label;					
			}*/
		return json_encode($data);
	}
	/* This function is used to autocomlete */
	public function getpharses(Request $request) {				
		$label=$request->term;
		$data = DB::table('language_transalation')				
				->select('*')
				->where('language_label', 'LIKE', "%$label%")						
				->where('code','en')
				->limit(10)
				->get();
			
			$data_return= array();
			foreach($data as $data) {											
				 $data_return[] = array (
          		  'label' => $data->language_label,
            	  'value' => $data->language_label,
            	  'id' => $data->id
        		);
			}
		return json_encode($data_return);		
	}

	public function addedittranslation(Request $request){
		if(isset($request->id)){
			$language_transalation = DB::table('language_transalation')->where('id',$request->id)->first();

			$NextRecord = DB::select(DB::raw("select * from language_transalation where id = (select min(id) from language_transalation where code = '$language_transalation->code' AND id > $request->id)"));
			$PreviouseRecord = DB::select(DB::raw("select * from language_transalation where id = (select max(id) from language_transalation where code ='$language_transalation->code' AND id < $request->id)"));
			
			return view('modify_language_translation', 
			['language_transalation' => $language_transalation,
			'language_selected' => DB::table('languages')->where('code',$language_transalation->code)->first(),
			'language' => DB::table('languages')->where('is_deleted','0')->get(),
			'NextRecord' => $NextRecord,
			'PreviouseRecord' => $PreviouseRecord]);
		}
		else {
			return view('modify_language_translation',
			['language' => DB::table('languages')->where('is_deleted','0')->get(),
			'language_selected' => DB::table('languages')->where('code','en')->first()]);
		}
	}

	public function savetranslation(Request $request){
			$validator = Validator::make($request->all(), [
				'keyword_title' => 'required'
			]);			

            if($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		foreach($arrLanguages as $key => $val){			
			if(isset($request[$val->code.'_keyword_desc'])){
				$language_value = $request[$val->code.'_keyword_desc'];
				$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
					DB::table('language_transalation')->insert([
						'language_key' => $keyword_key,
						'language_label' =>$request['keyword_title'],
						'language_value' => $language_value,					
						'code' => $val->code
					]);
			}		
		}
		$this->writelanguagefile();
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language Translation added successfully!</div>');
		
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
		/* Write the php file for the js variables  *
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
			
		}*/

	}
	public function updatetranslation(Request $request){
		$validator = Validator::make($request->all(), [
				'keyword_title' => 'required'
			]);	
            if($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)                        
                        ->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		
		foreach($arrLanguages as $key => $val){
			if(isset($request[$val->code.'_keyword_desc'])){
				$language_value = $request[$val->code.'_keyword_desc'];
				$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
				$language_transalation = DB::table('language_transalation')->where(['language_key'=>$keyword_key,'code'=>$val->code])->first();
				$arrlang=[
							'language_label' =>$request['keyword_title'],
							'language_value' => $language_value,					
							'code' => $val->code
						];
				if(strpos($language_value,"</div>")||strpos($language_value,"</p>")) {
					$arrlang['is_cmspage']=1;
				}
				if(count($language_transalation) > 0) {
						DB::table('language_transalation')
							->where('language_key', $request->key)							
							->where('code', $val->code)
							->update($arrlang);
				}
				else
				{
					$arrlang['language_key'] = $keyword_key;
					DB::table('language_transalation')->insert($arrlang);
				}
			}		
		}
		$this->writelanguagefile();
		if($request->hdSaveType != '0' && isset($request->nextrecordid) && $request->nextrecordid != ''){
			$moveRecordid = ($request->hdSaveType == 1) ? $request->nextrecordid : $request->previouserecordid; 
			return redirect('/language/modify/translation/'.$moveRecordid)->with('error_code', 5)->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language translation updated successfully!</div>');
		}
		else {
			return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Language translation updated successfully!</div>');
        }		
	}

   /* ==================================== Currency section START ======================================== */
    public function deletecurrency(Request $request) {
        /*if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {*/
        	if($request->id != 1) {
         	   DB::table('currency')->where('id', $request->id)->delete();
         	   $msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Currency deleted successfully</div>';
        	}
        	else {
        		$msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_can_not_delete_base').'</div>';
        	}
            return Redirect::back()->with('msg',$msg);
      //  }
    }

    public function storecurrency(Request $request) {
        /*if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {*/
            $validator = Validator::make($request->all(), ['name' => 'required','code' => 'required','symbol'=>'required']);
			if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $curreny_id = $request->input('curreny_id');
            if ($curreny_id && $curreny_id != "") {
                $name = $request->input('name');
                $code = $request->input('code');
                $symbol = $request->input('symbol');    
                DB::table('currency')
                        ->where('id', $curreny_id)
                        ->update(array(
                            'name' => $name,
                            'code'=>$code,
                            'symbol' =>$symbol));
                return Redirect::back()
                                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Currency updated successfully</div>');
            } 
            else {
                DB::table('currency')->insert([
                    'name' => $request->name,
                    'code' => $request->code,
                    'symbol' => $request->symbol,
                ]);
                return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Currency inserted successfully</div>');
            }
       // }
    }

    public function getjsoncurrency(Request $request) {
        $currency = DB::table('currency')->get()->toArray();
		foreach ($currency as $key => $usr) {
        	$checked = ($usr->is_active==0) ? 'checked' : '';
        	if($usr->is_active==0){
        		$currency[$key]->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTaxionStatus('.$usr->id.')" id="activestatus_'.$usr->id.'" '.$checked.' disabled on value="1"  type="checkbox"><label for="activestatus_'.$usr->id.'"></label></div>';           
        	}
        	else {
        	$currency[$key]->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTaxionStatus('.$usr->id.')" id="activestatus_'.$usr->id.'" '.$checked.'  on value="1"  type="checkbox"><label for="activestatus_'.$usr->id.'"></label></div>';           	
        	}
        }
        return json_encode($currency);
    }

	public function updatecurrencystatus(Request $request) {				
		$updateAll = DB::table('currency')->update(array('is_active' => 1));
		$update = DB::table('currency')->where('id', $request->id)->update(array('is_active' => $request->status));
		return ($update) ? 'true' : 'false';		
	}

    // show taxation form
    public function addeditcurrency(Request $request) {
        /*if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {*/

            if ($request->id) {
                $taxation = DB::table('currency')->where('id', $request->id)->first();
                return view('addeditcurrency')->with('taxation', $taxation);
            } else {
                return view('addeditcurrency');
            }
       // }
    }

    // show taxation
    public function showcurrency(Request $request) {
        /*if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {*/
            return view('currency');
        
    }
/* ==================================== Currency section END ======================================== */

/* ==================================== Emotional Status section START ======================================== */
    public function deleteemotionalstatus(Request $request) {
	   DB::table('emotional_status')->where('id', $request->id)->delete();
	   $msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Emotional status deleted successfully</div>';
       return Redirect::back()->with('msg',$msg);
    }

    public function storeemotionalstatus(Request $request) {
        $validator = Validator::make($request->all(), ['title' => 'required']);
		if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $status_id = $request->input('status_id');
        $name = $request->input('title');            
        if ($status_id && $status_id != "") {
            DB::table('emotional_status')
                    ->where('id', $status_id)
                    ->update(array('name' => $name));
            $msg='<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Emotional Status updated successfully</div>';            
            $keyword_key = isset($request['language_key']) ? $request['language_key'] : "";				
        } 
        else {
        	$keyword_key = 'keyword_emstatus_'.str_replace(" ","_",strtolower($request['title']));
            DB::table('emotional_status')->insert([
                'name' => $name,              
                'language_key'=>$keyword_key
            ]);
           $msg ='<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Emotional Status inserted successfully</div>';
        }       

        $arrLanguages =  DB::table('languages')->select('*')->where('id', '!=', 0)->get();		
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		foreach($arrLanguages as $key => $val){			
			if(isset($request[$val->code.'_keyword_name'])){				
			$language_value = $request[$val->code.'_keyword_name'];				
			$checkExist = DB::table('language_transalation')->where(['code'=>$val->code,'language_key'=>$keyword_key])->where('language_key','!=',"")->count();
			if($checkExist > 0) {
				$update = DB::table('language_transalation')->where(['language_key' =>$keyword_key,'code' => $val->code])->update(['language_label' =>$request['title'],'language_value' => $language_value]);
				
			}
			else {	            
					DB::table('language_transalation')->insert([
						'language_key' => $keyword_key,
						'language_label' =>$request['title'],
						'language_value' => $language_value,					
						'code' => $val->code
					]);
				}
			}		
		}
		$this->writelanguagefile();
		return Redirect::back()->with('msg', $msg);
    }

    public function getjsonemotionalstatus(Request $request) {
        $emotional_status = DB::table('emotional_status')->get()->toArray();
		foreach ($emotional_status as $key => $usr) {
        	$checked = ($usr->is_active==0) ? 'checked' : '';
    		$emotional_status[$key]->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateEmotionalStatus('.$usr->id.')" id="activestatus_'.$usr->id.'" '.$checked.'  on value="1"  type="checkbox"><label for="activestatus_'.$usr->id.'"></label></div>';
        	$emotional_status[$key]->name = trans('messages.'.$emotional_status[$key]->language_key);
        }
        return json_encode($emotional_status);
    }

	public function updateemotionalstatus(Request $request) {				
		/*$updateAll = DB::table('emotional_status')->update(array('is_active' => 1));*/
		$update = DB::table('emotional_status')->where('id', $request->id)->update(array('is_active' => $request->status));
		return ($update) ? 'true' : 'false';		
	}

    // show taxation form
    public function addeditemotionalstatus(Request $request) {
    	$language = DB::table('languages')->where('is_deleted','0')->get();
        if ($request->id) {
            $taxation = DB::table('emotional_status')->where('id', $request->id)->first();
            $language_transalation=DB::table('language_transalation')->where('language_key',$taxation->language_key)->get();
            return view('settings.addeditemotionalstatus',['taxation'=>$taxation,'language_transalation'=>$language_transalation,'language'=>$language]);
        }
        else {
            return view('settings.addeditemotionalstatus',['language'=>$language]);
        }    
    }

    // show taxation
    public function showemotionalstatus(Request $request) {        
    	return view('settings.emotionalstatus');        
    }
	/* ==================================== Emoto section END ======================================== */	
	
	/* ==================================== Hotel Texomoni section Start ======================================== */		
	public function taxonomieshotel(Request $request) {
		return view('settings.taxonomies_hotel',[
			'taxinomies_credit_cards' => DB::table('taxinomies_credit_cards')->orderBy('id', 'desc')->get(),
			'taxinomies_vat_invoicing' => DB::table('taxinomies_vat_invoicing')->orderBy('id', 'desc')->get(),
			'taxinomies_age_type' => DB::table('taxinomies_age_type')->orderBy('id', 'desc')->get(),
			'taxinomies_emotional_status' => DB::table('emotional_status')->orderBy('id', 'desc')->get(),
		]);
    }
	public function saveemotionalstatustaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);

		DB::table('emotional_status')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'color' => $request->color,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function emotionalstatustaxonomiesUpdate(Request $request) {

		foreach($request->chkemotionalstatus as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$color = isset($request->color[$key]) ? $request->color[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('emotional_status')->where('id', $key)->delete();							
			}
			else {
				DB::table('emotional_status')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

	public function savecreditcarttaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);

		DB::table('taxinomies_credit_cards')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'color' => $request->color,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function creditcardtaxonomiesUpdate(Request $request) {
		foreach($request->chkcreditcardtype as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$color = isset($request->color[$key]) ? $request->color[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_credit_cards')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_credit_cards')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }   
	
    /* save emotionstates in multi languages */
    public function emotionlanguagetranslation($title = "",$action = 'update',$langkey=""){
		//$currentlangCode = session('locale');
		$currentlangCode = 'en';
		 if($langkey != ""){
			if($action == 'update'){
				$check =  DB::table('language_transalation')->where(['language_key'=>$langkey,'code'=>$currentlangCode])->count();
				if($check > 0){
					DB::table('language_transalation')
							->where(['language_key'=>$langkey,'code'=>$currentlangCode])						
							->update(['language_value' => $title]);
				}
				else {
					DB::table('language_transalation')->insert([
						'language_key' => $langkey,
						'language_label' =>$title,
						'language_value' => $title,					
						'code' => $currentlangCode
					]);			
				}
			}
			else {
				$arrLanguages =  DB::table('languages')->select('*')->where('id', '!=', 0)->get();
				$collection = collect($arrLanguages);
				$arrLanguages = $collection->toArray();
				foreach($arrLanguages as $key => $val){			
					DB::table('language_transalation')->insert([
						'language_key' => $langkey,
						'language_label' =>$title,
						'language_value' => $title,					
						'code' => $val->code
					]);			
				}			
			}
		}
		$this->writelanguagefile();
		return $langkey;
	}
	
	/* Age Type Sections */
	public function saveagetypetaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);

		DB::table('taxinomies_age_type')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'age' => $request->age,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete age type */
	public function agetypetaxonomiesUpdate(Request $request) {
		foreach($request->chkagetype as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$age = isset($request->age[$key]) ? $request->age[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_age_type')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_age_type')->where('id', $key)->update(array('name' => $name,'description' => $description,'age' => $age,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }  

    /* Vat Invoicing */
	public function savevatinvoicetaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);

		DB::table('taxinomies_vat_invoicing')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'color' => $request->color,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function vatinvoicetaxonomiesUpdate(Request $request) {
		foreach($request->chkvatinvoicetype as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$color = isset($request->color[$key]) ? $request->color[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_vat_invoicing')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_vat_invoicing')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }    

/* ==================================== Hotel Texomoni section End ======================================== */	

/* ==================================== Payment Taxation sections section ======================================== */	
	public function taxonomiespayment(Request $request) {		
		return view('settings.taxonomies_payment',[
			'taxinomies_canc_policy' => DB::table('taxinomies_cancellation_policy')->orderBy('id', 'desc')->get()
		]);
    }

    public function savecanpolicytaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);
		DB::table('taxinomies_cancellation_policy')->insert([
			'name' => $request->name,
			'description' => $request->description,			
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function canpolicytaxonomiesUpdate(Request $request) {		
		foreach($request->chkmeals as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			/*$code = isset($request->code[$key]) ? $request->code[$key] : '';*/

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_cancellation_policy')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_cancellation_policy')->where('id', $key)->update(array('name' => $name,'description' => $description,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

/* ==================================== Meal/Meal Combination and room Taxation sections section ======================================== */	
	public function taxonomiesroom(Request $request) {		
		return view('settings.taxonomies_room',[
			'taxinomies_meals' => DB::table('taxinomies_meals')->orderBy('id', 'desc')->get(),			
			'taxinomies_meals_combination' => DB::table('taxinomies_meals_combination')->orderBy('id', 'desc')->get(),						
			'taxinomies_room_type' => DB::table('taxinomies_room_type')->orderBy('id', 'desc')->get(),			
			'taxinomies_room_bed' => DB::table('taxinomies_room_bed')->orderBy('id', 'desc')->get(),			
		]);
    }

    public function savemealscombinationtaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$meal_ids = isset($request->mealscombination) ? implode(",", $request->mealscombination) : "";		
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);

		DB::table('taxinomies_meals_combination')->insert([
			'name' => $request->name,			
			'meal_id' => $meal_ids,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function mealscombinationtaxonomiesUpdate(Request $request) {
		
		foreach($request->chkmealscombination as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$meal_ids = isset($request->mealscombination[$key]) ? $request->mealscombination[$key] : array();
			$meal_ids = implode(",", $meal_ids);		
			$code = isset($request->code[$key]) ? $request->code[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_meals_combination')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_meals_combination')->where('id', $key)->update(array('name' => $name,'meal_id' => $meal_ids,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

	public function savemealstaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);
		DB::table('taxinomies_meals')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'code' => $request->code,
			'price' => $request->price,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function mealstaxonomiesUpdate(Request $request) {
		
		foreach($request->chkmeals as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$code = isset($request->code[$key]) ? $request->code[$key] : '';
			$price = isset($request->price[$key]) ? $request->price[$key] : '';
			

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_meals')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_meals')->where('id', $key)->update(array('name' => $name,'description' => $description,'price' => $price,'code' => $code,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

    public function saveroomtypetaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);
		DB::table('taxinomies_room_type')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'code' => $request->code,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function roomtypetaxonomiesUpdate(Request $request) {
		
		foreach($request->chkroomtype as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$code = isset($request->code[$key]) ? $request->code[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_room_type')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_room_type')->where('id', $key)->update(array('name' => $name,'description' => $description,'code' => $code,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

     public function saveroombedtaxonomies(Request $request) {
		$languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));							
		$this->emotionlanguagetranslation($request->name,'add',$languageKey);
		DB::table('taxinomies_room_bed')->insert([
			'name' => $request->name,
			'description' => $request->description,
			'code' => $request->code,
			'language_key'=>$languageKey,
			'user_id'=>$request->user()->id
		]);
		return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');        
    }
	
	/* This function is used to update/delete */
	public function roombedtaxonomiesUpdate(Request $request) {		
		foreach($request->chkroombed as $key => $val) {        		
			$name = isset($request->name[$key]) ? $request->name[$key] : '';
			$languageKey = isset($request->langkey[$key]) ? $request->langkey[$key] : '';
			$description = isset($request->description[$key]) ? $request->description[$key] : '';
			$code = isset($request->code[$key]) ? $request->code[$key] : '';

			$this->emotionlanguagetranslation($name,'update',$languageKey);
			if($request->action == 'delete') {
				DB::table('taxinomies_room_bed')->where('id', $key)->delete();							
			}
			else {
				DB::table('taxinomies_room_bed')->where('id', $key)->update(array('name' => $name,'description' => $description,'code' => $code,'language_key'=>$languageKey));
			}          
		}
		$msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';
		return Redirect::back()->with('msg', $msg);       
    }

    /* ==================================== Location section START ======================================== */
    public function deletelocation(Request $request) {      
       DB::table('location_details')->where('id', $request->id)->delete();
 	   $msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Location deleted successfully</div>';        	
        return Redirect::back()->with('msg',$msg);    
    }

    public function storelocation(Request $request) {
        $validator = Validator::make($request->all(), ['name' => 'required','address' => 'required']);
		if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }        
        if (isset($request->location_id) && $request->location_id != "") {
            $name = $request->input('name');
            $address = $request->input('address');
            $lat = $request->input('lat');    
            $long = $request->input('long');    
            DB::table('location_details')
                    ->where('id', $request->location_id)
                    ->update(array('name' => $name,'address'=>$address,'description'=>$request->description,'lat' =>$lat,'long' =>$long,'user_id'=>$request->user()->id));
            return Redirect::back()->with('msg','<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Location updated successfully</div>');
        } 
        else {
            DB::table('location_details')->insert([
                'name' => $request->name,
                'address' => $request->address,
                'description'=>$request->description,
                'lat' => $request->lat,
                'long'=>$request->long,
                'user_id'=>$request->user()->id
            ]);
            return Redirect::back()->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Location inserted successfully</div>');
        }
    }

    public function getjsonlocation(Request $request) {
        $currency = DB::table('location_details')->get()->toArray();
		foreach ($currency as $key => $usr) {
        	$checked = ($usr->is_active==0) ? 'checked' : '';
        	if($usr->is_active==0){
        		$currency[$key]->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTaxionStatus('.$usr->id.')" id="activestatus_'.$usr->id.'" '.$checked.' value="1"  type="checkbox"><label for="activestatus_'.$usr->id.'"></label></div>';           
        	}
        	else {
        	$currency[$key]->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTaxionStatus('.$usr->id.')" id="activestatus_'.$usr->id.'" '.$checked.'  on value="1"  type="checkbox"><label for="activestatus_'.$usr->id.'"></label></div>';           	
        	}
        }
        return json_encode($currency);
    }

	public function updatelocationstatus(Request $request) {				
		$update = DB::table('location_details')->where('id', $request->id)->update(array('is_active' => $request->status));
		return ($update) ? 'true' : 'false';		
	}

    // show loocation
    public function addeditlocation(Request $request) {
        if ($request->id) {
            $taxation = DB::table('location_details')->where('id', $request->id)->first();
            return view('addeditlocation')->with('taxation', $taxation);
        } 
        else {
            return view('addeditlocation');
        }
    }

    // show Location
    public function showlocation(Request $request) {        
    	return view('location_list');
    }
/* ==================================== Location section END ======================================== */


    /* ===================================== Dynamic Menu Section ========================================================= */
    public function dynamic_menu_list(Request $request)
    {
        return view('dynamic_menu.index');
    }

    public function menuaddedit(Request $request)
    {
        $action = 'add';
        $menus = DB::table('dynamic_menu')->where('is_deleted', '0')->orderby('name', 'asc')->get()->toArray();
        //dd($categories);

        $arrRecords = [
            'action' => 'add',
            'menus' => $menus,
        ];


        if (isset($request->menu_id)) {

            $action = 'edit';
            $arrDetails = DB::table('dynamic_menu')->where(['id' => $request->menu_id, 'is_deleted' => '0'])->first();


            $arrRecords['action'] = 'edit';
            $arrRecords['menudetails'] = $arrDetails;
        }

        return view('dynamic_menu.menu_add_edit', $arrRecords);
    }

    public function savemenu(Request $request)
    {

        $departments = '';
        if(count($request->user_types) >0){
            $user_types  = implode(",", $request->user_types);
        }

        //dd($request->all());
        /*Validation*/
        if (isset($request->parent_menu_id) && !empty($request->parent_menu_id) && $request->action == 'edit') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50|unique:dynamic_menu',
            ]);
        }
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }
        /*Validation*/

        /*Trim Link*/
        $link = trim($request->link, "/");
        //$link = "'".$link."'";



        /*Edit*/
        if (isset($request->parent_menu_id) && !empty($request->parent_menu_id) && $request->action == 'edit') {
            $categorydetails = DB::table('dynamic_menu')->select('*')->where('id', $request->parent_menu_id)->first();

            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/dynamic_menu'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }


            $menu_data = [
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'parent_id' => isset($request->parent_id) ? $request->parent_id : '',
                'link' => $link,
                'menu_class' => $request->menu_class,
                'image' => $imageName,
                'priority' => $request->priority,
                'user_types' => $user_types,
                'type' => $request->type,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            //dd($cat_data);
            DB::table('dynamic_menu')->where('id', $request->parent_menu_id)->update($menu_data);


            /*update level*/
            $get_level = DB::table('dynamic_menu')->select('level')->where('id', $request->parent_id)->get()->first();
            //dd($get_level);
            $level = 0;
            if ($get_level == null) {
                $level = 1;
            } else {
                $level = $get_level->level + 1;
            }

            $level_data = [
                'level' => $level
            ];

            DB::table('dynamic_menu')->where('id', $request->parent_menu_id)->update($level_data);


            /* Store the log details */
            $logs = 'Menu Updated -> (ID:' . $request->parent_menu_id . ')';
            storelogs($request->user()->id, $logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Menu updated successfully!</div>';

            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);

        }
        else { /*Insert*/

            /*Image Handling*/
            if($request->hasFile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images/dynamic_menu'), $imageName);
            }
            else{
                $imageName = $request->old_image;
            }

            /*Department*/

            $menu_data = [
                'name' => $request->name,
                'language_key' => strtolower(str_replace(" ", "_", $request->name)),
                'parent_id' => isset($request->parent_id) ? $request->parent_id : '',
                'link' => $link,
                'menu_class' => $request->menu_class,
                'image' => $imageName,
                'priority' => $request->priority,
                'user_types' => $user_types,
                'type' => $request->type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $last_added_id = DB::table('dynamic_menu')->insertGetId($menu_data);


            /*update level*/
            $get_level = DB::table('dynamic_menu')->select('level')->where('id', $request->parent_id)->get()->first();
            $level = 0;
            if ($get_level == null) {
                $level = 1;
            } else {
                $level = $get_level->level + 1;
            }

            $level_data = [
                'level' => $level
            ];
            DB::table('dynamic_menu')->where('id', $last_added_id)->update($level_data);


            /* Store the log details */
            $logs = 'Menu Added -> (ID:' . $last_added_id . ')';
            storelogs($request->user()->id, $logs);
            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Menu added successfully!</div>';

            //update in language table
            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);
        }

        return Redirect::back()->with('msg', $msg);

    }

    public function deletemenu(Request $request)
    {
        $countRec = DB::table('dynamic_menu')->select('*')->where('id', $request->id)->count();
        //dd($countRec);
        if ($countRec > 0) {
            DB::table('dynamic_menu')->where('id', $request->id)->update(array('is_deleted' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_menu_removed_successfully').'</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_menu_not_exist').'</div>');
        }
    }

    public function updatemenustatus(Request $request)
    {
        $update = DB::table('dynamic_menu')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function getjsonmenuproperty(Request $request)
    {
        $categoryDetails = array();
        $category = DB::table('dynamic_menu')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0)->get();
        foreach ($category as $data) {
            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateCategoryStatus(' . $data->id . ')" id="activestatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';
            $get = DB::table('dynamic_menu')->select('*')
                ->where(['id' => $data->parent_id, 'is_deleted' => 0])
                ->first();
            $data->parent_id = isset($get->name) ? $data->parent_id . " | " . $get->name : '--';
            $data->preference = '0';
            $data->commissions = '0';
            /*if($data->icon != ""){
                $data->icon = '<img src="'.url('storage/app/images/languageicon').'/'.$data->icon.'" height="100px" width="100px">';
            }*/
            $categoryDetails[] = $data;
        }
        return json_encode($categoryDetails);
    }

    /* ===================================== Dynamic Menu Section End========================================================= */

    /* ===================================== Email Template ========================================================= */

    public function email_template()
    {
        return view('settings.email_template');
    }

    public function email_template_add_edit(Request $request)
    {
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
            'category_id' => $request->category_id
        ];

        if (isset($request->template_id)) {

            $action = 'edit';
            $arrDetails = DB::table('email_template')->where(['id' => $request->template_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['template'] = $arrDetails;
        }

        return view('settings.email_template_add_edit', $arrRecords);
    }

    public function email_template_update(Request $request)
    {
        if (isset($request->template_id) && !empty($request->template_id) && $request->action == 'edit') {

            $template_data = [
                'email_cat_id' => $request->email_cat_id,
                'subject' => $request->subject,
                'subject_language_key' => 'keyword_'.str_replace(" ","_",strtolower($request->subject)),
                'description' => htmlentities($request->description),
                'is_active' => $request->is_active,
            ];

            Db::table('email_template')->where('id', $request->template_id)->update($template_data);


            $lang_data = [
                'subject' => $request->subject,
            ];

            language_keyword_add($lang_data);


            $logs = 'Template Updated -> (ID:'.$request->template_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_template_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else{
            $template_data = [
                'email_cat_id' => $request->email_cat_id,
                'subject' => $request->subject,
                'subject_language_key' => 'keyword_'.str_replace(" ","_",strtolower($request->subject)),
                'description' => htmlentities($request->description),
                'is_active' => $request->is_active,
            ];

            $last_inserted_id = Db::table('email_template')->insertGetId($template_data);


            $lang_data = [
                'subject' => $request->subject,
            ];

            language_keyword_add($lang_data);


            $logs = 'Template Added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_template_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);

        }
    }

    public function get_email_template_json(Request $request)
    {

        $templates = array();
        $email_templates = DB::table('email_template')->select('*')->where('email_cat_id', $request->category_id)->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($email_templates as $data) {

            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateEmailTemplateStatus(' . $data->id . ')" id="activestatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';

            $data->description = html_entity_decode($data->description);

            $templates[] = $data;
        }
        return json_encode($templates);
    }

    public function email_template_changeactivestatus(Request $request)
    {
        $update = DB::table('email_template')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function template_delete(Request $request)
    {
        $countRec = DB::table('email_template')->select('*')->where('id', $request->id)->count();

        if ($countRec > 0) {
            DB::table('email_template')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Template removed successfully</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Template not Exist!</div>');
        }
    }

    public function template_search(Request $request)
    {

        $template  = DB::table('email_template as e_t')->select('e_t.*','e_t.id as e_t_id', 'e_t_c.name as e_t_c_name')
            ->leftJoin('email_template_category as e_t_c', 'e_t_c.id', '=', 'e_t.email_cat_id')
            ->where('e_t.id', '!=', '0')->where('e_t.is_delete', '=', '0');


        if(isset($request->email_cat_id)){
            $template->where('e_t.email_cat_id', $request->email_cat_id);
        }

        if(isset($request->filter_name))
        {
            $template->where('e_t.subject', 'like', '%'.$request->filter_name.'%' );
        }

        if(isset($request->filter_tag)){
            $tags = explode(",", $request->filter_tag);
            $filter_tag = [];
            foreach($tags as $tag)
            {
                $tag = trim($tag, " ");
                $template->where('e_t.description', 'like', '%'.$tag.'%');
            }




//            foreach($tags as $tag)
//            {
//                $tag = trim($tag, " ");
//                $template->Where('e_t.description', 'like', '%'.$tag.'%');
//            }

        }

        //dd($template->toSql());

        $arrayData['filtered_template'] = $template->get();

        return view('settings.email_template_search', $arrayData);
    }
    /* ===================================== Email Template End========================================================= */


    /* ===================================== Email Template Category ========================================================= */

    public function email_template_category()
    {
        return view('settings.email_template_category');
    }

    public function email_template_category_add_edit(Request $request)
    {
        $action = 'add';
        $arrRecords = [
            'action' => 'add',
        ];

        if (isset($request->template_id)) {

            $action = 'edit';
            $arrDetails = DB::table('email_template_category')->where(['id' => $request->template_category_id, 'is_delete' => '0'])->first();

            $arrRecords['action'] = 'edit';
            $arrRecords['template_category'] = $arrDetails;
        }

        return view('settings.email_template_category_add_edit', $arrRecords);
    }

    public function email_template_category_update(Request $request)
    {
        if (isset($request->template_category_id) && !empty($request->template_category_id) && $request->action == 'edit') {

            $template_category_data = [
                'name' => $request->name,
                'language_key' => 'keyword_'.str_replace(" ","_",strtolower($request->name)),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            Db::table('email_template_category')->where('id', $request->template_category_id)->update($template_category_data);


            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Template Category Updated -> (ID:'.$request->template_category_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_template_category_updated_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);
        }
        else{
            $template_category_data = [
                'name' => $request->name,
                'language_key' => 'keyword_'.str_replace(" ","_",strtolower($request->name)),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $last_inserted_id = Db::table('email_template_category')->insertGetId($template_category_data);


            $lang_data = [
                'name' => $request->name,
            ];

            language_keyword_add($lang_data);


            $logs = 'Template Category Added -> (ID:'.$last_inserted_id.')';
            storelogs($request->user()->id,$logs);

            $msg = '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_template_category_added_successfully').'</div>';
            return Redirect::back()->with('msg', $msg);

        }
    }

    public function get_email_template_category_json(Request $request)
    {

        $templates = array();
        $email_template_categorys = DB::table('email_template_category')->select('*')->where('id', '!=', 0)->where('is_delete', '=', 0)->get();
        foreach ($email_template_categorys as $data) {

            $checked = ($data->is_active == 0) ? 'checked' : '';
            $data->status = '<div class="switch"><input name="status" class="currencytogal" onchange="updateTemplateCategoryStatus(' . $data->id . ')" id="activestatus_' . $data->id . '" ' . $checked . ' value="1"  type="checkbox"><label for="activestatus_' . $data->id . '"></label></div>';



            $templates[] = $data;
        }
        return json_encode($templates);
    }

    public function email_template_category_changeactivestatus(Request $request)
    {
        $update = DB::table('email_template_category')->where('id', $request->id)->update(array('is_active' => $request->status));
        return ($update) ? 'true' : 'false';
    }

    public function template_category_delete(Request $request)
    {
        $countRec = DB::table('email_template_category')->select('*')->where('id', $request->id)->count();

        if ($countRec > 0) {
            DB::table('email_template_category')->where('id', $request->id)->update(array('is_delete' => '1'));
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Template removed successfully</div>');
        } else {
            return Redirect::back()->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Template not Exist!</div>');
        }
    }


    /* ===================================== Email Template Category ========================================================= */


    /* ===================================== Taxomomies Section ========================================================= */

    /*Taxonomies reviews*/
    public function taxonomiesreviews(Request $request) {
        return view('settings.taxonomies_reviews',[
            'taxinomies_reviews' => DB::table('taxonomies_reviews')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function savereviewstaxonomies(Request $request) {
        $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));

        $lang_data = [
            'name' => $request->name,
        ];

        language_keyword_add($lang_data);

        DB::table('taxonomies_reviews')->insert([
            'name' => $request->name,
            'color' => $request->color,
            'language_key'=>$languageKey,
            'user_id'=>$request->user()->id
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="reviews" aria-label="close">&times;</a> '.trans('messages.keyword_reviews_added_successfully').' </div>');
    }
    /* This function is used to update/delete */
    public function reviewstaxonomiesUpdate(Request $request) {
        //pre($request->all());

        foreach($request->chkreviews as $key => $val) {
            $name = isset($request->name[$key]) ? $request->name[$key] : '';
            $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name[$key]));
            $color = isset($request->color[$key]) ? $request->color[$key] : '';

            $lang_data = [
                'name' => $request->name[$key],
            ];

            language_keyword_add($lang_data);


            if($request->action == 'delete') {
                DB::table('taxonomies_reviews')->where('id', $key)->delete();
            }
            else {
                DB::table('taxonomies_reviews')->where('id', $key)->update(array('name' => $name,'color' => $color,'language_key'=>$languageKey));
            }
        }
        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="reviews" aria-label="close">&times;</a> '.trans('messages.keyword_reviews_removed_successfully').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="reviews" aria-label="close">&times;</a> '.trans('messages.keyword_reviews_updated_successfully').' </div>';
        return Redirect::back()->with('msg', $msg);
    }
    /*Taxonomies reviews*/



    /*Taxonomies Discount*/
    public function taxonomiesdiscount(Request $request) {
        return view('settings.taxonomies_discount',[
            'taxinomies_discount' => DB::table('taxonomies_discount')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function savediscounttaxonomies(Request $request) {
        $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));

        $lang_data = [
            'name' => $request->name,
        ];

        language_keyword_add($lang_data);

        DB::table('taxonomies_discount')->insert([
            'name' => $request->name,
            'color' => $request->color,
            'language_key'=>$languageKey,
            'user_id'=>$request->user()->id
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_discount_added_successfully').' </div>');
    }
    /* This function is used to update/delete */
    public function discounttaxonomiesUpdate(Request $request) {
        //pre($request->all());

        foreach($request->chkdiscount as $key => $val) {
            $name = isset($request->name[$key]) ? $request->name[$key] : '';
            $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name[$key]));
            $color = isset($request->color[$key]) ? $request->color[$key] : '';

            $lang_data = [
                'name' => $request->name[$key],
            ];

            language_keyword_add($lang_data);


            if($request->action == 'delete') {
                DB::table('taxonomies_discount')->where('id', $key)->delete();
            }
            else {
                DB::table('taxonomies_discount')->where('id', $key)->update(array('name' => $name,'color' => $color,'language_key'=>$languageKey));
            }
        }
        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_discount_removed_successfully').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_discount_updated_successfully').' </div>';
        return Redirect::back()->with('msg', $msg);
    }
    /*Taxonomies Discount*/

    /*Taxonomies Booking*/
    public function taxonomiesbooking(Request $request) {
        return view('settings.taxonomies_booking',[
            'taxinomies_booking' => DB::table('taxonomies_booking')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function savebookingtaxonomies(Request $request) {
        $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));

        $lang_data = [
            'name' => $request->name,
        ];

        language_keyword_add($lang_data);

        DB::table('taxonomies_booking')->insert([
            'name' => $request->name,
            'color' => $request->color,
            'language_key'=>$languageKey,
            'user_id'=>$request->user()->id
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_booking_added_successfully').' </div>');
    }
    /* This function is used to update/delete */
    public function bookingtaxonomiesUpdate(Request $request) {
        //pre($request->all());

        foreach($request->chkbooking as $key => $val) {
            $name = isset($request->name[$key]) ? $request->name[$key] : '';
            $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name[$key]));
            $color = isset($request->color[$key]) ? $request->color[$key] : '';

            $lang_data = [
                'name' => $request->name[$key],
            ];

            language_keyword_add($lang_data);


            if($request->action == 'delete') {
                DB::table('taxonomies_booking')->where('id', $key)->delete();
            }
            else {
                DB::table('taxonomies_booking')->where('id', $key)->update(array('name' => $name,'color' => $color,'language_key'=>$languageKey));
            }
        }
        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_booking_removed_successfully').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_booking_updated_successfully').' </div>';
        return Redirect::back()->with('msg', $msg);
    }
    /*Taxonomies Booking*/


    /*Taxonomies Payment*/
    public function taxonomies_payment(Request $request) {
        return view('settings.taxonomies_payment',[
            'taxinomies_payment' => DB::table('taxonomies_payment')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function savepaymenttaxonomies(Request $request) {
        $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));

        $lang_data = [
            'name' => $request->name,
        ];

        language_keyword_add($lang_data);

        DB::table('taxonomies_payment')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'language_key'=>$languageKey,
            'user_id'=>$request->user()->id
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_payment_added_successfully').' </div>');
    }
    /* This function is used to update/delete */
    public function paymenttaxonomiesUpdate(Request $request) {
        //pre($request->all());

        foreach($request->chkpayment as $key => $val) {
            $name = isset($request->name[$key]) ? $request->name[$key] : '';
            $description = isset($request->description[$key]) ? $request->description[$key] : '';
            $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name[$key]));
            $color = isset($request->color[$key]) ? $request->color[$key] : '';

            $lang_data = [
                'name' => $request->name[$key],
            ];

            language_keyword_add($lang_data);


            if($request->action == 'delete') {
                DB::table('taxonomies_payment')->where('id', $key)->delete();
            }
            else {
                DB::table('taxonomies_payment')->where('id', $key)->update(array('name' => $name,'description' => $description,'color' => $color,'language_key'=>$languageKey));
            }
        }
        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_payment_removed_successfully').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_payment_updated_successfully').' </div>';
        return Redirect::back()->with('msg', $msg);
    }
    /*Taxonomies Payment*/


    /*Taxonomies alert*/
    public function taxonomiesalert(Request $request) {
        return view('settings.taxonomies_alert',[
            'taxinomies_alert' => DB::table('taxonomies_alert')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function savealerttaxonomies(Request $request) {
        $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name));

        $lang_data = [
            'name' => $request->name,
        ];

        language_keyword_add($lang_data);

        DB::table('taxonomies_alert')->insert([
            'name' => $request->name,
            'color' => $request->color,
            'language_key'=>$languageKey,
            'user_id'=>$request->user()->id
        ]);
        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_alert_added_successfully').' </div>');
    }
    /* This function is used to update/delete */
    public function alerttaxonomiesUpdate(Request $request) {
        //pre($request->all());

        foreach($request->chkalert as $key => $val) {
            $name = isset($request->name[$key]) ? $request->name[$key] : '';
            $languageKey = 'keyword_'.str_replace(" ","_",strtolower($request->name[$key]));
            $color = isset($request->color[$key]) ? $request->color[$key] : '';

            $lang_data = [
                'name' => $request->name[$key],
            ];

            language_keyword_add($lang_data);


            if($request->action == 'delete') {
                DB::table('taxonomies_alert')->where('id', $key)->delete();
            }
            else {
                DB::table('taxonomies_alert')->where('id', $key)->update(array('name' => $name,'color' => $color,'language_key'=>$languageKey));
            }
        }
        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_alert_removed_successfully').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_alert_updated_successfully').' </div>';
        return Redirect::back()->with('msg', $msg);
    }
    /* ===================================== Taxomomies Section End========================================================= */

    /* This function is used to access */
    protected function access(Request $request) {
        $userid  = decodehelper($request->userid);
        $user = DB::table('users')->where('id', $userid)->first();
        $request->session()->put('isAdmin', 1);
        $request->session()->put('adminID', Auth::id());                
        if (Auth::loginUsingId($user->id)) {
            return redirect('/');
        }
    }
}
