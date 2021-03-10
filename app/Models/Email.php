<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    use Paginatable;

    protected $perPage = 10;

    public function statuses()
    {
        return $this->belongsToMany(Status::class)->withPivot('status_message');
    }

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}
