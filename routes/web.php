<?php

use App\Http\Controllers\Backoffice\PositionController;
use App\Http\Controllers\Backoffice\RuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('Layouts.Base');
});

Route::get('/rules', [RuleController::class, 'index'])->name('rule.index');
Route::get('/position', [PositionController::class, 'index'])->name('position.index');