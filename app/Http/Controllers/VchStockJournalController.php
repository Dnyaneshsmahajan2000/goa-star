<?php

namespace App\Http\Controllers;

use App\Models\VchStockJournal;
use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Item;
use App\Models\stock;
use App\Models\VchStockJournalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VchStockJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockJournal = VchStockJournal::all();
        $stockJournalItems = VchStockJournalItem::all();
        return view('vchStockJournal.index', compact('stockJournal', 'stockJournalItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return session()->all();
        session()->forget('stock_journal_items');
        $godowns = Godown::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
        return view('vchStockJournal.create')
            ->with('godowns', $godowns)
            ->with('items', $items);
    }

    public function store(Request $request)
    {
        try {
            $item_list = session()->get('stock_journal_items');
            $vchStockJournal = new VchStockJournal();
            $vchStockJournal->date = session('date');
            $vchStockJournal->details = $request->details;
            $vchStockJournal->created_by = auth()->id();
            $vchStockJournal->updated_by = auth()->id();
            $vchStockJournal->save();
            foreach ($item_list['source'] as $item) {
                $vchStockJournalItem = new VchStockJournalItem();
                $vchStockJournalItem->ref_id = $vchStockJournal->id;
                $vchStockJournalItem->type = 'source';
                $vchStockJournalItem->quantity = $item['quantity'];
                $vchStockJournalItem->item_id = $item['item_id'];
                $vchStockJournalItem->from_godown_id = $item['from_godown_id'];
                $vchStockJournalItem->save();

                $stock = new Stock();
                $stock->item_id = $item['item_id'];
                $stock->gd_id = $item['from_godown_id'];
                $stock->quantity = -$item['quantity'];
                $stock->vch_type = 'stock_journal';
                $stock->vch_no = $vchStockJournal->id;
                $stock->date = session('date');
                $stock->created_by = auth()->id();
                $stock->updated_by = auth()->id();
                $stock->save();
            }
            foreach ($item_list['destination'] as $item) {
                $vchStockJournalItem = new VchStockJournalItem();
                $vchStockJournalItem->ref_id = $vchStockJournal->id;
                $vchStockJournalItem->type = 'destination';
                $vchStockJournalItem->quantity = $item['quantity'];
                $vchStockJournalItem->item_id = $item['item_id'];
                $vchStockJournalItem->to_godown_id = $item['to_godown_id'];
                $vchStockJournalItem->save();

                $stock = new Stock();
                $stock->item_id = $item['item_id'];
                $stock->gd_id = $item['to_godown_id'];
                $stock->quantity = $item['quantity'];
                $stock->vch_type = 'stock_journal';
                $stock->vch_no = $vchStockJournal->id;
                $stock->date = session('date');
                $stock->created_by = auth()->id();
                $stock->updated_by = auth()->id();
                $stock->save();
            }

            return redirect()->route('vchStockJournal.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VchStockJournal $vchStockJournal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VchStockJournal $vchStockJournal, $id)
    {
        $VchStockJournal = VchStockJournal::find($id);
        $vch_items = [];

        foreach ($VchStockJournal->VchStockJournalItems as $vi) {
            if ($vi->type === 'source') {
                $vch_items['source'][$vi->item_id] = $vi;
            } else {
                $vch_items['destination'][$vi->item_id] = $vi;
            }
        }
        session()->put('stock_journal_items', $vch_items);
        $godowns = Godown::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
        $params['id'] = $id;
        $params['godowns'] = $godowns;
        $params['VchStockJournal'] = $VchStockJournal;
        $params['items'] = $items;
        return view('vchStockJournal.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VchStockJournal $vchStockJournal, $id)
    {
        $vchStockJournal_data = VchStockJournal::find($id);
        if ($vchStockJournal_data) {

            Stock::where('vch_no', $id)->delete();
            VchStockJournalItem::where('ref_id', $id)->delete();
            $item_list = session()->get('stock_journal_items');
            try {
                $vchStockJournal_data->date = session('date');
                $vchStockJournal_data->details = $request->details;
                $vchStockJournal_data->created_by = auth()->id();
                $vchStockJournal_data->updated_by = auth()->id();
                $vchStockJournal_data->save();
                foreach ($item_list['source'] as $item) {
                    $vchStockJournalItem = new VchStockJournalItem();
                    $vchStockJournalItem->ref_id = $vchStockJournal_data->id;
                    $vchStockJournalItem->type = 'source';
                    $vchStockJournalItem->quantity = $item['quantity'];
                    $vchStockJournalItem->item_id = $item['item_id'];
                    $vchStockJournalItem->from_godown_id = $item['from_godown_id'];
                    $vchStockJournalItem->save();

                    $stock = new Stock();
                    $stock->item_id = $item['item_id'];
                    $stock->gd_id = $item['from_godown_id'];
                    $stock->quantity = -$item['quantity'];
                    $stock->vch_type = 'stock_journal';
                    $stock->vch_no = $vchStockJournal_data->id;
                    $stock->date = session('date');
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();
                }
                foreach ($item_list['destination'] as $item) {
                    $vchStockJournalItem = new VchStockJournalItem();
                    $vchStockJournalItem->ref_id = $vchStockJournal_data->id;
                    $vchStockJournalItem->type = 'destination';
                    $vchStockJournalItem->quantity = $item['quantity'];
                    $vchStockJournalItem->item_id = $item['item_id'];
                    $vchStockJournalItem->to_godown_id = $item['to_godown_id'];
                    $vchStockJournalItem->save();

                    $stock = new Stock();
                    $stock->item_id = $item['item_id'];
                    $stock->gd_id = $item['to_godown_id'];
                    $stock->quantity = $item['quantity'];
                    $stock->vch_type = 'stock_journal';
                    $stock->vch_no = $vchStockJournal_data->id;
                    $stock->date = session('date');
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();
                }
                /*                 $vchStockJournal_data->stock_journal_data = serialize($item_list);
                $vchStockJournal_data->date = session('date');
                $vchStockJournal_data->details = $request->details;
                $vchStockJournal_data->save();

                foreach ($item_list as $item) {
                    $stock = new Stock();
                    $stock->item_id = $item['item_id'];
                    $stock->gd_id = $item['godown_id'];
                    if ($item['type'] == 'source') {
                        $stock->quantity = -$item['quantity'];
                    } else {
                        $stock->quantity = $item['quantity'];
                    }

                    $stock->vch_type = 'stock_journal';
                    $stock->vch_no = $vchStockJournal_data->id;
                    $stock->date = session('date');
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();
                }
 */
                return redirect()->route('vchstockjournal.index')->with("success", 'Updated Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
            }
        }
    }

    public function destroy(VchStockJournal $vchStockJournal, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                Stock::where('vch_no', $id)
                    ->where('vch_type', 'stock_journal')
                    ->delete();
                VchStockJournalItem::where('ref_id', $id)->delete();
                VchStockJournal::where('id', $id)->delete();
            });

            return redirect()->route('vchStockJournal.index')->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            // Handle the exception if transaction fails
            return redirect()->back()->with("error", 'Failed to delete');
        }
    }
}
