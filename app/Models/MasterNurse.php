<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNurse extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'employee_id', 'employee_name', 'image_url'];
}
