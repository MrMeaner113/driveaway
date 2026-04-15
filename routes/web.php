<?php

use App\Http\Controllers\QuoteRequestController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('quote-request')->name('quote-request.')->group(function () {
    Route::get('/', [QuoteRequestController::class, 'create'])->name('create');
    Route::post('/', [QuoteRequestController::class, 'store'])->name('store');
    Route::get('/confirmation', fn () => view('quote-request-confirmation'))->name('confirmation');
    Route::get('/provinces/{country}', [QuoteRequestController::class, 'provinces'])->name('provinces');
    Route::get('/cities/{province}', [QuoteRequestController::class, 'cities'])->name('cities');
    Route::get('/vehicle-models', [QuoteRequestController::class, 'vehicleModels'])->name('vehicle-models');
});

Route::get('/pending-approval', function () {
    return view('pending-approval');
})->middleware('auth')->name('pending.approval');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
