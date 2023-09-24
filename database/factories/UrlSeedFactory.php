<?php

namespace Database\Factories;

use App\Models\shortenerModel;
use Illuminate\Database\Eloquent\Factories\Factory;


class UrlSeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = shortenerModel::class;
    public function definition(): array
    {
        return [
            'url'=>$this->faker->url(),
            'title'=>$this->faker->word()
        ];
    }
}
