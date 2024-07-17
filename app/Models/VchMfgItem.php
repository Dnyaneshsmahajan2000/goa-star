<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchMfgItem extends Model
{
    use HasFactory;
    protected $table = 'vch_mfg_items';
    protected $primaryKey = 'id';

    protected $fillable = ['item_id', 'quantity', 'waste'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function vchmfg()
    {
        return $this->belongsTo(VchMfg::class, 'vch_mfg_id)');
    }
}
