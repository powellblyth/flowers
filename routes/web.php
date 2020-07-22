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

use Illuminate\Support\Facades\Route;

Auth::routes();

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

Route::group(['middleware' => 'auth'], function () {
    Route::post(
        '/cups/{id}/directResultSetWinnerPerson',
        ['as' => 'cup.directResultSetWinnerPerson', 'uses' => 'CupController@directResultSetWinnerPerson']
    );

    Route::resource('payments', 'PaymentController');

    Route::get('/entrants/search', ['as' => 'entrants.search', 'uses' => 'EntrantController@search']);
    Route::post('/entrants/store', ['as' => 'entrants.store', 'uses' => 'EntrantController@store']);
    Route::get('/entrants', ['as' => 'entrants.index', 'uses' => 'EntrantController@index']);
    Route::get('/entrants/create', ['as' => 'entrants.create', 'uses' => 'EntrantController@create']);
});

Route::group(['middleware' => 'is_admin'], function () {

    Route::get('/entrants/searchall', ['as' => 'entrants.searchall', 'uses' => 'EntrantController@searchall']);
    Route::get('/entrants/{id}/changecategories',
        ['as' => 'entrants.changecategories', 'uses' => 'EntrantController@changeCategories'])->middleware('auth');
    Route::post('/entrants/{id}/changecategories',
        ['as' => 'entrants.storechangecategories', 'uses' => 'EntrantController@changeCategories'])->middleware('auth');
    Route::get('/entrants/{id}/print', ['as' => 'entrant.print', 'uses' => 'EntrantController@printcards']);
});
//Route::post('/teams/creates', ['as' => 'teams.creates', 'uses' => 'tEAMAController@creates'])->middleware('auth');
//Route::get('/teams', ['as' => 'teams.index', 'uses' => 'TeamsController@index']);

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


Route::get('/reports/', ['as' => 'reports.index', 'uses' => 'ReportsController@index'])->middleware('auth')->middleware('is_admin');
Route::get('/reports/members', ['as' => 'reports.members', 'uses' => 'ReportsController@membershipReport'])->middleware('is_admin');
Route::get('/reports/entries', ['as' => 'reports.entries', 'uses' => 'ReportsController@entriesReport'])->middleware('is_admin');
Route::get('/reports/unplacedCategories',
    ['as' => 'reports.categories', 'uses' => 'ReportsController@unplacedcategoriesReport'])->middleware('is_admin');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

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