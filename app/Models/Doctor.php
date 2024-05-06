<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Doctor extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'doctors';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id', 'doctor_personal', 'doctor_contact', 'doctor_job'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    // public function schedules()
    // {
    //     return $this->hasMany(Schedule::class, 'doctor_id');
    // }
}
