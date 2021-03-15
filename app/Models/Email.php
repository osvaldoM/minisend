<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Email extends Model
{
    public static $STATUS_SENT = 'Sent';
    public static $STATUS_FAILED = 'Failed';
    public static $STATUS_POSTED = 'Posted';

    use HasFactory;
    use Paginatable;

    protected $perPage = 10;

    protected $fillable = [
        'should_fail'
    ];

    protected $casts = [
        'should_fail' => 'boolean',
    ];
    public function setPosted($message='Email is queued for sending')
    {
        $this->statuses()->create([
          'name' => self::$STATUS_POSTED,
          'message' => $message
        ]
        );
    }
    public function setSent($message='Email is sent')
    {
        $this->statuses()->create([
          'name' => self::$STATUS_SENT,
          'message' => $message
        ]
        );
    }
    public function setFailed($message='Email failed')
    {
        $this->statuses()->create([
          'name' => self::$STATUS_FAILED,
          'message' => $message
        ]
        );
    }


    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('created_at', 'DESC');
    }

    public function current_status()
    {
        return $this->hasOne(Status::class)->orderBy('created_at', 'DESC')->latest();
    }

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}
