<?php

namespace App\Http\Controllers;

use App\Models\vchG2GItem;
use Illuminate\Http\Request;

class VchG2GItemController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $item_id = $requestData['item_id'];
        $quantity = $requestData['quantity'];

        $vchg2g_items = session()->get('vchg2g_items');
        if (isset($vchg2g_items[$item_id])) {
            $vchg2g_items[$item_id]['quantity'] += $quantity;
        } else {
            $vchg2g_items[$item_id] = $requestData;
        }
        session()->put('vchg2g_items', $vchg2g_items);
    }

    /**
     * Store a newly created resource in storage.
     */
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
        return view('vchg2gstock.vch-g2g-items');
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
