<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function getFullPathAttribute()
    {
        return config('uploads.attachments_folder_path').$this->filename;
    }
}
