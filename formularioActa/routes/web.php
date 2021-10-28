<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActaController;

Route::post("/guardar","App\Http\Controllers\ActaController@guardar");

Route::get('/', function () {
    return view('form');
});
