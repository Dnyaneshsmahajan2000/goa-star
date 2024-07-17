<?php

namespace App\Http\Controllers;

use App\Models\Godown;
use App\Models\vchG2G;
use App\Models\stock;
use App\Models\vchG2GItem;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class VchG2GController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vchg2g = vchG2G::all();
        return view('vchg2gstock.index', compact('vchg2g'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session()->forget('vchg2g_items');
        // return session()->all();
        $godowns = Godown::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
        return view('vchg2gstock.create')
            ->with('godowns', $godowns)
            ->with('items', $items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'godown_from' => 'required',
        'godown_to' => 'required',
    ]);

    try {
        $item_list = session()->get('vchg2g_items');
        $vchg2g = new vchG2G();
        $vchg2g->godown_from = $request->godown_from;
        $vchg2g->godown_to = $request->godown_to;
        $vchg2g->date = session('date');
        $vchg2g->details = $request->details;
        $vchg2g->save();

        foreach ($item_list as $item) {
            $g2gItem = new vchG2GItem();

            $g2gItem->item_id = $item['item_id'];
            $g2gItem->quantity = $item['quantity'];
            $g2gItem->ref_id=$vchg2g->id;

            $vchg2g->vchG2GItem()->save($g2gItem); // Save each item directly

            // First Stock entry for godown_from
            $stock = new Stock();
            $stock->item_id = $item['item_id'];
            $stock->gd_id = $vchg2g->godown_from;
            $stock->quantity = -$item['quantity'];
            $stock->vch_type = 'g2g';
            $stock->vch_no = $vchg2g->id;
            $stock->date = session('date');
            $stock->created_by = auth()->id();
            $stock->updated_by = auth()->id();
            $stock->save();

            // Second Stock entry for godown_to
            $stockTo = new Stock();
            $stockTo->item_id = $item['item_id'];
            $stockTo->gd_id = $vchg2g->godown_to;
            $stockTo->quantity = $item['quantity'];
            $stockTo->vch_type = 'g2g';
            $stockTo->vch_no = $vchg2g->id;
            $stockTo->date = session('date');
            $stockTo->created_by = auth()->id();
            $stockTo->updated_by = auth()->id();
            $stockTo->save();
        }

        return redirect()->route('vchg2g.index')->with("success", 'Inserted Successfully');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
    }
}

    

    /**
     * Display the specified resource.
     */
    public function show(vchG2G $vchG2G)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vchG2G $vchG2G,$id)
    {
        $vchg2g = vchG2G::find($id);
        foreach($vchg2g->vchG2GItem as $vi)
        {
            $vchG2GItem[$vi->item_id]=$vi;
        }
        session()->put('vchg2g_items', $vchG2GItem);
        
       
        $godowns = Godown::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
       
        $params['id'] = $id;
      
        $params['godowns'] = $godowns;
        $params['vchg2g'] = $vchg2g;
        $params['items'] = $items;
        return view('vchg2gstock.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vchG2G $vchG2G ,$id)
    {
        $vchg2g = vchG2G::find($id);
        if($vchg2g){

            Stock::where('vch_no',$vchg2g->id)->delete();
            vchG2GItem::where('ref_id',$vchg2g->id)->delete();
//            $vchg2g->delete();

            $item_list=session()->get('vchg2g_items');
            try{
  //              $vchg2g = new vchG2G();
                $vchg2g->godown_from = $request->godown_from;
                $vchg2g->godown_to = $request->godown_to;
                $vchg2g->date = session('date');
                $vchg2g->details = $request->details;
                $vchg2g->save();
    
                foreach ($item_list as $item) {
                    $g2gItem = new vchG2GItem();
                    $g2gItem->item_id = $item['item_id'];
                    $g2gItem->quantity = $item['quantity'];
                    $g2gItem->ref_id=$vchg2g->id;
                    $g2gItems[] = $g2gItem;
    
                    // First Stock entry for godown_from
                    $stock = new Stock();
                    $stock->item_id = $item['item_id'];
                    $stock->gd_id = $vchg2g->godown_from;
                    $stock->quantity = -$item['quantity'];
                    $stock->vch_type = 'g2g';
                    $stock->vch_no = $vchg2g->id;
                    $stock->date = session('date');
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stocks[] = $stock;
    
                    // Second Stock entry for godown_to
                    $stockTo = new Stock();
                    $stockTo->item_id = $item['item_id'];
                    $stockTo->gd_id = $vchg2g->godown_to;
                    $stockTo->quantity = $item['quantity'];
                    $stockTo->vch_type = 'g2g';
                    $stockTo->vch_no = $vchg2g->id;
                    $stockTo->date = session('date');
                    $stockTo->created_by = auth()->id();
                    $stockTo->updated_by = auth()->id();
                    $stocks[] = $stockTo;
                }
                foreach ($stocks as $stock) {
                    $stock->save();
                }
                $vchg2g->vchG2GItem()->saveMany($g2gItems);
                return redirect()->route('vchg2g.index')->with("success", 'Updated Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
            }
            
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(vchG2G $vchG2G,$id)
    {
        try {
           
            Stock::where('vch_no', $id)->delete();
            vchG2GItem::where('ref_id', $id)->delete();

            vchG2G::where('id', $id)->delete();
            return redirect()->route('vchg2g.index')->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }
}
