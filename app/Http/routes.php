<?php

/**
 * Application Routes
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
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
        return 'hello world';
    }
);
Route::group(
    [
    'prefix' => 'api'
    ], 
    function () {
        Route::group(
            [
            'prefix' => 'online', 'namespace' => 'User'
            ], 
            function () {
                /*get the data of those who online and offline*/
                route::get('/', 'CsUserController@online');

                /*create a new online messg*/
                route::post('/{id}', 'CsUserController@create');

                /*update online info*/
                route::put('/{id}', 'CsUserController@update');
            }
        );

        Route::group(
            [
            'prefix' => 'admins', 'namespace' => 'Admin'
            ], 
            function () {
            }
        );

        Route::group(
            [
            'namespace' => 'User'
            ], 
            function () {

                Route::group(
                    ['middleware' => 'jwt.auth'],
                    function () {
                        /*obey the restful rule api*/
                        Route::resource('users', 'CsUserController');
                
                        /*search identified grade*/
                        Route::get('/users/grade/{id}', 'CsUserController@grade');

                        /*reset password*/
                        Route::put('/users/{id}/password', 'CsUserController@resetpd');

                        Route::get('/users/{id}/read', 'CsMailController@mail_read');
                        Route::get('/users/{id}/send', 'CsMailController@mail_send');
                        Route::get('/users/{id}/unread', 'CsMailController@mail_unread');
                        Route::get('/users/{id}/draft', 'CsMailController@mail_draft');
                    }
                );
            }
        );

        Route::group(
            [
                'prefix'    => 'mails',
                'namespace' => 'Mail'
            ], 
            function () {

                /*获取用户id已读列表*/
                Route::get('/{id}/read', 'CsMailController@mail_read');
                /*获取用户id未读列表*/
                Route::get('/{id}/unread', 'CsMailController@mail_unread');
                /*获取用户id发送列表*/
                Route::get('/{id}/send', 'CsMailController@mail_send');
                /*获取用户id草稿列表*/
                Route::get('/{id}/draft', 'CsMailController@mail_draft');
                /*获取用户id所有列表*/
                Route::get('/{id}/all', 'CsMailController@mail_all');
                /*统计各类站内信数量*/
                Route::get('/count/{id}', 'CsMailController@count');
                
                /*ajax异步获取名字信息*/
                Route::get('/match/{name}', 'CsMailController@match');
        
                /*发送站内信*/
                Route::post('/', 'CsMailController@store');

                Route::group(
                    [
                    'middleware' => 'jwt.auth'
                    ],
                    function () {

                    }
                );
            }
        );

        Route::group(
            [
            'namespace' => 'Auth'
            ],
            function () {
                Route::resource(
                    'authenticate',
                    'AuthenticateController',
                    ['only' => ['index']]
                );
                Route::post('authenticate', 'AuthenticateController@authenticate');
            }
        );

        Route::group(
            [
            'prefix' => 'discuss', 
            'namespace' => 'Applications\Discuss'
            ],
            function () {
                Route::resource('questions', 'QuestionController');
                Route::resource(
                    'questions/{question_id}/answers', 'AnswerController'
                );
            }
        );
    }
);
