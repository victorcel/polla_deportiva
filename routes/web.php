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

use App\Reporte;
use App\User;
use Carbon\Carbon;

//100018273
//100142261
Route::get('/', function () {
    $date = new DateTime();
    //dd($date->format('Y-m-d'));
    $sumaPunto = 0;
    $consFecha = DB::select("SELECT * FROM `reportes` WHERE date(created_at) ='" . $date->format('Y-m-d') . "'and user_id=" . Auth::user()->id . " order by created_at desc limit 1");
    // dd($consFecha[0]);
    $consultas = DB::connection('sqlsrv')->select("declare @res int
set @res=(select tPlayer.PlayerId from tPlayer ,tPlayerCard ,tPlayerIdentType where tPlayer.PlayerId = tPlayerCard.PlayerId and tPlayer .PlayerId = tPlayerIdentType .PlayerId and tPlayerCard .Acct=" . Auth::user()->username . ")
exec spGetAwardActivityHourPoints @CasinoID = N'1',@PlayerID =@res,@AccumulatorPeriod = N'H',@ShowAvgBetTime = 0,@ShowByDepartment = 1,@DebugLevel = 0,@IsTierPoint = 0;");
    if (count($consFecha) > 0) {
        //dd($consultas[0]);

        // dd($consultas);
        //Auth::user()->name;
        $consulFecha = new DateTime($consFecha[0]->created_at);
        //dd($consulFecha);

        foreach ($consultas as $consulta) {
            $date = new DateTime();
            //date_modify($date, '-24 hour');
            //dd($date->format('Y-m-d H:i'));
            $fecha = new DateTime($consulta->Period);

            if ($fecha->format('Y-m-d H:i') > $consulFecha->format('Y-m-d H:i')) {
                echo $fecha->format('Y-m-d H:i');
                $sumaPunto += $consulta->Base;
            }
        }
        if ($sumaPunto > 0) {
            $reporte = new Reporte;
            $reporte->puntos = $sumaPunto;
            $reporte->user_id = Auth::user()->id;
            $reporte->save();
        }

    } else {

        //Auth::user()->name;

        foreach ($consultas as $consulta) {
            $date = new DateTime();
            date_modify($date, '-24 hour');
            //dd($date->format('Y-m-d H:i'));
            $fecha = new DateTime($consulta->Period);
            if ($fecha->format('Y-m-d H') >= $date->format('Y-m-d H')) {
                $sumaPunto += $consulta->Base;
            }
        }
        $reporte = new Reporte;
        $reporte->puntos = $sumaPunto;
        $reporte->user_id = Auth::user()->id;
        $reporte->save();

    }
    $puntos = Session::get('puntos');
    $puntos['puntos'] = $consFecha[0]->puntos;
    Session::put('puntos', $puntos);
    $reporte_id = Session::get('reporte_id');
    $reporte_id['reporte_id'] = $consFecha[0]->id;
    Session::put('reporte_id', $reporte_id);
    //dd($ticket);
    $equipos = DB::table('pollas')->select(array(DB::raw('id'), DB::raw('(select pais from equipos where id=equipo_1) as equipo_1'), DB::raw('(select bandera from equipos where id=equipo_1) as bandera_1'), DB::raw('(select pais from equipos where id=equipo_2) as equipo_2'), DB::raw('(select bandera from equipos where id=equipo_2) as bandera_2')))->where('estado', '=', 'Activo')->simplePaginate(1);
    if (count($equipos) > 0) {
        return View('welcome', compact('equipos','consFecha'));//->with('message', $sumaPunto . ' Puntos Participar En Polla Mundialista');
    } else {
        \Auth::logout();
        return \Redirect::route('login')
            ->with('info', 'No hay equipos activo para la Polla Mundialista');
    }

})->name('index')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('anotar', 'AnotarController');

Route::resource('ticket', 'TicketController');
Route::get('ticket.trash', 'TicketController@trash')->name('ticket.trash');
Route::get('ticket.save', 'TicketController@save')->name('ticket.save');
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
    //100018273
    $consultas = DB::connection('sqlsrv')->select("declare @res int
set @res=(select tPlayer.PlayerId from tPlayer ,tPlayerCard ,tPlayerIdentType where tPlayer.PlayerId = tPlayerCard.PlayerId and tPlayer .PlayerId = tPlayerIdentType .PlayerId and tPlayerCard .Acct=100018273)
exec spGetAwardActivityHourPoints @CasinoID = N'1',@PlayerID =@res,@AccumulatorPeriod = N'H',@ShowAvgBetTime = 0,@ShowByDepartment = 1,@DebugLevel = 0,@IsTierPoint = 0;");
    // dd($consultas);
    //Auth::user()->name;
    $sumaPunto = 0;
    foreach ($consultas as $consulta) {
        $date = new DateTime();
        date_modify($date, '-24 hour');
        //dd($date->format('Y-m-d H:i'));
        $fecha = new DateTime($consulta->Period);
        if ($fecha->format('Y-m-d H') >= $date->format('Y-m-d H')) {
            $sumaPunto += $consulta->Base;
        }
    }
    echo "\n" . $sumaPunto;
})->name('sqlsrv');
