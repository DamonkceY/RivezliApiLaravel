<?php

use App\Models\Course;
use App\Models\Department;
use App\Models\Group;
use App\User;
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
            Route::get('getUserProfile/{id}', 'AuthController@getUserProfile');
            Route::get("mycourses",function(Request $request){
                $user = User::where("id",$request->user()->id)->with(["group.courses.user"])->first();
                $c = $user->group->courses;
                return response()->json([
                    "courses" => $c
                ]);
            });
            Route::post("getCourseId",function(Request $request){


                $c = Course::where("id",$request->id)->with(["files","user"])->first();
                return response()->json([
                    "course" => $c
                ]);
            });
        });
    });

    /**
     *
     * Admin Privileges
     *
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('allG', function () {
            return response()->json([
                'groups' => Group::with(['profs.group', 'profs.user', 'department', 'students'])->get()
            ]);
        });
        Route::get('allProfs', function () {
            return response()->json([
                'profs' => User::where('role', 1)->with(['groups.group', 'groups.user'])->get()
            ]);
        });
        Route::get('allDep', function () {
            return response()->json([
                'dep' => Department::all()
            ]);
        });

        Route::group(['middleware' => ['admin', 'auth:api']], function () {
            Route::group(['prefix' => 'department'], function () {
                Route::post('/add', 'DepartmentController@store');
                Route::post('/update', 'DepartmentController@update');
                Route::post('/delete', 'DepartmentController@delete');
            });

            Route::group(['prefix' => 'group'], function () {

                Route::post('/add', 'GroupController@store');
                Route::post('/update', 'GroupController@update');
                Route::delete('/delete', 'GroupController@delete');
            });

            Route::group(['prefix' => 'prof'], function () {

                Route::post('/add', 'AdminController@createProf');
                Route::post('/relateProf', 'AdminController@relateProf');
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


    /**
     *
     * Prof
     *
     */


    Route::group(['prefix' => 'prof'], function () {

        Route::group(['middleware' => ['auth:api', 'prof']], function () {
            Route::get("myG", function ( Request $request) {
                $p = User::where('id',$request->user()->id)->with("groups.group")->first();
                return response()->json([
                    "groups" => $p->groups
                ]);
            });
            Route::group(['prefix' => 'course'], function () {
                Route::post('/add', 'CourseController@store');
                Route::post('/update', 'CourseController@update');
                Route::post('/delete', 'CourseController@delete');
                Route::post("getAllG", function(Request $request){
                    return response()->json([
                        "courses" => Course::where("group_id",$request->id)->get()
                        // "courses" => $request->id
                    ]);
                });
                Route::post("getCourseDetails",function(Request $request){
                    return response()->json([
                        "course"=> Course::where("id",$request->id)->with(['files','user'])->first()
                    ]);
                });
            });

            Route::group(['prefix' => 'file'], function () {
                Route::post('/add', 'FileController@store');
                Route::post('/update', 'FileController@update');
                Route::post('/delete', 'FileController@delete');
            });
        });
    });
});
