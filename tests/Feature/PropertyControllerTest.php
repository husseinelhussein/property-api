<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * tests PropertyController methods.
 *
 * @package Tests\Feature
 * @coversDefaultClass \App\Http\Controllers\PropertyController
 */
class PropertyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the index method
     *
     * @return void
     * @covers \App\Http\Controllers\PropertyController::index
     */
    public function testIndex()
    {
        // crate PropertyType instances so the PropertyFactory can add a relation to PropertyType:

        PropertyType::factory()->count(3)->create();

        // Create Property instance
        $properties = Property::factory()->count(10)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Properties');

        $property = $properties->first();
        $des = $property->description;
        $response->assertSeeText($des);

    }
}
