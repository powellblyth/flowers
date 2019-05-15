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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::post('/categories/storeresults',
    ['as' => 'categories.storeresults',
        'uses' => 'CategoryController@storeresults'])->middleware('is_admin');
Route::get('/categories/resultsentry',
    ['as' => 'category.resultsentry',
        'uses' => 'CategoryController@resultsentry'])->middleware('is_admin');
Route::get('/categories',
    ['as' => 'category.index',
        'uses' => 'CategoryController@resultsentry']);

Route::resource('categories', 'CategoryController');
Route::resource('membershippurchases', 'MembershipPurchaseController');
//Route::resource('cups', 'CupController')->middleware('auth');
Route::get('/cups',
    ['as' => 'cups.index',
        'uses' => 'CupController@index']);
Route::get('/cups/{id}',
    ['as' => 'cups.show',
        'uses' => 'CupController@show']);
//Route::resource('cups', 'CupController');

//Route::post('/taps/{id}/connectToSensor', 
//        ['as' => 'taps.connectToSensor',
//    'uses' => 'TapsController@connectToSensor'])->middleware('auth');

Route::post('/cups/{id}/directresultpick',
    ['as' => 'cup.directResultPick',
        'uses' => 'CupController@directResultPick'])->middleware('is_admin');
Route::post('/cups/{id}/directresultsetwinner',
    ['as' => 'cup.directResultSetWinner',
        'uses' => 'CupController@directResultSetWinner'])->middleware('is_admin');
Route::post('/cups/{id}/directResultSetWinnerPerson',
    ['as' => 'cup.directResultSetWinnerPerson',
        'uses' => 'CupController@directResultSetWinnerPerson'])->middleware('auth');

Route::resource('payments', 'PaymentController')->middleware('auth');

Route::get('/entrants/search',
    ['as' => 'entrants.search',
        'uses' => 'EntrantController@search'])->middleware('auth');
Route::get('/entrants',
    ['as' => 'entrants.index',
        'uses' => 'EntrantController@index'])->middleware('auth');
Route::get('/entrants/searchall',
    ['as' => 'entrants.searchall',
        'uses' => 'EntrantController@searchall'])->middleware('is_admin');
Route::get('/entrants/all',
    ['as' => 'entrants.all',
        'uses' => 'EntrantController@all'])->middleware('is_admin');
Route::get('/entrants/{id}/changecategories',
    ['as' => 'entrants.changecategories',
        'uses' => 'EntrantController@changeCategories'])->middleware('auth')->middleware('is_admin');
Route::post('/entrants/{id}/changecategories',
    ['as' => 'entrants.storechangecategories',
        'uses' => 'EntrantController@changeCategories'])->middleware('auth')->middleware('is_admin');
Route::post('/entry/creates',
    ['as' => 'entry.creates',
        'uses' => 'EntryController@creates'])->middleware('auth');
Route::get('/entrants/{id}/print',
    ['as' => 'entrant.print',
        'uses' => 'EntrantController@printcards'])->middleware('auth');
Route::resource('entrants', 'EntrantController')->middleware('auth');

Route::post('/entrants/{id}/update',
    ['as' => 'entrants.update',
        'uses' => 'EntrantController@update'])->middleware('auth');
Route::post('/entrants/{id}/optins',
    ['as' => 'entrants.optins',
        'uses' => 'EntrantController@optins'])->middleware('auth');

Route::get('/reports/',
    ['as' => 'reports.index',
        'uses' => 'ReportsController@index'])->middleware('is_admin');
Route::get('/reports/members',
    ['as' => 'reports.members',
        'uses' => 'ReportsController@membershipReport'])->middleware('is_admin');
Route::get('/reports/entries',
    ['as' => 'reports.entries',
        'uses' => 'ReportsController@entriesReport'])->middleware('is_admin');
Route::get('/reports/unplacedCategories',
    ['as' => 'reports.categories',
        'uses' => 'ReportsController@unplacedcategoriesReport'])->middleware('is_admin');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

