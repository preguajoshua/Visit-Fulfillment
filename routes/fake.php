<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Fakes\AxxessCareApiController;

/*
|--------------------------------------------------------------------------
| Fake API Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('fake')->group(function() {

    // Fake AxxessCARE API
    Route::prefix('axxesscare')->group(function() {

        Route::get('visits', [AxxessCareApiController::class, 'visits']);
        Route::get('visits/{id}', [AxxessCareApiController::class, 'visit']);
        Route::get('visits/{id}/clinicians', [AxxessCareApiController::class, 'clinicians']);

        Route::get('clinicians/{id}/jobs', [AxxessCareApiController::class, 'jobs']);

        // ...
    });
});
