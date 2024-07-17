<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'ledger_id', 'vch_type', 'date', 'grand_total', // Add more fields if necessary
    ];

    // Define the relationship with Customer
    public function ledger()
    {
        return $this->belongsTo(ledger::class, 'ledger_id');
    }
}
