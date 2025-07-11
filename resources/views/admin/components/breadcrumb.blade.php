@props(['pageName'])
<!-- Start  Page Title -->
<div class="pagetitle">
    <h1>{{ __(' صفحة'.$pageName) }}</h1>
    <nav>
      <ol class="breadcrumb mt-4">
        {{ $slot }}
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->
