<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('v1')->group(function () {
    Route::get('/')->name('api_endpoint');
    Route::get('posts', 'ApiController@getPosts')->name('get_posts');
    Route::get('tags', 'ApiController@getTags')->name('get_tags');

    Route::get('posts/{slug}', 'ApiController@getSinglePost')->name('api_get_single_post');

    Route::get('tags/{slug}', 'ApiController@getTagPosts')->name('get_tag_posts');
    Route::get('author/{user_name}', 'ApiController@getAuthorPosts')->name('author_posts');

    /**
     * User Related Api
     */
    Route::prefix('user')->group(function () {
        Route::post('check-user-name-availability', 'ApiController@checkUserNameAvailability')->name('user_name_availability');
    });

});