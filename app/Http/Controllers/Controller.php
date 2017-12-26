<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construct()
    {
        $path =  config('constant.PATH');
        if(!empty($current_module)){ \Session::put('path', $path); }
        if (empty($current_module)) {$path = \Session::get('path');}
        $result = trim(str_replace('http://' . $_SERVER['HTTP_HOST'], '', $path), '/');
        $current_module = DB::select('select * from dynamic_menu where TRIM(BOTH "/" FROM link) = :link', ['link' => $result]);
        $this->module = $current_module[0];
        $this->module_id = (isset($current_module[0]->id)) ? $current_module[0]->id : '';
        $this->parent_id = (isset($current_module[0]->parent_id)) ? $current_module[0]->parent_id : '';
    }
}
