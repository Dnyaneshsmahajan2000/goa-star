<?php

namespace App\Http\Controllers;

//use Barryvdh\DomPDF\PDF;

use App\Models\Ledger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class DemoController extends Controller
{
    public function index()
    {
        $ledgers=Ledger::all();
        $pdf=Pdf::loadView('ledgers.index',['ledgers'=>$ledgers])->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->download('invoice.pdf');
    }
}
