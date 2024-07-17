<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchItem extends Model
{
    use HasFactory;
    public function voucher()
    {
        return $this->belongsTo(Vouchers::class,'vch_no');
    }
}
