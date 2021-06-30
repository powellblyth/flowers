<?php

use App\Http\Controllers\EntrantController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\MembershipPurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\CupController;
use App\Http\Controllers\SectionController;

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
})->name('home');

Route::resource('categories', CategoryController::class)->only(['index','show']);

//Route::resource('categories', 'CategoryController');
Route::get('/sections/forwebsite', [SectionController::class, 'forwebsite'])->name('section.forwebsite');

Route::resource('membershippurchases', MembershipPurchaseController::class);
Route::get('/cups', [CupController::class, 'index'])
    ->name('cups.index');
Route::get('/cups/printableresults', [CupController::class, 'printableresults'])
    ->name('cup.printableresults');
Route::get('/cups/{id}', [CupController::class, 'name'])->name('cups.show');


Route::group(['middleware' => 'is_admin'], function () {

    Route::post('/cups/{id}/directresultpick', [CupController::class, 'directResultPick'])
        ->name('cup.directResultPick');
    Route::post('/cups/{id}/directresultsetwinner', [CupController::class, 'directResultSetWinner'])
        ->name('cup.directResultSetWinner');

    Route::post('/categories/storeresults', [CategoryController::class, 'storeresults'])
        ->name('categories.storeresults');
    Route::get('/categories/resultsentry', [CategoryController::class, 'resultsentry'])
        ->name('category.resultsentry');
    Route::get('/categories/printtabletop', [CategoryController::class, 'printcards'])
        ->name('category.tabletopprint');
    Route::get('/categories/printlookup', [CategoryController::class, 'printlookups'])
        ->name('category.lookupprint');
    Route::get('/entries/printall', [EntryController::class, 'printallcards'])
        ->name('entries.printall');

    Route::get('/users/{id}/print', [UserController::class, 'printcards'])
        ->name('user.print');
});


Route::resource('teams', TeamsController::class);
Route::resource('shows', ShowsController::class);

require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::post('/entry/creates', [EntryController::class, 'creates'])->name('entry.creates');
//    Route::get('/entrants/{entrant}/edit', [EntrantController::class, 'edit'])->name('entrants.edit');

    Route::resource('entrants', EntrantController::class);
//    Route::get('/entrants/{entrant}', [EntrantController::class, 'show'])->name('entrants.show');
//    Route::get('/entrants/create', [EntrantController::class, 'create'])->name('entrants.create');
//    Route::post('/entrants', [EntrantController::class, 'store'])->name('users.entrants.store');

    Route::resource('users', UserController::class)->except(['index']);

//    Route::post('/entrants/{entrant}/update', [EntrantController::class, 'update'])
//        ->name('entrants.update');
    Route::post('/entrants/{id}/optins', [EntrantController::class, 'optins'])
        ->name('entrants.optins');

    Route::get('/users/{user}/{show?}', [UserController::class, 'show'])->name('users.showfiltered');
    Route::get('/entries', [EntryController::class, 'entryCard'])->name('entries.entryCard');
    Route::post('/entries', [EntryController::class, 'update'])->name('entries.store');

    Route::get('/family', [UserController::class, 'show'])->name('family');

    Route::get('/profile/subscribe', [ProfileController::class, 'subscribe'])
        ->name('users.subscribe');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});


Route::post(
    'stripe/webhook',
    [WebhookController::class, 'handleWebhook']
);
//Route::post(
//    'stripe/webhook',
//    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
//);
