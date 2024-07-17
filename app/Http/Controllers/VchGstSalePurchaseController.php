<?php

namespace App\Http\Controllers;

use App\Models\Godown;
use App\Models\Group;
use App\Models\Item;
use App\Models\transaction;
use App\Models\VchSalePurchase;
use Illuminate\Http\Request;
use App\Models\stock;
use Carbon\Carbon;

use App\Models\VchGstSalePurchase;
use App\Models\VchGstSalePurchaseItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Auth;

class VchGstSalePurchaseController extends Controller
{
    public $vch_type;
    public $gst_type;

    public function __construct(Request $request)
    {
        $this->vch_type = $request->vch_type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $vch_type)
    {
        $start_date = $request->has('start_date') ? Carbon::createFromFormat('Y-F-d', $request->start_date)->format('Y-m-d') : session('from_date');
        $end_date = $request->has('end_date') ? Carbon::createFromFormat('Y-F-d', $request->end_date)->format('Y-m-d') : session('to_date');
if ($vch_type != 'order') {
            if ((Auth::user()->role->name == 'SuperAdmin')) {
                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            } else {
                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->where('godown_id', Auth::user()->gd_id)
                    ->get();
            }
        } else {
            if ((Auth::user()->role->name == 'SuperAdmin')) {

                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereNull('ref_type')
                    ->whereNull('ref_id')
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            } else {

                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereNull('ref_type')
                    ->whereNull('ref_id')
                    ->where('godown_id', Auth::user()->gd_id)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            }
        }
        return view('VchGstSalePurchase.index', [
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
            $voucher = VchGstSalePurchase::find($id);
            session()->put('vch_items', $voucher->VchItems);
            $params['action'] = 'add';
            $params['voucher'] = $voucher;
        }


        if (in_array($this->vch_type, ['sale', 'sale_return', 'order'])) {
            $accounts = Group::getAllLedgers([GROUP_SALES_ACCOUNTS]);
            // $parties= Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);
           if(Auth::user()->role->name=='SuperAdmin'){
                $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])
                ->map(function ($parties) {
                    $parties->label = $parties->name;
                    unset($parties->name);
                  $parties->balance = $parties->getBalance();

                    return $parties;
                });

            }else{   
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])
            ->where('gd_id', Auth::user()->gd_id) 
            ->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                                        $parties->balance = $parties->getBalance();

                return $parties;
            });
        }
        } else {

            $accounts = Group::getAllLedgers([GROUP_PURCHASE_ACCOUNTS]);
            //   $parties= Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS]);
           if(Auth::user()->role->name=='SuperAdmin'){
                $parties = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS, GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])
                ->map(function ($parties) {
                    $parties->label = $parties->name;
                    unset($parties->name);
                                            $parties->balance = $parties->getBalance();

                    return $parties;
                });
            }else{

            
            $parties = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS, GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])
            ->where('gd_id', Auth::user()->gd_id) 
            ->map(function ($parties) {
                $parties->label = $parties->name;
                unset($parties->name);
                                        $parties->balance = $parties->getBalance();

                return $parties;
            });
        }
        }
        $godowns = Godown::all();
$items = Item::get()->map(function ($item) {
            // Sum the qty of the stocks for the current item_id
            $item->stock_qty = Stock::where('item_id', $item->id)->sum('quantity');

            // Modify the item as required
            $item->label = $item->name;
            unset($item->name);

            return $item;
        });

        $groups = Group::where('level', '<>', 1)
            ->orderBy('group_name')
            ->get();
        $params['vch_type'] = $this->vch_type;
        $params['id'] = $id;
        $params['accounts'] = $accounts;
        $params['parties'] = $parties;
        $params['godowns'] = $godowns;
        $params['items'] = $items;
        $params['groups'] = $groups;



        return view('VchGstSalePurchase.create', $params);
    }

    public function order_to_sale(Request $request, $vch_type, $id)
    {

        if (!$id) {
            session()->forget('vch_items');
            $params['action'] = 'add';
        } else {
            $voucher = VchGstSalePurchase::find($id);
            session()->put('vch_items', $voucher->VchItems);
            $params['action'] = 'add';
            $params['voucher'] = $voucher;
        }
        if (in_array($this->vch_type, ['sale', 'sale_return', 'order'])) {
            $accounts = Group::getAllLedgers([GROUP_SALES_ACCOUNTS]);
            // $parties= Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                                        $parties->balance = $parties->getBalance();

                unset($parties->name);
                return $parties;
            });
        } else {
            $accounts = Group::getAllLedgers([GROUP_PURCHASE_ACCOUNTS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                                        $parties->balance = $parties->getBalance();

                unset($parties->name);
                return $parties;
            });
        }
        $godowns = Godown::all();
  $items = Item::get()->map(function ($item) {
            // Sum the qty of the stocks for the current item_id
            $item->stock_qty = Stock::where('item_id', $item->id)->sum('quantity');

            // Modify the item as required
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
        return view('VchGstSalePurchase.create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $vch_type)
    {

        $request->validate([
            'ledger_name' => 'required|string|max:50',

        ]);
        
        try {

              $item_list = session()->get('vch_items');
    if (empty($item_list)) {
        return redirect()->back()->withInput()->with('error', 'Please add the items.');
    }
            $vch_items_data = session()->get('vch_items_data');

            $vouchers = new VchGstSalePurchase();
            $maxVchNo = VchGstSalePurchase::where('vch_type', $vch_type)->max('vch_no');
            $vch_no = $maxVchNo + 1;
            $vouchers->ledger_id = $request->ledger_id;
            $vouchers->godown_id = $request->gd_id;
            $vouchers->vch_type = $vch_type; // Assuming vch_no is the field name
            $vouchers->vch_no = $vch_no;
            $vouchers->total = $vch_items_data['total'];
            $vouchers->date = session('date');
            $vouchers->discount = $vch_items_data['total_discount'];
            $vouchers->cgst = $vch_items_data['total_cgst_amount'] ?? 0;
            $vouchers->sgst = $vch_items_data['total_sgst_amount'] ?? 0;
            $vouchers->igst = $vch_items_data['total_igst_amount'] ?? 0;
            $vouchers->total_gst = $vch_items_data['total_gst_amt'] ?? 0;
            $vouchers->total_after_taxes = $vch_items_data['grand_total_after_tax'];
            $vouchers->round_off = 0; // Assuming this field is optional and can be left blank
            if (isset($request->order_id)) {
                $vouchers->ref_type = "order";
                $vouchers->ref_id = $request->order_id;
            }

            $vouchers->grand_total = $vch_items_data['grand_total_after_tax'];
            $vouchers->date = session('date');
            $vouchers->save();

            $voucher_order = VchGstSalePurchase::find($request->order_id);
            if ($voucher_order) {
                $voucher_order->ref_type = "sale";
                $voucher_order->ref_id = $vouchers->order_id;
                $voucher_order->save();
            }
            $totalcgst = 0;
            $totalsgst = 0;
            $total_rate_after_discount = 0;
            $totaligst = 0;
            foreach ($item_list as $item) {
                $voucherItem = new VchGstSalePurchaseItem();
                $voucherItem->vch_id = $vouchers->id; // Assuming vch_no is the field name
                $voucherItem->item_id = $item['item_id'];
                $voucherItem->quantity = $item['quantity'];
                $voucherItem->rate = $item['rate'];
                $voucherItem->discount = $item['discount'];
                $voucherItem->rate_after_discount = $item['rate_after_discount'];
                $voucherItem->total = $item['total'];
                $gst = $item['gst_rate']; // Assuming $item['gst'] represents the total GST rate

                $gst_percentage = $gst / 100; // Total GST rate percentage converted to decimal
                $cgst_percentage = $gst_percentage / 2; // CGST rate percentage
                $sgst_percentage = $gst_percentage / 2; // SGST rate percentage

                $gst_amount = $item['total'] * $gst_percentage;
                $cgst_amount = $item['total'] * $cgst_percentage;
                $sgst_amount = $item['total'] * $sgst_percentage;


                $voucherItem->gst_rate = $gst;
                $voucherItem->total_gst = $gst_amount;
                $voucherItem->sgst = $sgst_amount;
                $voucherItem->cgst = $cgst_amount;
                $voucherItem->total_after_disc = $item['rate_after_discount'] * $item['quantity'];
                $voucherItem->grand_total = $item['rate_after_discount'] * $item['quantity'] + $gst_amount;
                $totalcgst += $cgst_amount;
                $totalsgst += $sgst_amount;

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
                    $stock->vch_no = $vch_no; // Assuming vch_no is the field name
                    $stock->vch_type = $vch_type; // Assuming vch_no is the field name
                    $stock->gd_id = $request->gd_id;
                    $stock->created_by = auth()->id();
                    $stock->updated_by = auth()->id();
                    $stock->save();
                }
            }
            $vouchers->VchItems()->saveMany($voucherItems);
            if ($vch_type != 'order') {

                $transaction = new Transaction();

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
                        'debit' => in_array($vch_type, ['sale', 'purchase_return']) ? $request->grand_total : 0,
                        'credit' => in_array($vch_type, ['sale_return', 'purchase']) ? $request->grand_total : 0
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
            }
            return redirect()->route('vch.gst.index', ['vch_type' => $vch_type])->with("success", 'Inserted Successfully');
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
        $voucher = VchGstSalePurchase::find($id);
        foreach ($voucher->VchItems as $vi) {
            $vch_items[$vi->item_id] = $vi;
        }
        session()->put('vch_items', $vch_items);
        //       return(session('vch_items'));

        $params['voucher'] = $voucher;
        if (in_array($this->vch_type, ['sale', 'sale_return', 'order'])) {
            $accounts = Group::getAllLedgers([GROUP_SALES_ACCOUNTS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                                        $parties->balance = $parties->getBalance();

                unset($parties->name);
                return $parties;
            });
        } else {
            $accounts = Group::getAllLedgers([GROUP_PURCHASE_ACCOUNTS]);
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS, GROUP_CASH_IN_HAND])->map(function ($parties) {
                $parties->label = $parties->name;
                                        $parties->balance = $parties->getBalance();

                unset($parties->name);
                return $parties;
            });
        }
        $godowns = Godown::all();
  $items = Item::get()->map(function ($item) {
            // Sum the qty of the stocks for the current item_id
            $item->stock_qty = Stock::where('item_id', $item->id)->sum('quantity');

            // Modify the item as required
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
        return view('VchGstSalePurchase.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VchSalePurchase $vchSalePurchase, $vch_type, $voucher)
    {
        $vouchers = VchGstSalePurchase::find($voucher);
        DB::beginTransaction(); // Start a database transaction

        if ($vouchers) {

            Transaction::where('vch_no', $vouchers->vch_no)->delete();

            Stock::where('vch_no', $vouchers->vch_no)->delete();

            VchGstSalePurchaseItem::where('vch_id', $vouchers->id)->delete();

            //            $vouchers->delete();

            $item_list = session()->get('vch_items');
            $vch_items_data = session()->get('vch_items_data');
            try {

                //$vouchers = new VchGstSalePurchase();
                //$maxVchNo = VchGstSalePurchase::where('vch_type', $vch_type)->max('vch_no');
                //$vch_no = $maxVchNo + 1;
                $vouchers->ledger_id = $request->ledger_id;
                $vouchers->godown_id = $request->gd_id;
                //$vouchers->vch_type = $vch_type; // Assuming vch_no is the field name
                //$vouchers->vch_no = $vch_no;
                $vouchers->total = $vch_items_data['total'];
                //$vouchers->date = session('date');
                $vouchers->discount = $vch_items_data['total_discount'];
                $vouchers->cgst = $vch_items_data['total_cgst_amount'];
                $vouchers->sgst = $vch_items_data['total_sgst_amount'];
                $vouchers->igst = $vch_items_data['total_igst_amount'];
                $vouchers->total_gst = $vch_items_data['total_gst_amt'];
                $vouchers->total_after_taxes = $vch_items_data['grand_total_after_tax'];
                $vouchers->round_off = 0; // Assuming this field is optional and can be left blank
                $vouchers->grand_total = $vch_items_data['grand_total_after_tax'];


                $vouchers->date = session('date');

                $vouchers->save();

                $totalcgst = 0;
                $totalsgst = 0;
                $total_rate_after_discount = 0;
                $totaligst = 0;
                foreach ($item_list as $item) {
                    $voucherItem = new VchGstSalePurchaseItem();
                    $voucherItem->vch_id = $vouchers->id; // Assuming vch_no is the field name
                    $voucherItem->item_id = $item['item_id'];
                    $voucherItem->quantity = $item['quantity'];
                    $voucherItem->rate = $item['rate'];
                    $voucherItem->discount = $item['discount'];
                    $voucherItem->rate_after_discount = $item['rate_after_discount'];
                    $voucherItem->total = $item['total'];
                    $gst = $item['gst_rate']; // Assuming $item['gst'] represents the total GST rate

                    $gst_percentage = $gst / 100; // Total GST rate percentage converted to decimal
                    $cgst_percentage = $gst_percentage / 2; // CGST rate percentage
                    $sgst_percentage = $gst_percentage / 2; // SGST rate percentage

                    $gst_amount = $item['total'] * $gst_percentage;
                    $cgst_amount = $item['total'] * $cgst_percentage;
                    $sgst_amount = $item['total'] * $sgst_percentage;


                    $voucherItem->gst_rate = $gst;
                    $voucherItem->total_gst = $gst_amount;
                    $voucherItem->sgst = $sgst_amount;
                    $voucherItem->cgst = $cgst_amount;
                    $voucherItem->total_after_disc = $item['rate_after_discount'] * $item['quantity'];
                    $voucherItem->grand_total = $item['rate_after_discount'] * $item['quantity'] + $gst_amount;
                    $totalcgst += $cgst_amount;
                    $totalsgst += $sgst_amount;

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
                $vouchers->VchItems()->saveMany($voucherItems);
                if ($vch_type != 'order') {

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

                    // Set attributes specific to each transaction type
                    $transaction->ledger_id = $attributes['ledger_id'];
                    $transaction->particular = $attributes['particular'];
                    $transaction->debit = $attributes['debit'] ?? 0;
                    $transaction->credit = $attributes['credit'] ?? 0;

                    $transaction->created_by = auth()->id();
                    $transaction->updated_by = auth()->id();
                    $transaction->save();
                }
                }
                DB::commit();
                return redirect()->route('vch.gst.index', ['vch_type' => $vch_type])->with("success", 'Inserted Successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('vch.gst.index', ['vch_type' => $vch_type])->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VchGstSalePurchase $vchSalePurchase, $vch_type, $id)
    {
        try {
            Transaction::where('vch_no', $id)->delete();
            Stock::where('vch_no', $id)->delete();
            VchGstSalePurchaseItem::where('vch_id', $id)->delete();

            VchGstSalePurchase::where('id', $id)->delete();
            return redirect()->route('vch.gst.index', ['vch_type' => $vch_type])->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }
}
