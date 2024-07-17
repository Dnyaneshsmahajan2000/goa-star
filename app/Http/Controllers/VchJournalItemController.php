<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class VchJournalItemController extends Controller
{
    public function __construct()
    {
      //  session_start();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return session()->get('vch_journal_data');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requestData = $request->all();

        $ledger_id = $requestData['ledger_id'];
        $amount = $requestData['amount'];
        $type = $requestData['type'];
        $vch_journal_data = session()->get('vch_journal_data');

        //print_r($vch_journal_data);
        if($type=='source' or $type=='transfer')
        {
            if (isset($vch_journal_data['source'][$ledger_id])) {
                $vch_journal_data['source'][$ledger_id]['amount'] += $amount;
            } else {
                $vch_journal_data['source'][$ledger_id] = $requestData;
            }
        }
        if($type=='destination'  or $type=='transfer')
        {
            if (isset($vch_journal_data['destination'][$ledger_id])) {
                $vch_journal_data['destination'][$ledger_id]['amount'] += $amount;
            } else {
                $vch_journal_data['destination'][$ledger_id] = $requestData;
            }
        }
        session()->put('vch_journal_data', $vch_journal_data);
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
    public function list()
    {
        //$item_list = session()->get('vch_journal_data');
        return view('Journals.vch-journal-data');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
