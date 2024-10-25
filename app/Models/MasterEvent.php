<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEvent extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'isActive'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
