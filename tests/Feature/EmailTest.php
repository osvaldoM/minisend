<?php

namespace Tests\Feature;

use App\Helpers\Helper;
use App\Models\Attachment;
use App\Models\Email;
use App\Models\Message;
use App\Models\Status;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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
            $email->message->attachments()->saveMany(Attachment::factory()->count(rand(0,2))->make());
            $email->statuses()->create(
                Arr::random([$sentStatus->toArray(), $failedStatus->toArray()])
            );
        });

        $this->emails->load(['statuses', 'message', 'message.attachments', 'current_status']);
    }

    public function testListPaginatedEmails()
    {
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

    public function testCreateEmail()
    {

        $fake_email = Email::factory()->make();
        $fake_message = Message::factory()->make();
        $fake_message->html_content = Helper::removeUnwantedTags($fake_message->html_content);

        $fake_email->message = $fake_message->toArray();

        $file_to_upload = UploadedFile::fake()->image('testimage.png');
        $file_name = $file_to_upload->hashName();

        $response = $this->json(
            'POST',
            route('email.store'),
            array_merge($fake_message->toArray(), [
                'attachments' => [
                    0 => $file_to_upload
                ]
            ])
        );

        $response
            ->assertStatus(201)
            ->assertJson($fake_email->toArray());
        $this->assertDatabaseHas('messages', $fake_message->toArray());

        Storage::disk()->assertExists(config('uploads.attachments_folder_path').$file_name);
    }
    public function testFailCreatingInvalidEmail()
    {

        $fake_email = Email::factory()->make();
        $fake_message = Message::factory()->make();
        $fake_message->text_content = '';

        $fake_email->message = $fake_message->toArray();

        $file_to_upload_with_ok_size = UploadedFile::fake()->image('testimage.png')->size(2000);
        $file_to_upload_with_large_size = UploadedFile::fake()->image('testimage.png')->size(9000);

        $response = $this->json(
            'POST',
            route('email.store'), array_merge($fake_message->toArray(), [
                'attachments' => [
                    0 => $file_to_upload_with_ok_size,
                    1 => $file_to_upload_with_large_size
                ]
            ])
        );

        $response
            ->dump()
            ->assertStatus(422)
            ->assertJsonValidationErrors(["text_content", 'attachments.1']);

    }
}
