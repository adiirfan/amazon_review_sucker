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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    Route::post('scrape', 'API\ScrapeController@index');
    Route::get('product', 'API\ProductController@index');
    Route::get('product/{ASIN}', 'API\ProductController@single');
    Route::get('product/{ASIN}/review', 'API\ReviewController@index');
    Route::get('product/{ASIN}/avg', 'API\ReviewController@getAVG');
    Route::get('product/{ASIN}/total', 'API\ReviewController@getSumTotal');
    Route::get('tags/', 'API\TagsController@tagIndex');
    Route::get('tags/analyze', 'API\TagsController@analyzeTags');
    Route::get('tags/analyze/{tags}/list', 'API\TagsController@reviewByTags');
    Route::post('tags/{reviewId}/add', 'API\TagsController@insertTags');
    Route::get('tags/review/{id}', 'API\TagsController@getTagsReview');
    Route::post('tagsreview/{id}/delete', 'API\TagsController@deleteTagsReview');
    Route::post('tags/{id}/delete', 'API\TagsController@deleteTags');
});
