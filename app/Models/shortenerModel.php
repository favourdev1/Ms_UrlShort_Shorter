<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shortenerModel extends Model
{
    use HasFactory;
    protected $fillable =[
        'url',
        'title',
        'original_url',
        'user_id'
    ];

    protected $table = "url";
}
