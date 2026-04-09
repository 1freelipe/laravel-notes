<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Hello World!';
});

// Fazendo uma rota se comunicar com um controller
Route::get('/main/{value}', [MainController::class, 'index']);
