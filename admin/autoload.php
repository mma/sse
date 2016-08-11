<?php

if (!function_exists('array_column')) {
    require_once(plugin_dir_path(__FILE__).'/vendor/array_column.php');
}

function __autoload($name){
	
    $class_name = $name.'.class.php';
	$path = plugin_dir_path( __FILE__ ).$class_name;
	
    if(file_exists($path)){
		require_once($class_name);
	}
}