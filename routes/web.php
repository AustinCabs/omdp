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

Route::get('/', 'PortalController@index');
Route::get('/permitee/{masterlist}', 'PortalController@show');
Route::get('/query/login', 'PortalController@queryLogInShow');
Route::get('/query/find', 'PortalController@queryShowDetails');

Route::group(['middleware' => ['auth','admin']], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

	#masterlist routes
	Route::get('/masterlist', 'MasterlistController@index');

	Route::get('/masterlist/addGet', 'MasterlistController@createGet');

	Route::post('/masterlist/addPost', 'MasterlistController@createPost');

	Route::get('/masterlist/{masterlist}', 'MasterlistController@show');

	Route::post('/masterlist/changeStatus/{masterlist}', 'MasterlistController@changeStatus');

	Route::get('/printPermit/{masterlist}', 'MasterlistController@printPermit');

	Route::get('/masterlist/updateGet/{masterlist}', 'MasterlistController@updateGet');

	Route::post('/masterlist/update/{masterlist}', 'MasterlistController@updatePost');

	Route::get('/masterlist/renewGet/{masterlist}','MasterlistController@renewGet');

	#settings
	Route::get('/settings/data', 'DataController@index');

	Route::post('/settings/data/create', 'DataController@create');

	Route::get('/settings/data/checklist', 'DataController@checklistSettings');

	Route::get('/settings/delete-permit/{permittype}', 'DataController@deletePermit');

	#user managment

	Route::get('/settings/users', 'UserController@index');
	Route::get('/settings/resetPassword/{user}', 'UserController@resetPassword');
	
	#announcement settings
	Route::get('/settings/announcement', 'AnnouncementController@index');

	Route::post('/settings/announcement/new', 'AnnouncementController@create');

	Route::get('/settings/announcement-delete/{announcement}', 'AnnouncementController@destroy');

	#reports
	Route::get('/reports', 'ReportController@index');

	Route::get('/exports', 'ReportController@generateReport');

	#chats
	Route::get('/chats', 'ChatController@index');
});

Route::group(['middleware' => 'auth'], function(){
	#billing
	Route::get('/billing', 'BillingController@index');

	Route::get('/billing/{masterlist}', 'BillingController@show');

	#my profile
	Route::get('/profile/{user}', 'UserController@showProfile');

	Route::post('/updateProfile/{user}', 'UserController@updateProfile');

});
