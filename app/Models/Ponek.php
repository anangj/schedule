<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ponek extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'date',
        'shift',
        'shift_id'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function shift()
    {
        return $this->belongsTo(MasterShift::class, 'shift_id');
    }
}
