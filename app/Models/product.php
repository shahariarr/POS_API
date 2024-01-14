<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'unit',
        'img',
        'user_id',
        'category_id',
    ];

}
