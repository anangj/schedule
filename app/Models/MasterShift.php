<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterShift extends Model
{
    use HasFactory;
    
    protected $fillable =['name_shift', 'start_time', 'end_time'];
}
