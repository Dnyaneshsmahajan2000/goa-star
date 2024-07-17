<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBom extends Model
{
    use HasFactory;
    protected $table = 'item_boms';

    protected $fillable = [
        'item_id',
        'rm_id',
        'unit',
        'qty',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class,'rm_id');
    }

}
