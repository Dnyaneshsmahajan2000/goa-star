<?php

namespace App\Http\Controllers;

use App\Models\VchItem;


use Illuminate\Http\Request;

class VchItemController extends Controller
{
    public function __construct()
    {
        //  session_start();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return ($_SESSION['vch_items']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $item_id = $requestData['item_id'];
        $quantity = $requestData['quantity'];
        //    $rate = $requestData['rate'] ?? 0;
        $vch_items = session()->get('vch_items');
        if (isset($vch_items[$item_id])) {
            $vch_items[$item_id]['quantity'] += $quantity;
            //            $vch_items[$item_id]['total'] = $vch_items[$item_id]['quantity'] * $rate;
        } else {
            $vch_items[$item_id] = $requestData;
            //          $vch_items[$item_id]['total'] = $quantity * $rate;
        }
        session()->put('vch_items', $vch_items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function list($type)
    {
        $item_list = session()->get('vch_items');
        if ($type == 'gst') {
            //     return $item_list;
            return view('VchGstSalePurchase.vch-items')->with('item_list', $item_list);
        } else {
            return view('VchSalePurchase.vch-items')->with('item_list', $item_list);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VchItem $vchItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VchItem $vchItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function delete(Request $request)
    {
        $id = $request->input('item_id');

        $vch_items = session()->get('vch_items');

        if (isset($vch_items[$id])) {
            unset($vch_items[$id]);
            session()->put('vch_items', $vch_items);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }
    }
}
