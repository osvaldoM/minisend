<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListMessages()
    {
        $messages = Message::factory()->count(5)->create();

        $response = $this->get(route('message.index'));

        $response->assertStatus(200)
        ->assertJson($messages->toArray());
    }
}
