<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Controllers\Subscriptions\SubscriptionController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionController as AccountSubscriptionController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionCancelController as AccountSubscriptionCancelController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionResumeController as AccountSubscriptionResumeController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionSwapController as AccountSubscriptionSwapController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionInvoiceController as AccountSubscriptionInvoiceController;
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


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/plans', [PlanController::class, 'index'])->name('subscriptions.plans');


    Route::middleware(['not.subscribed'])->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'index'])->name('account');

        Route::group(['prefix' => 'subscriptions'], function () {
            /* AccountSubscriptionController…上のuseのとこ参照 */
            Route::get('/', [AccountSubscriptionController::class, 'index'])->name('account.subscriptions');

            Route::middleware(['subscribed'])->group(function () {
                Route::get('/cancel', [AccountSubscriptionCancelController::class, 'index'])->name('account.subscriptions.cancel');
                Route::post('/cancel', [AccountSubscriptionCancelController::class, 'store']);

                Route::get('/resume', [AccountSubscriptionResumeController::class, 'index'])->name('account.subscriptions.resume');
                Route::post('/resume', [AccountSubscriptionResumeController::class, 'store']);
            });

            Route::get('/swap', [AccountSubscriptionSwapController::class, 'index'])->name('account.subscriptions.swap');
            Route::post('/swap', [AccountSubscriptionSwapController::class, 'store']);

            Route::get('/invoices', [AccountSubscriptionInvoiceController::class, 'index'])->name('account.subscriptions.invoices');
            Route::get('/invoices/{id}', [AccountSubscriptionInvoiceController::class, 'show'])->name('account.subscriptions.invoice');
        });
    });

});

require __DIR__ . '/auth.php';
