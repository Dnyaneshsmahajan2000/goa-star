<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = "id";

    protected $fillable = ['item_id', 'gd_id', 'quantity', 'vch_no', 'vch_type', 'date', 'created_by', 'updated_by'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function item_stock()
    {
        return $this->belongsTo(Item::class, 'opening_stock');
    }

}
