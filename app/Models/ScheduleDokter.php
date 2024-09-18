<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDokter extends Model
{
    use HasFactory;

    protected $fillable = ['poli','doctor_id','weekday','start_hour','end_hour','start_minute','end_minute','status', 'appointment'];

    public function masterDokter()
    {
        return $this->belongsTo(MasterDokter::class, 'doctor_id', 'id');
    }
}
