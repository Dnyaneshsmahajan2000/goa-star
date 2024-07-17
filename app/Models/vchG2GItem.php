<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vchG2GItem extends Model
{
    use HasFactory;
    protected $table='vch_g2g_items';
    protected $primaryKey ='id';

    protected $fillable =['item_id','quantity'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }   
}
