<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchSalePurchaseItem extends Model
{
    use HasFactory;
    protected $table = 'vch_sale_purchase_items';
    protected $primaryKey = "id";

    protected $fillable = ['vch_id', 'gd_id', 'item_id', 'item_name', 'quantity', 'rate', 'total', 'grand_total'];
    public function voucher()
    {
        return $this->belongsTo(VchSalePurchase::class, 'vch_id');
    }
    public function item_data()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
