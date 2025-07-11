@extends('admin.layouts.app')
@section('title')
    {{ __('صفحة العقارات ') }}
@endsection
@section('css')
@endsection

@section('content')

    {{-- Start breadcrumbs --}}
    <x-breadcrumb pageName="العقارات">
        <x-breadcrumb-item><a href="{{ route('home.index') }}">{{ 'الصفحة الرئيسيية' }}</a></x-breadcrumb-item>
        <x-breadcrumb-item><a href="{{ route('properties.index',['propertyType'=>$property->propertyType?->id]) }}">{{ __($property->propertyType?->name) }}</a></x-breadcrumb-item>
        <x-breadcrumb-item>{{ $property->title }}</x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumbs --}}

    <div class="container-fluid px-4">

        <h2 class="mt-4 mb-3">{{ $property->title }} تفاصيل</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <h5><strong>الاسم:</strong></h5>
                    <p>{{ $property->title }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>الموقع:</strong></h5>
                    <p>{{ optional($property->location)->name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>تصنيف العقار:</strong></h5>
                    <p>{{ optional($property->propertyType)->name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>الحالة:</strong></h5>
                    <span class="badge bg-{{ $property->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>

                <div class="col-md-6">
                    <h5><strong>مساحة الارض:</strong></h5>
                    <p>{{ $property->land_area }} m²</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>نوع الهنجر:</strong></h5>
                    <p>{{ $property->hangar_type ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>مساحة ال{{ $property->hangar_type }} :</strong></h5>
                    <p>{{ $property->hangar_area ?? 'N/A' }} m²</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>ارتفاع ال{{ $property->hangar_type }} :</strong></h5>
                    <p>{{ $property->hangar_height ?? 'N/A' }} m</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>حمل الكهرباء:</strong></h5>
                    <p>{{ $property->electricity_power }} {{ $property->electricity_unit }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>تاريخ انتهاء الرخصة:</strong></h5>
                    <p>{{ optional($property->license_expiry_date)->format('d-m-Y') ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>عدد الرافعات:</strong></h5>
                    <p>{{ $property->cranes_count }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>عدد ادوار الاداري:</strong></h5>
                    <p>{{ $property->admin_floors ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h5><strong>السعر:</strong></h5>
                    <p>{{ number_format($property->price, 2) }} EGP</p>
                </div>

                <div class="col-md-12">
                    <h5><strong>ملاحظات:</strong></h5>
                    <p>{{ $property->notes }}</p>
                </div>

            </div>
        </div>

        {{-- Images Section --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>الصور</h5>
            </div>
            <div class="card-body">
                @if ($property->images && count($property->images))
                    <div class="row g-3">
                        @foreach ($property->images as $attachment)
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0">
                                    <img src="{{ asset('storage/' . $attachment->path) }}"
                                        class="img-fluid rounded cursor-pointer attachment-thumbnail"
                                        alt="{{ $attachment->file_name }}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-image="{{ asset('storage/' . $attachment->path) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>لايوجد صور متاحة.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Image Viewer Modal --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body text-center position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <img src="" class="img-fluid rounded" id="modalImage" alt="Preview">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.attachment-thumbnail').on('click', function() {
                console.log('Image clicked');
                const imageUrl = $(this).data('image');
                console.log(imageUrl);
                $('#modalImage').attr('src', imageUrl);
            });
        });
    </script>
@endsection
