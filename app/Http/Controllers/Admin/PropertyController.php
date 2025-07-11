<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyAttachments;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use Illuminate\Support\Facades\Storage;

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

            $propertyType = PropertyType::select('id','name')->where('id', $propertyTypeId)->first();
        // Return the view with properties
        return view('admin.pages.properties.index', compact('properties', 'propertyType'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::select('id', 'name')->where('status', 'active')->get();
        $propertyTypes = PropertyType::select('id', 'name')->where('status', 'active')->get();

        return view('admin.pages.properties.create_edit', compact('locations', 'propertyTypes'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('admin.pages.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $locations = Location::select('id', 'name')->where('status', 'active')->get();
        $propertyTypes = PropertyType::select('id', 'name')->where('status', 'active')->get();

        return view('admin.pages.properties.create_edit', compact('property', 'locations', 'propertyTypes'));
    }


    public function store(PropertyRequest $request)
    {
        DB::beginTransaction();

        try {
            $property = Property::create(array_merge(
                $request->validated(),
                ['created_by' => auth()->id()]
            ));

            $this->handleAttachments($request, $property);

            DB::commit();

            return redirect()->back()->with('success', 'Property created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e); // For logging
            return back()->withErrors(['error' => 'Failed to create property: ' . $e->getMessage()]);
        }
    }

    public function update(PropertyRequest $request, Property $property)
    {
        DB::beginTransaction();

        try {
            $property->update(array_merge(
                $request->validated(),
                ['updated_by' => auth()->id()]
            ));

            if ($request->hasFile('attachments')) {
                $this->deleteAttachments($property); // Clean old
                $this->handleAttachments($request, $property); // Add new
            }

            DB::commit();

            return redirect()->back()->with('success', 'Property updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);
            return back()->withErrors(['error' => 'Failed to update property: ' . $e->getMessage()]);
        }
    }

    public function destroy(Property $property)
    {
        DB::beginTransaction();

        try {
            $this->deleteAttachments($property);

            $property->delete();

            DB::commit();

            return back()->with('success', 'Property deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);
            return back()->withErrors(['error' => 'Failed to delete property: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle uploading attachments and saving metadata.
     */
    protected function handleAttachments(PropertyRequest $request, Property $property): void
    {
        $storedAttachments = [];

        foreach ($request->file('attachments', []) as $attachment) {
            $uniqueName = 'property_' . $property->id . '_' . Str::uuid() . '.' . $attachment->getClientOriginalExtension();
            $filePath = Storage::putFileAs('uploads/properties', $attachment, $uniqueName);

            $storedAttachments[] = [
                'property_id' => $property->id,
                'path' => $filePath,
                'file_name' => $attachment->getClientOriginalName(),
                'size' => $attachment->getSize(),
                'file_type' => $attachment->getMimeType(),
                'file_extension' => $attachment->getClientOriginalExtension(),
                'uploaded_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($storedAttachments)) {
            PropertyAttachments::insert($storedAttachments); // Faster than looping
        }
    }

    /**
     * Delete attachments from storage and database.
     */
    protected function deleteAttachments(Property $property): void
    {
        $attachments = $property->attachments;

        foreach ($attachments as $attachment) {
            Storage::delete($attachment->path);
        }

        $property->attachments()->delete(); // Clean DB
    }
}
