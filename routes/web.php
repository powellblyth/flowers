<?php

use App\Http\Controllers\EntrantController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\MembershipPurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\ShowController;
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
    return view('welcome_2023');
})->name('home');

Route::resource('categories', CategoryController::class)->only(['index']);

//Route::resource('categories', 'CategoryController');
Route::get('/sections/forwebsite', [SectionController::class, 'forwebsite'])->name('section.forwebsite');

Route::get('/cupsadmin', [CupController::class, 'adminindex'])
    ->name('cups.adminindex');

Route::resource('membershippurchases', MembershipPurchaseController::class);


Route::controller(RaffleController::class)
    ->group(function () {
        Route::get('/raffle/', 'index')
        ->name('raffle.index');
        Route::get('/shows/{show}/raffle', 'forShow')
        ->name('show.raffle');
    });

Route::get('/cups', [CupController::class, 'index'])
    ->name('cups.index');
Route::get('/shows/{show}/cups', [CupController::class, 'forShow'])
    ->name('show.cups');
Route::get('/shows/{show}/categories', [CategoryController::class, 'forShow'])
    ->name('show.categories');
Route::get('/cupCategories', [CupController::class, 'categories'])
    ->name('cups.categories');
Route::get('/cups/printableresults', [CupController::class, 'printableresults'])
    ->name('cup.printableresults');
Route::get('/cups/{cup}', [CupController::class, 'showold'])->name('cups.showold');
Route::get('/shows/{show}/cups/{cup}', [CupController::class, 'show'])->name('cups.show');


Route::group(['middleware' => ['is_admin', 'auth']], function () {

//        Route::post('/cups/{id}/directresultpick', [CupController::class, 'directResultPick'])
//        ->name('cup.directResultPick');
    Route::post('/cups/{cup}/directResultSetWinner', [CupController::class, 'directResultSetWinner'])
        ->name('cup.directResultSetWinner');

    Route::post('/sections/{section}/storeresults', [SectionController::class, 'storeresults'])
        ->name('sections.storeresults');
    Route::get('/sections/{section}/resultsentry', [SectionController::class, 'resultsEntryForm'])
        ->name('sections.resultsentry');
    Route::get('/categories/printtabletop', [CategoryController::class, 'printcards'])
        ->name('category.tabletopprint');
    Route::get('/categories/printlookup', [CategoryController::class, 'printlookups'])
        ->name('category.lookupprint');
    Route::get('/entries/printall', [EntryController::class, 'printallcards'])
        ->name('entries.printall');
    Route::get('/judges/printSheets', [\App\Http\Controllers\JudgeController::class, 'printSheets'])
        ->name('judges.printSheets');

    Route::get('/users/{id}/print', [UserController::class, 'printcards'])
        ->name('user.print');
});


Route::resource('teams', TeamsController::class);
Route::resource('shows', ShowController::class);

require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::post('/entry/creates', [EntryController::class, 'creates'])->name('entry.creates');
//    Route::get('/entrants/{entrant}/edit', [EntrantController::class, 'edit'])->name('entrants.edit');


    Route::resource('users', UserController::class)->except(['index','update']);

//    Route::post('/entrants/{entrant}/update', [EntrantController::class, 'update'])
//        ->name('entrants.update');
    Route::post('/entrants/{id}/optins', [EntrantController::class, 'optins'])
        ->name('entrants.optins');

    Route::resource('entrants', EntrantController::class)->except(['showen']);


    Route::get('/users/{user}/{show?}', [UserController::class, 'show'])->name('users.showfiltered');

    Route::controller(EntryController::class)
        ->group(function () {
            Route::get('/entries', 'entryCard')->name('entries.entryCard');
            Route::post('/entries', 'update')->name('entries.store');
        });
    Route::get('/family', [UserController::class, 'show'])->name('family');

    Route::get('/profile/subscribe', [ProfileController::class, 'subscribe'])
        ->name('users.subscribe');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::resource('subscriptions', \App\Http\Controllers\SubscriptionController::class);
    Route::resource('paymentcards', \App\Http\Controllers\PaymentCardsController::class);
//    Route::put('profile', [ProfileController::class, 'password'])->name('profile.password');
});
Route::get('/shows/me/status', [ShowController::class, 'statusReport'])->name('shows.status');

Route::controller(\App\Http\Controllers\MarketingController::class)
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/pricing', 'pricing')
            ->name('marketing.pricing');
        Route::get('/membership', 'membership')
            ->name('marketing.membership');
    });

Route::get('sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');


Route::post(
    'stripe/webhook',
    [WebhookController::class, 'handleWebhook']
);
//Route::post(
//    'stripe/webhook',
//    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
//);
