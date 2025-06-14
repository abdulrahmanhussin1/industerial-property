@extends('admin.layouts.app')
@section('title')
    {{ __('Properties Page ') }}
@endsection

@section('content')
 {{-- Start breadcrumbs --}}
    <x-breadcrumb pageName="Properties">
        <x-breadcrumb-item>{{ __('Home') }}</x-breadcrumb-item>
        <x-breadcrumb-item>{{ __('Properties') }}</x-breadcrumb-item>
        <x-breadcrumb-item>{{ isset($property) ? 'Edit Property' : 'Create Property' }}</x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumbs --}}

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h4>{{ isset($property) ? 'Edit Property' : 'Create Property' }}</h4>
        </div>
        <div class="card-body my-3">
            <form method="POST" action="{{ isset($property) ? route('properties.update', $property->id) : route('properties.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($property))
                    @method('PUT')
                @endif
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $property->title ?? '') }}" required>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Location</label>
                    <select name="location_id" class="form-control">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $property->location_id ?? '') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Property Type</label>
                    <select name="property_type_id" class="form-control" required>
                        <option value="">Select Type</option>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}" {{ old('property_type_id', $property->property_type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Land Area</label>
                    <input type="number" name="land_area" class="form-control" value="{{ old('land_area', $property->land_area ?? '') }}" required>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Hangar Type</label>
                    <select name="hangar_type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="hangar" {{ old('hangar_type', $property->hangar_type ?? '') == 'hangar' ? 'selected' : '' }}>Hangar</option>
                        <option value="truss" {{ old('hangar_type', $property->hangar_type ?? '') == 'truss' ? 'selected' : '' }}>Truss</option>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Hangar Area</label>
                    <input type="number" name="hangar_area" class="form-control" value="{{ old('hangar_area', $property->hangar_area ?? '') }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Hangar Height</label>
                    <input type="number" step="0.01" name="hangar_height" class="form-control" value="{{ old('hangar_height', $property->hangar_height ?? '') }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Admin Floors</label>
                    <input type="number" name="admin_floors" class="form-control" value="{{ old('admin_floors', $property->admin_floors ?? '') }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Electricity Power</label>
                    <input type="number" step="0.01" name="electricity_power" class="form-control" value="{{ old('electricity_power', $property->electricity_power ?? '') }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Electricity Unit</label>
                    <select name="electricity_unit" class="form-control">
                        <option value="">Select Unit</option>
                        <option value="kw" {{ old('electricity_unit', $property->electricity_unit ?? '') == 'kw' ? 'selected' : '' }}>kW</option>
                        <option value="mega" {{ old('electricity_unit', $property->electricity_unit ?? '') == 'mega' ? 'selected' : '' }}>Mega</option>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">License Expiry Date</label>
                    <input type="date" name="license_expiry_date" class="form-control" value="{{ old('license_expiry_date', $property->license_expiry_date ?? '') }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status', $property->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $property->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Cranes Count</label>
                    <input type="number" name="cranes_count" class="form-control" value="{{ old('cranes_count', $property->cranes_count ?? 0) }}">
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $property->price ?? '') }}">
                </div>

                <div class="row mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control">{{ old('notes', $property->notes ?? '') }}</textarea>
                </div>

                <div class="row mb-3">
                    <label class="form-label">Attachments</label>
                    <input type="file" name="attachments[]" multiple class="form-control">
                    @if(isset($property) && $property->attachments)
                        <ul class="mt-2">
                            @foreach($property->attachments as $attachment)
                                <li><a href="{{ asset('storage/' . $attachment->file) }}" target="_blank">{{ basename($attachment->file) }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">{{ isset($property) ? 'Update' : 'Create' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
