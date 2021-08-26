<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that a Property can be generated and saved.
     *
     * @return void
     */
    public function testSaveModel()
    {
        // crate PropertyType instances so the PropertyFactory can add a relation to PropertyType:

        PropertyType::factory()->count(3)->create();

        // Create Property instance
        $property = Property::factory()->create();

        // test getting the PropertyType from Property instance
        $type = $property->propertyType;
        $this->assertInstanceOf(PropertyType::class, $type);
    }
}
