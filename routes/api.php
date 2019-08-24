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

Route::apiResource('permission_for', 'Api\PermissionForController');
Route::apiResource('permission', 'Api\PermissionController');
Route::get('permission/permissionForData', 'Api\PermissionController@permission_for_data');
Route::apiResource('role', 'Api\RoleController');
Route::apiResource('admin', 'Api\AdminController');
Route::apiResource('seo', 'Api\SeoController');
Route::apiResource('category', 'Api\CategoryController');
Route::apiResource('carousel', 'Api\CarouselController');
Route::apiResource('tag', 'Api\TagController');
