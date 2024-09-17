<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lobby extends Model
{
    use HasFactory;

    protected $fillable = ['title','source','start_date','end_date', 'is_active'];
}
