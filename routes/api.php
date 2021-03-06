<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//provincia
 Route::get('/provincia','provinceController@listar');
 Route::get('/provincia/{id}','provinceController@detalhes');
//municipio
 Route::get('/municipio','municipioController@listarTodosMunicipios');
 
 Route::middleware('apiKey')->group(function () {
     //provincia
    Route::post('/provincia','provinceController@addProvincia');
    Route::put('/provincia','provinceController@editProvincia');
    //Municipio
    Route::post('/municipio','municipioController@addMunicipio');
    Route::put('/municipio','municipioController@editMunicipio');
    //Comuna
    Route::post('/comuna','comunaController@addComuna');
});