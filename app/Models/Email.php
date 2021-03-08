<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    public function statuses()
    {
        return $this->belongsToMany(Status::class)->withPivot('status_message');
    }

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}
