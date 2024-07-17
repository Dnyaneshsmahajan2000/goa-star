<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
    public $table = 'godowns';

    public $fillable = [
        'godown_name',
        'Comments'
    ];

    protected $casts = [
        'godown_name' => 'string',
        'Comments' => 'string'
    ];

    public static array $rules = [
        'godown_name' => 'required'
    ];

    
}
