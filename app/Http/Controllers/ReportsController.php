<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Reports;
use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Group;
use App\Models\VchSalePurchase;
use App\Models\VchGstSalePurchase;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\stock;
use App\Models\transaction;
use App\Models\VchGstSalePurchaseItem;
use App\Models\VchPaymentReceipt;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Reports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }
     public function voucherindex()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.godownwise-voucher', compact('godowns'));
    }
    public function voucherreport(Request $request)
    {
        $vch_type = $request->vch_type;
        $godown_id = $request->godown_id;
        $start_date = session('from_date');
        $end_date = session('to_date');
        if ($vch_type != 'order') {
            if ($godown_id != 'All') {
                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->where('godown_id', $godown_id)
                    ->get();
            } else {
                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            }
        } else {
            if ($godown_id != 'All') {

                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereNull('ref_type')
                    ->whereNull('ref_id')
                    ->where('godown_id', $godown_id)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            } else {
                $vouchers = VchGstSalePurchase::where('vch_type', $vch_type)
                    ->whereNull('ref_type')
                    ->whereNull('ref_id')
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
            }
        }
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        if ($godown_id != 'All') {
            $godown_data = Godown::find($godown_id);
            $godown_data = $godown_data->name;
        } else {
            $godown_data = 'All Godowns';
        }
        return view('Reports.godownwise-voucher', compact('vouchers', 'godowns', 'vch_type', 'godown_data'));
    }

    public function report30daysdebtors()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.30-day-debtor', compact('godowns'));
    }

    public function generateReport(Request $request)
    {
        /*    $days = $request->input('days', 30);
        $godown_id = $request->godown_id;
        if ($godown_id != 'All') {
            $debtors = DB::table('vch_payment_receipts')
                ->join('ledgers', 'vch_payment_receipts.ledger_id', '=', 'ledgers.id')
                ->where('ledgers.group_id', GROUP_SUNDRY_DEBTORS_CUSTOMERS)
                ->where('ledgers.gd_id', $godown_id)
                ->where('vch_payment_receipts.date', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $days . ' DAY)'))
                ->where('vch_payment_receipts.amount', '>', 0)
                ->where('vch_payment_receipts.vch_type', 'receipt')
                ->distinct()
                ->select('vch_payment_receipts.ledger_id', 'vch_payment_receipts.amount', 'vch_payment_receipts.date', 'ledgers.name', 'ledgers.mobile')
                ->get();
        } else {
            $debtors = DB::table('vch_payment_receipts')
                ->join('ledgers', 'vch_payment_receipts.ledger_id', '=', 'ledgers.id')
                ->where('ledgers.group_id', GROUP_SUNDRY_DEBTORS_CUSTOMERS)
                ->where('vch_payment_receipts.date', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $days . ' DAY)'))
                ->where('vch_payment_receipts.amount', '>', 0)
                ->where('vch_payment_receipts.vch_type', 'receipt')
                ->distinct()
                ->select('vch_payment_receipts.ledger_id', 'vch_payment_receipts.amount', 'vch_payment_receipts.date', 'ledgers.name', 'ledgers.mobile')
                ->get();
        } */
        $godown_id = $request->godown_id;

        $days = $request->input('days', 1); // Default to 1 if 'days' not provided

        if ($godown_id != 'All') {

            $allLedgers = Group::getAllLedgers(([GROUP_SUNDRY_DEBTORS_CUSTOMERS]))->where('gd_id', $godown_id);
        } else {
            $allLedgers = Group::getAllLedgers(([GROUP_SUNDRY_DEBTORS_CUSTOMERS]));
        }

        $data = [];

        foreach ($allLedgers as $ledger) {
            $total_credit = Transaction::where('ledger_id', $ledger->id)->sum('credit');
            $total_debit = Transaction::where('ledger_id', $ledger->id)->sum('debit');

            $balance = $total_credit - $total_debit;
            $balance = abs($balance);

            // Check if there is an entry for this ledger_id in the receipt table
            $receiptCount = VchPaymentReceipt::where('ledger_id', $ledger->id)
                ->where('date', '>=', Carbon::now()->subDays($days)->format('Y-m-d'))
                ->count();

            if ($receiptCount > 0 && $balance > 0) {
                $data[] = [
                    'ledger_id' => $ledger->id,
                    'name' => $ledger->name,
                    'mobile_no' => $ledger->mobile,
                    'balance' => $balance
                ];
            }
        }

        //   return view('ledger.index', ['data' => $data]);
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.30-day-debtor', ['data' => $data, 'godowns' => $godowns]);
    }

    // public function godownstock(Request $request)
    // {
    //     $godowns = Godown::all();

    //     $items_data = Item::all();

    //     return view('reports.godown-wise', compact('godowns', 'items_data'));
    // }
    public function get_stock_totals($id)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        $ledger_ids = [$this->$id];

        $stock_ob = stock::whereIn('gd_id', $ledger_ids)
            ->where('date', '<', $from_date)
            ->get();
        $outward = stock::whereIn('gd_id', $ledger_ids)
            ->whereBetween('date', [$from_date, $to_date])
            ->get();
        $inward = stock::whereIn('gd_id', $ledger_ids)
            ->whereIn('vch_type', ['sale', 'purchase_return'])
            ->whereBetween('date', [$from_date, $to_date])->get();
        $opening_stock = $stock_ob->sum('quantity');

        $inward = $inward->sum('quantity');
        $outward = $outward->sum('quantity');

        return ['inward' => $inward, 'outward' => $outward, 'opening_stock' => $opening_stock];
    }


    public function godownstock_report(Request $request)
    {
        $godowns = Godown::all();

        $from_date = session('from_date');
        $to_date = session('to_date');

        $gd_id = $request->godown_id;

        $items=Item::all();

        return view('Reports.godown-wise', compact('items','gd_id','godowns'));
        // Fetch stock data based on godown ID
        if ($gd_id != 'All') {
            $items_data = Stock::where('gd_id', $gd_id)->get();
        } else {
            $items_data = Stock::all();
        }

        // Calculate opening balance
        $openingBalanceQuery = Stock::select('item_id', DB::raw('SUM(quantity) as opening_balance'))
            ->where('date', '<', $from_date);

        if ($gd_id != 'All') {
            $openingBalanceQuery->where('gd_id', $gd_id);
        }

        $openingBalance = $openingBalanceQuery->groupBy('item_id')->get();

        // Calculate inward quantities
        $inwardQuery = Stock::select('item_id', DB::raw('SUM(quantity) as inward'))
            ->whereBetween('date', [$from_date, $to_date])
            ->where('quantity', '>', 0);

        if ($gd_id != 'All') {
            $inwardQuery->where('gd_id', $gd_id);
        }

        $inward = $inwardQuery->groupBy('item_id')->get();

        // Calculate outward quantities
        $outwardQuery = Stock::select('item_id', DB::raw('SUM(quantity) as outward'))
            ->whereBetween('date', [$from_date, $to_date])
            ->where('quantity', '<', 0);

        if ($gd_id != 'All') {
            $outwardQuery->where('gd_id', $gd_id);
        }

        $outward = $outwardQuery->groupBy('item_id')->get();

        return view('Reports.godown-wise', compact('items_data', 'openingBalance', 'godowns', 'inward', 'outward'));
    }

    public function inactive()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        $groups_data = Group::where('is_enabled', 1)->get();
        return view('reports.inactive-customer', compact('groups_data', 'godowns'));
    }
    public function inactivereport(Request $request)
    {
        $group_id = $request->input('group_id');
        $type = $request->input('type');
        $godown_id = $request->godown_id;
        $from_date = session('from_date');
        $to_date = session('to_date');
        $groups_data = Group::where('is_enabled', 1)->get();
        $accounts = Group::getAllLedgers([$group_id]);

        if ($godown_id != 'All') {
            $ledger_ids = $accounts->filter(function ($account) use ($godown_id) {
                return $account->gd_id == $godown_id;
            })->pluck('id')->toArray();
        } else {
            $ledger_ids = $accounts->pluck('id')->toArray();
        }
        if ($godown_id != 'All') {
            $voucher = VchGstSalePurchase::where('vch_type', $type)
                ->where('godown_id', $godown_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        } else {

            $voucher = VchGstSalePurchase::where('vch_type', $type)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        }

        $voucher_ledger_ids = $voucher->pluck('ledger_id')->toArray();
        $difference = array_diff($ledger_ids, $voucher_ledger_ids);
        $ledgerIdArray = [];

        foreach ($difference as $ledgerId) {
            $ledgerIdArray[] = ["ledger_id" => $ledgerId];
        }

        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }

        return view('Reports.inactive-customer', compact('group_id', 'groups_data', 'type', 'ledgerIdArray', 'godowns'));
    }
    public function ordersaledifferenceview()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.order-sale-difference', compact('godowns'));
    }
    public function ordersaledifference(Request $request)
    {
        $godown_id = $request->godown_id;
        $from_date = session('from_date');
        $to_date = session('to_date');

        if ($godown_id != 'All') {
            $sale_data = VchGstSalePurchase::where('vch_type', 'sale')
                ->where('ref_type', 'order')
                ->where('godown_id', $godown_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();

            $order_ids = $sale_data->pluck('ref_id')->toArray();

            $order_data = VchGstSalePurchase::whereIn('id', $order_ids)
                ->where('vch_type', 'order')
                ->where('godown_id', $godown_id)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        } else {
            $sale_data = VchGstSalePurchase::where('vch_type', 'sale')
                ->where('ref_type', 'order')
                ->whereBetween('date', [$from_date, $to_date])
                ->get();

            $order_ids = $sale_data->pluck('ref_id')->toArray();

            $order_data = VchGstSalePurchase::whereIn('id', $order_ids)
                ->where('vch_type', 'order')
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        }

        $itemQuantities = [];

        // Process sale data
        foreach ($sale_data as $saleItem) {
            $vchNo = $saleItem['vch_no'];
            $ledgerId = $saleItem['ledger_id'];
            $date = $saleItem['date'];
            foreach ($saleItem->VchItems as $saleItems) {
                $itemId = $saleItems['item_id'];
                $qty = $saleItems['quantity'];

                // Initialize array if not already initialized
                if (!isset($itemQuantities[$ledgerId][$itemId])) {
                    $itemQuantities[$ledgerId][$itemId] = [
                        'item_id' => $itemId,
                        'vch_no' => $vchNo,
                        'ledger_id' => $ledgerId,
                        'date' => $date,
                        'sale_qty' => 0,
                        'order_qty' => 0,
                    ];
                }

                // Add sale quantity
                $itemQuantities[$ledgerId][$itemId]['sale_qty'] += $qty;
            }
        }

        // Process order data
        foreach ($order_data as $order) {
            foreach ($order->VchItems as $orderItem) {
                $ledgerId = $order['ledger_id'];
                $itemId = $orderItem['item_id'];
                $qty = $orderItem['quantity'];

                // Initialize array if not already initialized
                if (!isset($itemQuantities[$ledgerId][$itemId])) {
                    $itemQuantities[$ledgerId][$itemId] = [
                        'item_id' => $itemId,
                        'ledger_id' => $ledgerId,
                        'sale_qty' => 0,
                        'order_qty' => 0,
                    ];
                }

                // Add order quantity
                $itemQuantities[$ledgerId][$itemId]['order_qty'] += $qty;
            }
        }
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }

        return view('Reports.order-sale-difference', compact('itemQuantities', 'godowns'));
    }



  public function order(Reports $reports)
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }

        return view('Reports.order', compact('godowns'));
    }
    public function customer(Request $request)
    {
        $godown_id = $request->input('godown_id');

        $from_date = session('from_date');
        $to_date = session('to_date');
        if ($godown_id != 'All') {
            $parties_data = VchGstSalePurchase::where('vch_type', 'order')
                ->where('godown_id', $godown_id)
                ->whereNull('ref_type')
                ->whereNull('ref_id')
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        } else {
            $parties_data = VchGstSalePurchase::where('vch_type', 'order')
                ->whereNull('ref_type')
                ->whereNull('ref_id')->get();
        }

        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.order', compact('parties_data', 'godowns'));
    }


  public function highestcustomer(Request $request)
    {
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.most-buying-ledgers', compact('godowns'));
    }
    public function type(Request $request)
    {
        $total = 0;
        $type = $request->input('type', $request['type']);
        $godown_id = $request->godown_id;
        if ($godown_id != 'All') {
            $ledgers = VchGstSalePurchase::selectRaw('ledger_id, SUM(grand_total) AS total_amount')
                ->where('vch_type', $type)
                ->where('godown_id', $godown_id)
                ->whereBetween('date', [session('from_date'), session('to_date')])
                ->groupBy('ledger_id')

                ->orderByDesc('total_amount')
                ->get();

            $ledgers;
            foreach ($ledgers as $ledger) {
                $total += $ledger->total_amount;
                // $ledger->user->name;
            }
        } else {

            $ledgers = VchGstSalePurchase::selectRaw('ledger_id, SUM(grand_total) AS total_amount')
                ->where('vch_type', $type)
                ->whereBetween('date', [session('from_date'), session('to_date')])
                ->groupBy('ledger_id')
                ->orderByDesc('total_amount')
                ->get();

            $ledgers;
            foreach ($ledgers as $ledger) {
                $total += $ledger->total_amount;
                // $ledger->user->name;
            }
        }
        if (Auth::user()->role->name == 'SuperAdmin') {

            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.most-buying-ledgers', compact('ledgers', 'total', 'godowns'));
    }
     public function ordersummaryview()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.order-summary', compact('godowns'));
    }
    public function ordersummary(Request $request)
    {

        $godown_id = $request->godown_id;
        if ($godown_id != 'All') {

                 $vouchers = VchGstSalePurchase::where('vch_type', 'order')
                ->where('ref_id')
                ->where('godown_id', $godown_id)
                ->pluck('id');
        } else {
            $vouchers = VchGstSalePurchase::where('vch_type', 'order')
                ->where('ref_id')
                ->pluck('id');
        }


        $data = [];
        foreach ($vouchers as $vch_no) {
            $vchItems = VchGstSalePurchaseItem::where('vch_id', $vch_no)
                ->get();

            foreach ($vchItems as $vi) {
                // return $vi;
                if (isset($data[$vi->item_id])) {
                    $data[$vi->item_id]['quantity'] += $vi->quantity;
                } else {
                    $data[$vi->item_id]['quantity'] = $vi->quantity;
                    $data[$vi->item_id]['item_name'] = $vi->item_data->name;

                    if ($godown_id != 'All') {
                        $stock = DB::table('stocks')
                            ->where('item_id', $vi->item_id)
                            ->where('gd_id', auth()->user()->gd_id)
                            ->sum('quantity');
                    } else {
                        $stock = DB::table('stocks')
                            ->where('item_id', $vi->item_id)
                            ->sum('quantity');
                    }
                    $data[$vi->item_id]['stock'] = $stock;
                }
            }
        }
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.order-summary', compact('data', 'godowns'));
    }


     public function trail_balance_view(Request $request)
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.trail-balance', compact('godowns'));
    }
    public function trail_balance(Request $request)
    {
        $godown_id = $request->godown_id;
        if ($godown_id != 'All') {
            $includeIds = [1, 2, 3, 4, 5, 6]; // Add the IDs you want to include
            $ledgers = Ledger::where(function ($query) use ($godown_id, $includeIds) {
                $query->where('gd_id', $godown_id)
                    ->orWhereIn('id', $includeIds);
            })->get();
        } else {
            $ledgers = Ledger::all();
        }

        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.trail-balance', compact('ledgers', 'godowns'));
    }


  public function minstockqtyview()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.minstockqty', compact('godowns'));
    }
    public function minstockqty(Request $request)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');

        $godown_id = $request->godown_id;
        if ($godown_id != 'All') {
            $minStockQty = DB::table('items')
                ->leftJoin('stocks', 'items.id', '=', 'stocks.item_id')
                ->select('items.name', DB::raw('COALESCE(SUM(stocks.quantity), 0) AS total_quantity'))
                ->groupBy('items.id', 'items.name')
                ->havingRaw('SUM(stocks.quantity) <= MIN(items.min_stock_qty)')
                ->whereBetween('date', [$from_date, $to_date])
                ->where('stocks.gd_id', $godown_id)
                ->get();
        } else {
            $minStockQty = DB::table('items')
                ->leftJoin('stocks', 'items.id', '=', 'stocks.item_id')
                ->select('items.name', DB::raw('COALESCE(SUM(stocks.quantity), 0) AS total_quantity'))
                ->groupBy('items.id', 'items.name')
                ->havingRaw('SUM(stocks.quantity) <= MIN(items.min_stock_qty)')
                ->whereBetween('date', [$from_date, $to_date])
                ->get();
        }

        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.minstockqty', compact('minStockQty', 'godowns'));
    }
    public function bank(Reports $reports)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        /* 


        $banks = DB::table('ledgers')
            ->select(
                'ledgers.id',
                'ledgers.name',
                DB::raw('SUM(transactions.credit) as total_credit'),
                DB::raw('SUM(transactions.debit) as total_debit')
            )
            ->leftJoin('transactions', 'transactions.ledger_id', '=', 'ledgers.id')
            ->leftJoin('groups', 'ledgers.group_id', '=', 'groups.id')
            ->whereIn('groups.group_name', ['Cash-in-hand', 'Bank Accounts'])
            ->groupBy('ledgers.id', 'ledgers.name')
            ->get();
 */
        $banks = Ledger::where(function ($query) {
            $query->where('group_id', GROUP_BANK_ACCOUNTS)
                ->orWhere('group_id', GROUP_CASH_IN_HAND);
        })->get();

        return view('Reports.bank', compact('banks'));
    }
    public function groupindex(Reports $reports)
    {
        $groups_data = Group::where('is_enabled', 1)->get();
        return view('Reports.group', compact('groups_data'));
    }
    public function groupreport(Request $request)
    {
        $group_id = $request->input('group_id');
        $from_date = session('from_date');
        $to_date = session('to_date');
        $groups_data = Group::where('is_enabled', 1)->get();

        $groups = Group::where('parent_id', $group_id)->get();
        $ledgers = Ledger::where('group_id', $group_id)->get();

        $group_name = Group::where('id', $group_id)->value('group_name');
        return view('Reports.group', compact('groups', 'ledgers', 'group_name', 'groups_data', 'group_id'));
    }

  public function payableview()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.payable', compact('godowns'));
    }
    public function  payable(Request $request)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        $godown_id = $request->godown_id;
        $groups = Group::where('parent_id', GROUP_SUNDRY_CREDITORS_SUPPLIERS)->get();
        if ($godown_id != 'All') {
            $parties = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS])
                ->where('gd_id', $godown_id);
        } else {
            $parties = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS]);
        }

        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.payable', compact('parties', 'groups', 'godowns'));
    }

    public function receivableview()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.receivable', compact('godowns'));
    }

    public function  receivable(Request $request)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        /*   $groups = Group::where('parent_id', GROUP_SUNDRY_DEBTORS_CUSTOMERS)->get();
        /*      $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);
    */
        $godown_id = $request->godown_id;


        $groups = Group::where('parent_id', GROUP_SUNDRY_DEBTORS_CUSTOMERS)->get();

        if ($godown_id != 'All') {
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS])
                ->where('gd_id',$godown_id);

        } else {
            $parties = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);

        }
        if (Auth::user()->role->name == 'SuperAdmin') {
            $godowns = Godown::all();
        } else {
            $godowns = Godown::where('id', Auth::user()->gd_id)->get();
        }
        return view('Reports.receivable', compact('parties', 'groups', 'godowns'));

        //  return view('reports.group', compact('groups', 'ledgers', 'group_name', 'from_date', 'to_date', 'groups_data'));
    }


    public function day(Request $request)
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        $results = \App\Models\transaction::select(
            'ledger_id',
            'vch_type',
            'vch_no',
            DB::raw('MIN(date) as date'),
            DB::raw('SUM(credit) as credit'),
            DB::raw('SUM(debit) as debit')
        )
            ->where('vch_type', '!=', 'opening_balance')
            ->whereBetween('date', [$from_date, $to_date])
            ->groupBy('ledger_id', 'vch_type', 'vch_no')
            ->with('ledger') // Eager load the ledger relationship
            ->get();

        $totalDebit = $results->sum('debit');
        $totalCredit = $results->sum('credit');

        return view('Reports.day', compact('results', 'totalDebit', 'totalCredit'));
        //return view('reports.day', compact('results'));
    }

    public function sale_report(Reports $reports, $vch_type)
    {
        // Define financial year start and end dates
        $financialYearStart = session('fy_start_date'); // April 1st of current year
        $financialYearEnd = session('fy_end_date'); // March 31st of next year

        // Get all months and their respective counts and totals for the financial year
             if (Auth::user()->role->name == 'SuperAdmin') {
            $SalePurchaseReport = VchGstSalePurchase::selectRaw("DATE_FORMAT(date, '%Y-%m') AS month")
                ->selectRaw("COUNT(*) AS count")
                ->selectRaw("SUM(grand_total) AS total")
                ->where('vch_type', $vch_type)
                ->whereBetween('date', [$financialYearStart, $financialYearEnd])
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();
        } else {
            $SalePurchaseReport = VchGstSalePurchase::selectRaw("DATE_FORMAT(date, '%Y-%m') AS month")
                ->selectRaw("COUNT(*) AS count")
                ->selectRaw("SUM(grand_total) AS total")
                ->where('vch_type', $vch_type)
                ->where('godown_id', Auth::user()->gd_id)
                ->whereBetween('date', [$financialYearStart, $financialYearEnd])
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();
        }
        // Generate an array containing all months of the financial year with month names
        $monthNames = [
            '04' => 'April', '05' => 'May', '06' => 'June',
            '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
            '01' => 'January', '02' => 'February', '03' => 'March',
        ];

        // Initialize array with all months and initial values
        $allMonths = [];
        foreach ($monthNames as $monthNumber => $monthName) {
            $allMonths[$monthName] = (object) [
                'month' => $monthName,
                'year' => date('Y'), // Set the current year as default
                'count' => 0,
                'total' => 0,
            ];
        }

        // Merge actual data into all months array
        foreach ($SalePurchaseReport as $reportItem) {
            $monthYear = explode('-', $reportItem->month);
            $monthNumber = $monthYear[1]; // Extract month portion from 'YYYY-MM' format
            $monthName = $monthNames[$monthNumber];
            $allMonths[$monthName]->year = $monthYear[0]; // Extract year
            $allMonths[$monthName]->count = $reportItem->count;
            $allMonths[$monthName]->total = $reportItem->total;
        }

        // Convert the associative array back to a simple array
        $formattedReport = array_values($allMonths);

        return view('Reports.vchsalepurchase', compact('formattedReport', 'vch_type'));
    }
 public function ledgerview(Request $request, $id)
    {

        /*   $ledger = Ledger::find($ledger_id);
        $reportData = [];

        $grand_total_opening_cr = $grand_total_opening_dr = 0;
        $grand_total_debit = $grand_total_credit = 0;

        $debit_ob = Transaction::where('ledger_id', $ledger_id)
            ->where('date', '<', $from_date)
            ->sum('debit');
        $credit_ob = Transaction::where('ledger_id', $ledger_id)
            ->where('date', '<', $from_date)
            ->sum('credit');

        $opening_balance_cr = $opening_balance_dr = 0;
        $opening_balance_text = '';

        if ($credit_ob > $debit_ob) {
            $grand_total_opening_cr += $opening_balance_cr = $credit_ob - $debit_ob;
            $opening_balance_text = $opening_balance_cr . " cr";
        } else {
            $grand_total_opening_dr += $opening_balance_dr = $debit_ob - $credit_ob;
            $opening_balance_text = $opening_balance_dr . " dr";
        }

        $debit_of_ledger_between_date = Transaction::where('ledger_id', $ledger_id)
            ->whereBetween('date', [$from_date, $to_date])
            ->sum('debit');
        $credit_of_ledger_between_date = Transaction::where('ledger_id', $ledger_id)
            ->whereBetween('date', [$from_date, $to_date])
            ->sum('credit');

        $grand_total_debit += $debit_of_ledger_between_date;
        $grand_total_credit += $credit_of_ledger_between_date;

        $total_credit_of_ledger = $opening_balance_cr + $credit_of_ledger_between_date;
        $total_debit_of_ledger = $opening_balance_dr + $debit_of_ledger_between_date;

        $closing_balance_cr = $closing_balance_dr = 0;
        $closing_balance_text = '';

        if ($total_credit_of_ledger > $total_debit_of_ledger) {
            $closing_balance_cr = $total_credit_of_ledger - $total_debit_of_ledger;
            $closing_balance_text = $closing_balance_cr . " cr";
        } else {
            $closing_balance_dr = $total_debit_of_ledger - $total_credit_of_ledger;
            $closing_balance_text = $closing_balance_dr . " dr";
        }

        $reportData[] = [
            'ledger_name' => $ledger->name,
            'opening_balance_text' => $opening_balance_text,
            'debit_of_ledger_between_date' => $debit_of_ledger_between_date,
            'credit_of_ledger_between_date' => $credit_of_ledger_between_date,
            'closing_balance_text' => $closing_balance_text,
        ];

        if ($grand_total_opening_cr > $grand_total_opening_dr) {
            $grand_opening_text = $grand_total_opening_cr - $grand_total_opening_dr . " cr";
        } else {
            $grand_opening_text = $grand_total_opening_dr - $grand_total_opening_cr . " dr";
        }

        if ($grand_total_credit > $grand_total_debit) {
            $grand_closing_text = $grand_total_credit - $grand_total_debit . " cr";
        } else {
            $grand_closing_text = $grand_total_debit - $grand_total_credit . " dr";
        }

        
 */
        // Calculate opening balance
   $openingBalance_credit = Transaction::where('ledger_id', $id)
            ->where('date', '<', session('from_date'))
            ->sum('credit');

        $openingBalance_debit = Transaction::where('ledger_id', $id)
            ->where('date', '<', session('from_date'))
            ->sum('debit');
        $openingBalance = Transaction::where('ledger_id', $id)
            ->where('vch_type', 'opening_balance')
            ->get();

        $creditSum = $openingBalance->sum('credit');
        $debitSum = $openingBalance->sum('debit');


        $calculated_opening_balance = $openingBalance_debit - $openingBalance_credit + $creditSum + $debitSum;

        // Determine the opening balance with the appropriate suffix
        $openingBalance = $calculated_opening_balance >= 0
            ? $calculated_opening_balance . " Dr"
            : abs($calculated_opening_balance) . " Cr";

        // Get the ledgers within the date range
        $ledgers = Transaction::where('ledger_id', $id)
            ->whereBetween('date', [session('from_date'), session('to_date')])
            ->where('vch_type', '!=', 'opening_balance')
            ->orderBy('date', 'asc')
            ->get();
        // Initialize totals
        $total_debit = 0;
        $total_credit = 0;

        // Calculate total debits and credits
        foreach ($ledgers as $ledger) {
            $total_debit += $ledger->debit;
            $total_credit += $ledger->credit;
        }

        // Calculate closing balance
        $calculated_closing_balance = $calculated_opening_balance + $total_debit - $total_credit;

        // Determine the closing balance with the appropriate suffix
        $closingBalance = $calculated_closing_balance >= 0
            ? $calculated_closing_balance . " Dr"
            : abs($calculated_closing_balance) . " Cr";

        return view('Reports.ledgerview', [
            'ledgers' => $ledgers,
            'ledger_id' => $id,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'grand_total_debit' => $total_debit,
            'grand_total_credit' => $total_credit,
            'openingBalance_credit' => $openingBalance_credit,
            'openingBalance_debit' => $openingBalance_debit
        ]);
        //        return view('Reports.ledgerview', compact('ledger_id', 'ledgers', 'particulars'));

        //        return view('Reports.ledgerview', compact('ledgers', 'ledger_id', 'particulars'));
    }
}
