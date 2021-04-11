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
    return view('welcome', ['isLocked' => config('app.state') == 'locked']);
});
Route::group(['middleware' => 'is_admin'], function () {
    Route::post('/categories/storeresults', ['as' => 'categories.storeresults', 'uses' => 'CategoryController@storeresults']);
    Route::get('/categories/resultsentry', ['as' => 'category.resultsentry', 'uses' => 'CategoryController@resultsentry']);
    Route::get('/categories/printtabletop', ['as' => 'category.tabletopprint', 'uses' => 'CategoryController@printcards']);
    Route::get('/categories/printlookup',
        ['as'   => 'category.lookupprint',
         'uses' => 'CategoryController@printlookups'])->middleware('is_admin');
});
Route::get('/categories', ['as' => 'category.index', 'uses' => 'CategoryController@resultsentry']);
Route::get('/sections/forwebsite', ['as' => 'section.forwebsite', 'uses' => 'SectionController@forwebsite']);

Route::resource('categories', 'CategoryController');


Route::resource('membershippurchases', 'MembershipPurchaseController');
//Route::resource('cups', 'CupController')->middleware('auth');
Route::get('/cups', ['as' => 'cups.index', 'uses' => 'CupController@index']);
Route::get('/cups/printableresults', ['as' => 'cup.printableresults', 'uses' => 'CupController@printableresults']);

Route::get('/cups/{id}', ['as' => 'cups.show', 'uses' => 'CupController@show']);
//Route::resource('cups', 'CupController');

//Route::post('/taps/{id}/connectToSensor', 
//        ['as' => 'taps.connectToSensor',
//    'uses' => 'TapsController@connectToSensor'])->middleware('auth');
Route::group(['middleware' => 'is_admin'], function () {

    Route::post('/cups/{id}/directresultpick', ['as' => 'cup.directResultPick', 'uses' => 'CupController@directResultPick']);
    Route::post(
        '/cups/{id}/directresultsetwinner',
        ['as'   => 'cup.directResultSetWinner',
         'uses' => 'CupController@directResultSetWinner']
    );
});

Route::group(['middleware' => 'is_admin'], function () {
    Route::post('/categories/storeresults', ['as' => 'categories.storeresults', 'uses' => 'CategoryController@storeresults']);
    Route::get('/categories/resultsentry', ['as' => 'category.resultsentry', 'uses' => 'CategoryController@resultsentry']);
    Route::get('/categories/printtabletop', ['as' => 'category.tabletopprint', 'uses' => 'CategoryController@printcards']);
    Route::get('/categories/printlookup',
        ['as'   => 'category.lookupprint',
         'uses' => 'CategoryController@printlookups'])->middleware('is_admin');
});
Route::get('/categories', ['as' => 'category.index', 'uses' => 'CategoryController@resultsentry']);
Route::get('/sections/forwebsite', ['as' => 'section.forwebsite', 'uses' => 'SectionController@forwebsite']);

Route::resource('categories', 'CategoryController');


Route::resource('membershippurchases', 'MembershipPurchaseController');
//Route::resource('cups', 'CupController')->middleware('auth');
Route::get('/cups', ['as' => 'cups.index', 'uses' => 'CupController@index']);
Route::get('/cups/printableresults', ['as' => 'cup.printableresults', 'uses' => 'CupController@printableresults']);

Route::get('/cups/{id}', ['as' => 'cups.show', 'uses' => 'CupController@show']);
//Route::resource('cups', 'CupController');

//Route::post('/taps/{id}/connectToSensor',
//        ['as' => 'taps.connectToSensor',
//    'uses' => 'TapsController@connectToSensor'])->middleware('auth');
Route::group(['middleware' => 'is_admin'], function () {

    Route::post('/cups/{id}/directresultpick', ['as' => 'cup.directResultPick', 'uses' => 'CupController@directResultPick']);
    Route::post(
        '/cups/{id}/directresultsetwinner',
        ['as' => 'cup.directResultSetWinner',
         'uses' => 'CupController@directResultSetWinner']
    );
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('teams', 'TeamsController');
Route::resource('shows', 'ShowsController');
Route::resource('memberships', 'MembershipsController');
Route::get('/shows/{show}/duplicate',['as'=>'shows.duplicate', 'uses'=>'ShowsController@duplicate']);

Route::post('/entry/creates', ['as' => 'entry.creates', 'uses' => 'EntryController@creates'])->middleware('auth');
Route::get('/entrants/{entrant}/edit', ['as' => 'entrants.edit', 'uses' => 'EntrantController@edit'])->middleware('auth');
Route::get('/entrants/{entrant}', ['as' => 'entrants.show', 'uses' => 'EntrantController@show'])->middleware('auth');
Route::get('/users/{user}/entrants/create', ['as' => 'users.createentrant', 'uses' => 'EntrantController@create'])->middleware('auth');
//Route::resource('entrants', 'EntrantController')->create('auth');

Route::post('/entrants/{entrant}/update', ['as' => 'entrants.update', 'uses' => 'EntrantController@update'])->middleware('auth');
Route::post('/entrants/{id}/optins',
    ['as' => 'entrants.optins', 'uses' => 'EntrantController@optins'])->middleware('auth');

Route::resource('users', 'UserController');
Route::get('/users/{user}/{show?}', ['as' => 'users.showfiltered', 'uses' => 'UserController@show']);
Route::get('/users', ['as' => 'users.index', 'uses' => 'UserController@index'])->middleware('is_admin');
//Route::get('/users/new', ['as' => 'users.create', 'uses' => 'UserController@create'])->middleware('is_admin');
Route::delete('/users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@delete'])->middleware('is_admin');

Route::get('/users/{id}/print', ['as' => 'user.print', 'uses' => 'UserController@printcards'])->middleware('is_admin');
Route::get('/family', ['as' => 'home', 'uses' => 'UserController@show'])->middleware('auth');


Route::get('/users/{user}/edit', ['as' => 'user.edit', 'uses' => 'UserController@edit'])->middleware('is_admin');

Route::get('/entries/printall', ['as' => 'entries.printall', 'uses' => 'EntryController@printallcards'])->middleware('is_admin');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//Route::get('')
Route::group(['middleware' => 'auth'], function () {
//    Route::resource('user', 'UserController', ['except' => ['show', 'edit']]);
    Route::get('/profile/subscribe',
        ['as'   => 'users.subscribe',
         'uses' => 'ProfileController@subscribe']
    );
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);
Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
