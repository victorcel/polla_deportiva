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

use App\User;
use Carbon\Carbon;

Route::get('/', function () {
    $equipos = DB::table('pollas')->select(array(DB::raw('id'), DB::raw('(select pais from equipos where id=equipo_1) as equipo_1'), DB::raw('(select bandera from equipos where id=equipo_1) as bandera_1'), DB::raw('(select pais from equipos where id=equipo_2) as equipo_2'), DB::raw('(select bandera from equipos where id=equipo_2) as bandera_2')))->simplePaginate(1);
    // dd($equipos);
//select (select pais from equipos where id=equipo_1) as equipo_1,(select bandera from equipos where id=equipo_1) as bandera_1, (select pais from equipos where id=equipo_2) as equipo_2,(select bandera from equipos where id=equipo_2) as bandera_2 from pollas
    return view('welcome', compact('equipos'))->with('info', 'Llego');
})->name('index')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('anotar', 'AnotarController');

Route::get('consulta', function () {
    $now = new \DateTime();
    // dd($now->format('Y'));
    // DB::select(' ALTER TABLE users DROP INDEX email');
    $consultas = DB::connection('sqlsrv')->select("select top 100 '%2862'+CAST( tPlayerCard .Acct  AS VARCHAR(10))+'?' as PlayerId,tPlayerIdentType .PlayerIdentity , tPlayerCard .Acct ,tPlayer.FirstName ,tPlayer.LastName
                    from tPlayer ,tPlayerCard ,tPlayerIdentType
                    where tPlayer .PlayerId = tPlayerCard .PlayerId and
                    tPlayer .PlayerId = tPlayerIdentType .PlayerId and tPlayerCard .Acct >= 100013867 and tPlayer.FirstName not like '/' and YEAR(tPlayer.CreatedDtm)=" . $now->format('Y') . ' and month(tPlayer.CreatedDtm)=' . $now->format('m') . "
                    --and tPlayerCard .Acct = '100092730'");
    $cont = 0;
    foreach ($consultas as $consulta) {
        $cont = $cont + 1;
        $user = new User;
        $user->email = $consulta->PlayerId;
        $user->name = $consulta->FirstName;
        $user->last_name = $consulta->LastName;
        $user->password = bcrypt($consulta->PlayerIdentity);
        $user->username = $consulta->Acct;
        $user->save();
    }

});

Route::get('sql', function () {
    //100039350
    $consultas = DB::connection('sqlsrv')->select("declare @res int
set @res=(select tPlayer.PlayerId from tPlayer ,tPlayerCard ,tPlayerIdentType where tPlayer.PlayerId = tPlayerCard.PlayerId and tPlayer .PlayerId = tPlayerIdentType .PlayerId and tPlayerCard .Acct=100021942)
exec spGetAwardActivityHourPoints @CasinoID = N'1',@PlayerID =@res,@AccumulatorPeriod = N'H',@ShowAvgBetTime = 0,@ShowByDepartment = 1,@DebugLevel = 0,@IsTierPoint = 0;");
    // dd($consultas);

$sumaPunto=0;
    foreach ($consultas as $consulta) {
    $date = new DateTime();
    date_modify($date, '-1 day');
        $fecha= new DateTime($consulta->Period);
       if ($fecha->format('Y-m-d H')>=$date->format('Y-m-d H')){
           $sumaPunto+= $consulta->Base;
       }
    }
    echo "\n" . $sumaPunto;
})->name('sqlsrv');
