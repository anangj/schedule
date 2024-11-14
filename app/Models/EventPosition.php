<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPosition extends Model
{
    use HasFactory;

    protected $fillable = ['position_name', 'floor', 'isActive'];


    public function masterEvent() {
        return $this->hasMany(MasterEvent::class, 'position_id', 'id');
    }
}
