<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/showimage', function () {
    return view('showimage');
});

Route::get('/oapptest', function () {
    return view('oapp.oapptest');
});

Route::get('/oapptomorrow', function () {
    return view('oapp.oapptomorrow');
});

Route::get('/oapptoday', function () {
    return view('oapp.oapptoday');
});

Route::get('/ptvisit', function () {
    return view('oapp.ptvisit');
});

Route::get('/ptresult', function () {
    return view('oapp.ptresult');
});

Route::get('/tracktime', function () {
    return view('servicealert.tracktime');
});

Route::resource('emr', 'EmrController');
Route::get('emrsetting', 'EmrController@setting')->name('emrsetting');
Route::resource('vaccine', 'VaccineController');
Route::resource('setting', 'SettingController');
Route::resource('userman', 'UsermanController');
Route::resource('sessionregister', 'SessionregisterController');
Route::resource('ptregister', 'PtRegisterController');
Route::get('ptcheck', 'PtRegisterController@ptcheck')->name('ptcheck');
Route::get('ptinfo', 'PtRegisterController@ptinfo')->name('ptinfo');
Route::get('ptregisted', 'PtRegisterController@registed')->name('ptregisted');

Route::get('province', 'ProvinceController@index')->name('province');
Route::get('amphure', 'ProvinceController@amphure')->name('amphure');
Route::get('district', 'ProvinceController@district')->name('district');

Route::get('/liff', function () {
    return view('liff');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homeregister', 'HomeController@register')->name('homeregister');
Route::get('/main', 'MainController@index')->name('main');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/book', 'BookController@index')->name('book');
Route::get('/bookcalendar', 'BookController@calendar')->name('bookcalandar');
Route::get('/booktime', 'BookController@time')->name('booktime');
Route::post('/bookcc', 'BookController@quecc')->name('bookcc');
Route::post('/bookstore', 'BookController@store')->name('bookstore');

Route::get('/card', 'CardController@index')->name('card');

Route::resource('oapp', 'OappController');
Route::get('/oapp', 'OappController@index')->name('oapp');
Route::get('/oappupdatecheck', 'OappController@updatecheck')->name('oappupdatecheck');
Route::get('/oappdetail', 'OappController@detail')->name('oappdetail');
Route::get('/checkin', 'OappController@checkin')->name('checkin');
Route::get('/statusq', 'OappController@statusq')->name('statusq');
Route::get('/oappman', 'OappController@oappman')->name('oappman');
Route::get('/oappconfirm', 'OappController@oappconfirm')->name('oappconfirm');

Route::get('checkup', 'CheckupController@index')->name('checkup');

Route::get('appointment', 'AppointmentController@index')->name('appointment');
Route::get('appointment/calendar', 'AppointmentController@calendar')->name('appcalendar');
Route::get('appointment/calendar/time', 'AppointmentController@time')->name('apptime');
Route::post('appointment/calendar/time/quecc', 'AppointmentController@quecc')->name('appquecc');
Route::post('appointment/store', 'AppointmentController@store')->name('store');
Route::get('appointment/appman', 'AppointmentController@appman')->name('appman');
Route::get('appointment/appconfirm', 'AppointmentController@appconfirm')->name('appconfirm');
