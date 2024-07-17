<?php

namespace App\Http\Controllers;

use App\Models\Mpin;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\transaction;
use App\Models\VchGstSalePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MpinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return session()->all();'
        session()->forget('mpin_authenticated');

        return view('auth.mpin');
    }

    public function create()
    {
        return view('auth.mpincreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $pin = $request->input('pin'); // Get the PIN from the request
            $confirmedPin = $request->input('confirm_pin'); // Get the confirmed PIN from the request

            $user = Auth::user(); // Retrieve the authenticated user

            if ($pin === $confirmedPin) {
                $user->pin = $pin; // Set the PIN for the user
                $user->save(); // Save the user's PIN to the database
                return view('auth.mpin'); // Redirect to the mpinblade page
            } else {
                throw ValidationException::withMessages(['pin' => 'The PIN and confirmed PIN do not match.']);
            }
        } catch (ValidationException $e) {
            // Handle validation errors, such as PIN mismatch
            return redirect()->back()->withErrors($e->errors())->withInput($request->only('mobile'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mpin $mpin)
    {
        // Implementation for showing MPIN
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mpin $mpin)
    {
        // Implementation for editing MPIN
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mpin $mpin)
    {
        // Implementation for updating MPIN
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mpin $mpin)
    {
        // Implementation for deleting MPIN
    }

    public function mpin(Request $request)
    {
        $gd_id = 'All';

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


        $user = Auth::user(); // Retrieve the authenticated user
        $user_pin = $user->pin;
        $pin = $request->input('pin');

        if ($user_pin == $pin) {
            //return view('home'); // Redirect to the home view
               session(['mpin_authenticated' => true]);
                session()->put('pin', $pin);
      if (session('pin_url') != NULL) {
                      return redirect(session('pin_url'));
       // return redirect()->route(session('pin_url'));
    }else{
    return redirect()->intended('/home')->with([
        'total_balance_receivable' => $total_balance_receivable,
        'total_balance_payable' => $total_balance_payable,
        'count' => $count,
        'item_count_RM' => $item_count_RM,
        'item_count_FG' => $item_count_FG,
        'customer_count' => $customer_count
        // Add more data as needed
    ]);
        
    }

        } else {
            return redirect()->back()->with('error', 'Invalid PIN'); // Redirect back with error message
        }
    }
}
