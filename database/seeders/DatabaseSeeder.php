<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Email;
use App\Models\Message;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $postedStatus_name = 'Posted';

        $sentStatus = Status::factory()->state([
            'name' => 'Sent',
            'message' => 'Email is sent'
        ])->make();
        $failedStatus = Status::factory()->state([
            'name' => 'Failed',
            'message' => 'Email failed'
        ])->make();

        Email::factory()->count(30)->has(Status::factory()->state([
            'name' => $postedStatus_name,
            'message' => 'Email is queued for sending'
        ]))->create()->each(function ($email) use ($sentStatus, $failedStatus) {
            $email->message()->save(Message::factory()->make());
            $email->message->attachments()->saveMany(Attachment::factory()->count(rand(0,2))->make());
            $email->statuses()->create(
                Arr::random([$sentStatus->toArray(), $failedStatus->toArray()])
            );
        });
    }
}
