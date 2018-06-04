<?php

namespace App\Http\Controllers;


use App\Anotar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class TicketController extends Controller
{

    public function __construct()
    {
        if (!Session::has('ticket')) Session::put('ticket', array());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Session::get('ticket');
        $total = (count($tickets) * 20);
        return view('ticket.show', compact('tickets', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save()
    {
        $tickets = Session::get('ticket');
        foreach ($tickets as $ticket) {
            $partido = new Anotar;
            $partido->resutaldo_equipo_1 = $ticket['equipo_1'];
            $partido->resutaldo_equipo_2 = $ticket['equipo_2'];
            $partido->user_id = \Auth::user()->id;
            $partido->partido_id= $ticket['partido_id'];
            $partido->reporte_id= Session::get('reporte_id')['reporte_id'];
            $partido->save();
            $this->imprimir($ticket['slug'], $ticket['equipo_1'], $ticket['equipo_2']);
        }
        $this->trash();
        \Auth::logout();
        return \Redirect::route('login')
            ->with('info', 'Polla Mundialista fue realizada de forma correcta');
    }

    public function imprimir($slug, $equipo_1, $equipo_2)
    {
        $profile = CapabilityProfile::load("TM-T88IV");
        $connector = new WindowsPrintConnector("EPSON");//TG2480H "smb://guest:123456@".\Request::ip()."/tg2480-h"##@##smb://guest:123456@10.43.18.100/EPSON1
        //   $connector = new WindowsPrintConnector("TG2480H");//TG2480H "smb://guest:123456@".\Request::ip()."/tg2480-h"
        //dd($connector);

        $printer = new Printer($connector, $profile);
        $now = new \DateTime();
        //dd($product->price);
        //  dd($printer);
        try {
            //   $connector->write("\x1b"."Sun Casino Colombia S.A.S\n"."\x44");
            //$printer->selectPrintMode(Printer::MODE_FONT_B);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Sun Casinos Colombia S.A.S\n");
            $printer->text("Fecha Impresion:\n");
            $printer->text($now->format('d-m-Y H:i:s'));
            $printer->feed(2);
            $printer->text("Nombre del cliente: \n" . \Auth::user()->name . " " . \Auth::user()->last_name . "\n");
            $printer->text("Numero tarjeta: \n" . \Auth::user()->username . "\n");
            $printer->feed(1);
            $printer->setTextSize(2, 2);
            $printer->text("POLLA MUNDIALISTA\n");
            $printer->setTextSize(1, 1);
            $printer->text("Acierta y gana\n");
            $printer->feed(1);
            $printer->setTextSize(2, 1);
            $printer->text($slug . "\n");
            $printer->feed(1);
            $printer->setTextSize(3, 3);
            $printer->feed(1);
            $printer->text("  " . $equipo_1 . " " . "--" . " " . $equipo_2 . "  ");
            $printer->feed(4);

            $printer->setTextSize(1, 1);
            $printer->text("ANOTA EN LOS SORTEOS\n");
            $printer->text("De lunes a Miércoles de 8PM a 12AM\n");
            $printer->text("Domingos de 6PM a 11PM");
//            $printer->barcode(\Auth::user()->username, Printer::BARCODE_CODE39);
            $printer->feed(4);
            $printer->text("Gracias por redimir su polla mundialista\n");
            $printer->text("Este boleto es personal\n");
            $printer->text("e intransferible\n");
            $printer->feed(2);
            $printer->cut();
        } catch (Exception $e) {
            dd($e->getMessage());
        } finally {
//            $connector->write("\x1b" . "\x69");
            $printer->close();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $ticket = Session::get('ticket');
        // $ticket->user =\Auth::user()->id;
        // $request->equipo_2 = 0;
        //   $product->;
        $ticket[$request->slug] = $request->all();
        Session::put('ticket', $ticket);

        return redirect()->route('ticket.index');
    }

    public function trash()
    {
        \Session::forget('ticket');
        return redirect()->route('ticket.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        $tickets = \Session::get('ticket');
        unset($tickets[$id]);
        \Session::put('ticket', $tickets);
        return redirect()->route('ticket.index');
    }
}
