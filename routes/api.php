<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['cors', 'json.response']], function () {


    Route::get('getGroups', 'GroupController@getAll');
    /**
     *
     * Authentification
     *
     */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');

        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::get('logout', 'AuthController@logout');
            Route::post('updateAvatar', 'AuthController@updateAvatar');
            Route::get('getAvatar', 'AuthController@getAvatar');
            Route::get('user', 'AuthController@user');
            Route::get('getUserPosts', 'AuthController@getUserPosts');
            Route::post('send', 'MessageController@send');
            Route::post('getGroupMessages', 'MessageController@getGroupMessages');
            Route::get('getUserProfile/{id}','AuthController@getUserProfile');
        });
    });

    /**
     *
     * Admin Privileges
     *
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => ['admin', 'auth:api']], function () {
            Route::group(['prefix' => 'department'], function () {
                Route::post('/add', 'DepartmentController@store');
                Route::post('/update', 'DepartmentController@update');
                Route::delete('/delete', 'DepartmentController@delete');
            });

            Route::group(['prefix' => 'group'], function () {

                Route::post('/add', 'GroupController@store');
                Route::post('/update', 'GroupController@update');
                Route::delete('/delete', 'GroupController@delete');
            });

            Route::group(['prefix' => 'prof'], function () {

                Route::post('/add', 'AdminController@createProf');
                Route::post('/update', 'GroupController@update');
                Route::delete('/delete', 'GroupController@delete');
            });
        });
    });

    /**
     *
     *
     *
     */
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/download', 'FileController@download');
        Route::group(['prefix' => 'post'], function () {
            Route::post('/add', 'PostController@store');
            Route::post('/getAll', 'PostController@getAll');
            Route::post('/getAllUser', 'PostController@getAllUser');
            Route::post('/update', 'PostController@update');
            Route::delete('/delete', 'PostController@delete');
            Route::get('/getComments', 'PostController@getComments');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::post('/add', 'CommentController@store');
            Route::post('/update', 'CommentController@update');
            Route::delete('/delete', 'CommentController@delete');
        });

        Route::get('getProfs', 'AuthController@getProfs');
    });


    Route::group(['prefix' => 'prof'], function () {
        Route::group(['middleware' => ['auth:api', 'prof']], function () {
            Route::group(['prefix' => 'course'], function () {
                Route::post('/add', 'CourseController@store');
                Route::post('/update', 'CourseController@update');
                Route::delete('/delete', 'CourseController@delete');
            });

            Route::group(['prefix' => 'file'], function () {
                Route::post('/add', 'FileController@store');
                Route::post('/update', 'FileController@update');
                Route::delete('/delete', 'FileController@delete');
            });
        });
    });
});
