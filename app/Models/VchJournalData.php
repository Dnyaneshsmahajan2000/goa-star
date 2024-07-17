<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchJournalData extends Model
{
    use HasFactory;
    protected $table='vch_journal_data';
    protected $primaryKey ='id';

    protected $fillable =['legder_id','amount'];
    public function ledger()
    {
        return $this->belongsTo(ledger::class);
    } 
    public function voucherjournal()
    {
        return $this->belongsTo(VchJournal::class, 'ref_id');
    }
    public function ledger_data()
    {
        return $this->belongsTo(Ledger::class,'ledger_id');
    }
}
