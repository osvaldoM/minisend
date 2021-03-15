<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'filename' => $this->faker->file(base_path('resources/sample-attachments'), Storage::disk()->path(config('uploads.attachments_folder_path')), false),
            'original_filename' => function (array $attributes) {
                    return 'original-'.$attributes['filename'];
            }
        ];
    }
}
