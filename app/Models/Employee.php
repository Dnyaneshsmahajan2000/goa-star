<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table='users';
    protected $primaryKey="id";
    
    protected $fillable=['name','mobile','group_id'];
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
       }
       public function godown(){
        return $this->belongsTo(Godown::class,'gd_id');
       }
}
