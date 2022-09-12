<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\ApiAuthMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pruebas/{nombre?}', function($nombre = null){
    $texto = '<h2>Texto desde la ruta</h2>';
    $texto .= 'Nombre '.$nombre;
    
    return view('pruebas', array(
        'texto' => $texto
    ));
});

//Route::get('/test-orm', 'App\Http\Controllers\PruebasController@testOrm');

//Rutas de api
//
//Rutas del controlador de usuario
    Route::post('/api/register', 'App\Http\Controllers\UserController@register');
    Route::post('/api/login', 'App\Http\Controllers\UserController@login');
    Route::put('/api/user/update', 'App\Http\Controllers\UserController@update');
    Route::post('/api/user/upload', 'App\Http\Controllers\UserController@upload')->middleware(ApiAuthMiddleware::class);
    Route::get('/api/user/avatar/{filename}', 'App\Http\Controllers\UserController@getImage');
    Route::get('/api/user/detail/{id}', 'App\Http\Controllers\UserController@detail');
    
//Rutas del controlador tipo de vehiculo
    Route::resource('/api/tipoDeVehiculo', 'App\Http\Controllers\TipoDeVehiculoController');
//Rutas del controlador marca
    Route::resource('/api/marca', 'App\Http\Controllers\MarcaController');
//Rutas del controlador serviciosgetTurnoByDate 
    Route::resource('/api/servicios', 'App\Http\Controllers\ServiciosController');
//Rutas del controlador modelo
    Route::resource('/api/modelo', 'App\Http\Controllers\ModeloController');
    Route::get('/api/modelo/marca/{id}', 'App\Http\Controllers\ModeloController@getModeloByMarca');
//Rutas del controlador vehiculo
    Route::resource('/api/vehiculo', 'App\Http\Controllers\VehiculoController');
    Route::get('/api/vehiculo/user/{id}', 'App\Http\Controllers\VehiculoController@getVehiculoByUser');    
//Rutas del controlador turno
    Route::resource('/api/turno', 'App\Http\Controllers\TurnoController');
    Route::get('/api/turno/user/{id}', 'App\Http\Controllers\TurnoController@getTurnoByUser');
    Route::get('/api/turno/date/{fecha}', 'App\Http\Controllers\TurnoController@getTurnoByDate');
    Route::delete('/api/turno/admin/{id}', 'App\Http\Controllers\TurnoController@destroyAdmin');    
    //Route::get('/api/turno/user/date/{fecha}', 'App\Http\Controllers\TurnoController@getTurnoByUserByDate');