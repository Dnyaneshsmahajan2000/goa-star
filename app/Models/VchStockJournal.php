<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchStockJournal extends Model
{
    use HasFactory;
    protected $table='vch_stock_journals';
    protected $primaryKey ='id';

    protected $fillable=['date','inserted_by'];

    public function godownFrom(){
        return $this->belongsTo(Godown::class,'gd_id');
       }
       public function godownTo(){
        return $this->belongsTo(Godown::class,'gd_id');
       }
       public function VchStockJournalItems()
    {
        return $this->hasMany(VchStockJournalItem::class,'ref_id');
    }
}
