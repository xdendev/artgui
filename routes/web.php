<?php

use Illuminate\Support\Facades\Route;
use Xden\ArtGui\Http\Controllers\ArtGuiController;

Route::middleware(config('artgui.middlewares', ['web']))
    ->prefix(config('artgui.prefix', 'artgui'))
    ->group(function () {
        Route::get('', [ArtGuiController::class, 'index'])->name('artgui.index');
        Route::post('{command}', [ArtGuiController::class, 'run'])
            ->where('command', '[a-z0-9:_-]+')
            ->name('artgui.run');
    });
