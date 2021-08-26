<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('properties.index', compact('properties', 'propertyTypes'));
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
        if(isset($filters['description'])){
            $query->where('description', 'LIKE', '%' . $filters['description'] . '%');
        }
        if(isset($filters['number_of_bedrooms'])){
            $query->where('number_of_bedrooms', '=', $filters['number_of_bedrooms']);
        }
        if(isset($filters['price'])){
            $query->where('price', '=', $filters['price']);
        }

        if(isset($filters['property_type'])){
            $query->where('property_type_id', '=', $filters['property_type']);
        }
        if(isset($filters['type'])){
            $query->where('type', '=', $filters['type']);
        }
        $properties = $query->paginate();
        $propertyTypes = PropertyType::all();
        return view('properties.index', compact('properties', 'propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
