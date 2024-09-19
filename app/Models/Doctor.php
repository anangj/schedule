<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Doctor extends Model
{
    protected $fillable = ['employee_id', 'employee_name', 'shift', 'date', 'shift_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function schedules()
    {
        return $this->hasMany(ScheduleDokter::class, 'doctor_id');
    }

    public function shift()
    {
        return $this->belongsTo(MasterShift::class, 'shift_id');
    }
}
