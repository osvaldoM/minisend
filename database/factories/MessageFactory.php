<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;


class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from' => $this->faker->email,
            'to' => $this->faker->email,
            'subject' => $this->faker->text(100),
            'html_content' => trim($this->faker->randomHtml(2, 300)),
            'text_content' => function(array $attributes) {
                //converting html to text using a DOMDocument would be the ideal solution. however, this should be able to handle simple test cases
                return preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($attributes['html_content']))) );
            },
//            'attachments' => $this->faker->file(base_path('resources/sample-attachments'), storage_path('app/attachments'), false)
        ];
    }
}
