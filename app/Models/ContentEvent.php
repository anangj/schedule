<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentEvent extends Model
{
    use HasFactory;

    protected $fillable = ['master_event_id', 'type', 'url', 'filename', 'metadata'];

    public function masterEvent()
    {
        return $this->belongsTo(MasterEvent::class);
    }
}
