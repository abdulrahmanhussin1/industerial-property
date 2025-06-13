@extends('admin.layouts.app')
@section('title')
{{ __('Properties Page ') }}

@endsection
@section('css')
<style>
    .transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow:hover {
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-4px);
}

</style>
@endsection
@section('content')
{{-- Start breadcrumbs --}}
    <x-breadcrumb pageName="Properties">
        <x-breadcrumb-item>{{ __('Home') }}</x-breadcrumb-item>
        <x-breadcrumb-item>{{ __('Properties') }}</x-breadcrumb-item>
    </x-breadcrumb>
{{-- End breadcrumbs --}}
<div class="container py-5">

    {{-- Filter --}}
    {{-- <form method="GET" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="hangar_type" class="form-label">Hangar Type</label>
                <select name="hangar_type" id="hangar_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="جمالون" {{ request('hangar_type') == 'جمالون' ? 'selected' : '' }}>جمالون</option>
                    <option value="هانجر" {{ request('hangar_type') == 'هانجر' ? 'selected' : '' }}>هانجر</option>
                    <option value="هانتر" {{ request('hangar_type') == 'هانتر' ? 'selected' : '' }}>هانتر</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="license_type" class="form-label">License Type</label>
                <select name="license_type" id="license_type" class="form-select">
                    <option value="">All</option>
                    <option value="قديمة" {{ request('license_type') == 'قديمة' ? 'selected' : '' }}>قديمة</option>
                    <option value="هندسى" {{ request('license_type') == 'هندسى' ? 'selected' : '' }}>هندسى</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form> --}}

    {{-- Grid of Property Cards --}}
    <div class="row g-4">
        @forelse ($properties as $property)
            <div class="col-3">
                <a href="{{ route('properties.show', ["property"=>$property]) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 transition hover-shadow">
                        @if ($property->images?->first())
                            <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5 text-muted">No Image</div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $property->title ?? 'Untitled Property' }}</h5>
                            <p class="card-text text-muted mb-1">📏 Area: {{ $property->land_area }} m²</p>
                            <p class="card-text text-muted mb-1">🏗 Hangar: {{ $property->hangar_area }} m² ({{ $property->hangar_type }})</p>
                            <p class="card-text text-muted mb-1">⚡ Electricity: {{ $property->electricity_power }} MW</p>
                            <p class="card-text fw-bold text-primary">💰 {{ number_format($property->price) }} EGP</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No properties found.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $properties->withQueryString()->links() }}
    </div>
</div>


@endsection
