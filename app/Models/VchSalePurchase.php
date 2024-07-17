<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchSalePurchase extends Model
{
    use HasFactory;
    protected $table = 'vch_sale_purchase';
    protected $primaryKey = "id";

    protected $fillable = ['ledger_id', 'gd_id', 'vch_type', 'total', 'grand_total'];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class,'ledger_id');
    }
    public function VchNonGstItems()
    {
        return $this->hasMany(VchSalePurchaseItem::class,'vch_id');
    }
}
