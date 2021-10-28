<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\archivoVerController;

Route::get("/","App\Http\Controllers\archivoVerController@visualizar");

Route::get('vistaActas', function () {
    return view('vistaActas');
});

Route::post("/visualizarfiltro","App\Http\Controllers\archivoVerController@visualizarFiltro");
Route::post("/Acta/{id}/{busqueda}","App\Http\Controllers\archivoVerController@verActa");
