<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Routing array
	|--------------------------------------------------------------------------
	|
	| This is passed to the Route::group and allows us to group and filter the
	| routes for our package
	|
	*/
	'routing' => array(
		'prefix' => '/social'
	),

	/*
	|--------------------------------------------------------------------------
	| facebook array
	|--------------------------------------------------------------------------
	|
	| Login and request things from facebook.
	|
	*/
	'facebook' => array(
		'key' => '',
		'secret' => '',
		'scopes' => array('email'),
		'redirect_url' => 'social/facebooklogin',
	),

	/*
	|--------------------------------------------------------------------------
	| twitter array
	|--------------------------------------------------------------------------
	|
	| Login and request things from twitter
	|
	*/
	// 'twitter' => array(
	// 	'key' => '',
	// 	'secret' => '',
	// 	'scopes' => array(),
	// 	'redirect_url' => '/',
	// ),

	/*
	|--------------------------------------------------------------------------
	| google array
	|--------------------------------------------------------------------------
	|
	| Login and request things from google
	| Random scope configuration example: https://github.com/artdarek/oauth-4-laravel
	*/
	'google' => array(
		'key' => '',
		'secret' => '',
		'scopes' => array('userinfo_email', 'userinfo_profile'),
		'redirect_url' => 'social/googlelogin',
	),

	/*
	|--------------------------------------------------------------------------
	| github array
	|--------------------------------------------------------------------------
	|
	| Login and request things from github
	|
	*/
	// 'github' => array(
	// 	'key' => '',
	// 	'secret' => '',
	// 	'scopes' => array('email'),
	// 	'redirect_url' => '/',
	// ),

);
