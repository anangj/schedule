<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekday',
        'start_hour',
        'start_minute',
        'end_hour',
        'end_minute',
        'shift',
        'doctor_id',
        'nurse_id'
    ];
    protected $casts = [
        'id' => 'integer',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurse_id');
    }
}
