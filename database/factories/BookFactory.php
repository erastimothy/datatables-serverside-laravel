<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'summary' => $this->faker->text,
            'price' => $this->faker->randomNumber(2),
            'category_id' => rand(1,10),
        ];
    }
}
