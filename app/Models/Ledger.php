<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    protected $table = 'ledgers';
    protected $primaryKey = "id";

    protected $fillable = ['name', 'group_id', 'mobile', 'state'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'gd_id');
    }
    public function VchJournalController()
    {
        return $this->belongsTo(VchJournal::class, 'journal_id');
    }
    public function transactions()
    {
        return $this->hasMany(transaction::class);
    }
       public function getBalance()
    {
        // Summing debit and credit for the ledger
        $sums = $this->transactions()
            ->selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')
            ->first();

        $balance = $sums->total_credit - $sums->total_debit;

        return $balance;
    }
    public function get_totals()
    {


        /*  if (!empty($ledgers)) {

            $opening_balance = 0;
            $from_date = session('from_date');
            $to_date = session('to_date');

            $ledger_ids = []; // Initialize $ledger_ids array
            foreach ($ledgers as $ledger) {
                $ledger_ids[] = $ledger->id;
            }

            $transactions_ob = Transaction::whereIn('ledger_id', $ledger_ids)
                ->where('date', '<', $from_date)
                ->get();
            $transactions = Transaction::whereIn('ledger_id', $ledger_ids)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();

            $opening_total_credit = $transactions_ob->sum('credit');
            $opening_total_debit = $transactions_ob->sum('debit');
            $opening_balance_cr = $opening_balance_dr = null;

            if ($opening_total_credit > $opening_total_debit) {
                $opening_balance_cr = $opening_total_credit - $opening_total_debit;
            } else {
                $opening_balance_dr = $opening_total_debit - $opening_total_credit;
            }

            $credit = $transactions->sum('credit');
            $debit = $transactions->sum('debit');

            return ['credit' => $credit, 'debit' => $debit, 'opening_cr' => $opening_balance_cr, 'opening_dr' => $opening_balance_dr];
        } */
    }
}
