<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Ledger;
use App\Models\transaction;
use App\Models\VchGstSalePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role->name == 'SuperAdmin') {
            $gd_id = 'All';
        } else {
            $gd_id = Auth::user()->gd_id;
        }
        $ledgers_receivable = Group::getAllLedgers([GROUP_SUNDRY_DEBTORS_CUSTOMERS]);
        $total_credit_receivable = 0;
        $total_debit_receivable = 0;

        foreach ($ledgers_receivable as $ledger) {
            if ($gd_id == 'All' || $ledger->godown_id == $gd_id) {
                // Assuming you have a method to retrieve transactions associated with a ledger
                $transactions = transaction::where('ledger_id', $ledger->id)->get();

                foreach ($transactions as $transaction) {
                    $total_credit_receivable += $transaction->credit;
                    $total_debit_receivable += $transaction->debit;
                }
            }
        }

        $total_balance_receivable = $total_credit_receivable - $total_debit_receivable;

        $ledgers_payable = Group::getAllLedgers([GROUP_SUNDRY_CREDITORS_SUPPLIERS]);
        $total_credit_payable = 0;
        $total_debit_payable = 0;
        foreach ($ledgers_payable as $ledger) {
            if ($gd_id == 'All' || $ledger->godown_id == $gd_id) {
                $transactions = transaction::where('ledger_id', $ledger->id)->get();
                foreach ($transactions as $transaction) {
                    $total_credit_payable += $transaction->credit;
                    $total_debit_payable += $transaction->debit;
                }
            }
        }
        $total_balance_payable = $total_credit_payable - $total_debit_payable;

        $start_date = session()->get('from_date');
        $end_date = session()->get('to_date');

        $countQuery = VchGstSalePurchase::where('vch_type', 'order')
            ->where('ref_no', NULL)
             ->whereNull('ref_type')
            ->whereNull('ref_id')
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date);

        if ($gd_id != 'All') {
            $countQuery->where('godown_id', $gd_id);
        }

        $count = $countQuery->count();


        $item_count_RM = DB::table('items')
            ->leftJoin('stocks', 'items.id', '=', 'stocks.item_id')
            ->select('items.id', DB::raw('SUM(stocks.quantity) as total_quantity'), 'items.min_stock_qty')
            ->where('items.type', 'RM')
            ->groupBy('items.id', 'items.min_stock_qty')
            ->havingRaw('SUM(stocks.quantity) <= MIN(items.min_stock_qty)')
            ->get()
            ->count();

        $item_count_FG = DB::table('items')
            ->leftJoin('stocks', 'items.id', '=', 'stocks.item_id')
            ->select('items.id', DB::raw('SUM(stocks.quantity) as total_quantity'), 'items.min_stock_qty')
            ->where('items.type', 'FG')
            ->groupBy('items.id', 'items.min_stock_qty')
            ->havingRaw('SUM(stocks.quantity) <= MIN(items.min_stock_qty)')
            ->get()
            ->count();
        $days = 30;
        $customer_count = DB::table('vch_payment_receipts')
            ->join('ledgers', 'vch_payment_receipts.ledger_id', '=', 'ledgers.id')
            ->where('ledgers.group_id', GROUP_SUNDRY_DEBTORS_CUSTOMERS)
            ->where('vch_payment_receipts.date', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $days . ' DAY)'))
            ->where('vch_payment_receipts.amount', '>', 0)
            ->where('vch_payment_receipts.vch_type', 'receipt')
            ->distinct('vch_payment_receipts.ledger_id')
            ->count('vch_payment_receipts.ledger_id');
        return view('home')->with([
            'total_balance_receivable' => $total_balance_receivable,
            'total_balance_payable' => $total_balance_payable,
            'count' => $count,
            'item_count_RM' => $item_count_RM,
            'item_count_FG' => $item_count_FG,
            'customer_count' => $customer_count
            // Add more data as needed
        ]);
    }
}
