<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::paginate();
        $propertyTypes = PropertyType::all();
        $filters = [];
        return view('properties.index', compact('properties', 'propertyTypes', 'filters'));
    }

    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $filters = $request->all();
        $query = Property::query();

        // Apply the description filter:
        if (isset($filters['description'])){
            $query->where('description', 'LIKE', '%' . $filters['description'] . '%');
        }

        // Apply the number_of_bedrooms filter:
        if (isset($filters['number_of_bedrooms'])) {
            $query->where('number_of_bedrooms', '=', $filters['number_of_bedrooms']);
        }

        // Apply price filter:
        if ( isset($filters['price']) ) {
            $query->where('price', '=', $filters['price']);
        }

        // Apply property_type filter:
        if (isset($filters['property_type'])) {
            $query->where('property_type_id', '=', $filters['property_type']);
        }

        // Apply type filter:
        if (isset($filters['type'])) {
            $query->where('type', '=', $filters['type']);
        }
        $properties = $query->paginate();
        foreach ($filters as $name => $value) {
            $properties->appends($name, $value);
        }
        $propertyTypes = PropertyType::all();
        return view('properties.index', compact('properties', 'propertyTypes', 'filters'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id the id of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.show', compact('property'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('property.index');
    }
}
