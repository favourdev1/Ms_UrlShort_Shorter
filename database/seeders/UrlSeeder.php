<?php

namespace Database\Seeders;

use App\Models\shortenerModel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        shortenerModel::factory()->count(20)->create();
    }
}
