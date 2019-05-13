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
    'uses' => 'CategoryController@storeresults'])->middleware('auth');;
Route::get('/categories/resultsentry', 
        ['as' => 'category.resultsentry',
    'uses' => 'CategoryController@resultsentry'])->middleware('auth');;

Route::resource('categories', 'CategoryController');
Route::resource('membershippurchases', 'MembershipPurchaseController');
Route::resource('cups', 'CupController')->middleware('auth');;

//Route::post('/taps/{id}/connectToSensor', 
//        ['as' => 'taps.connectToSensor',
//    'uses' => 'TapsController@connectToSensor'])->middleware('auth');

Route::post('/cups/{id}/directresultpick', 
    ['as' => 'cup.directResultPick',
    'uses' => 'CupController@directResultPick'])->middleware('auth');;
Route::post('/cups/{id}/directresultsetwinner', 
    ['as' => 'cup.directResultSetWinner',
    'uses' => 'CupController@directResultSetWinner'])->middleware('auth');;
Route::post('/cups/{id}/directResultSetWinnerPerson', 
    ['as' => 'cup.directResultSetWinnerPerson',
    'uses' => 'CupController@directResultSetWinnerPerson'])->middleware('auth');;

Route::resource('payments', 'PaymentController')->middleware('auth');;

Route::get('/entrants/search', 
        ['as' => 'entrants.search',
    'uses' => 'EntrantController@search'])->middleware('auth');;
Route::get('/entrants/{id}/changecategories', 
        ['as' => 'entrants.changecategories',
    'uses' => 'EntrantController@changeCategories'])->middleware('auth');;
Route::post('/entrants/{id}/changecategories', 
        ['as' => 'entrants.storechangecategories',
    'uses' => 'EntrantController@changeCategories'])->middleware('auth');;
Route::post('/entry/creates', 
        ['as' => 'entry.creates',
    'uses' => 'EntryController@creates'])->middleware('auth');;
Route::get('/entrants/{id}/print', 
        ['as' => 'entrant.print',
    'uses' => 'EntrantController@printcards'])->middleware('auth');;
Route::resource('entrants', 'EntrantController')->middleware('auth');;

Route::post('/entrants/{id}/update', 
        ['as' => 'entrants.update',
    'uses' => 'EntrantController@update'])->middleware('auth');;
Route::post('/entrants/{id}/optins', 
        ['as' => 'entrants.optins',
    'uses' => 'EntrantController@optins'])->middleware('auth');;

Route::get('/reports/', 
        ['as' => 'reports.index',
    'uses' => 'ReportsController@index'])->middleware('auth');;
Route::get('/reports/members', 
        ['as' => 'reports.members',
    'uses' => 'ReportsController@membershipReport'])->middleware('auth');;
Route::get('/reports/entries', 
        ['as' => 'reports.entries',
    'uses' => 'ReportsController@entriesReport'])->middleware('auth');;
Route::get('/reports/unplacedCategories', 
        ['as' => 'reports.categories',
    'uses' => 'ReportsController@unplacedcategoriesReport'])->middleware('auth');;
