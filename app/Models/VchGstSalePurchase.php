<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchGstSalePurchase extends Model
{
    use HasFactory;
    protected $table = 'vch_gst_sale_purchase';
    protected $primaryKey = "id";

    protected $fillable = ['ledger_id', 'gd_id', 'vch_type', 'total', 'grand_total'];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class,'ledger_id');
    }
    public function VchItems()
    {
        return $this->hasMany(VchGstSalePurchaseItem::class,'vch_id');
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class,'godown_id');
    }

    public function item_data()
    {
        return $this->hasMany(VchGstSalePurchaseItem::class, 'item_id');
    }

    public function vch()
    {
        return $this->hasMany(VchGstSalePurchaseItem::class, 'vch_no', 'vch_no');
    }
    public function saleItems()
    {
        return $this->hasMany(VchGstSalePurchaseItem::class); // Adjust SaleItem class according to your actual implementation
    }

}
