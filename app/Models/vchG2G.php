<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vchG2G extends Model
{
    use HasFactory;
    protected $table='vch_g2g';
    protected $primaryKey ='id';

    protected $fillable=['godown_from','godown_to'];

    public function godownFrom(){
        return $this->belongsTo(Godown::class,'godown_from');
       }
       public function godownTo(){
        return $this->belongsTo(Godown::class,'godown_to');
       }
       public function vchG2GItem()
       {
           return $this->hasMany(VchG2GItem::class,'ref_id');
       }
}
