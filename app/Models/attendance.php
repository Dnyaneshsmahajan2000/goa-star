<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $primaryKey = "id";

    protected $fillable = [
        'emp_id',
        'date',
        'attendance'
    ];
}
