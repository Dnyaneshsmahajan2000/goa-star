<?php

namespace App\Http\Controllers;

use App\Models\VchMfgItem;
use Illuminate\Http\Request;

class VchMfgItemController extends Controller
{
    public function __construct()
    {
       // session_start();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $item_id = $requestData['item_id'];
        $quantity = $requestData['quantity'];
        $waste = $requestData['waste'];
        $vchmfg_items = session()->get('vchmfg_items');
        if (isset($vchmfg_items[$item_id])) {
            $vchmfg_items[$item_id]['quantity'] += $quantity;
            $vchmfg_items[$item_id]['waste'] += $waste;
        } else {
            $vchmfg_items[$item_id] = $requestData;
        }
        session()->put('vchmfg_items', $vchmfg_items);
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
        //$item_list = session()->get('vchmfg_items');
        return view('vchmfg.vch-mfg-items');
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
     public function delete(Request $request)
    {
        $id = $request->input('item_id');

        $vch_items = session()->get('vchmfg_items');

        if (isset($vch_items[$id])) {
            unset($vch_items[$id]);
            session()->put('vchmfg_items', $vch_items);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }
    }
}
