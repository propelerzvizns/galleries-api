<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            // 'first_name' => $this->faker->name,
            // 'last_name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'user_id' => $this->faker->randomNumber($nbDigits = 1)
        ];
    }
}
