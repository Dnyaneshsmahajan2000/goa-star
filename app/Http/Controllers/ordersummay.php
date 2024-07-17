public function ordersummary()
    {
        $vouchers = VchGstSalePurchase::where('vch_type', 'order')
            // ->where('ref_no', '')
            ->where('godown_id', auth()->user()->gd_id)
            ->pluck('vch_no');


        $data = [];
        foreach ($vouchers as $vch_no) {
            $vchItems = VchGstSalePurchaseItem::
                where('vch_id', $vch_no)
                ->get();

            foreach ($vchItems as $vi) {
                if (isset($data[$vi->item_id])) {
                    $data[$vi->item_id]['quantity'] += $vi->quantity;
                } else {
                    $data[$vi->item_id]['quantity'] = $vi->quantity;
                    $data[$vi->item_id]['item_name'] = $vi->item_name;
                    $stock = DB::table('stocks')
                        ->where('item_id', $vi->item_id)
                        ->where('gd_id', auth()->user()->gd_id)
                        ->sum('quantity');
                    $data[$vi->item_id]['stock'] = $stock;
                }
            }
        }

        return view('reports.order-summary', compact('data'));
    }
