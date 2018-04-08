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

Route::get('/', ['uses' => 'HomeController@index'])->name('home');

Auth::routes();

Route::get('/home', 'HomeController@home')->name('welcome');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');


//Route::get('{all}', ['uses' => 'HomeController@index'])->where(['all' => '.*']);




/**
 * I moved this api url here because of
 * session state and CSRF protection
 *
 *
 */
Route::prefix('api/v1')->group(function () {
    Route::post('save-new-post', 'ApiController@saveNewPost')->name('save_new_post');

    /**
     * User Related Api
     */
    Route::prefix('user')->group(function () {
        Route::post('register', 'ApiController@userRegister')->name('api_user_register');
        Route::post('sign-in', 'ApiController@signIn')->name('api_sign_in');
        Route::post('logout', 'ApiController@logout')->name('api_logout');
    });


    Route::prefix('office')->group(function () {
        Route::get('users-posts', 'ApiController@getUsersOfficePosts')->name('get_users_office_posts');
        Route::get('all-posts', 'ApiController@getAllPosts')->name('get_all_office_posts');
        Route::post('post-status-change', 'ApiController@postStatusChange')->name('post_status_change');
    });

});



Route::get('{all}', function () {
    return view('home');
})->where(['all' => '.*']);