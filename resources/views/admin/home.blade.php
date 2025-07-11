@extends('admin.layouts.app')
@section('title')
{{ __('Home Page ') }}

@endsection
@section('css')
<style>
    .transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow:hover {
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-4px);
    background-color: gray;
}

</style>
@endsection
@section('content')
{{-- Start breadcrumbs --}}
    <x-breadcrumb pageName=" الرئيسية">
        <x-breadcrumb-item>{{ __('الصفحة الرئيسية') }}</x-breadcrumb-item>
    </x-breadcrumb>
{{-- End breadcrumbs --}}
<div class="container py-5">
    <div class="row my-3">
                    @if (App\Traits\AppHelper::perUser('properties.create'))
                <div class="text-end">
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        {{ __('اضافة عقار جديد') }}
                    </a>
                </div>
                
            @endif
    </div>
    <div class="row g-4">
        @foreach ($propertyTypes as $type)
            <div class="col-md-6 col-lg-6">
                <a href="{{ route('properties.index',['propertyType'=>$type->id]) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 rounded-4 transition hover-shadow">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
                            <div class="icon mb-3">
                                <i class="bi bi-building fs-1 text-primary"></i> {{-- Optional icon --}}
                            </div>
                            <h2 class=" text-center text-dark fw-bold">
                                {{ $type->name }}
                            </h2>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>


@endsection
