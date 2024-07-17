<?php

namespace App\Http\Controllers;

use App\Models\VchPaymentReceipt;
use App\Models\Group;
use App\Models\Ledger;

use App\Models\Mode;
use App\Models\transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VchPaymentReceiptController extends Controller
{

    public $vch_type;

    public function __construct(Request $request)
    {
        $this->vch_type = $request->vch_type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($vch_type)
    {
        $start_date=session('from_date');
        $end_date=session('to_date');

$vouchers = VchPaymentReceipt::where('vch_type', $vch_type)
    ->whereBetween('date', [$start_date, $end_date])
    ->get();

        return view('VchPaymentReceipt.index', [
            'vch_type' => $this->vch_type,
            'Vouchers' => $vouchers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $type)
    {
        // $vchPaymentReceipt=new VchPaymentReceipt();
        $banks = Group::getAllLedgers([GROUP_BANK_ACCOUNTS, GROUP_CASH_IN_HAND]);
        $modes = Mode::all();
        $parties = Group::getAllLedgers([GROUP_BANK_ACCOUNTS, GROUP_DUTIES_TAXES, GROUP_SALES_ACCOUNTS, GROUP_PURCHASE_ACCOUNTS, GROUP_CASH_IN_HAND], 'out');

        $parties = collect($parties)->map(function ($party) {
            $party['label'] = $party['name']; // Set label
            unset($party['name']); // Unset name
            // Add other properties as needed
            return $party; // Return modified party
        });

        $vouchers = VchPaymentReceipt::where(['vch_type' => $type, 'date' => session('date')])->get();


        //   $party->label = $party->name;
        //     unset($party->name);
        //     return $party;


        $params['vch_type'] = $this->vch_type;
        //  $params['id'] = $id;
        $params['modes'] = $modes;
        $params['banks'] = $banks;
        $params['parties'] = $parties;
        $params['vouchers'] = $vouchers;


        return view('VchPaymentReceipt.create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $vch_type)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            $voucher = new VchPaymentReceipt();
            $mode = Mode::findOrFail($request->mode);
            $modeName = $mode->value;
            $maxVchNo = VchPaymentReceipt::where('vch_type', $vch_type)->max('vch_no');
            $vch_no = $maxVchNo + 1;
            $voucher->ledger_id = $request->ledger_id;
            $voucher->amount = $request->amount;
            $voucher->date = session('date');
            $voucher->mode = $modeName;
            $voucher->vch_no = $vch_no;
            $voucher->vch_type = $vch_type;
            $voucher->from = $request->bank_id;
            $voucher->details = $request->details;
            $voucher->created_by = auth()->id();
            $voucher->updated_by = auth()->id();
            $voucher->save();

            $transactionTypes = [
                'payment' => [
                    'account' => ['debit' => 0, 'credit' => $request->amount, 'ledger_id' => $request->bank_id],
                    'ledger' => ['debit' => $request->amount, 'credit' => 0, 'ledger_id' => $request->ledger_id]
                ],
                'receipt' => [
                    'account' => ['debit' => $request->amount, 'credit' => 0, 'ledger_id' => $request->bank_id],
                    'ledger' => ['debit' => 0, 'credit' => $request->amount, 'ledger_id' => $request->ledger_id]
                ]
            ];
            $ledger_name = Ledger::find($request->ledger_id);
            $account_name = Ledger::find($request->bank_id);

            if ($vch_type == 'payment') {
                $particular_bank = 'To ' . $ledger_name->name . ' [ Mode: ' . $modeName . ' ] ';
                $particular_ledger = 'From ' .  $account_name->name . ' [ Mode: ' . $modeName . ' ]';
            } else {
                $particular_ledger = 'To ' . $account_name->name . ' [ Mode: ' . $modeName . ' ] ';
                $particular_bank = 'From ' . $ledger_name->name . ' [ Mode: ' . $modeName . ' ] ';
            }

            foreach ($transactionTypes[$vch_type] as $particular => $attributes) {
                $transaction = new Transaction();
                $mode = Mode::findOrFail($request->mode);
                $modeName = $mode->value;
                $transaction->date = session('date');
                $transaction->vch_type = $vch_type;
                $transaction->vch_no = $vch_no;
                $transaction->ref_id = ($particular === 'account') ? $request->ledger_id : $request->bank_id;
                $transaction->ledger_id = $attributes['ledger_id'];
                if ($particular == 'account') {
                    $transaction->particular = $particular_bank;
                } else {

                    $transaction->particular = $particular_ledger;
                }
                $transaction->mode = $modeName;
                $transaction->debit = $attributes['debit'] ?? 0;
                $transaction->credit = $attributes['credit'] ?? 0;
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('vch.pr.create', ['vch_type' => $vch_type])->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if there is an error
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VchPaymentReceipt $vchPaymentReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($vch_type, $vch_no)
    {
        $voucher = VchPaymentReceipt::where(['vch_type' => $vch_type, 'vch_no' => $vch_no])->first();

        $banks = Group::getAllLedgers([GROUP_BANK_ACCOUNTS, GROUP_CASH_IN_HAND]);
        $modes = Mode::all();
        $parties = Group::getAllLedgers([GROUP_BANK_ACCOUNTS, GROUP_DUTIES_TAXES, GROUP_SALES_ACCOUNTS, GROUP_PURCHASE_ACCOUNTS, GROUP_CASH_IN_HAND], 'out');

        $parties = collect($parties)->map(function ($party) {
            $party['label'] = $party['name']; // Set label
            unset($party['name']); // Unset name
            return $party; // Return modified party
        });

        $params = [
            'vch_type' => $vch_type,
            'vch_no' => $vch_no,
            'modes' => $modes,
            'banks' => $banks,
            'parties' => $parties,
            'voucher' => $voucher,
        ];

        return view('VchPaymentReceipt.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vch_type, $vch_no)
    {
        DB::beginTransaction(); // Start a database transaction
        try {
            $voucher = VchPaymentReceipt::where('vch_no', $vch_no)->where('vch_type', $vch_type)->first();
            if (!$voucher) {
                return redirect()->back()->with('error', 'Voucher not found.');
            }
            Transaction::where('vch_no', $voucher->vch_no)->where('vch_type', $vch_type)->delete();
            $mode = Mode::findOrFail($request->mode);
            $modeName = $mode->value;

            $voucher->ledger_id = $request->ledger_id;
            $voucher->amount = $request->amount;
            $voucher->date = session('date');
            $voucher->mode = $modeName;
            $voucher->from = $request->bank_id;
            $voucher->details = $request->details;
            $voucher->updated_by = auth()->id();
            $voucher->save();


            $transactionTypes = [
                'payment' => [
                    'account' => ['debit' => 0, 'credit' => $request->amount, 'ledger_id' => $request->bank_id],
                    'ledger' => ['debit' => $request->amount, 'credit' => 0, 'ledger_id' => $request->ledger_id]
                ],
                'receipt' => [
                    'account' => ['debit' => $request->amount, 'credit' => 0, 'ledger_id' => $request->bank_id],
                    'ledger' => ['debit' => 0, 'credit' => $request->amount, 'ledger_id' => $request->ledger_id]
                ]
            ];
            $ledger_name = Ledger::find($request->ledger_id);
            $account_name = Ledger::find($request->bank_id);

            if ($vch_type == 'payment') {
                $particular_bank = 'To ' . $ledger_name->name . ' [ Mode: ' . $modeName . ' ] ';
                $particular_ledger = 'From ' .  $account_name->name . ' [ Mode: ' . $modeName . ' ]';
            } else {
                $particular_ledger = 'To ' . $account_name->name . ' [ Mode: ' . $modeName . ' ] ';
                $particular_bank = 'From ' . $ledger_name->name . ' [ Mode: ' . $modeName . ' ] ';
            }
            foreach ($transactionTypes[$vch_type] as $particular => $attributes) {
                $transaction = new Transaction();
                $mode = Mode::findOrFail($request->mode);
                $modeName = $mode->value;
                $transaction->date = session('date');
                $transaction->vch_type = $vch_type;
                $transaction->vch_no = $voucher->vch_no;
                $transaction->ref_id = ($particular === 'account') ? $request->ledger_id : $request->bank_id;
                $transaction->ledger_id = $attributes['ledger_id'];
                if ($particular == 'account') {
                    $transaction->particular = $particular_bank;
                } else {

                    $transaction->particular = $particular_ledger;
                }
                $transaction->mode = $modeName;
                $transaction->debit = $attributes['debit'] ?? 0;
                $transaction->credit = $attributes['credit'] ?? 0;
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }

            DB::commit();

            return redirect()->route('vch.pr.index', ['vch_type' => $vch_type])->with("success", 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($vch_type, $id)
    {

        try {
            $voucher = VchPaymentReceipt::where('id', $id)->where('vch_type', $vch_type)->first();
            $vch_no = $voucher->vch_no;

            Transaction::where('vch_no', $vch_no)
                ->where('vch_type', $vch_type)
                ->delete();

            VchPaymentReceipt::where('vch_no', $vch_no)
                ->where('vch_type', $vch_type)
                ->delete();
            return redirect()->route('vch.pr.index', ['vch_type' => $vch_type])->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }
}
