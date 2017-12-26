<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		 $path =  config('constant.PATH');
        if(!empty($current_module)){ \Session::put('path', $path); }
        if (empty($current_module)) {$path = \Session::get('path');}
        $result = trim(str_replace('http://' . $_SERVER['HTTP_HOST'], '', $path), '/');
        $current_module = DB::select('select * from dynamic_menu where TRIM(BOTH "/" FROM link) = :link', ['link' => $result]);
        $module_id = (isset($current_module[0]->id)) ? $current_module[0]->id : '';
        $parent_id = (isset($current_module[0]->parent_id)) ? $current_module[0]->parent_id : '';
        view()->share(['module_id' => $module_id, 'parent_id' => $parent_id]);
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
