<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($propertyTypeId)
    {
        // Fetch properties based on the property type
        $properties = Property::where('property_type_id', $propertyTypeId)
        ->where('status', 'active')
        ->paginate(12);

        // Return the view with properties
        return view('admin.pages.properties.index', compact('properties'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::select('id', 'name')->where('status','active')->get();
        $propertyTypes = PropertyType::select('id', 'name')->where('status', 'active')->get();

        return view('admin.pages.properties.create_edit', compact('locations', 'propertyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }
}
