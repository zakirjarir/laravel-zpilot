<?php

use Illuminate\Support\Facades\Route;
use ZakirJarir\LaravelZPilot\Http\Controllers\ZPilotController;




Route::group(['prefix' => 'install', 'middleware' => ['web']], function () {
    Route::get('/', [ZPilotController::class, 'welcome'])->name('zpilot.welcome');
    Route::get('/requirements', [ZPilotController::class, 'requirements'])->name('zpilot.requirements');
    Route::get('/environment', [ZPilotController::class, 'environment'])->name('zpilot.environment');
    Route::post('/environment/save', [ZPilotController::class, 'saveEnvironment'])->name('zpilot.saveEnvironment');
    Route::get('/database', [ZPilotController::class, 'database'])->name('zpilot.database');
    Route::post('/database/install', [ZPilotController::class, 'runInstallation'])->name('zpilot.runInstallation');
    Route::get('/finish', [ZPilotController::class, 'finish'])->name('zpilot.finish');
});
