<?php
	/* This day used for date add/minuser of particular day */
	$GLOBALS['datedays'] = 10;
	/*This function is used to store the log details of login user */
	function storelogs($userID,$logs){
		DB::table('member_activity_log')->insert(array(
					'user_id' => $userID,
					'logs' => $logs,
					'ip_address' => \Request::ip(),
					'log_date' => date('Y-m-d H:i:s')));
	}
	
	function getlanguages() {
		return DB::table('languages')->where('is_deleted','0')->get();
	}
	function getWizardCategoryById($id) {
		return DB::table('wizard_categories')->where(['is_deleted'=>'0','is_active'=>'0','id'=>$id])->first();		
	}
	function    getWizardSubCategory($id) {
		return DB::table('wizard_categories')->where(['is_deleted'=>'0','is_active'=>'0','parent_id'=>$id])->get();
	}

    function dateFormate($date,$formate = 'd/m/Y'){
        /*
        $date = str_replace('/', '-', $date);
        $formate = ($formate == null) ? $arrMainSettings['timeformate'] : $formate;*/
        $newDate = date($formate,strtotime($date));
        return $newDate;
    }
	
	function getWizardOptionByCategory($categoyid,$first='get') {
    DB::enableQueryLog();
    $query=DB::table('wizard_categories')
    ->where(['wizard_categories.is_deleted'=>'0','wizard_categories.id'=>$categoyid])
    
    ->leftjoin('wizard_options', 'wizard_categories.id', '=', 'wizard_options.category_id')
    ->where(['wizard_options.is_deleted'=>'0','wizard_options.is_active'=>'0'])
        /*->leftjoin('wizard_options_value', 'wizard_options_value.id_stato', '=', 'stato.id_stato') */
        ->select('wizard_options.*','wizard_categories.language_key as cat_lang_key','wizard_categories.name as categoryName');
    if($first=='get')
        return $query->get();
    else
    return $query->first();
  }


  /* Create the wizard */
  function createwizard($value,$isdynamic = '0', $checkboxname=null,$selectedValue=null,$language=null) {
    if(isset($value->language_key)){    
//        $html = '<label for="">'.trans('messages.'.$value->language_key).'</label>';
            $html = '';
           
              $checkboxname = ($checkboxname != null && $checkboxname != "") ? $checkboxname : $value->cat_lang_key;

              $catname = isset($value->cat_lang_key) ? trans('messages.keyword_'.$value->cat_lang_key) : '';
              $fieldName = $value->cat_lang_key.$value->language_key;
              $name = $catname.trans('messages.'.$value->language_key);
              $name = trim(str_replace(' ', '_',$name));
			  $name = trim(str_replace('(', '',$name));
			  $name = trim(str_replace(')', '',$name));
			  $name = trim(str_replace("'", '',$name));
              $id = 'id_'.$name;
              $placeholder = trans('messages.'.$value->language_key);
              $is_required = (isset($value->is_required) && $value->is_required == '1') ? 'required' : '';
              if(!is_array($selectedValue))
             $selectedValue = ($selectedValue != null && $selectedValue != "") ? explode(",", $selectedValue) : array();
              $is_checked = (in_array($value->id, $selectedValue)) ? 'checked' : '';

            if($isdynamic == '1') {

               // $html .= '<div class="col-md-6 col-sm-12 col-xs-12"><div class="ryt-chk">';
                $html .= '<input name="'.$checkboxname.'[]" '.$is_checked.' id="'.$id.'" value="'.$value->id.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
                $html .= '<label class="control-label" for="'.$id.'">'.trans('messages.'.$value->language_key).'</label>';
				//$html.='</div></div>';

            }
            elseif($isdynamic == '2'){
                 $html .= '<input name="'.$checkboxname.'[]" '.$is_checked.' class="'.$id.'_language" id="'.$id.'" value="'.$value->id.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
                $html .= '<label class="control-label" for="'.$id.'">'.trans('messages.'.$value->language_key).'</label>
						<input class="form-control" name="language['.$value->id.'][]" value="'.$language.'" id="'.$id.'_language" type="text" onKeyDown="fun_checkbox(this.id)"></li>';
                 
            }
            else if($isdynamic == '3')
            {
               // $html .= '<div class="col-md-12 col-sm-12 col-xs-12">';
               // $html .= '<div class="ryt-chk">';
                $html .= '<input class="form-control" '.$is_checked.'  name="'.$checkboxname.'[]" id="'.$id.'"type="checkbox"  value="'.$value->id.'" '.$is_required.'>';
                $html .= '<label for="'.$id.'">'.trans('messages.'.$value->language_key).'</label>';
               // $html .= '</div>';
                //$html .= '</div>';
            }


          }

        return $html;  

  }
    function backup_createwizard_backup($value,$isdynamic = '0') {
    if(isset($value->language_key)){
        $html = '<label for="">'.trans('messages.'.$value->language_key).'</label>';
        if($isdynamic == '1') {
            $html = '<label class="control-label col-md-6 col-sm-12 col-xs-12" for="">'.trans('messages.'.$value->language_key).'</label>';
        }
        else if($isdynamic == '2') {
            $html = '<div class="col-md-4 col-sm-12 col-xs-12"><div class="form-group"><label class="bold">'.trans('messages.'.$value->language_key).'</label></div></div>';
        }
        $arrtype = DB::table('wizard_options_type')->where(['option_id'=>$value->id,'is_deleted'=>'0','is_active'=>'0'])->get();
        foreach($arrtype as $keyelement => $valelement) {

            $optionValue = DB::table('wizard_options_value')->where(['option_type_id'=>$valelement->id,'is_active'=>'0','is_deleted'=>'0'])->get();
            /*print('<pre>');
            print_r($optionValue);
            print_r($valelement);*/
            $catname = isset($value->cat_lang_key) ? trans('messages.'.$value->cat_lang_key) : '';
            $fieldName = $value->cat_lang_key.$value->language_key;
            $name = $catname.trans('messages.'.$value->language_key);
            $name = trim(str_replace(' ', '_',$name));
            $id = 'id_'.$keyelement.$name;
            $placeholder = trans('messages.'.$value->language_key);
            $is_required = (isset($value->is_required) && $value->is_required == '1') ? 'required' : '';
            if($valelement->type == 'text') {
                $html .= '<input class="form-control" name="'.$fieldName.'" id="'.$id.'" placeholder="'.$placeholder.'" type="text" '.$is_required.'>';
            }
            elseif($valelement->type == 'textarea') {
                $html .= '<textarea class="form-control" name="'.$fieldName.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$is_required.'></textarea>';
            }
            elseif($valelement->type == 'radio') {
                foreach ($optionValue as $opValKey => $opvalValue) {
                    $html .= trans('messages.'.$opvalValue->language_key);
                    $html .= '<input class="form-control" name="'.$fieldName.'" value="'.$opvalValue->value.'" id="'.$id.'" placeholder="'.$placeholder.'" type="radio" '.$is_required.'>';
                }
            }
            elseif($valelement->type == 'select') {
                $html .= '<select class="form-control" name="'.$fieldName.'" id="'.$id.'" '.$is_required.'>';
                /*$options = DB::table('wizard_options_value')->where('option_id',$value->id)->get();*/
                foreach($optionValue as $opkey => $opval){
                    $optionlabel = trans('messages.'.$opval->language_key);
                    $optionvalue = $opval->value;
                    $html .='<option value="'.$optionvalue.'">'.$optionlabel.'</option>';
                }
                $html .='</select>';
            }
            elseif($valelement->type == 'checkbox') {
                if($isdynamic == '1') {
                    foreach($optionValue as $opkey => $opval) {
                        $html .= '<div class="col-md-6 col-sm-12 col-xs-12"><div class="ryt-chk">';
                        $html .= '<input name="'.$value->cat_lang_key.'[]" id="'.$id.'" value="'.$opval->value.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
                        $html .= '<label for="'.$id.'"></label></div></div>';
                    }
                }
                elseif($isdynamic == '2'){
                    $html .= '<div class="col-md-8 col-sm-12 col-xs-12">';
                    foreach($optionValue as $opkey => $opval) {
                        $html .='<div class="form-group"><div class="pagination-type"><ul class="pagination">';
                        $html .= '<li><a href="javascript:void(0);"><div class="input-group-addon"><div class="ryt-chk"><input name="'.$value->cat_lang_key.'['.$opval->id.']" id="'.$id.'" type="checkbox" value="'.$opval->value.'" '.$is_required.'><label for="'.$id.'"></label></div></div></a></li>';
                        $arrLanguage = getlanguages();
                        foreach ($arrLanguage as $keyl => $valuel) {
                            $active = ($valuel->code == 'en') ? 'active' : '';
                            $html .='<li class="'.$active.'"><a href="javascript:void(0);">'.$valuel->code.'</a></li>';
                        }
                        $html .='<li class="langtext" id=""><input class="form-control" name="'.$value->cat_lang_key.'_language['.$opval->id.']" id="'.$id.'_language" type="text"></li>';
                        $html .='</ul></div></div>';
                    }
                    $html .= '</div>';
                }
                else {
                    foreach($optionValue as $opkey => $opval) {
                        $html .= '<input class="form-control" name="'.$fieldName.'" value="'.$opval->value.'" id="'.$id.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
                    }
                }
            }
        }
        return $html;
    }
}

	/*Create the wizard */
	function createwizardwithlang($value,$isdynamic = '0',$editData = array()) {
		if(isset($value->language_key)){		
		$html = '<label for="">'.trans('messages.'.$value->language_key).'</label>';
		if($isdynamic == '1'){
          	$html = '<label class="control-label col-md-6 col-sm-12 col-xs-12" for="">'.trans('messages.'.$value->language_key).'</label>';
		}
        $arrtype = explode(",", $value->type);
      	foreach($arrtype as $keyelement => $valelement){
      	  $name = $value->cat_lang_key.$value->language_key;
      	  $name = trim(str_replace(' ', '_',$name));
          $id = 'id_'.$keyelement.$name;
          $placeholder = trans('messages.'.$value->language_key);
          $is_required = (isset($value->is_required) && $value->is_required == '1') ? 'required' : '';
          if($valelement == '0') {                      
           $html .= '<input class="form-control" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" type="text" '.$is_required.'>';
          }
          elseif($valelement == '0') {          	
          	$html .= '<textarea class="form-control" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$is_required.'></textarea>';	
          }
          elseif($valelement == '2') {          	
          	$html .= '<input class="form-control" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" type="radio" '.$is_required.'>';
          }
		      elseif($valelement == '3') { 
            $fieldName = trim(str_replace("keyword_", "",$value->language_key)); 
            $html .= '<select class="form-control" name="'.$name.'" id="'.$id.'" '.$is_required.'>';
            $options = DB::table('wizard_options_value')->where('option_id',$value->id)->get();
            foreach($options as $opkey => $opval) {
            	$optionlabel = trans('messages.'.$opval->language_key);
            	$optionvalue = $opval->value;
              $select = (isset($editData[$fieldName]) && $editData[$fieldName] == $optionvalue) ? 'selected' : '';
            	$html .='<option value="'.$optionvalue.'" '.$select.'>'.$optionlabel.'</option>';
            }
            $html .='</select>';
          }          
          elseif($valelement == '4') {          	
      		if($isdynamic == '1') {          	
              $html .= '<div class="col-md-6 col-sm-12 col-xs-12"><div class="ryt-chk">';
              $html .= '<input name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
              $html .= '<label for="'.$id.'"></label></div></div>';                  		
      		}
      		else {          	
      			$html .= '<input class="form-control" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" type="checkbox" '.$is_required.'>';
      		}
          }
        }
        return $html;         
    }
	}

    function getWizardEndLevelCategories()
    {
        $categoryitem = DB::table('wizard_categories')->select('*')
            ->where('id', '!=', 0)
            ->where('is_active', '=', 0)
            ->where('is_deleted', '=', 0)->get();
         $arrLastCategory = array();   
        foreach ($categoryitem as $key => $value) {
        	$check = DB::table('wizard_categories')->where('parent_id', '!=', $value->id)->count();
        	if($check > 0){
        		$arrLastCategory[] = $value;
       	 	}
        }

        return $arrLastCategory;
    }

    function getWizardOptionTypeValue($optionid = null)
    {
        $optiontypevalue = DB::table('wizard_options_value')->select('*')            
            ->where('option_type_id',$optionid)
            ->where('is_deleted', '=', 0)->get();

        return $optiontypevalue;
    }





	function getLocationInfoByIp($IPAddress = null){
		if($IPAddress == null){
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = @$_SERVER['REMOTE_ADDR'];
			$result  = array('country'=>'', 'city'=>'');
			if(filter_var($client, FILTER_VALIDATE_IP)){
				$ip = $client;
			}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
				$ip = $forward;
			}else{
				$ip = $remote;		
			}
			$IPAddress = $ip;
		}
		$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$IPAddress));    
		if($ip_data && $ip_data->geoplugin_countryName != null){
			$result['country_code'] = $ip_data->geoplugin_countryCode;
			$result['country'] = $ip_data->geoplugin_countryName;
			$result['city'] = $ip_data->geoplugin_city;
		}
		$result['country'] = !empty($result['country']) ? $result['country'] : 'italy';
		$result['city'] = !empty($result['city']) ? $result['city'] : 'milan';
		return @$result;	
	}	

	/* Here Create the unique function that used anywhere in site */
	function replace_charcter($replaceValue = array(),$content) {
		$htmlcontent = $content;
		foreach($replaceValue as $key => $val){
			$htmlcontent = str_replace($key,$val,$htmlcontent);	
		}
		return $htmlcontent;
		/*$htmlcontent = str_replace('[#SPLASHPAGE_TITLE#]',$memberdata->title,$memberdata->content);	
		echo $htmlcontent*/
	}


	function wordformate($word){
		return ucwords(strtolower($word));
	}
	function stringformate($word){
		return ucfirst(strtolower($word));
	}

	/* Get the active currency details */
	function getActiveCurrency($id='0') {
		$where = ($id != '0') ? array('id'=>$id) : array('is_active'=>'0');
		$Query = DB::table('currency')->where($where)->first();
		$collection= collect($Query);
		$returnarr = $collection->toArray();
		if(!isset($Query->id)){
			$returnarr =array('id'=>'1','name'=>'Euro','symbol'=>'€','price'=>'64','code'=>'EUR','is_active'=>'0');
		}
		return $returnarr;
	}
	
	function getAllUsers($isArray=false){
		$users = DB::table('users')
                ->join('ruolo_utente', 'users.dipartimento', '=', 'ruolo_utente.ruolo_id')
                ->leftjoin('stato', 'users.id_stato', '=', 'stato.id_stato')
                ->select('*')
                ->where('id', '!=', 0)
                ->where('users.is_delete', '=', 0)                
                ->where(function($query){$query->where('is_approvato', '=', 1)->orwhere('is_approvato',3);})               
                ->where('ruolo_utente.is_delete', '=', 0)
                ->get();
		if($isArray == true){
			$users->toArray();
		}
		return $users;
	}
	function encodehelper($id){
		//return base64_encode($id);
		return substr(md5($id), 0, 8).dechex($id);
	}	
	
	function decodehelper($id){
		//return base64_decode($id);
		$md5_8 = substr($id, 0, 8);
		$real_id = hexdec(substr($id, 8));
		return ($md5_8==substr(md5($real_id), 0, 8)) ? $real_id : 0;
	}	

	

	/* This function is used to display breadcrumbs */
	function getbreadcrumbs() {
		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylangaw/', '', $request["path"]), '/') : $request["path"];		
		$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');		

		$breadcrumbsArray = array();
		if(!empty($result)){
			$moduldetails = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);		
		}

		$parentid = isset($moduldetails[0]->modulo_sub) ? $moduldetails[0]->modulo_sub : null;
		$link = isset($moduldetails[0]->modulo_link) ? $moduldetails[0]->modulo_link : '';
		$phase_key = isset($moduldetails[0]->phase_key) ? $moduldetails[0]->phase_key : null;
		$arrParentmodules[] = array('0'=>$phase_key,'1'=>$link);
		//$arrParentmodules = array();

		while($parentid != null) {
			$parentwhere = array('id'=>$parentid);
			$parenmoduldetails = DB::table('modulo')->select('*')->where($parentwhere)->first();
			$linkperant = isset($parenmoduldetails->modulo_link) ? $parenmoduldetails->modulo_link : '';
			$arrParentmodules[] = array('0'=>$parenmoduldetails->phase_key,'1'=>$linkperant); 
			$parentid = $parenmoduldetails->modulo_sub;			
		}
		$breadcrumbs = "";
		$arrBreadcrumbsArray = $arrParentmodules;		
		if(empty($arrParentmodules[0]) || empty($arrParentmodules[0][0])) {			
			$arrBreadcrumbsArray = staticbreadcrumbs($path);								
		} 		
		if(!empty($arrBreadcrumbsArray)){			
			$breadcrumbs = "<ol class='breadcrumb'>";
			foreach(array_reverse($arrBreadcrumbsArray) as $key => $val){
				//$breadcrumbs .= '<li class="breadcrumb-item">'.trans('messages.'.$val).'</li>'; 
				if(is_array($val)){					
					$breadcrumbs .= ($val[1] != null) ? '<li class="breadcrumb-item"><a href="'.url($val[1]).'">'.trans('messages.'.$val[0]).'</a></li>' : '<li class="breadcrumb-item">'.trans('messages.'.$val[0]).'</li>';					
				}
				else {
					$breadcrumbs .= '<li class="breadcrumb-item">'.trans('messages.'.$val).'</li>'; 
				}
			}
			$breadcrumbs .="</ol>";		
		}		
		return $breadcrumbs;
	}


	function staticbreadcrumbs($path) {

		$c = explode('/',$path);
		$last = explode('/', end($c));		
		
		$path = preg_replace('/[0-9]+/', '', $path);
		$key = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');							

		/*$arrBreadcrumbs['url_key'] = array('CHILD PAGE Language KEY','PAREND PAGE LANGUAGE');*/
		$arrBreadcrumbs['enti/modify/corporation'] = array('keyword_modify',array('0'=>'keyword_entity','1'=>'enti/myenti'));
		$arrBreadcrumbs['enti/add'] = array('keyword_add',array('0'=>'keyword_entity','1'=>'enti/myenti'));
		$arrBreadcrumbs['estimates/modify/quote'] = array('keyword_modify',array('0'=>'keyword_quotes','1'=>'estimates/my'));
		$arrBreadcrumbs['estimates/add'] = array('keyword_add',array('0'=>'keyword_quotes','1'=>'estimates/my'));
		$arrBreadcrumbs['progetti/modify/project'] = array('keyword_modify',array('0'=>'keyword_projects','1'=>'progetti/miei'));
		$arrBreadcrumbs['progetti/add'] = array('keyword_add',array('0'=>'keyword_projects','1'=>'progetti/miei'));
		$arrBreadcrumbs['pagamenti/mostra/accounting'] = array('keyword_invoices',array('0'=>'keyword_groupings','1'=>'pagamenti'),array('0'=>'keyword_accounting','1'=>'pagamenti'));
		$arrBreadcrumbs['pagamenti/tranche/add'] = array('keyword_add',array('0'=>'keyword_invoices','1'=>'pagamenti/tranche/elenco'),array('0'=>'keyword_accounting','1'=>'pagamenti/tranche/elenco'));
		$arrBreadcrumbs['pagamenti/tranche/modifica'] = array('keyword_modify',array('0'=>'keyword_invoices','1'=>'pagamenti/tranche/elenco'),array('0'=>'keyword_accounting','1'=>'pagamenti/tranche/elenco'));		
		$arrBreadcrumbs['costi/modify'] = array('keyword_modify',array('0'=>'keyword_costs','1'=>'statistiche/economiche'),array('0'=>'keyword_statistics','1'=>'statistiche/economiche'));

		/* =================================================== Admin ===================================== */
		$arrBreadcrumbs['admin/modify/utente'] = array('keyword_add',array('0'=>'keyword_users','1'=>'admin/utenti'),array('0'=>'keyword_role_capabilities','1'=>'admin/utenti'));
		$arrBreadcrumbs['role-permessi'] = array('keyword_add',array('0'=>'keyword_permission','1'=>'utente-permessi'),'keyword_role_capabilities');
		$arrBreadcrumbs['admin/tassonomie/pacchetti/add'] = array('keyword_add',array('0'=>'keyword_packages','1'=>'admin/tassonomie/pacchetti'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['admin/tassonomie/modify/pacchetto'] = array('keyword_modify',array('0'=>'keyword_packages','1'=>'admin/tassonomie/pacchetti'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['admin/taxonomies/optional/add'] = array('keyword_add',array('0'=>'keyword_optional','1'=>'admin/taxonomies/optional'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['admin/taxonomies/modify/optional'] = array('keyword_modify',array('0'=>'keyword_optional','1'=>'admin/taxonomies/optional'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['admin/tassonomie/dipartimenti/add'] = array('keyword_add',array('0'=>'keyword_department','1'=>'admin/tassonomie/dipartimenti'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['admin/tassonomie/dipartimenti/modify/department'] = array('keyword_modify',array('0'=>'keyword_department','1'=>'admin/tassonomie/dipartimenti'),'keyword_sale','keyword_taxonomies');
		$arrBreadcrumbs['taxation/add'] = array('keyword_add',array('0'=>'keyword_taxation','1'=>'taxation'),'keyword_sale','keyword_taxonomies');	
		$arrBreadcrumbs['admin/notification'] = array('keyword_add',array('0'=>'keyword_notifications','1'=>'admin/shownotification'),'keyword_notifications');	
		$arrBreadcrumbs['notification/detail'] = array('keyword_entelist',array('0'=>'keyword_notifications','1'=>'admin/shownotification'),'keyword_notifications');	
		$arrBreadcrumbs['admin/modify/quizpaackage'] = array('keyword_add',array('0'=>'keyword_quiz_pacchetto','1'=>'admin/quizpackage'),'keyword_quiz');	
		$arrBreadcrumbs['admin/modify/language'] = array('keyword_add',array('0'=>'keyword_languages','1'=>'admin/language'),array('0'=>'keyword_languages&phases','1'=>'admin/language'),'keyword_settings');	
		$arrBreadcrumbs['admin/add/languagetranslation'] = array('keyword_add',array('0'=>'keyword_language_phase','1'=>'admin/languagetranslation/1'),array('0'=>'keyword_languages&phases','1'=>'admin/language'),'keyword_settings');	
		$arrBreadcrumbs['menu/add'] = array('keyword_add',array('0'=>'keyword_menu','1'=>'admin/menu'),'keyword_settings');	
		$arrBreadcrumbs['menu/modify'] = array('keyword_modify',array('0'=>'keyword_menu','1'=>'admin/menu'),'keyword_settings');	
		$arrBreadcrumbs['admin/modify/page'] = array('keyword_add',array('0'=>'keyword_list_pages','1'=>'admin/pages'),'keyword_settings');	
		
		
		/*Below for the same url for add/edit, so that check the edit url with numerics */
		if(is_numeric($last[0])){
			$arrBreadcrumbs['admin/modify/utente'] = array('keyword_modify',array('0'=>'keyword_users','1'=>'admin/utenti'),array('0'=>'keyword_role_capabilities','1'=>'admin/utenti'));			
			$arrBreadcrumbs['role-permessi'] = array('keyword_modify',array('0'=>'keyword_permission','1'=>'utente-permessi'),'keyword_role_capabilities');
			$arrBreadcrumbs['taxation/add'] = array('keyword_modify',array('0'=>'keyword_taxation','1'=>'taxation'),'keyword_sale','keyword_taxonomies');
			$arrBreadcrumbs['admin/notification'] = array('keyword_modify',array('0'=>'keyword_notifications','1'=>'admin/shownotification'),'keyword_notifications');	
			$arrBreadcrumbs['admin/modify/quizpaackage'] = array('keyword_modify',array('0'=>'keyword_quiz_pacchetto','1'=>'admin/quizpackage'),'keyword_quiz');	
			$arrBreadcrumbs['admin/modify/language'] = array('keyword_modify',array('0'=>'keyword_languages','1'=>'admin/language'),array('0'=>'keyword_languages&phases','1'=>'admin/language'),'keyword_settings');
			$arrBreadcrumbs['admin/languagetranslation'] = array('keyword_language_phase',array('0'=>'keyword_languages&phases','1'=>'admin/language'),'keyword_settings');	
			$arrBreadcrumbs['admin/modify/languagetranslation'] = array('keyword_modify', array('0'=>'keyword_language_phase','1'=>'admin/languagetranslation/1'),array('0'=>'keyword_languages&phases','1'=>'admin/language'),'keyword_settings');	
			$arrBreadcrumbs['calendario'] = array('keyword_deadline',array('0'=>'keyword_calendar','1'=>'calendario/0'));
			$arrBreadcrumbs['admin/modify/page'] = array('keyword_modify',array('0'=>'keyword_list_pages','1'=>'admin/pages'),'keyword_settings');	
			$arrBreadcrumbs['admin/loginactivity/user'] = array('keyword_member_activity',array('0'=>'keyword_login_activity','1'=>'admin/loginactivity/user'));	

			
		}
		return isset($arrBreadcrumbs[$key]) ? $arrBreadcrumbs[$key] : array();
	}
	
	/* This function is used to list of all module for dashboard drag and drop */
	function getModules() {
		DB::connection()->enableQueryLog();
		//$arrid = "'1', '2', '3', '4', '6', '9', '21', '27','67'";
		$arrid = "'1', '2', '3', '4','21'";	
		$arrModules = DB::select(DB::raw("select * from modulo where id NOT IN (select module_id from dashboard_widgets where user_type = ".Auth::user()->dipartimento." and user_id = ".Auth::user()->id.") AND id IN($arrid)"));
		/*$queries = DB::getQueryLog();
                    $last_query = end($queries);
                    print_r($last_query);                
                    exit;
			$arrModules = DB::table('modulo')
					->select('modulo.*')					
					->Join('dashboard_widgets', 'dashboard_widgets.module_id', '=', 'modulo.id', 'left outer')
					->where(['modulo.type'=>1])->whereNull('dashboard_widgets.module_id')
					->where('dashboard_widgets.user_type', "!=", Auth::user()->dipartimento)->whereIn('modulo.id',$arrid)->get();
		*/			
		return $arrModules;
	}
	function checkmodule($id)
	{
		$where=[];
		if($id==21)
		$where=array('id'=>$id);
		else
		$where=array('modulo_sub'=>$id);
		$arrModules = DB::table('modulo')->where($where)->get();
		if(count($arrModules))
		{
			foreach($arrModules as $arr):
			if(checkpermission($arr->modulo_sub, $arr->id, 'lettura'))
			return true;
			endforeach;
		}
		return false;
	}

function pre($array = '')
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}



function writelanguagefile($type=''){
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


/*
 *  Pass array of field_name => $request->field_name type
 *
 */

function language_keyword_add($arrLang)
{
    $arrlanguages = getlanguages();
    foreach($arrLang as $k => $language_value)
    {
        $language_label = strtolower(str_replace(" ", "_", $language_value));
        $language_key = "keyword_".$language_label;

        foreach ($arrlanguages as $keylang => $valuelang)
        {

            $language_transalation = DB::table('language_transalation')
                ->where(['language_key'=>$language_key,'code'=>$valuelang->code])
                ->first();

            $arrlang=['language_label'=>$language_label,
                'language_value' => ($valuelang->code == 'en') ? $language_value : null,
                'code' => $valuelang->code];


            if(count($language_transalation) > 0) {

                DB::table('language_transalation')
                    ->where('language_key', $language_key)
                    ->where('code', $valuelang->code)
                    ->update($arrlang);
            }
            else {
                $arrlang['language_key'] = $language_key;
                DB::table('language_transalation')->insert($arrlang);
            }

        }

    }

    writelanguagefile();
}


function getWizardCategories($parent_id = 0)
{
    $categoryitem = DB::table('wizard_categories')->select('*')
        ->where('id', '!=', 0)
        ->where('parent_id', $parent_id)
        ->where('is_active', '=', 1)
        ->where('is_deleted', '=', 0)->get()->toArray();

    return $categoryitem;
}


function generateLinkIfNotEmpty($cat_id)
{
    $category_list = DB::table('wizard_options')->select('id')
        ->where('id', '!=', 0)
        ->where('category_id', $cat_id)
        ->where('is_deleted', '=', 0)
        ->get()->toArray();

    return count($category_list);
}
/* Test Treeview  */

function fetchCategoryTree($parent = 0,  $user_tree_array = '', $cpath = array()) {

    if (!is_array($user_tree_array))
        $user_tree_array = array();


    $category_list = DB::table('wizard_categories')->select('*')
        ->where('id', '!=', 0)
        ->where('parent_id', $parent)
        ->where('is_active', '=', 0)
        ->where('is_deleted', '=', 0)
        ->orderBy('name', 'ASC')
        ->get()->toArray();


    $user_tree_array[] = "<ul class=''>";
    foreach($category_list as $row)
    {
        // url('/wizard/options')."/".$row->id
        $user_tree_array[] = "<li><a href='".url('wizard/options/')."/".$row->id."'  class=''>".ucfirst($row->name)."</a></li>";
        $user_tree_array = fetchCategoryTree($row->id, $user_tree_array);
    }
    $user_tree_array[] = "</ul>";
    return $user_tree_array;
}


function fetchCategoryTreeDesign($parent = 0,$cur_lev = 0, $user_tree_array = '', $cpath =array())
{

    if (!is_array($user_tree_array)){
        $user_tree_array = array();
    }



    $category_list = DB::table('wizard_categories')->select('*')
        ->where('id', '!=', 0)
        ->where('parent_id', $parent)
        ->where('is_active', '=', 0)
        ->where('is_deleted', '=', 0)
        ->orderBy('name', 'ASC')
        ->get()->toArray();



    $user_tree_array[] = "<ul style='list-style-type:none;' class='".(($cur_lev == 0) ? 'sidebar-nav third-step-dropdown' : '')."'>";

    foreach($category_list as $row)
    {
        $cur_lev++;
        $user_tree_array[] = "<li><a href='".url('wizard/options/')."/".$row->id."'  class=''>".ucfirst($row->name)."</a></li>";
        $user_tree_array = fetchCategoryTreeDesign($row->id,$cur_lev,  $user_tree_array);

    }
    $user_tree_array[] = "</ul>";

    return $user_tree_array;
}


function wizard_option_value($type,$id)
{
    return $valuetype=DB::table('wizard_options_value')->where(array('option_type_id'=>$type,'option_id'=>$id,'is_deleted'=>0))->get();

}


function fetchCategory()
{
    $categories = DB::table('wizard_categories')->select('id', 'name')->where(array('is_active'=> 0, 'is_deleted'=>0))->get();
    return $categories;
}

function fetchParentCategory()
{
    $categories = DB::table('wizard_categories')->select('id', 'name')->where(array('parent_id' => 0, 'is_active'=> 0, 'is_deleted'=>0))->get();
    return $categories;
}


// Room details section
function fetch_room_details()
{
    $room_details = DB::table('room_details')->select('*')->where(array('is_active'=> 0, 'is_deleted'=>0))->get();
    return $room_details;
}

/*This function is used to get the locations */
function getlocations(){
  return DB::table('location_details')->where(['is_active'=>'0'])->get();
}  

function getTaxonomies($tableName){
  return DB::table($tableName)->get();
}

function getyesno(){
  return array('0'=>trans('messages.keyword_yes'),'1'=>trans('messages.keyword_no'));
}

function fetchicons()
{
    $icons = DB::table('font_table')->select('class_name')->get();
    return $icons;
}


// room types
function fetch_room_type()
{
    $room_details = DB::table('taxinomies_room_type')->select('*')->get();
    return $room_details;
}

function room_details()
{
    $room_details = DB::table('room_details')->select('*')->get()->first();
    return $room_details;
}


function getCategoryByLanguageKey($lang_key = '')
{
    $result = DB::table('wizard_categories')->select('id')->where('language_key', $lang_key)->get()->first();
    return $result;
}

function getAmenitiesOptionWithRoomId($room_id = '')
{
    $result = DB::table('room_amenities')->select('options_id')->where('room_id', $room_id)->first();

    /*$options_id = array();
    foreach($result as $key => $value)
    {
        $options_id[] = $value->options_id;
    }*/
    return $result;
}

function getHotels($id = null)
{
    $hotel_main = DB::table('hotel_main')->select('*')->where('id', '!=', 0)->where('is_deleted', '=', 0);
    if($id != null) {
      $hotel_main = $hotel_main->where('id',$id);
    }
    $hotel_main = $hotel_main->get();
    return $hotel_main;

}

function fetch_room_type_by_hotel_id($hotel_id)
{
    $room_details = DB::table('room_details')->select('*')
        ->where('hotelid', $hotel_id)
        ->get();
    return $room_details;
}
function fetch_room_from_hotel_main($hotel_id, $type)
{
    $room_details = DB::table('hotel_main')->select('room_id')
        ->where('id', $hotel_id)
        ->get()->first();
        $ids =  $room_details->room_id;
        if($type == 'string')
        {
            $all_room_ids = $ids;
        }
        if($type = 'array')
        {
		  $ids = trim($ids,",");
          $all_room_ids = explode(",", $ids);
        }
        return $all_room_ids;
}

function getHotelNameById($hotel_id)
{
    $room_details = DB::table('hotel_main')->select('name')
        ->where('id', $hotel_id)
        ->get()->first();

    return $room_details->name;
}
function getMealCombinationName($combination_id) {
    $combination = Db::table('taxinomies_meals_combination')->select('meal_id')->where('id', $combination_id)->get()->first();
    $meal_ids =  $combination->meal_id;
    $meal_ids = explode(',', $meal_ids);
    $meal_name = '';
    foreach($meal_ids as $value) {
        $names = DB::table('taxinomies_meals')->select('name')->where('id', $value)->get()->first();
        $meal_name .= "+ ".$names->name." ";
    }
    $meal_name = trim($meal_name, "+");
    return $meal_name;
}

function getUserTypes()
{
    $user_types = DB::table('user_type')->where('id','!=', '0')->where('is_delete',0)->get();
    return $user_types;
}

function getUserTypesById($user_type_id)
{
    $user_types = DB::table('user_type')->select('type')->where('id', $user_type_id)->get()->first();
    return (!empty($user_types->type)) ? $user_types->type : '-';
}

function getUserTypeIDFromUserID($userid)
{
    $user = DB::table('users')->select('*')->where('id', $userid)->get()->first();
    return $user->profile_id;
}

function getNameByUserID($userid)
{
    $user = DB::table('users')->select('*')->where('id', $userid)->get()->first();
    return $user->name;
}



/*Bookings Section*/
function getStatus()
{
    $active = trans('messages.keyword_active');
    $inactive = trans('messages.keyword_inactive');
    $array = ['0' => $active, '1' => $inactive];
    return $array;
}


function getCardStatus()
{
    $with_card = trans('messages.keyword_with_card');
    $without_card = trans('messages.keyword_without_card');
    $array = ['0' => $with_card, '1' => $without_card];
    return $array;
}

function getBookingsCountries()
{
    $booking_country = DB::table('bookings')->select('country')->get();
    if(count($booking_country) > 0)
    {
        return $booking_country;
    }
}

function getCurrencies()
{
    $Query = DB::table('currency')->get();
    if(count($Query) > 0)
    {
        return $Query;
    }
}

function getEmotionalStatus()
{
    $q = DB::table('emotional_status')->get();
    return $q;
}

function generateBookingId($length = 6)
{
    $pool = '0123456789';
    $ticket_id = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    $data = DB::table('bookings')->select('unique_booking_id')->where('unique_booking_id', $ticket_id)->first();
    if(count($data) == 0)
    {
        return $ticket_id;
    }
    else{
        generateBookingId();
    }
}



function dateFormat($date,$formate = 'd/m/Y'){
    /*
    $date = str_replace('/', '-', $date);
    $formate = ($formate == null) ? $arrMainSettings['timeformate'] : $formate;*/
    $newDate = date($formate,strtotime($date));
    return $newDate;
}

function generateTransferId($length = 10)
{
    $pool = '0123456789';
    $unique_transfer_id = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    $data = DB::table('transfer')->select('unique_transfer_id')->where('unique_transfer_id', $unique_transfer_id)->first();
    if(count($data) == 0)
    {
        return $unique_transfer_id;
    }
    else{
        generateTransferId();
    }
}


function getHotelPolicies()
{
    $hotel_policies = DB::table('hotel_plolicies')->select('title', 'description')->where('id', '!=' ,'0')->where(['is_deleted' => '0'])->get();
    if(count($hotel_policies) > 0)
    {
        return $hotel_policies;
    }
}


function getPercentage($first, $second)
{
    $per = ($first * $second) / 100;
    return $per;
}

function getBookedRooms($booking_id)
{
    $booked_rooms = DB::table('bookings_hotel_rooms as br')->select('br.*', 'rd.personal_name as room_name', 'b.client_name', 'b.age', 'c.symbol as symbol')
        ->leftJoin('room_details as rd', 'br.room_id', '=', 'rd.id')
        ->leftJoin('bookings as b', 'br.booking_id', '=', 'b.id')
        ->leftJoin('currency as c', 'b.currency_id', '=', 'c.id')
        ->where('br.id', '!=', '0')->where(['br.is_deleted' => '0'])->get();

    return $booked_rooms;
}


function getBookingConversations($booking_id)
{
    $reply = DB::table('bookings_conversations as bc')->select('bc.*', 'u.name as username')
        ->leftJoin('users as u', 'bc.user_id', '=', 'u.id')
        ->leftJoin('bookings as b','bc.booking_id', '=', 'b.id')
        ->where('bc.booking_id', $booking_id)->orderBy('bc.created_at', 'ASC')->get();
    return $reply;
}

function getUsers()
{
    $users = DB::table('users')->where(['is_active' => '0', 'is_delete' => '0'])->where('id', '!=', '0')->get();
    if(count($users) > 0)
    {
        return $users;
    }
}

/*Bookings Section end*/


/*Permission Section*/
function fetch_modules($parent = 0,$cur_lev = 0, $user_tree_array = '')
{

    if (!is_array($user_tree_array)){
        $user_tree_array = array();
    }

    $menu_list = DB::table('dynamic_menu as d')->select('d.*')
        ->where('d.id', '!=', 0)
        ->where('d.parent_id', $parent)
        ->where('d.is_active', '=', 0)
        ->where('d.is_deleted', '=', 0)
        ->orderBy('d.name', 'ASC')
        ->get()->toArray();


    foreach($menu_list as $row)
    {
        $class_name = str_replace(" ", "_", $row->name);
        $user_tree_array[] = ['module_id' => $row->id,'link' => $row->link,'class_name' => $class_name, 'level' => $row->level, 'name'=> $row->name, 'parent_id' => $row->parent_id];

        $user_tree_array = fetch_modules($row->id,$cur_lev, $user_tree_array);
    }
    return $user_tree_array;
}

function getUserTypePermissions($typeid)
{
    $per = DB::table('user_type')->select('permissions')->where('id', $typeid)->get()->first();
    $permissions = json_decode($per->permissions);


    $result_array = [];
    if(count($permissions) > 0){
        foreach($permissions as $key => $value)
        {
            $result_array[] = $value;
        }
    }

    return $result_array;
}

function getUserPermissions($typeid)
{
    $per = DB::table('users')->select('permissions')->where('id', $typeid)->get()->first();
    $permissions = json_decode($per->permissions);


    $result_array = [];
    if(count($permissions) > 0){
        foreach($permissions as $key => $value)
        {
            $result_array[] = $value;
        }
    }

    return $result_array;
}

function getParentName($id = '')
{
    $per = DB::table('dynamic_menu')->select('name')->where('id', $id)->get()->first();
    $class_name = str_replace(" ", "_", $per->name);
    return $class_name;
}
/*Permission Section*/



/*Dynamic Menu Section*/
function checkIfLinkExist($link)
{
    $menu = DB::table('dynamic_menu')->where('link', $link)->first();
    if(count($menu) > 0)
    {
        return true;
    }else{
        return false;
    }
}


function getParentIdWithLink($link)
{
    $menu = DB::table('dynamic_menu')->where('link', $link)->first();
    $parent_id = '';
    if(isset($menu->parent_id))
    {
        \Session::put('main_link' , $menu->link);
        $parent_id = $menu->parent_id;
        return $parent_id;
    }
    else{
        $request = parse_url(URL::previous());
        $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/migrate/', '', $request["path"]), '/') : $request["path"];
        $cpath = explode('/',$path);
        $link = current($cpath);
        $menu  = DB::table('dynamic_menu')->where('link','like','%'.$link.'%')->first();
        if(isset($menu->parent_id))
        {
            $parent_id = $menu->parent_id;
            return $parent_id;
        }
    }

}

function checkUrlAndGetMenus($link)
{

    
    if(getParentIdWithLink($link) == '0') {
        $main_menu = DB::table('dynamic_menu')->where(['link' => $link,'parent_id' => '0', 'is_deleted' => '0', 'is_active' => '0'])->first();
    }
    else {

        $main_menu = DB::table('dynamic_menu')->where(['id'=> getParentIdWithLink($link),'is_deleted' => '0', 'is_active' => '0'])->first();
    }
    $child_menus = DB::table('dynamic_menu')->where(['parent_id'=> $main_menu->id, 'is_deleted' => '0','is_active' => '0'])->orderBy('priority', 'ASC')->orderBy('sub_priority', 'ASC')->get();

    //return $child_menus;
    $html = '';


    if(count($child_menus) > 0)
    {



        foreach($child_menus as $key => $child_menu)
        {
            if($child_menu->link == '')
            {
                $html .= '<ul class="sidebar-nav third-step-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="btn btn-primary dropdown-toggle '.(isset($child_menu->menu_class) ? $child_menu->menu_class : '').'" type="button" data-toggle="dropdown" >'.$child_menu->name.'<span class="caret"></span></a>
                            </li>
                        </ul>';

            }
            elseif($child_menu->menu_class == 'primary')
            {
                $html .= '<ul class="sidebar-nav third-step-dropdown">
                            <li class="dropdown">
                                <a href="'.( (isset($child_menu->link) && !empty($child_menu->link)) ? url('/'.$child_menu->link) : 'javascript:void(0)'  ).'" class="btn btn-primary dropdown-toggle '.(isset($child_menu->menu_class) ? $child_menu->menu_class : '').' '.(($link == $child_menu->link) ? 'active' : '').'" >'.$child_menu->name.'</a>
                            </li>
                        </ul>';
            }
            else{
                $html .= '<ul class="sidebar-nav third-step-dropdown">
                        <li class="dropdown">
                            <ul class="dropdown-menu">
                                <li><a href="'.( (isset($child_menu->link) && !empty($child_menu->link)) ? url('/'.$child_menu->link) : 'javascript:void(0)'  ).'" class="'.(isset($child_menu->menu_class) ? $child_menu->menu_class : '').' '.(($link == $child_menu->link) ? 'active' : '').'">'.$child_menu->name.'</a></li>
                            </ul>
                        </li>
                    </ul>';
            }


            // If childmenu link found allotment in link then runs following code
            if($child_menu->link == 'allotment')
            {

                $html .= getAllotMentHTML();
            }




        }
    }
    return $html;
}

function getAllotMentHTML()
{
    $html = '<br><div class="sidebar-booking-filter sidebar-allotment">';
    $html .= '<div class="date-picker"><p class="gry-clr">start date</p><input placeholder="07/09/2017" id="example1" name="select-date" type="text"></div>
              <div class="date-picker"><p class="gry-clr">End date</p><input placeholder="15/09/2017" id="example2" name="select-date" type="text"></div>';

    $html .= '<p>'.trans('messages.keyword_rooms').'</p>';

    $html .= '<div class="ryt-chk-content"><div class="ryt-chk"><input id="one" type="checkbox"><label for="one">Junior Suite</label></div></div>';
    $html .= '<div class="ryt-chk-content"><div class="ryt-chk"><input id="one1" type="checkbox"><label for="one1">Suite</label></div></div>';
    $html .= '<div class="ryt-chk-content"><div class="ryt-chk"><input id="one2" type="checkbox"><label for="one2">Double rooms</label></div></div><hr>';


    $html .= '<div class="available-blk-allotment">';
    $html .= '<div class="ryt-chk-content">';
    $html .= '<div class="ryt-chk"><input id="one3" type="checkbox"><label for="one3">Available</label></div>';
    $html .= '<div class="ryt-chk"><input id="one4" type="checkbox"><label for="one4">Sold Out</label></div>';
    $html .= '<div class="ryt-chk"><input id="one5" type="checkbox"><label for="one5">Stop Out</label></div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<button class="btn btn-default btn-6-12">Shows the data table</button>';

    $html .= '</div>';

    return $html;
}


function fetPrimaryDynamicMenu()
{
    $primaryDynamicMenu = DB::table('dynamic_menu')->where(['is_deleted' => 0, 'level' => 1,'is_active'=> '0'])->orderBy('priority', 'ASC')->get();
    return $primaryDynamicMenu;
}


function fetSecondaryDynamicMenu($parent_id = '')
{
    $secondaryDynamicMenu = DB::table('dynamic_menu')->where(['is_deleted' => 0, 'parent_id' => $parent_id, 'is_active' => '0'])->orderBy('name', 'ASC')->get();
    return $secondaryDynamicMenu;
}

function getParentIdFromDyanamicMenuId($cat_id)
{
    $primaryDynamicMenu = DB::table('dynamic_menu')->where(['is_deleted' => 0, 'id' => $cat_id])->orderBy('name', 'ASC')->first();
    return $primaryDynamicMenu;
}

function getLastPriority()
{
    $lastPriority = DB::table('dynamic_menu')->select('priority')->where(['is_deleted' => 0])->max('priority');

    $lastPriority++;
    return $lastPriority;

}
/*Dynamic Menu Section End*/




/*Email Template Section*/
function getEmailTemplateCategory()
{
    $category = DB::table('email_template_category')->where(['is_delete' => '0'])->get()->toArray();
    return $category;
}

function getEmailTags()
{
    $tags = DB::table('email_tags')->get()->toArray();
    return $tags;
}

function weekDays()
{
    $days = ['Mo','Tu','We', 'Th', 'Fr', 'Sa', 'Su'];
    return $days;
}
/*Email Template Section*/


/*package & promotion Section*/
function getPromotionsType()
{
    $type = DB::table('promotions_type')->get();
    return $type;
}

function getPackageOptions()
{
    $options = DB::table('package_options')->where('is_delete', '0')->get()->toArray();
    return $options;
}

function getSelectedPackageOptions($package_id)
{
    $options = DB::table('selected_package_options')->select('*')->where(['package_id' => $package_id])->get()->toArray();

    //return $options;
    $selected_array = [];
    foreach($options as $k => $v)
    {
        $selected_array[] = [
            'options_id' => $v->options_id,
            'price' => $v->price
        ];
    }
    return $selected_array;

}

function generateCode($length = 6)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

function getTaxonomiesDiscount()
{
    $discount = DB::table('taxonomies_discount')->where('is_deleted', '0')->get();
    return $discount;
}

function getRoomNameWithRoomId($room_id)
{
    $room = DB::table('taxinomies_room_type')->where('id', $room_id)->first();
    if(count($room) > 0)
    {
        return $room->name;
    }
}

function discount_accommodation_type()
{
    $accommodation_type = DB::table('discount_accommodation_type')->get();
    return $accommodation_type;
}
function getDiscountActions()
{
    $action = DB::table('discount_action')->get();
    return $action;
}

/*package & promotion Section*/



/*wizard options*/
function fetchCategoryTreeDesign_backup($parent = 0,$cur_lev = 0, $user_tree_array = '')
{

    if (!is_array($user_tree_array)){
        $user_tree_array = array();
    }
    $category_list = DB::table('wizard_categories')->select('*')
        ->where('id', '!=', 0)
        ->where('parent_id', $parent)
        ->where('is_active', '=', 0)
        ->where('is_deleted', '=', 0)
        ->orderBy('name', 'ASC')
        ->get()->toArray();


    foreach($category_list as $row)
    {
        $user_tree_array[] = ['id'=> $row->id, 'name' => $row->name, 'language_key' => $row->language_key, 'parent_id' => $row->parent_id, 'level' => $row->level, 'is_active' => $row->is_active];
//        $user_tree_array[] = "<a href='".url('wizard/options/')."/".$row->id."'  class=''>".ucfirst($row->name)."</a>";
        $user_tree_array = fetchCategoryTreeDesign($row->id,$cur_lev,  $user_tree_array);
    }


    return $user_tree_array;
}


function fetPrimaryCategory()
{
    $primaryCategory = DB::table('wizard_categories')->where(['is_deleted' => 0, 'level' => 1,'is_active'=> '0'])->orderBy('name', 'ASC')->get();
    return $primaryCategory;
}


function fetSecondaryCategory($parent_id = '')
{
    $primaryCategory = DB::table('wizard_categories')->where(['is_deleted' => 0, 'parent_id' => $parent_id, 'is_active' => '0'])->orderBy('name', 'ASC')->get();
    return $primaryCategory;
}

function getParentIdFromCategoryId($cat_id)
{
    $primaryCategory = DB::table('wizard_categories')->where(['is_deleted' => 0, 'id' => $cat_id])->orderBy('name', 'ASC')->first();
    return $primaryCategory;
}

function getFirstOptionOnList()
{
    $firstParentCategory = DB::table('wizard_categories')->where('id', '!=', '0')->where('parent_id', '0')->where(['is_active' => '0', 'is_deleted' => '0'])->orderBy('name', 'ASC')->first();

    if(count($firstParentCategory) > 0)
    {
        $firstSubCategory = DB::table('wizard_categories')->where('id', '!=', '0')->where('parent_id', $firstParentCategory->id)->where(['is_active' => '0', 'is_deleted' => '0'])->orderBy('name', 'ASC')->first();
    }

    if(count($firstSubCategory) > 0)
    {
        return $firstSubCategory->id;

    }else{
        //return "not found2";
        $alternateCategory = DB::table('wizard_categories')->where('id', '!=', '0')->where(['is_active' => '0', 'is_deleted' => '0'])->orderBy('name', 'ASC')->first();
        return $alternateCategory->id;
    }

}
/*wizard options*/



/*==================================Messages Section=================================*/
/*Messages/ alert Section*/
function getAlertTaxonomies()
{
    $alerts = DB::table('taxonomies_alert')->where('is_deleted', 0)->get();
    return $alerts;
}

function getUsersByUserType($user_type_id)
{
    $users = Db::table('users')->where('id' , '!=', '0')->where(['profile_id' => $user_type_id,'is_delete' => '0', 'is_active' => '0'])->get();
    return $users;
}

function getAlertTaxonomiesById($id)
{
    $alerts = DB::table('taxonomies_alert')->where('is_deleted', 0)->where('id', $id)->first();
    return $alerts;
}

/*Messages/ alert Section*/
/*Support Section*/
function generateTicketId($length = 6)
{
    $pool = '0123456789';
    $ticket_id = "#tic".substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    $data = DB::table('message_support')->select('unique_ticket')->where('unique_ticket', $ticket_id)->first();
    if(count($data) == 0)
    {
        return $ticket_id;
    }
    else{
        generateTicketId();
    }
}

function getSupportReply($support_id)
{
    //admin-comment
    $reply = DB::table('message_support_reply as msr')->select('msr.*')
        ->leftJoin('message_support as ms','msr.support_id', '=', 'ms.id')
        ->where('msr.support_id', $support_id)->orderBy('msr.created_at', 'ASC')->get();
    return $reply;
}

function getUserWithId($id)
{
    $user = DB::table('users')->select('name', 'image')->where('id', $id)->first();
    return $user;
}

/*Support Section*/

/*==================================Messages Section=================================*/




/*==================================Review Section=================================*/
function getReviewsTaxonomies()
{
    $reviews = DB::table('taxonomies_reviews')->where('is_deleted','0')->get()->toArray();
    return $reviews;
}

function getUserTypeByUserID($user_id)
{
    $user_profile_id = DB::table('users')->where('id', $user_id)->first();

    $user_type = DB::table('user_type')->where('id', $user_profile_id->profile_id)->first();
    return $user_type->type;
}
/*==================================Review Section=================================*/




function checkpermission_backup($module, $sub_id, $read_write,$iswriteper = 'false') {
    if($iswriteper != 'false'){
        $request = parse_url($_SERVER['REQUEST_URI']);
        $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylangaw/', '', $request["path"]), '/') : $request["path"];
        /*$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');*/
        $result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
        $current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);
        /*DB::enableQueryLog();
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        print_r($last_query);*/
        if(empty($current_module)){
            $path = URL::previous();
            $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('http://'.$_SERVER['HTTP_HOST'].'/easylangaw/', '', $path), '/') : $path;
//				$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
            $result = trim(str_replace('http://'.$_SERVER['HTTP_HOST'], '', $path), '/');
            $current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);
            /*DB::enableQueryLog();
            $queries = DB::getQueryLog();
            $last_query = end($queries);
            print_r($last_query);*/
        }
        $module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 1;
        $sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 12;
    }
    //$this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 1;
    //$this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 12;

    $user_id = Auth::user()->id;
    $user_permission = Auth::user()->permessi;
    $permission = json_decode($user_permission);

    if($user_id == 0) {
        return true;
    }
    else if($user_permission != "null" && $permission != null) {
        $check = in_array($module.'|'.$sub_id.'|'.$read_write, $permission);//echo $check;dd($permission);
        if($check){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/*Permissions*/
function checkpermission($module, $parent_id, $read_write,$iswriteper = 'false') {
    if($iswriteper != 'false'){
        $request = parse_url($_SERVER['REQUEST_URI']);
        $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/thermapro/', '', $request["path"]), '/') : $request["path"];
        /*$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');*/
        $result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
        $current_module = DB::select('select * from dynamic_menu where TRIM(BOTH "/" FROM link) = :link', ['link' => $result]);
        /*DB::enableQueryLog();
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        print_r($last_query);*/



        if(empty($current_module)){
            $path = URL::previous();
            dd($path);
            $path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('http://'.$_SERVER['HTTP_HOST'].'/thermapro/', '', $path), '/') : $path;
//				$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
            $result = trim(str_replace('http://'.$_SERVER['HTTP_HOST'], '', $path), '/');
            $current_module = DB::select('select * from dynamic_menu where TRIM(BOTH "/" FROM link) = :link', ['link' => $result]);
            /*DB::enableQueryLog();
            $queries = DB::getQueryLog();
            $last_query = end($queries);
            print_r($last_query);*/
        }
        $module = (isset($current_module[0])) ? $current_module[0] : 1;
        $parent_id = (isset($current_module[0]->parent_id)) ? $current_module[0]->parent_id : 12;
    }
    //$this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 1;
    //$this->parent_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 12;

    $user_id = Auth::user()->id;
    $user_permission = Auth::user()->permissions;
    $permission = json_decode($user_permission);

    if($user_id == 0) {
        return true;
    }
    else if($user_permission != "null" && $permission != null) {
        $check = in_array($module.'|'.$parent_id.'|'.$read_write, $permission);//echo $check;dd($permission);
        if($check){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
/*Permissions*/


/*Transfer Section*/
function getClientStatus()
{
    $booked = trans('messages.keyword_booked');
    $cancelled = trans('messages.keyword_cancelled');
    $check_in = trans('messages.keyword_check_in');
    $check_out = trans('messages.keyword_check_out');

    $array = [
        '1' => $booked,
        '2' => $cancelled,
        '3' => $check_in,
        '4' => $check_out
    ];

    return $array;

}
/*Transfer Section*/