<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function emails()
    {
        return $this->belongsToMany(Email::class)->withPivot('status_message');
    }
}
