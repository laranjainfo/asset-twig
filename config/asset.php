<?php

// Asset configuration file
// 
// You can change the version based on package.json file, just change the version value to:
// 
//	$pkg = file_get_contents('../destination/of/package.json');
//	$pkg = json_decode($pkg);
//	$v	 = '?v='.$pkg->version;
//	
//	Then:
//	
//	return = [
//		...
//		'version_perfix' => '?v=',
//		'version' => $v,
//	];
//	
return [
	'site_url'			=> 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
	'prefix'			=> 'web',
	'version'			=> true,
	'css_dir'			=> 'css',
	'js_dir'			=> 'js',
	'images_dir'		=> 'images',
	'touch_icon_dir'	=> 'icons',
	'manifest_dir'		=> '',
	'version_prefix'	=> '?v=',
	'version'			=> '1.0.0',
];
