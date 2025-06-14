@extends('admin.layouts.app')
@section('title')
{{ __('Profile Page ') }}

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
    <x-breadcrumb pageName="Profile">
        <x-breadcrumb-item>{{ __('Profile') }}</x-breadcrumb-item>
    </x-breadcrumb>
{{-- End breadcrumbs --}}
<div class="container py-5">

    <div class="row g-4">
        <div class="col-md-12 col-lg-12">
            <div class="card h-100 shadow-sm border-0 rounded-4 transition hover-shadow">
                <div class="card-body p-5">
                    <h2 class="text-center text-dark fw-bold mb-4">{{ __('Profile Information') }}</h2>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-12">
            <div class="card h-100 shadow-sm border-0 rounded-4 transition hover-shadow">
                <div class="card-body p-5">
                    <h2 class="text-center text-dark fw-bold mb-4">{{ __('Update Password') }}</h2>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- <div class="col-md-12 col-lg-12">
            <div class="card h-100 shadow-sm border-0 rounded-4 transition hover-shadow">
                <div class="card-body p-5">
                    <h2 class="text-center text-dark fw-bold mb-4">{{ __('Delete Account') }}</h2>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div> --}}
    </div>
</div>


@endsection
