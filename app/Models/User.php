<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table='users';
    protected $primaryKey="id";

    protected $fillable=['name','mobile','gender','role_id'];

    public function role(){
        return $this->belongsTo(UserRole::class,'role_id');
       }
       public function godown(){
        return $this->belongsTo(Godown::class,'gd_id');
       }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ledger()
    {
        return $this->hasOne(Ledger::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'ledger_id');
    }



}
