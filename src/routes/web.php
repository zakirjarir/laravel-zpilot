<?php

use Illuminate\Support\Facades\Route;
use ZakirJarir\LaravelInstaller\Http\Controllers\InstallerController;

Route::group(['prefix' => 'install', 'middleware' => ['web']], function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('installer.welcome');
    Route::get('/requirements', [InstallerController::class, 'requirements'])->name('installer.requirements');
    Route::get('/environment', [InstallerController::class, 'environment'])->name('installer.environment');
    Route::post('/environment/save', [InstallerController::class, 'saveEnvironment'])->name('installer.saveEnvironment');
    Route::get('/database', [InstallerController::class, 'database'])->name('installer.database');
    Route::post('/database/migrate', [InstallerController::class, 'runMigrations'])->name('installer.runMigrations');
    Route::get('/seeder', [InstallerController::class, 'seeder'])->name('installer.seeder');
    Route::post('/seeder/run', [InstallerController::class, 'runSeeders'])->name('installer.runSeeders');
    Route::get('/finish', [InstallerController::class, 'finish'])->name('installer.finish');
});
