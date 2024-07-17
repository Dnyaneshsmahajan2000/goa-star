<?php

namespace App\Http\Controllers;

use App\Models\VchJournal;
use App\Http\Controllers\Controller;
use App\Models\Ledger;
use App\Models\data;
use App\Models\transaction;
use App\Models\VchJournalData;
use App\Models\VchStockJournalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VchJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journal = VchJournal::all();
        return view('Journals.index', compact('journal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return session()->all();
        session()->forget('vch_journal_data');
        // $ledgers = Ledger::all();
        $ledgers = Ledger::all()->map(function ($ledgers) {
            $ledgers->label = $ledgers->name;
            unset($ledgers->name);
            return $ledgers;
        });

        return view('Journals.create')
            ->with('ledgers', $ledgers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item_list = session()->get('vch_journal_data');
            $vchJournal = new VchJournal();
            $vchJournal->date = session('date');
            $vchJournal->details = $request->details;
            $vchJournal->created_by = auth()->id();
            $vchJournal->updated_by = auth()->id();

            $vchJournal->save();
            foreach ($item_list['source'] as $item) {
                $VchJournalData = new VchJournalData();
                $VchJournalData->ref_id = $vchJournal->id;
                $VchJournalData->type = $item['type'];
                $VchJournalData->amount = $item['amount'];
                $VchJournalData->ledger_id = $item['ledger_id'];
                $VchJournalData->save();

                $transaction = new transaction();
                $transaction->ledger_id = $item['ledger_id'];
                if ($item['type'] == 'source') {
                    $transaction->debit = $item['amount'];
                    $transaction->credit = 0;
                } else {
                    $transaction->credit = $item['amount'];
                    $transaction->debit = 0;
                }
                $transaction->vch_type = 'journal';
                $transaction->particular = "Journal";
                $transaction->vch_no = $vchJournal->id;
                $transaction->date = session('date');
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }
            foreach ($item_list['destination'] as $item) {
                $VchJournalData = new VchJournalData();
                $VchJournalData->ref_id = $vchJournal->id;
                $VchJournalData->type = $item['type'];
                $VchJournalData->amount = $item['amount'];
                $VchJournalData->ledger_id = $item['ledger_id'];
                $VchJournalData->save();

                $transaction = new transaction();
                $transaction->ledger_id = $item['ledger_id'];
                $transaction->particular = "Journal";

                if ($item['type'] == 'source') {
                    $transaction->debit = $item['amount'];
                    $transaction->credit = 0;
                } else {
                    $transaction->credit = $item['amount'];
                    $transaction->debit = 0;
                }
                $transaction->vch_type = 'journal';
                $transaction->vch_no = $vchJournal->id;
                $transaction->date = session('date');
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }
            /*  foreach ($item_list as $item) {
                $transaction = new transaction();
                $transaction->ledger_id = $item['ledger_id'];
                if ($item['type'] == 'source') {
                    $transaction->debit = $item['amount'];
                    $transaction->credit = 0;
                } else {
                    $transaction->credit = $item['amount'];
                    $transaction->debit = 0;
                }
                $transaction->vch_type = 'journal';
                $transaction->vch_no = $vchJournal->id;
                $transaction->date = session('date');
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
                $transaction->save();
            }
 */
            return redirect()->route('vchjournal.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VchJournal $vchJournal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VchJournal $vchJournal, $id)
    {
        $VchJournal = VchJournal::find($id);
        $vch_items = [];
        foreach ($VchJournal->VchJournalItems as $vi) {
            if ($vi->type === 'source') {
                $vch_items['source'][$vi->ledger_id] = $vi;
            } else {
                $vch_items['destination'][$vi->ledger_id] = $vi;
            }
        }
        session()->put('vch_journal_data', $vch_items);
        $ledgers = ledger::all()->map(function ($ledgers) {
            $ledgers->label = $ledgers->name;
            unset($ledgers->name);
            return $ledgers;
        });
        $params['id'] = $id;
        $params['ledgers'] = $ledgers;
        $params['VchJournal'] = $VchJournal;
        return view('Journals.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VchJournal $vchJournal, $id)
    {
        $vchJournal_data = VchJournal::find($id);
        if ($vchJournal_data) {

            transaction::where('vch_no', $id)
                ->where('vch_type', 'journal')
                ->delete();
            VchJournalData::where('ref_id', $id)->delete();
            $journal_data = session()->get('vch_journal_data');
            try {

                $vchJournal_data->date = session('date');
                $vchJournal_data->details = $request->details;
                $vchJournal_data->save();

                foreach ($journal_data['source'] as $item) {
                    $VchJournalData = new VchJournalData();
                    $VchJournalData->ref_id = $vchJournal_data->id;
                    $VchJournalData->type = $item['type'];
                    $VchJournalData->amount = $item['amount'];
                    $VchJournalData->ledger_id = $item['ledger_id'];
                    $VchJournalData->save();

                    $transaction = new transaction();
                    $transaction->ledger_id = $item['ledger_id'];
                    if ($item['type'] == 'source') {
                        $transaction->debit = $item['amount'];
                        $transaction->credit = 0;
                    } else {
                        $transaction->credit = $item['amount'];
                        $transaction->debit = 0;
                    }
                    $transaction->vch_type = 'journal';
                    $transaction->particular = "Journal";
                    $transaction->vch_no = $id;
                    $transaction->date = session('date');
                    $transaction->created_by = auth()->id();
                    $transaction->updated_by = auth()->id();
                    $transaction->save();
                }
                foreach ($journal_data['destination'] as $item) {
                    $VchJournalData = new VchJournalData();
                    $VchJournalData->ref_id = $vchJournal_data->id;
                    $VchJournalData->type = $item['type'];
                    $VchJournalData->amount = $item['amount'];
                    $VchJournalData->ledger_id = $item['ledger_id'];
                    $VchJournalData->save();

                    $transaction = new transaction();
                    $transaction->ledger_id = $item['ledger_id'];
                    $transaction->particular = "Journal";

                    if ($item['type'] == 'source') {
                        $transaction->debit = $item['amount'];
                        $transaction->credit = 0;
                    } else {
                        $transaction->credit = $item['amount'];
                        $transaction->debit = 0;
                    }
                    $transaction->vch_type = 'journal';
                    $transaction->vch_no = $id;
                    $transaction->date = session('date');
                    $transaction->created_by = auth()->id();
                    $transaction->updated_by = auth()->id();
                    $transaction->save();
                }
                return redirect()->route('vchjournal.index')->with("success", 'Updated Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.' . $e->getMessage());
            }
        }
    }

    public function destroy(VchJournal $vchJournal, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                transaction::where('vch_no', $id)
                    ->where('vch_type', 'journal')
                    ->delete();
                VchJournalData::where('ref_id', $id)->delete();
                VchJournal::where('id', $id)->delete();
            });

            return redirect()->route('vchjournal.index')->with("success", 'Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", 'Failed to delete');
        }
    }
}
