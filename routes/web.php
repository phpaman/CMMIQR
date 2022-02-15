<?php

use Illuminate\Support\Facades\Route;
use Craftsys\Msg91\Facade\Msg91;

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

Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    dd("Cache is cleared");
});

Route::get( 'sms', function(){
    Msg91::sms()
    ->to(912343434312) // set the mobile with country code
    ->flow("your_flow_id_here") // set the flow id
    ->send();
    return "sent";
});

Route::get('info', function(){
   return phpinfo(); 
});

Route::get('/home','HomeController@index2')->name('index2');

Route::get('/spin', function(){
    return view('frontend.spin');
});

// Route::get('/home','HomeController@index')->name('index');
Route::post('/get/sub/attendee','HomeController@getSubattendee')->name('member.get.sub_attendees');
Route::post('/save/booking','HomeController@saveBooking')->name('frontend.save.booking');
Route::post('/save/booking/confirmation','HomeController@confirm')->name('confirm');
Route::post('/get/event/instructions','HomeController@getInstructions')->name('event.get.instructions');
Route::get('/view/sponsor/booking','HomeController@viewSponsorBooking')->name('view.sponsor.booking');
Route::post('/save/sponsor/booking','HomeController@saveSponsorBooking')->name('frontend.sponsor.booking');

Route::prefix('admin')->group(function () {
    //ADMIN LOGIN//
    Route::get('/login','Admin\LoginController@index')->name('admin.loginpage');
    Route::post('/dologin','Admin\LoginController@login')->name('admin.login');
    Route::get('/logout','Admin\LoginController@logout')->name('logout');
Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard','Admin\DashboardController@index')->name('admin.dashboard');
    //ATTENDEES//
    Route::get('/main-attendees','Admin\AttendeesController@mainAttendees')->name('admin.mainattendees');
    Route::get('/add/main-attendees','Admin\AttendeesController@addMainAttendee')->name('admin.add.mainattendees');
    Route::post('/save/main-attendees','Admin\AttendeesController@saveMainAttendee')->name('admin.save.mainattendees');
    Route::post('/save/category','Admin\AttendeesController@saveCategory')->name('admin.save.category');
    Route::post('/category/edit/details','Admin\AttendeesController@categoryEditDetails')->name('admin.edit.categorydetails');
    //ADMIN BOOKING//
    Route::post('/newbookingData','Admin\AttendeesController@newbookingData')->name('admin.add.newbookingData');
    Route::post('/savebooking','Admin\AttendeesController@saveBooking')->name('admin.save.booking');
    Route::get('/bookings','Admin\AttendeesController@Bookings')->name('admin.bookings');
    Route::post('/show/booking/details','Admin\AttendeesController@showBookingDetails')->name('admin.show.bookingdetails');
    Route::post('/booking/details','Admin\AttendeesController@bookingDetails')->name('admin.booking.details');
    Route::get('/booking/resend/email/{slug}','Admin\AttendeesController@resendEmail')->name('admin.resend.email');
    Route::get('/booking/download/pdf/{slug}','Admin\AttendeesController@downloadpdf')->name('admin.download.pdf');
    //EVENTS//
    Route::get('/events','Admin\AttendeesController@showEvents')->name('admin.events');
    Route::post('/save/events','Admin\AttendeesController@saveEvents')->name('admin.save.event');
    Route::post('/edit/events','Admin\AttendeesController@editEvents')->name('admin.edit.events');
    Route::post('/update/events','Admin\AttendeesController@updateEvents')->name('admin.update.events');
    //SPONSERS//
    Route::get('/show/sponsers','Admin\SponserController@index')->name('admin.sponsers');
    Route::post('/save/sponsers','Admin\SponserController@save')->name('admin.save.sponser');
    Route::post('/booking/sponser','Admin\SponserController@booking')->name('admin.booking.sponser');
    
});  
});

Route::prefix('user')->group(function () {
Route::group(['middleware' => 'user'], function () {
    Route::get('/dashboard','User\DashboardController@index')->name('user.dashboard');  
    Route::post('/details','User\DashboardController@userDetails')->name('user.detail'); 
    Route::post('/update/details','User\DashboardController@updateAttendeeDetails')->name('user.update.details');  
    Route::get('/uid/{id}','User\UserController@index')->name('user.uid.attendeedetail');  
    Route::get('/bookings','User\UserController@bookings')->name('user.show.bookings'); 
    Route::post('/booking/details','User\UserController@bookingDetails')->name('user.booking.details');
});
});


