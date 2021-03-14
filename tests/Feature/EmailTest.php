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
        parent::setUp();

        $postedStatus_name = 'Posted';

        $sentStatus = Status::factory()->state([
            'name' => 'Sent',
            'message' => 'Email is sent'
        ])->make();
        $failedStatus = Status::factory()->state([
            'name' => 'Failed',
            'message' => 'Email failed'
        ])->make();

        $this->emails = Email::factory()->count(10)->has(Status::factory()->state([
            'name' => $postedStatus_name,
            'message' => 'Email is queued for sending'
        ]))->create()->each(function ($email) use ($sentStatus, $failedStatus) {
            $email->message()->save(Message::factory()->make());
            $email->statuses()->create(
                Arr::random([$sentStatus->toArray(), $failedStatus->toArray()])
            );
        });

        $this->emails->load(['statuses', 'message','current_status']);
    }

    public function testListPaginatedEmails()
    {
        //fix issue with sorting when using slice
        $per_page = 5;
        $current_page = 2;

        $response = $this->get(route('email.index', ['page' =>$current_page, 'per_page' => $per_page]));

        $response
            ->assertStatus(200)
            ->assertJsonPath('per_page', $per_page)
            ->assertJsonPath('current_page', $current_page);

        $this->assertEqualsCanonicalizing($response['data'], array_slice($this->emails->toArray(),(($current_page-1) * $per_page),$per_page));
    }

    public function testListPaginatedEmailsWithSenderSearch()
    {
        $email_with_random_sender = Arr::random($this->emails->toArray());

        $response = $this->get(route('email.index', ['query' => $email_with_random_sender['message']['from']]));

        $testEmail = Arr::first($response['data'], function ($value, $key) use ($email_with_random_sender) {
            return $value['id'] == $email_with_random_sender['id'];
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
            return $value['id'] == $email_with_random_recipient['id'];
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
            return $value['id'] == $email_with_random_subject['id'];
        });

        $response->assertStatus(200);
        $this->assertNotEmpty($testEmail);
        $this->assertEqualsCanonicalizing($testEmail, $email_with_random_subject);
    }

    public function testListEmailsToRecipient()
    {
        $email_with_random_recipient = Arr::random($this->emails->toArray());

        $response = $this->get(route('emailsToRecipient', ['recipient' => $email_with_random_recipient['message']['to']]));

        $testEmail = Arr::first($response->getData(true), function ($value, $key) use ($email_with_random_recipient) {
            return $value['id'] == $email_with_random_recipient['id'];
        });

        $response->assertStatus(200);

        $this->assertNotEmpty($testEmail);
        $this->assertEqualsCanonicalizing($testEmail, $email_with_random_recipient);

    }

    public function testShowEmail()
    {
        $random_email = Arr::random($this->emails->toArray());

        $response = $this->get(route('email.show', ['email' => $random_email['id']]));

        $response->assertStatus(200)
            ->assertJson($random_email);
    }
}
