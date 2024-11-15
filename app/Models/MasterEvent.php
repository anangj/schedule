<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEvent extends Model
{
    use HasFactory;

    protected $fillable = ['positions_id','name', 'start_date', 'end_date', 'isActive', 'content_order'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function positions() {
        return $this->belongsTo(EventPosition::class); 
    }

    public function contentEvent() {
        return $this->hasOne(ContentEvent::class);
    }
}
