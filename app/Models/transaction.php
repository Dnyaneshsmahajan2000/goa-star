<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = "id";

    protected $fillable = ['ledger_id', 'vch_type', 'vch_no', 'particular', 'debit', 'credit', 'date', 'created_by', 'updated_by'];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }
      public function paymentReceipt()
    {
        return $this->belongsTo(VchPaymentReceipt::class, 'vch_no', 'vch_no')
            ->where('vch_type', $this->vch_type);
    }

    public function gstSalePurchase()
    {
        return $this->belongsTo(VchGstSalePurchase::class, 'vch_no', 'vch_no')
            ->where('vch_type', $this->vch_type);
    }
}
