<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'subject',
        'text_content',
        'html_content',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class)->orderBy('created_at', 'DESC');
    }

}
