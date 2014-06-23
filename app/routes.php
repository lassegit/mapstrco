<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'TracksController@index');

Route::get('hot', 'TracksController@index');

Route::get('genres', 'TracksController@index');

Route::get('about', 'TracksController@index');

Route::get('latest-tracks', 'TracksController@latestTracks');

Route::resource('tracks', 'TracksController');

Route::post('comments', ['as' => 'comments.store', 'uses' => 'CommentsController@store']);

Route::resource('users', 'UsersController');

Route::post('login', 'UsersController@login');

Route::get('mastercluster', 'TracksController@masterCluster');

Route::get('liketrack/{id}', 'LikesController@likeTrack');

Route::get('unliketrack/{id}', 'LikesController@unlikeTrack');

Route::get('likecomment/{id}', 'LikesController@likeComement');

Route::get('unlikecomment/{id}', 'LikesController@unlikeComement');

Route::get('latest-comments', 'CommentsController@latestComments');

Route::get('logout', 'UsersController@logout');

Route::get('social/facebooklogin', 'SocialAuthController@facebookLogin');

Route::get('social/googlelogin', 'SocialAuthController@googleLogin');


/**
 * Composer attaching user specific content or login forms to master layout.
 * Template file is located in layouts.header.controls.
 */
View::composer('users.loggedin', function($view)
{
	if (Auth::check()) 
	{
		// Cache user
		$user = Cache::remember('userblock' . Auth::user()->id, 10, function() {
			return User::find(Auth::user()->id);
		});
	} 

	else 
	{
		$user = null;
	}

    $view->with('user', $user);
});
