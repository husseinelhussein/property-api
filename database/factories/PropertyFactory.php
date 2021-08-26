<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = PropertyType::all()->pluck('id')->toArray();
        return [
            'county' => $this->faker->text,
            'country' => $this->faker->text,
            'town' => $this->faker->text,
            'description' => $this->faker->text,
            'displayable_address' => $this->faker->address,
            'image' => $this->faker->text,
            'thumbnail' => $this->faker->text,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'number_of_bedrooms' => $this->faker->numberBetween(1, 10),
            'number_of_bathrooms' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(1, 10000),
            'property_type_id' => $this->faker->randomElement($types),
            'type' => $this->faker->randomElement(['sale', 'rent']),
        ];
    }
}
