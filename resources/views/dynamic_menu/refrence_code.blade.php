/* ==================================== Menu section START ======================================== */

public function menu() {
return view('menu');
}

public function parentmenu(Request $request) {
$parentmenu = DB::table("modulo")
->select('*')
->where('modulo_sub', '=', null)
->where('type', $request->parent)
->get()
->toArray();
// print_r($submenu);die;
echo json_encode($parentmenu);
}

public function menuadd() {
$parent = DB::table("modulo")->select('*')->where('modulo_sub', null)->get();
/*$departments = DB::table("departments")->select('*')->get();*/
$departments = DB::table("ruolo_utente")->select('*')->where('ruolo_id', '!=','0')->get();
return view('menuaddmodify',
['parent' => $parent,
'departments'=>$departments,
'language' => DB::table('languages')->where('is_deleted','0')->get()]);
}

public function menumodify(Request $request) {
$parent = DB::table("modulo")->select('*')->where('modulo_sub', null)->get();
$menu = DB::table("modulo")->select('*')->where('id', $request->id)->first();
//$departments = DB::table("departments")->select('*')->get();
$departments = DB::table("ruolo_utente")->select('*')->where('ruolo_id', '!=','0')->get();
$language_transalation = DB::table('language_transalation')->where('language_key',$menu->tutorial_lang_key)->get();
//$language_transalation = DB::table('language_transalation')->where('id',$request->id)->first();
//echo "<pre>"; print_r($menu);die;
        //$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
        return view('menuaddmodify',
		['menu' => $menu,
		'parent' => $parent,
		'departments'=>$departments,
		'language' => DB::table('languages')->where('is_deleted','0')->get()
		]);
    }

    public function menudelete(Request $request) {
        DB::table('modulo')
                ->where('id', $request->id)
                ->delete();
         return Redirect::back()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Menu deleted successfully!</div>');
    }

    public function storemenu(Request $request) {

        $validator = Validator::make($request->all(), [
                    'manuname' => 'required',
                    'image'=>'mimes:jpeg,jpg,png,svg|max:1000',
                    'image_app'=>'mimes:jpeg,jpg,png|max:1000',
                    'menutype' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }

        $nome = "";
        if ($request->image != null) {
            // Memorizzo l'immagine nella cartella public/imagesavealpha
            Storage::put('images/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath()));
            $nome = $request->file('image')->getClientOriginalName();
        }
        else {
            // Imposto l'immagine di default
            $nome = "defaulmenuicon.jpg";
        }

		$avatar_image = "";
		if (isset($request->avatar_imag) && $request->avatar_image != null) {
            Storage::put('images/modulavtar/' . $request->file('avatar_image')->getClientOriginalName(), file_get_contents($request->file('avatar_image')->getRealPath()));
            $avatar_image = $request->file('avatar_image')->getClientOriginalName();
        }
		$image_app = "";
		if (isset($request->image_app) && $request->image_app != null) {
            Storage::put('images/modulapp_icon/' . $request->file('image_app')->getClientOriginalName(), file_get_contents($request->file('image_app')->getRealPath()));
            $image_app = $request->file('image_app')->getClientOriginalName();
        }




        $status = $this->checkurl($request->menulink);
        $phase_key = 'keyword_'.str_replace(" ","_",strtolower($request->manuname));
		$keyword_tour_key = 'keyword_menutext_'.str_replace(" ","_",strtolower($request->manuname));
		$deparments = isset($request->deparments) ? implode(",",$request->deparments) : '0';
            DB::table('modulo')->insert([
            	'modulo' => $request->manuname,
                'phase_key' => $phase_key,
                'modulo_sub' => (isset($request->submenu) && $request->submenu != "") ? $request->submenu : $request->parentmenu,
                'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                'modulo_class' => $request->menuclass,
                'menu_active' => $status,
                'dipartimento'=>$deparments,
                'image' => $nome,
            	'type' => $request->menutype,
            	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
            	'backpriority' => isset($request->backpriority) ? $request->backpriority : '',
				'tutorial_lang_key'=>$keyword_tour_key,
				'avatar_image'=>$avatar_image,
				'image_app'=>$image_app
                ]);

            $arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('is_deleted', 0)
                        ->get();

			$collection = collect($arrLanguages);
			$arrLanguages = $collection->toArray();

			foreach($arrLanguages as $key => $val){
				$language_value = str_replace(" ","_",strtolower($request->manuname));
				DB::table('language_transalation')->insert([
					'language_key' => $phase_key,
					'language_label' =>$language_value,
					'language_value' => $request->manuname,
					'code' => $val->code
				]);

				if(isset($request[$val->code.'_keyword_desc'])){
					$language_value_text = $request[$val->code.'_keyword_desc'];
					DB::table('language_transalation')->insert([
						'language_key' => $keyword_tour_key,
						'language_label' =>$request->manuname." Menu Text",
						'language_value' => $language_value_text,
						'code' => $val->code,
						'is_cmspage' => '2'
					]);
				}
			}
			$this->writelanguagefile();


       /* if ($request->submenu != '') {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => $request->manuname,
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_subsub' => $request->submenu,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => "",
                        'menu_active' => $status
                    ]
            );
        } elseif ($request->parentmenu != "") {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => $request->manuname,
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => "",
                        'menu_active' => $status
                    ]
            );
        } else {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->insert(
                    ['modulo' => strtoupper($request->manuname),
                        'phase_key' => "keyword_" . $request->manuname,
                        'modulo_link' => $request->menulink,
                        'modulo_class' => $request->menuclass,
                        'menu_active' => $status
                    ]
            );
        }*/
        return redirect('/admin/menu/')
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_addsuccessmsg').'!</div>');
        //$keyword_key = 'keyword_'.str_replace(" ","_",strtolower($request['keyword_title']));
    }

    public function submenu(Request $request) {

    	if($request->parent != '0'){
        	$submenu = DB::table("modulo")
                ->select('*')
                ->where('modulo_sub', $request->parent)
                ->get()
                ->toArray();

            $submenu1[] = '';
			foreach($submenu as $sub) {
				$results = DB::table("modulo")
		                ->select('*')
		                ->where('modulo_sub', $sub->id)
		                ->get()
		                ->toArray();
				// array_push($submenu, $results);
		        $submenu1 = array_merge($submenu1, $results);
			}
			$submenu = array_merge($submenu, $submenu1);
        }
        else {
        	$submenu = DB::table("modulo")
                ->select('*')
                ->where('modulo_sub','!=', null)
                ->get()
                ->toArray();
        }

        echo json_encode($submenu);
    }

    public function checkurl($url) {
        $menuactive = 0;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);
        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($httpCode == 302 || $httpCode == 200) {
            /* Handle 404 here. */
            $menuactive = 1;
        }
        curl_close($handle);
        return $menuactive;
    }

    public function menujson() {

        $modulo = DB::table("modulo")
                ->select('*')
                ->get()
                ->toArray();


        foreach ($modulo as $key => $val) {
            if ($val->dipartimento != 0) {
                $department = DB::table("ruolo_utente")
                        ->select('*')
                        ->where('ruolo_id', $val->dipartimento)
                        ->first();
                $modulo[$key]->dipartimento = $department->nome_ruolo;
            } else {
                $modulo[$key]->dipartimento = 'All';
            }
            $val->type = ($val->type == '1') ? 'Front' : 'Backend';

            $checked = ($val->menu_active==0) ? 'checked' : '';
            $modulo[$key]->menu_active = '<div class="switch"><input name="status" onchange="updateStaus('.$val->id.')" id="activestatus_'.$val->id.'" '.$checked.' on value="1"  type="checkbox"><label for="activestatus_'.$val->id.'"></label></div>';

            /*if ($val->menu_active == 0) {
                $modulo[$key]->menu_active = 'Active';
            }
            else {
                $modulo[$key]->menu_active = 'Inactive';
            }*/
        }
        echo json_encode($modulo);
    }

    public function updatemenustatus(Request $request) {
		$update = DB::table('modulo')->where('id', $request->menuid)->update(array('menu_active' => $request->status));
		return ($update) ? 'true' : 'false';
	}

    public function menuupdate(Request $request) {
        $validator = Validator::make($request->all(), [
                    'manuname' => 'required',
                    'image'=>'mimes:jpeg,jpg,png,svg|max:1000',
					'image_app'=>'mimes:jpeg,jpg,png|max:1000',
                    'menutype' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
        }
        $deparments = isset($request->deparments) ? implode(",",$request->deparments) : '0';

    	$nome = "";
    	$oldMenuDetails = DB::table('modulo')->where('id', $request->id)->first();
    	$page = DB::table('admin_pages')->where('menu_id', $request->id)->first();
    	if(isset($page)){
    		DB::table('admin_pages')->where('page_id', $page->page_id)
    		->update(array('page_title' => $request->manuname));
    	}

    	$nome = $oldMenuDetails->image;
        if ($request->image != null) {
            // Memorizzo l'immagine nella cartella public/imagesavealpha
            Storage::put('images/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath()));
            $nome = $request->file('image')->getClientOriginalName();
        } /*else {

            // Imposto l'immagine di default
            //$nome = "defaulmenuicon.jpg";
        }*/

		$avatar_image = $oldMenuDetails->avatar_image;
		//print_r($request->avatar_image);
		//exit;
		if (isset($request->avatar_image) && $request->avatar_image != null) {
            Storage::put('images/modulavtar/' . $request->file('avatar_image')->getClientOriginalName(), file_get_contents($request->file('avatar_image')->getRealPath()));
            $avatar_image = $request->file('avatar_image')->getClientOriginalName();
        }
		$image_app = $oldMenuDetails->image_app;
		if (isset($request->image_app) && $request->image_app != null) {
            Storage::put('images/modulapp_icon/' . $request->file('image_app')->getClientOriginalName(), file_get_contents($request->file('image_app')->getRealPath()));
            $image_app = $request->file('image_app')->getClientOriginalName();
        }

		$arrLanguages =  DB::table('languages')
                        ->select('*')
                        ->where('id', '!=', 0)
                        ->get();
		$collection = collect($arrLanguages);
		$arrLanguages = $collection->toArray();
		$keyword_key = 'keyword_menutext_'.str_replace(" ","_",strtolower($request->manuname));
		foreach($arrLanguages as $key => $val){
			if(isset($request[$val->code.'_keyword_desc'])){
				$language_value = $request[$val->code.'_keyword_desc'];
					$language_transalation = DB::table('language_transalation')->where(['language_key'=>$oldMenuDetails->tutorial_lang_key,'code'=>$val->code])->first();
					if(count($language_transalation) > 0){
						DB::table('language_transalation')
						->where('language_key', $oldMenuDetails->tutorial_lang_key)
						->where('code', $val->code)
						->update([
						'language_label' =>$request->manuname." Menu Text",
						'language_value' => $language_value,
						'is_cmspage' => '2'
						]);
					}
					else {
					DB::table('language_transalation')->insert([
						'language_key' => $keyword_key,
						'language_label' =>$request->manuname." Menu Text",
						'language_value' => $language_value,
						'code' => $val->code,
						'is_cmspage' => '2'
					]);
					}
			}
		}


        //module sub sub menu

        if ($request->submenu != '') {
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')->where('id', $request->id)->
                    update(array(
                        'modulo' => $request->manuname,
                        'modulo_sub' => $request->submenu,
                        'modulo_subsub' => $request->submenu,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => "",
                        'menu_active' => $status,
                        'dipartimento'=>$deparments,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : '',
						'tutorial_lang_key'=>$keyword_key,
						'avatar_image'=>$avatar_image,
						'image_app'=>$image_app
            ));
        } elseif ($request->parentmenu != "") {
            //module sub menu
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')
                    ->where('id', $request->id)
                    ->update(array(
                        'modulo' => $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_subsub' => 0,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => "",
                        'menu_active' => $status,
                        'dipartimento'=>$deparments,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : '',
						'tutorial_lang_key'=>$keyword_key,
						'avatar_image'=>$avatar_image,
						'image_app'=>$image_app

            ));
        }
        else {
            //module parent menu
            $status = $this->checkurl($request->menulink);
            DB::table('modulo')
                    ->where('id', $request->id)
                    ->update(array(
                        'modulo' => $request->manuname,
                        'modulo_sub' => $request->parentmenu,
                        'modulo_link' => isset($request->menulink) ? $request->menulink : '',
                        'modulo_class' => $request->menuclass,
                        'menu_active' => $status,
                        'dipartimento'=>$deparments,
                        'image' => $nome,
	                	'type' => $request->menutype,
	                	'frontpriority' => isset($request->frontpriority) ? $request->frontpriority : '',
	                	'backpriority' => isset($request->backpriority) ? $request->backpriority : '',
						'tutorial_lang_key'=>$keyword_key,
						'avatar_image'=>$avatar_image,
						'image_app'=>$image_app
                	));
        }

		$this->writelanguagefile();
        return Redirect::back()
        	->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.trans('messages.keyword_editsuccessmsg').'</div>');
    }
    /* ==================================== Menu section END ======================================== */
