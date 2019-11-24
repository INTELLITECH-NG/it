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
    return redirect()->route('login');
});
Route::get('/home', 'HomeController@dashboard')->name('home');
Route::get('/general-settings', 'HomeController@general')->name('settings');
Route::put('/general/update', 'HomeController@updateGeneral')->name('general.update');
Route::get('/sendMail','SendMailController@index')->name('sendMail.index');
Route::get('/sendMail/form','SendMailController@form')->name('sendMail.form');
Route::post('/sendMail/send','SendMailController@send')->name('sendMail.mail');
Route::get('/sendMail/details/{sendMail}','SendMailController@details')->name('sendMail.details');
Route::post('/sendMail/delete','SendMailController@destroy')->name('sendMail.destroy');

Auth::routes();

Route::get('/personal-settings','UserController@editPersonal')->name('user.settings');
Route::put('/update-password/{id}','UserController@updatePassword')->name('user.updatePassword');
Route::post('/user/delete','UserController@destroy')->name('user.destroy');
Route::resource('user','UserController');

Route::get('/email/import','EmailController@import')->name('import');
Route::post('/email/import-emails','EmailController@importEmail')->name('import-emails');
Route::post('/email/delete','EmailController@destroy')->name('email.destroy');
Route::resource('email','EmailController');

Route::put('/update-status/{id}','SMTPController@updateStatus')->name('mailer.update.status');
Route::post('/mailer/delete','SMTPController@destroy')->name('mailer.destroy');
Route::resource('mailer','SMTPController');

Route::get('/emails/group/{group}','GroupController@show')->name('group-mail');
Route::post('/group/delete','GroupController@destroy')->name('group.destroy');
Route::resource('group','GroupController');

Route::group(['middleware' => ['role:admin']], function() {
    Route::get('user/{user}/edit', 'UserController@edit')->name('user.edit');
    Route::get('email/{email}/edit', 'EmailController@edit')->name('email.edit');
    Route::get('mailer/{mailer}/edit', 'SMTPController@edit')->name('mailer.edit');
    Route::get('group/{group}/edit', 'GroupController@edit')->name('group.edit');
    Route::delete('user/{user}', 'UserController@destroy')->name('user.destroy');
    Route::delete('email/{email}', 'EmailController@destroy')->name('email.destroy');
    Route::delete('mailer/{mailer}', 'SMTPController@destroy')->name('mailer.destroy');
    Route::delete('group/{group}', 'GroupController@destroy')->name('group.destroy');
});