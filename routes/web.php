<?php

use App\Http\Controllers\Backoffice\RuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('Layouts.Base');
});

Route::get('/rules', [RuleController::class, 'index'])->name('rule.index');