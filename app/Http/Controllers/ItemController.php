<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Group;
use App\Models\stock;
use App\Models\ItemBom;
use App\Models\ItemCategory;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        $itemgroups = ItemGroup::all();
        $itemcategory = ItemCategory::all();
        return view('items.create', compact('itemgroups', 'itemcategory', 'units'));
    }
    public function bom($bom)
    {

        $units = Unit::all();
        $item = Item::find($bom);
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });

        return view('item_boms.index')->with('item', $item)->with('items', $items)->with('units', $units);
    }

    public function bom_store(Request $request)
    {
            // Validate the incoming request data
            /* $validatedData = $request->validate([
        'item_id' => 'required|exists:items,id',
        'rm_id' => 'required|exists:raw_materials,id',
        'qty' => 'required|numeric|min:0',
        'unit' => 'required',
    ]) */;

        try {
            $bom = new ItemBom();
            $bom->item_id = $request['item_id'];

            $bom->rm_id = $request['rm_id'];
            $bom->qty = $request['qty'];

            $bom->unit = $request['unit'];


            $bom->save();

            if ($request['unit'] !== 'Nos') {
                $item = Item::find($request['item_id']);
                if ($item) {
                    $additionalWeight = $request['qty'];
                    $item->weight += $additionalWeight;
                    $item->save();
                }
            }
            return redirect()->route('item.bom.create', ['bom' => $request['item_id']])
                ->with('success', 'Item added successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

   public function bom_delete($bom, $item_id)
    {
        $itemBom = ItemBom::find($bom);
        $itemBom->delete();

        //return view('item_boms.index')->with('success', 'Item Bom deleted successfully!');
        return redirect()->route('item.bom.create', ['bom' => $item_id]);
    }



    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            // 'description' => 'nullable|string',
            // 'item_group_id' => 'string|min:0|max:255',
            // 'item_category_id' => 'string|min:0|max:255',
            // 'is_bom' => 'string|min:0|max:255',
            // 'type' => 'string|max:255',
            // 'unit' => 'nullable|string|max:255',
            // 'weight' => 'nullable|numeric|min:0|max:255',
            // 'rate' => 'nullable|integer|min:0|max:255',
            // 'gst_rate' => 'nullable|integer|min:0|max:255',
            // 'hsn_code' => 'nullable|numeric',
            // 'opening_stock' => 'nullable|numeric|min:0|max:255',
            // 'min_stock_qty' => 'nullable|numeric|min:0|max:255',
            // 'maintain_stock' => 'nullable|numeric|min:0|max:255',
            // 'item_barcode' => 'nullable|numeric',
            // 'discount' => 'numeric',
        ]);

        try {
            $item = new Item();
            $item->name = ucwords($request->name);
            $item->description = $request->description;
            $item->item_group_id = $request->item_group_id;
            $item->item_category_id = $request->item_category_id;
            $item->is_bom = $request->is_bom;
            $item->type = $request->type;
            $item->unit = ucwords($request->unit);
            $item->weight = $request->weight;
            $item->rate = $request->rate;
            $item->gst_rate = $request->gst_rate;
            $item->hsn_code = $request->hsn_code;
            $item->opening_stock = $request->opening_stock;
            $item->min_stock_qty = $request->min_stock_qty;
            $item->maintain_stock = $request->maintain_stock;
            $item->item_barcode = $request->item_barcode;
            $item->discount = $request->discount;

            $item->save();


            $stock = new Stock();
            $stock->item_id = $item->id;
            $stock->gd_id = 1;
            $stock->quantity = $item->opening_stock;
            $stock->vch_type = 'os';
            $stock->unit = $item->unit;
            $stock->vch_no = $item->id;
            $stock->rate = $item->rate;
            $stock->date = session('date');
            $stock->created_by = auth()->id();

            $stock->updated_by = auth()->id();

            // $stock->value = $item->opening_stock * $item->rate;

            $stock->save();

            if ($item->is_bom == 'yes') {
                $id = $item->id;
                return redirect()->route('item.bom.create', $id)->with('success', 'Item added successfully.');
            }
            return redirect()->route('item.index')->with('success', 'Item added successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::find($id);
        $units = Unit::all();
        $itemgroups = ItemGroup::all();
        $itemcategory = ItemCategory::all();
        return view('items.show', compact('item', 'itemgroups', 'itemcategory', 'units'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * @param int
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $item = Item::find($id);
        $units = Unit::all();
        $itemgroups = ItemGroup::all();
        $itemcategory = ItemCategory::all();
        return view('items.edit', compact('item', 'itemgroups', 'itemcategory', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $Item = Item::find($id);

        // echo "<pre>";
        // echo print_r($Item);

        $Item->name = ucwords($request->name);
        $Item->description = $request->description;
        $Item->item_group_id = $request->item_group_id;
        $Item->item_category_id = $request->item_category_id;
        $Item->is_bom = $request->is_bom;
        $Item->type = $request->type;
        $Item->unit = ucwords($request->unit);
        $Item->weight = $request->weight;
        $Item->rate = $request->rate;
        $Item->gst_rate = $request->gst_rate;
        $Item->hsn_code = $request->hsn_code;
        $Item->opening_stock = $request->opening_stock;
        $Item->min_stock_qty = $request->min_stock_qty;
        $Item->maintain_stock = $request->maintain_stock;
        $Item->item_barcode = $request->item_barcode;
        $Item->discount = $request->discount;
        $Item->save();

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'item_group_id' => 'integer',
        //     'item_category_id' => 'integer',
        //     'is_bom' => 'string|max:255',
        //     'type' => 'integer|string|max:255',
        //     'unit' => 'integer|string|max:255',
        //     'weight' => 'float|string|max:255',
        //     'rate' => 'float|string|max:255',
        //     'gst_rate' => 'float|string|max:255',
        //     'hsn_code' => 'integer|string|max:255',
        //     'opening_stock' => 'integer|string|max:255',
        //     'min_stock_qty' => 'integer|string|max:255',
        //     'maintain_stock' => 'integer|string|max:255',
        //     'item_barcode' => 'integer|string|max:255',
        //     'discount' => 'numeric|max:255',
        // ]);

        return redirect()->route('item.index')->with('success', 'Item updated successfully');
    }
 
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        $item->delete();

        return redirect()->route('item.index')->with('success', 'Item deleted successfully');
    }
}
