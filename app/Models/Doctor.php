<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

// jika ingin menggunakan mongo, ganti extends ke Eloquent

class Doctor extends Model
{
    protected $connection = 'mysql';
    // protected $collection = 'doctors';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'doctor_id', 'doctor_personal', 'doctor_contact', 'doctor_job', 'hospital', 'schedule'
    // ];

    protected $fillable = ['employee_id', 'employee_name', 'shift', 'date'];

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
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }
}
