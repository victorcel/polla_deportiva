<?php

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

Route::get('/', function () {
    $equipos= DB::table('pollas')->select(array(DB::raw('id'),DB::raw('(select pais from equipos where id=equipo_1) as equipo_1'),DB::raw('(select bandera from equipos where id=equipo_1) as bandera_1'),DB::raw('(select pais from equipos where id=equipo_2) as equipo_2'),DB::raw('(select bandera from equipos where id=equipo_2) as bandera_2')))->simplePaginate(1);
   // dd($equipos);
//select (select pais from equipos where id=equipo_1) as equipo_1,(select bandera from equipos where id=equipo_1) as bandera_1, (select pais from equipos where id=equipo_2) as equipo_2,(select bandera from equipos where id=equipo_2) as bandera_2 from pollas
    return view('welcome',compact('equipos'));
})->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('anotar', 'AnotarController');
