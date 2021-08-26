<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PropertyType::factory()->count(3)->create();
        Property::factory()->count(50)->create();
    }
}
