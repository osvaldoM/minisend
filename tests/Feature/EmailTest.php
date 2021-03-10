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

    private $emails;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->emails = Email::factory()
            ->hasAttached(
                Status::factory()->count(2),
                ['status_message' => Arr::random(['request timout', 'smtp auth error'])]
            )
            ->count(30)
            ->create()
            ->each(function ($email) {
                $email->message()->save(Message::factory()->make());
            });

        $this->emails->loadMissing(['statuses', 'message']);
    }

    public function testListPaginatedEmails()
    {
        $per_page = 5;
        $current_page = 2;

        $response = $this->get(route('email.index', ['page' =>$current_page, 'per_page' => $per_page]));

        $response->assertStatus(200)
        ->assertJsonPath('per_page', $per_page)
        ->assertJsonPath('current_page', $current_page);
        $this->assertEqualsCanonicalizing($response['data'], array_slice($this->emails->toArray(),(($current_page-1) * $per_page),$per_page));
    }

    public function testListPaginatedEmailsWithSenderSearch()
    {
        $email_with_random_sender = Arr::random($this->emails->toArray());

        $response = $this->get(route('email.index', ['query' => $email_with_random_sender['message']['from']]));

        $testEmail = Arr::first($response['data'], function ($value, $key) use ($email_with_random_sender) {
            return $value['id'] >= $email_with_random_sender['id'];
        });

        $response->assertStatus(200);
        $this->assertNotEmpty($testEmail);
        $this->assertEqualsCanonicalizing($testEmail, $email_with_random_sender);
    }

    public function testListPaginatedEmailsWithRecipientSearch()
    {
        $email_with_random_recipient = Arr::random($this->emails->toArray());

        $response = $this->get(route('email.index', ['query' => $email_with_random_recipient['message']['to']]));

        $testEmail = Arr::first($response['data'], function ($value, $key) use ($email_with_random_recipient) {
            return $value['id'] >= $email_with_random_recipient['id'];
        });

        $response->assertStatus(200);
        $this->assertNotEmpty($testEmail);
        $this->assertEqualsCanonicalizing($testEmail, $email_with_random_recipient);
    }

    public function testListPaginatedEmailsWithSubjectSearch()
    {
        $email_with_random_subject = Arr::random($this->emails->toArray());

        $response = $this->get(route('email.index', ['query' => $email_with_random_subject['message']['subject']]));

        $testEmail = Arr::first($response['data'], function ($value, $key) use ($email_with_random_subject) {
            return $value['id'] >= $email_with_random_subject['id'];
        });

        $response->assertStatus(200);
        $this->assertNotEmpty($testEmail);
        $this->assertEqualsCanonicalizing($testEmail, $email_with_random_subject);
    }
}
