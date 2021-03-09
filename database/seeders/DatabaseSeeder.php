<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $postedStatus = Status::factory()->state([
            'name' => 'Posted'
        ])->create();
        $sentStatus = Status::factory()->state([
            'name' => 'Sent'
        ])->create();
        $failedStatus = Status::factory()->state([
            'name' => 'Failed'
        ])->create();

        Email::factory()->count(10)->hasAttached($postedStatus)->create()->each(function ($email) use (&$sentStatus, &$failedStatus) {
            $email->message()->save(Message::factory()->make());
            $email->statuses()->attach(
                Arr::random([$sentStatus, $failedStatus]),
                ['status_message' => Arr::random(['request timout', 'smtp auth error'])]
            );
        });
    }
}
