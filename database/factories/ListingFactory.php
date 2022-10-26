<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\LaravelIgnition\Support\Composer\FakeComposer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //ovde se moze stavit faker iz userfactory
            'title' => $this->faker->sentence(), //lazna recenica
            'tags' => 'laravel, api, backend', //valjda nema lazni csv faker
            'company' => $this->faker->company(), //faker company
            'email' => $this->faker->companyEmail(), //faker mail
            'website' => $this->faker->url(), //url generate
            'location' => $this->faker->city(), //grad, vjerovatno ima i za svakakve
            'description' => $this->faker->paragraph(), //duzi tekst, za razliku od sentence()
        ];
    }
}
