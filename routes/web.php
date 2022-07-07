<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Controllers\Subscriptions\SubscriptionController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionController as AccountSubscriptionController;
use App\Http\Controllers\Account\Subscriptions\SubscriptionCancelController as AccountSubscriptionCancelController;
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
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'index'])->name('account');

        Route::group(['prefix' => 'subscriptions'], function () {
            /* AccountSubscriptionController…上のuseのとこ参照 */
            Route::get('/', [AccountSubscriptionController::class, 'index'])->name('account.subscriptions');
            Route::get('/cancel', [AccountSubscriptionCancelController::class, 'index'])->name('account.subscriptions.cancel');
            Route::post('/cancel', [AccountSubscriptionCancelController::class, 'store']);
        });
    });
});

require __DIR__ . '/auth.php';
