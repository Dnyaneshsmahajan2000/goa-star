<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchJournal extends Model
{
    use HasFactory;
    protected $table = "vch_journals";
    protected $primaryKey = "id";

    protected $fillable = [
        'legder_id',
        // 'type',
        'amount',
        // 'mode',
        'journal_data',
        'date',
    ];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }
    public function VchJournalItems()
    {
        return $this->hasMany(VchJournalData::class,'ref_id');
    }
}
