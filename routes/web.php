<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ClinicianController;
use App\Http\Controllers\AgencyController;

// Authentication Routes
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('splash');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::prefix('visits')->group(function () {
        Route::get('/', [VisitController::class, 'index'])->name('visits.index');
        Route::get('{id}', [VisitController::class, 'show'])->name('visits.show');
    });

    Route::prefix('clinicians')->group(function () {
        Route::get('/', [ClinicianController::class, 'index'])->name('clinicians.index');
        Route::get('{clinician}', [ClinicianController::class, 'show'])->name('clinicians.show');
    });

    Route::prefix('agency')->group(function () {
        Route::get('/', [AgencyController::class, 'index'])->name('agency.index');
        Route::get('/{agency}', [AgencyController::class, 'show'])->name('agency.show');
    });
    // ...
});
