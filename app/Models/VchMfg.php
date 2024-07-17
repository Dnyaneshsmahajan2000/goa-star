<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VchMfg extends Model
{
    use HasFactory;

    protected $table = 'vch_mfg';
    protected $primaryKey = "id";

    protected $fillable = [
        'godown_id',
        'machine_id',
        'start_reading',
        'end_reading',
    ];

    public function machine()
    {
        return $this->belongsTo(machine::class, 'machine_id');
    }
    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }
    public function vchMfgItem()
    {
        return $this->hasMany(VchMfgItem::class, 'vch_mfg_id');
    }
   
}
