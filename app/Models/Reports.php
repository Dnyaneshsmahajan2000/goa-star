<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;
    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }
    public function VchItems()
    {
        return $this->hasMany(VchGstSalePurchaseItem::class, 'vch_id');
    }
    public function modes()
    {
        return $this->belongsTo(Mode::class, 'mode');
    }
    public function banks()
    {
        return $this->belongsTo(Ledger::class, 'from');
    }
    public function item_data()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
   
}
