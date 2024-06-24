<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDokter extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'id_tera', 'nama_dokter', 'poli', 'spesialis', 'image_url'];

    public function schedule()
    {
        return $this->hasMany(ScheduleDokter::class, 'doctor_id', 'id');
    }
}
