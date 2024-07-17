<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExpenses extends Model
{
    use HasFactory;

    protected $table = 'employee_expenses';
    protected $primaryKey = "id";

    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }
}
