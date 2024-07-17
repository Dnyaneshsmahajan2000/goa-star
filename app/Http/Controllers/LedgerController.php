<?php

namespace App\Http\Controllers;

use App\Models\transaction; // Add this line at the top with other "use" statements

use App\Models\Ledger;
use App\Models\Group;
use App\Models\Godown;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // Add this line at the top with other "use" statements
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $ledgers = Ledger::all();
        if (Auth::user()->role->name == 'SuperAdmin') {
            $ledgers = Ledger::all();
        } else {
            $godown_id = Auth::user()->gd_id;
            $includeIds = [1, 2, 3, 4, 5, 6]; // Add the IDs you want to include
            $ledgers = Ledger::where(function ($query) use ($godown_id, $includeIds) {
                $query->where('gd_id', $godown_id)
                    ->orWhereIn('id', $includeIds);
            })->get();
        }

        return view('ledgers.index', compact('ledgers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $groups = Group::where('is_enabled', 1)->get();
        $godowns = Godown::all();
        return view('ledgers.create', compact('groups', 'godowns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'group_id' => 'required|string|max:50',
            'state' => 'required|string',
            'mobile' => 'required|max:10|min:10',

        ]);
        try {
            $ledger = new Ledger();
            $ledger->name = ucwords($request->name);
            $ledger->group_id = $request->group_id;
            $ledger->mobile = $request->mobile;
            $ledger->address = $request->address;
            $ledger->city = $request->city; // Assuming city is a field in the table
            $ledger->state = ucwords($request->state);
            $ledger->pincode = $request->pincode;
            $ledger->email = $request->email;
            $ledger->gst_no = $request->gst_no;
            $ledger->gd_id = $request->gd_id;
            $ledger->credit_limit = $request->credit_limit;
            $ledger->bank_name = $request->bank_name;
            $ledger->account_no = $request->account_no;
            $ledger->ifsc_code = $request->ifsc_code;
            $ledger->micr_code = $request->micr_code;
            $ledger->opening_balance = $request->opening_balance;
            $ledger->opening_bal_type = $request->opening_bal_type;
            $ledger->ref_id = $request->ref_id;
            $ledger->created_by = $request->created_by;
            $ledger->updated_by = $request->updated_by;

            $ledger->save();

            if ($request->opening_balance != 0) {
                $transaction = new Transaction();
                $transaction->ledger_id = $ledger->id;
                $transaction->ref_id = $request->ref_id;
                $transaction->vch_type = 'opening_balance';
                $transaction->vch_no = $ledger->id;
                $transaction->particular = 'Opening Balance';

                if ($request->opening_bal_type == 'credit') {
                    $transaction->debit = 0;
                    $transaction->credit = $request->opening_balance;
                } else {
                    $transaction->debit = $request->opening_balance;
                    $transaction->credit = 0;
                }
                $transaction->date = Carbon::now()->toDateString();
                // $transaction->created_by=Auth::user()->name;
                // $transaction->created_by = auth()->user()->name; 
                $transaction->created_by = auth()->id();
                //$transaction->created_by=1;
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }
            return redirect()->route('ledger.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ledger = Ledger::find($id);
        $groups = Group::where('is_enabled', 1)->get();
        $godowns = Godown::all();
        return view('ledgers.edit', compact('ledger', 'groups', 'godowns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'group_id' => 'required|string|max:50',
            'state' => 'required|string',
            'mobile' => 'required|digits:10',

        ]);

        try {
            $ledger = Ledger::findOrFail($id);
            $ledger->name = ucwords($request->name);
            $ledger->group_id = $request->group_id;
            $ledger->mobile = $request->mobile;
            $ledger->state = ucwords($request->state);
            $ledger->address = $request->address;
            $ledger->city = $request->city;
            $ledger->pincode = $request->pincode;
            $ledger->email = $request->email;
            $ledger->gst_no = $request->gst_no;
            $ledger->gd_id = $request->gd_id;
            $ledger->credit_limit = $request->credit_limit;
            $ledger->bank_name = $request->bank_name;
            $ledger->account_no = $request->account_no;
            $ledger->ifsc_code = $request->ifsc_code;
            $ledger->micr_code = $request->micr_code;
            $ledger->opening_balance = $request->opening_balance;
            $ledger->opening_bal_type = $request->opening_bal_type;
            $ledger->ref_id = $request->ref_id;
            $ledger->created_by = $request->created_by;
            $ledger->updated_by = auth()->id();

            $ledger->save();
   //            Transaction::where('ledger_id', $id)->delete();
            $records = Transaction::where('ledger_id', $id)
                ->where('vch_type', 'opening_balance')
                ->where('particular', 'opening balance')
                ->get();

            // If records exist, delete them
            if ($records->isNotEmpty()) {
                // Loop through and delete each record, or use delete() directly if you want to delete all at once
                foreach ($records as $record) {
                    $record->delete();
                }
            }
            if ($request->opening_balance != 0) {
                $transaction = new Transaction();
                $transaction->ledger_id = $ledger->id;
                $transaction->ref_id = $ledger->id;
                $transaction->vch_type = 'opening_balance';
                $transaction->vch_no = $ledger->id;
                $transaction->particular = 'Opening Balance';

                if ($request->opening_bal_type == 'credit') {
                    $transaction->debit = 0;
                    $transaction->credit = $request->opening_balance;
                } else {
                    $transaction->debit = $request->opening_balance;
                    $transaction->credit = 0;
                }
                $transaction->date = Carbon::now()->toDateString();
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }
            return redirect()->route('ledger.index')->with("success", 'Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        try {
            // Attempt to delete the ledger
            $ledger = Ledger::findOrFail($id);
            $ledger->delete();

            return redirect()->route('ledger.index')->with('success', 'Ledger deleted successfully');
        } catch (QueryException $e) {
            // Check if the error is a foreign key constraint violation
            if ($e->getCode() == '23000') {
                return redirect()->route('ledger.index')->with('error', 'Please remove the transactions of this ledger then it will be deleted');
            }

            // For other database errors, you might want to log them and show a generic error message
            Log::error($e);
            return redirect()->route('ledger.index')->with('error', 'An error occurred while deleting the ledger');
        }   }
}
