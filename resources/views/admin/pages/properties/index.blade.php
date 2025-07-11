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
        <x-breadcrumb-item><a href="{{ route('home.index') }}">{{ 'Home' }}</a></x-breadcrumb-item>
        <x-breadcrumb-item>{{ __($propertyType->name) }}</x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumbs --}}
    <div class="card">
        <div class="card-header bg-white border-0">
            <h2 class="text-center text-dark fw-bold mb-0">{{ __('Properties') }}</h2>
        </div>
        <div class="card-body">
            {{-- Display success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Display error messages --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>


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
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative overflow-hidden property-card transition">
        
        <a href="{{ route('properties.show', ['property' => $property]) }}" class="text-decoration-none text-reset">
            @if ($property->images?->first())
                <img src="{{ asset('storage/' . $property->images->first()->path) }}"
                    class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light text-muted" 
                     style="height: 200px; border-top-left-radius: .75rem; border-top-right-radius: .75rem;">
                    <i class="bi bi-image" style="font-size: 2rem;"></i>
                    <span class="ms-2">No Image</span>
                </div>
            @endif

            <div class="card-body px-3 py-2">
                <h5 class="card-title text-dark fw-semibold mb-2">
                    {{ $property->title ?? 'Untitled Property' }}
                </h5>

                <ul class="list-unstyled text-muted small mb-2">
                    <li><i class="bi bi-rulers"></i> Area: {{ $property->land_area }} m²</li>
                    <li><i class="bi bi-building"></i> Hangar: {{ $property->hangar_area ?? 0 }} m² ({{ ucfirst($property->hangar_type ?? '-') }})</li>
                    <li><i class="bi bi-lightning-charge"></i> Electricity: {{ $property->electricity_power ?? 0 }} {{ strtoupper($property->electricity_unit) }}</li>
                </ul>

                <p class="fw-bold text-primary fs-6 mb-1">
                    💰 {{ number_format($property->price, 0) }} EGP
                </p>

                <small class="text-muted">Created: {{ $property->created_at->format('d M Y') }}</small>
            </div>
        </a>

        {{-- Footer buttons --}}
        <div class="card-footer bg-white border-top d-flex justify-content-between px-3 py-2">
            <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
            </a>

            <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>

    </div>
</div>

            @empty
                <div class="container w-50">
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
