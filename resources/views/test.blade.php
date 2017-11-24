<?php
Route::get('template/categories', 'AdminController@email_template_category');
Route::get('template/categories/edit/{category_id?}', 'AdminController@email_template_category_add_edit');
Route::post('template/categories/update', 'AdminController@email_template_category_update');
Route::get('template/categories/property/json', 'AdminController@get_email_template_category_json');
Route::get('template/categories/changeactivestatus/{id}/{status}', 'AdminController@email_template_category_changeactivestatus');
Route::get('template/categories/delete/{id}', 'AdminController@template_category_delete');



?>