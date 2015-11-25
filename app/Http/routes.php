<?php

/**
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 *
 * PHP version 5.6
 *
 * @category PHP
 * @package  PHP_Laveral
 * @author   teddyliao <sxliao@foxmail.com>
 * @license  http://xiyoulinux.org BSD Licence
 * @link     http://cs.xiyoulinux.org
 */
Route::get(
    '/', function () {
        return view('test');
    }
);

Route::group(
    [
    'prefix' => 'online', 'namespace' => 'UserOnline'
    ], 
    function () {
        route::get('/', 'UserOnlineController@index');
    }
);

Route::group(
    [
    'prefix' => 'users', 'namespace' => 'User'
    ], 
    function () {
        /*get all users' information*/
        route::get('/', 'CsUserController@index');

        /*get user info from id*/
        route::get('/{id}', 'CsUserController@show');

        /*get gravatar pic*/
        route::get('/{id}/gravatar', 'CsUserController@gravatar');

        /*deliver privilege*/
        route::post('/privilege', 'CsUserController@privilege');

        /*delete member*/
        route::post('/delete', 'CsUserController@delete');

        /*create member*/
        route::post('/create', 'CsUserController@create');

        /*update personal information*/
        route::post('/update/{id}', 'CsUserController@update');
        
    }
);
