<?php

namespace App\Http\Controllers;

use App\Models\VchSalePurchase;
use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Group;
use App\Models\Item;
use App\Models\stock;
use App\Models\transaction;
use App\Models\VchSalePurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VchSalePurchaseController extends Controller
{
    public $vch_type;
    public $gst_type;

    public function __construct(Request $request)
    {
        $this->vch_type = $request->vch_type;
    }
    public function index($vch_type)
    {
        $vouchers = VchSalePurchase::where('vch_type', $vch_type)->get();

        return view('VchSalePurchase.index', [
            'vch_type' => $this->vch_type,
            'Vouchers' => $vouchers
        ]);
    }

    public function create(Request $request, $type, $id = null)
    {

        if (!$id) {
            session()->forget('vch_items');
            $params['action'] = 'add';
        } else {
            $voucher = VchSalePurchase::find($id);
            session()->put('vch_items', $voucher->VchNonGstItems);
            $params['action'] = 'add';
            $params['voucher'] = $voucher;
        }


        if (in_array($this->vch_type, ['sale', 'sale_return', 'order'])) {
            $accounts = Group::getAllLedgers([GROUP_SALES_ACCOUNTS]);
            // $parties= Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                return $parties;
            });
        } else {
            $accounts = Group::getAllLedgers([GROUP_PURCHASE_ACCOUNTS]);
            //   $parties= Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                return $parties;
            });
        }
        $godowns = Godown::all();
        $items = Item::where('type', 'fg')->get()->map(function ($item) {
            $item->label = $item->name;
            unset($item->name);
            return $item;
        });


        $params['vch_type'] = $this->vch_type;
        $params['id'] = $id;
        $params['accounts'] = $accounts;
        $params['parties'] = $parties;
        $params['godowns'] = $godowns;
        $params['items'] = $items;

        return view('VchSalePurchase.create', $params);
    }

    public function order_to_sale(Request $request)
    {

        return view('VchSalePurchase.create')
            ->with('vch_type', 'order to sale')
            ->with('action', 'add')
            ->with('id', 'add');
    }


    public function store(Request $request, $vch_type)
    {

        $request->validate([
            'ledger_name' => 'required|string|max:50',

        ]);
        try {

            $item_list = session()->get('vch_items');
            $vch_items_data = session()->get('vch_items_data');

            $vouchers = new VchSalePurchase();
            $maxVchNo = VchSalePurchase::where('vch_type', $vch_type)->max('vch_no');
            $vch_no = $maxVchNo + 1;
            $vouchers->ledger_id = $request->ledger_id;
            $vouchers->godown_id = $request->gd_id;
            $vouchers->vch_type = $vch_type; // Assuming vch_no is the field name
            $vouchers->vch_no = $vch_no;
            $vouchers->total = $vch_items_data['total'];
            $vouchers->date = session('date');
            $vouchers->discount = $vch_items_data['total_discount'];
            $vouchers->round_off = 0; // Assuming this field is optional and can be left blank
            $vouchers->grand_total = $vch_items_data['grand_total_after_tax'];


            $vouchers->date = session('date');

            $vouchers->save();
            $totalcgst = 0;
            $totalsgst = 0;
            $total_rate_after_discount = 0;
            $totaligst = 0;
            foreach ($item_list as $item) {
                $voucherItem = new VchSalePurchaseItem();
                $voucherItem->vch_id = $vouchers->id; // Assuming vch_no is the field name
                $voucherItem->item_id = $item['item_id'];
                $voucherItem->quantity = $item['quantity'];
                $voucherItem->rate = $item['rate'];
                $voucherItem->discount = $item['discount'];
                $voucherItem->rate_after_discount = $item['rate_after_discount'];
                $voucherItem->total = $item['total'];
                $voucherItem->total_after_disc = $item['rate_after_discount'] * $item['quantity'];
                $voucherItem->grand_total = $item['rate_after_discount'] * $item['quantity'];
                $total_rate_after_discount += $item['rate_after_discount'] * $item['quantity'];
                $voucherItems[] = $voucherItem;
                if ($vch_type == 'sale_return' || $vch_type == 'purchase') {
                    $stockQuantityChange = $item['quantity'];
                } else {
                    $stockQuantityChange = -$item['quantity'];
                }
                if ($vch_type != 'order') {
                    $stock = new stock();
                    $stock->item_id = $item['item_id'];
                    $stock->quantity = $stockQuantityChange;
                    $stock->rate = $item['rate'];
                    $stock->date = session('date');
                    $stock->vch_no = $vch_no; // Assuming vch_no is the field name
                    $stock->vch_type = $vch_type; // Assuming vch_no is the field name
                    $stock->gd_id = $request->gd_id;
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();
                }
            }
            $vouchers->VchNonGstItems()->saveMany($voucherItems);

            $transaction = new transaction();

            $transaction->vch_no = $vch_no;

            $transactionTypes = [
                'account' => [
                    'ledger_id' => $request->account_id,
                    'particular' => $request->ledger_name,
                    'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $total_rate_after_discount : 0,
                    'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $total_rate_after_discount : 0
                ],
                'ledger' => [
                    'ledger_id' => $request->ledger_id,
                    'particular' => $vch_type,
                    'debit' => in_array($vch_type, ['sale', 'purchase_return']) ? $request->total_bill : 0,
                    'credit' => in_array($vch_type, ['sale_return', 'purchase']) ? $request->total_bill : 0
                ],
                'cgst' => [
                    'ledger_id' => LEDGER_CGST,
                    'particular' => $request->ledger_name,
                    'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totalcgst : 0,
                    'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totalcgst : 0,
                ],
                'sgst' => [
                    'ledger_id' => LEDGER_SGST,
                    'particular' => $request->ledger_name,
                    'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totalsgst : 0,
                    'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totalsgst : 0,
                ],
                'igst' => [
                    'ledger_id' => LEDGER_IGST,
                    'particular' => $request->ledger_name,
                    'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totaligst : 0,
                    'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totaligst : 0,
                ]
            ];

            foreach ($transactionTypes as $key => $attributes) {
                $transaction = new Transaction(); // Assuming Transaction is your model for transactions
                $transaction->date = session('date');
                $transaction->vch_type = $vch_type;
                $transaction->vch_no = $vch_no;
                $transaction->ref_id = $key === 'account' ? $request->ledger_id : $request->account_id;

                // Set attributes specific to each transaction type
                $transaction->ledger_id = $attributes['ledger_id'];
                $transaction->particular = $attributes['particular'];
                $transaction->debit = $attributes['debit'] ?? 0;
                $transaction->credit = $attributes['credit'] ?? 0;

                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }






            //transactions


            return redirect()->route('vch.index', ['vch_type' => $vch_type])->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VchSalePurchase $vchSalePurchase)
    {
        //
    }

    public function edit($vch_type, $id)
    {

        $voucher = VchSalePurchase::find($id);
        foreach ($voucher->VchNonGstItems as $vi) {
            $vch_items[$vi->item_id] = $vi;
        }
        session()->put('vch_items', $vch_items);

        $params['voucher'] = $voucher;
        if (in_array($this->vch_type, ['sale', 'sale_return', 'order'])) {
            $accounts = Group::getAllLedgers([GROUP_SALES_ACCOUNTS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                return $parties;
            });
        } else {
            $accounts = Group::getAllLedgers([GROUP_PURCHASE_ACCOUNTS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                return $parties;
            });
        }
        $godowns = Godown::all();
        $items = Item::all()->map(function ($items) {
            $items->label = $items->name;
            unset($items->name);
            return $items;
        });
        $params['vch_type'] = $this->vch_type;
        $params['id'] = $id;
        $params['accounts'] = $accounts;
        $params['parties'] = $parties;
        $params['godowns'] = $godowns;
        $params['items'] = $items;
        return view('VchSalePurchase.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VchSalePurchase $vchSalePurchase, $vch_type, $id)
    {
        $vouchers = VchSalePurchase::find($id);
        DB::beginTransaction(); // Start a database transaction

        if ($vouchers) {

            Transaction::where('vch_no', $vouchers->vch_no)->delete();

            Stock::where('vch_no', $vouchers->vch_no)->delete();

            VchSalePurchaseItem::where('vch_id', $vouchers->id)->delete();
            $item_list = session()->get('vch_items');
            $vch_items_data = session()->get('vch_items_data');
            try {

                //                $vouchers = new VchSalePurchase();
                //              $maxVchNo = VchSalePurchaseItem::where('vch_type', $vch_type)->max('vch_no');
                //            $vch_no = $maxVchNo + 1;
                $vouchers->ledger_id = $request->ledger_id;
                $vouchers->godown_id = $request->gd_id;
                //        $vouchers->vch_type = $vch_type; // Assuming vch_no is the field name
                //          $vouchers->vch_no = $vch_no;
                $vouchers->total = $vch_items_data['total'];
                $vouchers->date = session('date');
                $vouchers->discount = $vch_items_data['total_discount'];
                //   $vouchers->total_after_taxes = $vch_items_data['grand_total_after_tax'];
                $vouchers->round_off = 0; // Assuming this field is optional and can be left blank
                $vouchers->grand_total = $vch_items_data['grand_total_after_tax'];


                $vouchers->date = session('date');

                $vouchers->save();
                $totalcgst = 0;
                $totalsgst = 0;
                $total_rate_after_discount = 0;
                $totaligst = 0;
                foreach ($item_list as $item) {
                    $voucherItem = new VchSalePurchaseItem();
                    $voucherItem->vch_id = $vouchers->id; // Assuming vch_no is the field name
                    $voucherItem->item_id = $item['item_id'];
                    $voucherItem->quantity = $item['quantity'];
                    $voucherItem->rate = $item['rate'];
                    $voucherItem->discount = $item['discount'];
                    $voucherItem->rate_after_discount = $item['rate_after_discount'];
                    $voucherItem->total = $item['total'];

                    $voucherItem->total_after_disc = $item['rate_after_discount'] * $item['quantity'];
                    $voucherItem->grand_total = $item['rate_after_discount'] * $item['quantity'];
                    $total_rate_after_discount += $item['rate_after_discount'] * $item['quantity'];
                    $voucherItems[] = $voucherItem;
                    if ($vch_type == 'sale_return' || $vch_type == 'purchase') {
                        $stockQuantityChange = $item['quantity'];
                    } else {
                        $stockQuantityChange = -$item['quantity'];
                    }
                    if ($vch_type != 'order') {
                        $stock = new Stock();
                        $stock->item_id = $item['item_id'];
                        $stock->quantity = $stockQuantityChange;
                        $stock->rate = $item['rate'];
                        $stock->date = session('date');
                        $stock->vch_no = $vouchers->id; // Assuming vch_no is the field name

                        $stock->vch_type = $vch_type; // Assuming vch_no is the field name
                        $stock->gd_id = $request->gd_id;
                        $stock->created_by = auth()->id();
                        $stock->updated_by = auth()->id();
                        $stock->save();
                    }
                }
                $vouchers->VchNonGstItems()->saveMany($voucherItems);

                $transaction = new Transaction();

                $transaction->vch_no = $vouchers->id;;

                $transactionTypes = [
                    'account' => [
                        'ledger_id' => $request->account_id,
                        'particular' => $request->ledger_name,
                        'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $total_rate_after_discount : 0,
                        'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $total_rate_after_discount : 0
                    ],
                    'ledger' => [
                        'ledger_id' => $request->ledger_id,
                        'particular' => $vch_type,
                        'debit' => in_array($vch_type, ['sale', 'purchase_return']) ? $request->total_bill : 0,
                        'credit' => in_array($vch_type, ['sale_return', 'purchase']) ? $request->total_bill : 0
                    ],
                    'cgst' => [
                        'ledger_id' => LEDGER_CGST,
                        'particular' => $request->ledger_name,
                        'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totalcgst : 0,
                        'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totalcgst : 0,
                    ],
                    'sgst' => [
                        'ledger_id' => LEDGER_SGST,
                        'particular' => $request->ledger_name,
                        'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totalsgst : 0,
                        'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totalsgst : 0,
                    ],
                    'igst' => [
                        'ledger_id' => LEDGER_IGST,
                        'particular' => $request->ledger_name,
                        'debit' => in_array($vch_type, ['sale_return', 'purchase']) ? $totaligst : 0,
                        'credit' => in_array($vch_type, ['sale', 'purchase_return']) ? $totaligst : 0,
                    ]
                ];

                foreach ($transactionTypes as $key => $attributes) {
                    $transaction = new Transaction(); // Assuming Transaction is your model for transactions
                    $transaction->date = session('date');
                    $transaction->vch_type = $vch_type;
                    $transaction->vch_no = $vouchers->id;;
                    $transaction->ref_id = $key === 'account' ? $request->ledger_id : $request->account_id;

                    $transaction->ledger_id = $attributes['ledger_id'];
                    $transaction->particular = $attributes['particular'];
                    $transaction->debit = $attributes['debit'] ?? 0;
                    $transaction->credit = $attributes['credit'] ?? 0;

                    $transaction->created_by = auth()->id();
                    $transaction->updated_by = auth()->id();
                    $transaction->save();
                }
                DB::commit();

                return redirect()->route('vch.index', ['vch_type' => $vch_type])->with("success", 'Inserted Successfully');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VchSalePurchase $vchSalePurchase, $vch_type, $id)
    {
        try {
            Transaction::where('vch_no', $id)->delete();
            Stock::where('vch_no', $id)->delete();
            VchSalePurchaseItem::where('vch_id', $id)->delete();

            VchSalePurchase::where('id', $id)->delete();
            return redirect()->route('vch.index', ['vch_type' => $vch_type])->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }
}
