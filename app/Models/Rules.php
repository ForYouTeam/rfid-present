<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'tag', 'value', 'created_at', 'updated_at'
    ];
}
