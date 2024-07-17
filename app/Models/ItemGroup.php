<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Define the ItemGroup model
class ItemGroup extends Model
{
    use HasFactory;

    protected $table = 'item_groups';

    protected $fillable = [
        'name',
        'description',
        
    ];

    public function items()
    {
        
        return $this->hasMany(Item::class,'item_group_id');
    }
}