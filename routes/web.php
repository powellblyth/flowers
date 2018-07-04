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
    return view('welcome');
});
Route::post('/categories/storeresults', 
        ['as' => 'categories.storeresults',
    'uses' => 'CategoryController@storeresults']);
Route::get('/categories/resultsentry', 
        ['as' => 'category.resultsentry',
    'uses' => 'CategoryController@resultsentry']);

Route::resource('categories', 'CategoryController');
Route::resource('membershippurchases', 'MembershipPurchaseController');
Route::resource('cups', 'CupController');

//Route::post('/taps/{id}/connectToSensor', 
//        ['as' => 'taps.connectToSensor',
//    'uses' => 'TapsController@connectToSensor'])->middleware('auth');

Route::post('/cups/{id}/directresultpick', 
    ['as' => 'cup.directResultPick',
    'uses' => 'CupController@directResultPick']);
Route::post('/cups/{id}/directresultsetwinner', 
    ['as' => 'cup.directResultSetWinner',
    'uses' => 'CupController@directResultSetWinner']);
Route::post('/cups/{id}/directResultSetWinnerPerson', 
    ['as' => 'cup.directResultSetWinnerPerson',
    'uses' => 'CupController@directResultSetWinnerPerson']);

Route::resource('payments', 'PaymentController');

Route::get('/entrants/search', 
        ['as' => 'entrants.search',
    'uses' => 'EntrantController@search']);
Route::post('/entry/creates', 
        ['as' => 'entry.creates',
    'uses' => 'EntryController@creates']);
Route::get('/entrants/{id}/print', 
        ['as' => 'entrant.print',
    'uses' => 'EntrantController@printcards']);
Route::resource('entrants', 'EntrantController');

Route::post('/entrants/{id}/update', 
        ['as' => 'entrants.update',
    'uses' => 'EntrantController@update']);
Route::post('/entrants/{id}/optins', 
        ['as' => 'entrants.optins',
    'uses' => 'EntrantController@optins']);
