<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchGstSalePurchaseItem extends Model
{
    use HasFactory;
    protected $table = 'vch_gst_sale_purchase_items';
    protected $primaryKey = "id";

    protected $fillable = ['vch_id', 'gd_id', 'item_id', 'item_name', 'quantity', 'rate', 'total', 'grand_total'];
    public function voucher()
    {
        return $this->belongsTo(VchGstSalePurchase::class);
    }
    public function item_data()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
    public function vch()
    {
        return $this->belongsTo(VchGstSalePurchase::class, 'vch_no', 'vch_no');
    }
}
