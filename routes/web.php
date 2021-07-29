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

Route::get('/', function () {
    return redirect('login');
});


Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function () {
		
		Route::get('show_online_operator', 'DashboardController@show_online_operator');
		Route::get('dashboard', 'DashboardController@index');
		Route::get('widget_preview', 'DashboardController@widget_preview');
		Route::get('widget_code', 'DashboardController@widget_code');
        
		
		//User Controller
		Route::post('users/update_user_activity', 'UserController@update_user_activity');
		Route::resource('users','UserController');
		
		//Profile Controller
		Route::get('profile/my_profile', 'ProfileController@my_profile');
		Route::get('profile/edit', 'ProfileController@edit');
		Route::post('profile/update', 'ProfileController@update');
		Route::get('profile/change_password', 'ProfileController@change_password');
		Route::post('profile/update_password', 'ProfileController@update_password');
		
		Route::resource('departments','DepartmentController');
		Route::resource('canned_messages','CannedMessageController');
		
		//Message Controller
		Route::get('message/chat/{chat_request_id?}', 'MessageController@chat');
		Route::post('message/upload_file', 'MessageController@upload_file');
		Route::post('message/send_message', 'MessageController@send_message');
		Route::get('message/end_chat/{chat_request_id}', 'MessageController@end_chat');
		Route::get('message/get_messages/{chat_request_id}/{last_id?}', 'MessageController@get_messages');
		Route::get('message/get_chat_history_data', 'MessageController@get_chat_history_data');
		Route::get('message/chat_history/{id?}', 'MessageController@chat_history');
		Route::get('message/remove_history/{id}', 'MessageController@remove_history');	
		
		//Transfer Chat Window
		Route::get('chat/transfer_window', 'MessageController@chat_transfer_window');
		Route::get('chat/transfer_chat/{chat_request_id}/{operator_id}/{guest_id}', 'MessageController@transfer_chat');
		
		//Offline Message
		Route::resource('offline_messages','OfflineMessageController');		
		
		//Utility Controller
		Route::match(['get', 'post'],'administration/general_settings/{store?}', 'UtilityController@settings')->name('general_settings.update');
		Route::match(['get', 'post'],'administration/widget_settings/{store?}', 'UtilityController@widget_settings')->name('widget_settings.update');
		Route::post('administration/upload_logo', 'UtilityController@upload_logo')->name('general_settings.update');
		Route::get('administration/toggle_offline_mode', 'UtilityController@toggle_offline_mode')->name('utility.toggle_offline_mode');
		
		/**************************
			Super Admin Routes    
		***************************/
		Route::resource('tenants','SuperAdmin\TenantController');
		
	
});
	
//Public Route
Route::get('chat_widget.js', 'GuestController@show_chat_widget');
Route::get('widget_content', 'GuestController@widget_content');
Route::post('guest/store_guest_user', 'GuestController@store_guest_user');
Route::post('guest/update_user_activity', 'GuestController@update_user_activity');
Route::post('guest/upload_file', 'GuestController@upload_file');
Route::post('guest/send_message', 'GuestController@send_message');
Route::post('guest/send_offline_message', 'GuestController@send_offline_message');
Route::get('guest/get_messages/{last_id?}', 'GuestController@get_messages');
Route::get('guest/end_chat', 'GuestController@end_chat');
