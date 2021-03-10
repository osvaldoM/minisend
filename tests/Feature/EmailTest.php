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
    public function testListPaginatedEmails()
    {
        $per_page = 5;
        $current_page = 2;
        $emails = Email::factory()
            ->hasAttached(
                Status::factory()->count(2),
                ['status_message' => Arr::random(['request timout', 'smtp auth error'])]
            )
            ->count(30)
            ->create()
        ->each(function ($email) {
            $email->message()->save(Message::factory()->make());
        });

        $emails->loadMissing(['statuses', 'message']);

        $response = $this->get(route('email.index', ['page' =>$current_page, 'per_page' => $per_page]));

        $response->assertStatus(200)
        ->assertJsonPath('per_page', $per_page)
        ->assertJsonPath('current_page', $current_page);
        $this->assertEqualsCanonicalizing($response->json()['data'], array_slice($emails->toArray(),(($current_page-1) * $per_page),$per_page));
    }
}
