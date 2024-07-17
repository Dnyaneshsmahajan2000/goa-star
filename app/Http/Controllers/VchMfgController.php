<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Item;
use App\Models\ItemBom;
use App\Models\Machine;
use App\Models\stock;
use App\Models\VchMfg;
use App\Models\VchMfgItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VchMfgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vchmfgs = VchMfg::all();
        $godowns = Godown::all();
        $machines = Machine::all();
        return view('vchmfg.index', compact('vchmfgs', 'godowns', 'machines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session()->forget('vchmfg_items');
        // return session()->all();
        $godowns = Godown::all();
        $machines = Machine::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
        return view('vchmfg.create')
            ->with('godowns', $godowns)
            ->with('items', $items)
            ->with('machines', $machines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'godown_id' => 'required|string|max:11',
            'machine_id' => 'required|string|max:11',
            'start_reading' => 'required|string|max:255',
            'end_reading' => 'required|string|max:255'
        ]);

        try {
            $vchmfg = new VchMfg();
            $vchmfg->godown_id = $request->godown_id;
            $vchmfg->machine_id = $request->machine_id;
            $vchmfg->start_reading = $request->start_reading;
            $vchmfg->end_reading = $request->end_reading;
            $vchmfg->date = session('date');
            $vchmfg->save();

            $readingConsumed =  $vchmfg->start_reading - $vchmfg->end_reading;
            $totalBatchWeight = 0;


            // Fetch item list from session
            $item_list = session()->get('vchmfg_items');

            // Initialize total batch weight
            $totalBatchWeight = 0;

            // First loop to calculate total batch weight
            foreach ($item_list as $item) {
                $fg_item = Item::find($item['item_id']);
                $fg_item_weight = $fg_item->weight;

                $totalBatchWeight += $item['quantity'] * $fg_item_weight;
            }

            $unitConsumptionPerKg = 0;

            if ($totalBatchWeight != 0) {
                $unitConsumptionPerKg = $readingConsumed / $totalBatchWeight;
            }

            // Process each item in the item list
            foreach ($item_list as $item) {
                $vchmfgitem = new VchMfgItem();
                $fg_item = Item::find($item['item_id']);
                $fg_item_weight = $fg_item->weight;

                $item_unit_consumption = $fg_item_weight * $unitConsumptionPerKg;

                $vchmfgitem->item_id = $item['item_id'];
                $vchmfgitem->quantity = $item['quantity'];
                $vchmfgitem->waste = $item['waste'];
                $vchmfgitem->vch_mfg_id = $vchmfg->id;
                $vchmfgitem->unit = $item_unit_consumption;

                $fg_waste_qty = 0;
                if ($fg_item_weight != 0) {
                    $fg_waste_qty = round($item['waste'] / $fg_item_weight);
                }

                $fg_total_qty = $item['quantity'] + $fg_waste_qty;

                $vchmfg->VchMfgItem()->save($vchmfgitem);

                $stock = new Stock();
                $stock->item_id = $item['item_id'];
                $stock->gd_id = $vchmfg->godown_id;
                $stock->quantity = $item['quantity'];
                $stock->vch_type = 'mfg';
                $stock->vch_no = $vchmfg->id;
                $stock->unit = $item_unit_consumption;
                $stock->date = session('date');
                $stock->created_by = auth()->id();
                $stock->updated_by = auth()->id();
                $stock->save();

                $boms = ItemBom::where('item_id', $item['item_id'])
                    ->leftJoin('items', 'item_boms.rm_id', '=', 'items.id')
                    ->get(['item_boms.*', 'items.*']);
                foreach ($boms as $bom) {
                    $bom_quantity = -$bom['qty'];
                    $bom_stock = new Stock();
                    $bom_stock->item_id = $bom->id; // Use the BOM item ID
                    $bom_stock->gd_id = $vchmfg->godown_id;
                    $bom_stock->quantity = $bom_quantity * $fg_total_qty;
                    $bom_stock->vch_type = 'mfg';
                    $bom_stock->unit = $item_unit_consumption;
                    $bom_stock->vch_no = $vchmfg->id;
                    $bom_stock->date = session('date');
                    $bom_stock->created_by = auth()->id();
                    $bom_stock->updated_by = auth()->id();
                    $bom_stock->save();
                }
            }


            return redirect()->route('vchmfg.create')->with('success', 'vchmfg entry created successfully.');
        } catch (\Exception $e) {
            return $e;
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VchMfg $vchmfg)
    {
        return view('vchmfg.show', compact('vchmfg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vchmfg = VchMfg::find($id);
        foreach ($vchmfg->vchMfgItem as $vi) {
            $vchMfgItem[$vi->item_id] = $vi;
        }
        session()->put('vchmfg_items', $vchMfgItem);


        $godowns = Godown::all();
        $machines = Machine::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });

        $params['id'] = $id;

        $params['godowns'] = $godowns;
        $params['machines'] = $machines;
        $params['vchmfg'] = $vchmfg;
        $params['items'] = $items;
        return view('vchmfg.edit', $params);
    }
    // public function edit(VchMfg $vchmfg)
    // {
    //     $machines = Machine::all();
    //     $godowns = Godown::all();
    //     return view('vchmfg.edit', compact('vchmfg', 'machines', 'godowns'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vchmfg)

    {
        $id = $vchmfg;
        $vchmfg = VchMfg::find($id);
        if ($vchmfg) {
            // Begin transaction
            DB::beginTransaction();

            try {
                Stock::where('vch_no', $vchmfg->id)->delete();
                vchMfgItem::where('vch_mfg_id', $vchmfg->id)->delete();
                $item_list = session()->get('vchmfg_items');

                $vchmfg->godown_id = $request->godown_id;
                $vchmfg->machine_id = $request->machine_id;
                $vchmfg->start_reading = $request->start_reading;
                $vchmfg->end_reading = $request->end_reading;
                $vchmfg->date = session('date');
                $vchmfg->save();

                $readingConsumed =  $vchmfg->start_reading - $vchmfg->end_reading;
                $totalBatchWeight = 0;

                // Fetch item list from session
                $item_list = session()->get('vchmfg_items');

                // Initialize total batch weight
                $totalBatchWeight = 0;

                // First loop to calculate total batch weight
                foreach ($item_list as $item) {
                    $fg_item = Item::find($item['item_id']);
                    $fg_item_weight = $fg_item->weight;

                    $totalBatchWeight += $item['quantity'] * $fg_item_weight;
                }

                $unitConsumptionPerKg = 0;

                if ($totalBatchWeight != 0) {
                    $unitConsumptionPerKg = $readingConsumed / $totalBatchWeight;
                }

                // Process each item in the item list
                foreach ($item_list as $item) {
                    $vchmfgitem = new VchMfgItem();
                    $fg_item = Item::find($item['item_id']);
                    $fg_item_weight = $fg_item->weight;

                    $item_unit_consumption = $fg_item_weight * $unitConsumptionPerKg;

                    $vchmfgitem->item_id = $item['item_id'];
                    $vchmfgitem->quantity = $item['quantity'];
                    $vchmfgitem->waste = $item['waste'];
                    $vchmfgitem->vch_mfg_id = $vchmfg->id;
                    $vchmfgitem->unit = $item_unit_consumption;

                    $fg_waste_qty = 0;
                    if ($fg_item_weight != 0) {
                        $fg_waste_qty = round($item['waste'] / $fg_item_weight);
                    }

                    $fg_total_qty = $item['quantity'] + $fg_waste_qty;

                    $vchmfg->VchMfgItem()->save($vchmfgitem);

                    $stock = new Stock();
                    $stock->item_id = $item['item_id'];
                    $stock->gd_id = $vchmfg->godown_id;
                    $stock->quantity = $item['quantity'];
                    $stock->vch_type = 'mfg';
                    $stock->vch_no = $vchmfg->id;
                    $stock->unit = $item_unit_consumption;
                    $stock->date = session('date');
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();

                    $boms = ItemBom::where('item_id', $item['item_id'])
                        ->leftJoin('items', 'item_boms.rm_id', '=', 'items.id')
                        ->get(['item_boms.*', 'items.*']);
                    foreach ($boms as $bom) {
                        $bom_quantity = -$bom['qty'];
                        $bom_stock = new Stock();
                        $bom_stock->item_id = $bom->id; // Use the BOM item ID
                        $bom_stock->gd_id = $vchmfg->godown_id;
                        $bom_stock->quantity = $bom_quantity * $fg_total_qty;
                        $bom_stock->vch_type = 'mfg';
                        $bom_stock->unit = $item_unit_consumption;
                        $bom_stock->vch_no = $vchmfg->id;
                        $bom_stock->date = session('date');
                        $bom_stock->created_by = auth()->id();
                        $bom_stock->updated_by = auth()->id();
                        $bom_stock->save();
                    }
                }

                // Commit transaction if all operations succeed
                DB::commit();

                return redirect()->route('vchmfg.create')->with('success', 'vchmfg entry Updated successfully.');
            } catch (\Exception $e) {
                // Rollback transaction if any operation fails
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            Stock::where('vch_no', $id)->delete();
            vchMfgItem::where('vch_mfg_id', $id)->delete();
            VchMfg::where('id', $id)->delete();

            return redirect()->route('vchmfg.index')->with('success', 'vchmfg entry deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }
}
