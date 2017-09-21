<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() { return view("app");} );
//Route::controllers([ 'Web' => 'WebController',]);
Route::controllers([
		'web'=>'WebController',
					
]);
//认证路由配置
Route::controllers([
		'webauth' => 'Auth\WebAuthController',
		'webpassword' => 'Auth\WebPasswordController',
]);


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
