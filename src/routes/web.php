<?php

use Illuminate\Support\Facades\Route;
use ZakirJarir\LaravelInstaller\Http\Controllers\InstallerController;

// Route

Route::group(['prefix' => 'install', 'middleware' => ['web']], function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('installer.welcome');
    Route::get('/requirements', [InstallerController::class, 'requirements'])->name('installer.requirements');
    Route::get('/environment', [InstallerController::class, 'environment'])->name('installer.environment');
    Route::post('/environment/save', [InstallerController::class, 'saveEnvironment'])->name('installer.saveEnvironment');
    Route::get('/database', [InstallerController::class, 'database'])->name('installer.database');
    Route::post('/database/install', [InstallerController::class, 'runInstallation'])->name('installer.runInstallation');
    Route::get('/finish', [InstallerController::class, 'finish'])->name('installer.finish');
});
