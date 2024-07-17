<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchPaymentReceipt extends Model
{
    use HasFactory;
    protected $table='vch_payment_receipts';
    protected $primaryKey ='id';

    protected $fillable=['ledger_id','amount','date','mode','vch_no','vch_type','from','created_by','updated_by'];

    public function parties()
    {
        return $this->belongsTo(Ledger::class,'ledger_id');
    }
    public function modes()
    {
        return $this->belongsTo(Mode::class,'mode');
    }
    public function banks()
    {
        return $this->belongsTo(Ledger::class,'from');
    }
}
