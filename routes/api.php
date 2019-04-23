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
Route::post('login', 'Api\AuthController@login');

Route::middleware('auth:api')->group(function () {
	Route::get('users', 'Api\UserController@listUsers');
	Route::post('user', 'Api\UserController@addUser');
	Route::put('user/{id}', 'Api\UserController@editUser');

	Route::get('departments', 'Api\UserController@listDepartments');
	Route::get('positions', 'Api\UserController@listPostions');

	Route::get('roles', 'Api\RoleController@listRoles');
	Route::post('role', 'Api\RoleController@addRole');
	Route::put('role/{id}', 'Api\RoleController@editRole');

	Route::get('permissions', 'Api\PermissionController@listPermissions');

	Route::post('logout', 'Api\AuthController@logout');
});
