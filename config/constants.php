<?php

$request = parse_url($_SERVER['REQUEST_URI']);
$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/therma/', '', $request["path"]), '/') : $request["path"];


return [
    'PATH'      =>      $path,
   'MAP_KEY' => 'AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE',//AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI
];
