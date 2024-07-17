<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchStockJournalItem extends Model
{
    use HasFactory;
    protected $table = 'vch_stock_journal_items';
    protected $primaryKey = "id";

    protected $fillable = ['vch_id', 'item_id', 'quantity', 'type'];


    public function godownFrom()
    {
        return $this->belongsTo(Godown::class, 'from_godown_id');
    }
    public function godownTo()
    {
        return $this->belongsTo(Godown::class, 'to_godown_id');
    }
    public function voucherstockjournal()
    {
        return $this->belongsTo(VchStockJournal::class, 'ref_id');
    }
    public function item_data()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
}
