<?php

namespace Tests\Feature;

use App\Models\Email;
use App\Models\Message;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListEmails()
    {
        $emails = Email::factory()
            ->hasAttached(
                Status::factory()->count(2),
                ['status_message' => Arr::random(['request timout', 'smtp auth error'])]
            )
            ->count(5)
            ->create()
        ->each(function ($email) {
            $email->message()->save(Message::factory()->make());
        });

        $response = $this->get(route('email.index'));

        $response->assertStatus(200)
        ->assertJson($emails->toArray());
    }
}
