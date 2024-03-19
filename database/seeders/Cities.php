<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\City;

class Cities extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create(['city' => 'Тернопіль', 'price' => ['2.5' => '85', '4.5' => '95', '6.5' => '120', '10' => '140']]);
        City::create(['city' => 'Кутківці', 'price' => ['default' => '130']]);
        City::create(['city' => 'Гаї Гречинські', 'price' => ['default' => '160']]);
        City::create(['city' => 'Петриків', 'price' => ['default' => '130']]);
        City::create(['city' => 'Великі Гаї', 'price' => ['default' => '190']]);
        City::create(['city' => 'Біла', 'price' => ['default' => '200']]);
        City::create(['city' => 'Березовиця', 'price' => ['default' => '180']]);
        City::create(['city' => 'Підгороднє', 'price' => ['default' => '180']]);
        City::create(['city' => 'Байківці', 'price' => ['default' => '220']]);
        City::create(['city' => 'Острів', 'price' => ['default' => '250']]);
    }
}
