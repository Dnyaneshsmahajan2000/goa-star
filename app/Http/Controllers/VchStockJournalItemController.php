<?php

namespace App\Http\Controllers;

use App\Models\vchG2GItem;
use Illuminate\Http\Request;

class VchStockJournalItemController extends Controller
{
    public function __construct()
    {
      //  session_start();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return session()->get('stock_journal_items');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $item_id = $requestData['item_id'];
        $quantity = $requestData['quantity'];
        $type = $requestData['type'];
        $vchg2g_items = session()->get('stock_journal_items');
        if ($type == 'source' or $type == 'transfer') {
            if (isset($vchg2g_items['source'][$item_id])) {
                $vchg2g_items['source'][$item_id]['quantity'] += $quantity;
            } else {
                $vchg2g_items['source'][$item_id] = $requestData;
            }
        }
        if ($type == 'destination'  or $type == 'transfer') {
            if (isset($vchg2g_items['destination'][$item_id])) {
                $vchg2g_items['destination'][$item_id]['quantity'] += $quantity;
            } else {
                $vchg2g_items['destination'][$item_id] = $requestData;
            }
        }
        session()->put('stock_journal_items', $vchg2g_items);
    }

     public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function list()
    {
        //$item_list = session()->get('vchg2g_items');
        return view('vchStockJournal.vch-stock-journal-items');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
