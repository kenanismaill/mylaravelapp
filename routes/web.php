<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['web']],function (){
    Route::get('/', function () {
         return view('welcome');
    })->name('home');

    Route::post('/signup',[
       'uses'=>'UserController@SignUp',
        'as'=>'signup'
    ]);

    Route::get('/logout',[
        'uses'=>'UserController@getloggout',
        'as'=>'logout'
    ]);

    Route::post('/signin',[
        'uses'=>'UserController@SignIn',
        'as'=>'signin'
    ]);

    Route::get('/dashboard',[
        'uses'=>'PostController@getDashboard',
        'as'=>'dashboard',

        ])->middleware('auth');

    Route::post('/createpost',[
        'uses'=>'PostController@createPost',
        'as'=>'createpost',

    ]);

    Route::get('/deletepost/{post_id}',[
       'uses'=>'postController@deletePost',
       'as'=>'deletepost',

    ]);

    Route::post('/edit',[
       'uses'=>'postController@editpost',
       'as'=>'edit'
    ]);

    Route::get('/account',[
        'uses'=>'UserController@useraccount',
        'as'=>'account'
        ]);

    Route::post('/updateaccount',[
        'uses'=>'UserController@updateaccount',
        'as'=>'account.save'
    ]);

    Route::get('/userimage/{filename}',[
       'uses'=>'UserController@getuserImage',
       'as'=>'account.image'
    ]);
});
