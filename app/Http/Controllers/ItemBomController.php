<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemBom;
use Illuminate\Http\Request;

class ItemBomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all item_boms from the database
        $item_boms = ItemBom::all();
        $items = Item::all();
        // Return the view with the retrieved item_boms data
        return view('item_boms.index', compact('item_boms', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new item_bom
        return view('item_boms.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $item = new ItemBom();
            $item->item_id = $request->item_id;
            $item->rm_id = $request->rm_id;
            $item->qty = $request->qty;
            $item->unit = $request->unit;
            $item->save();

            return redirect()->route('item.bom.index')->with('success', 'Item added successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemBom $itemBom)
    {
        // Return the view for showing a specific item_bom
        return view('item_boms.show', compact('item_bom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $item_boms = ItemBom::find($id);
        return view('item_boms.index', compact('item_boms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $itemBom = ItemBom::find($id);
        $itemBom->item_id = $request->item_id;
        $itemBom->rm_id = $request->rm_id;
        $itemBom->qty = $request->qty;
        $itemBom->unit = $request->unit;
        $itemBom->save();
        return redirect()->route('item_boms.index')->with("success", 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemBom $itemBom)
    {
        $itemBom->delete();

        return redirect()->route('item_boms.index')->with('success', 'Item Bom deleted successfully!');
    }
}
