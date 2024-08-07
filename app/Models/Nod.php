<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'employee_name',
        'date',
        'shift',
        'shift_id'
    ];

    public function shift()
    {
        return $this->belongsTo(MasterShift::class, 'shift_id');
    }
}
