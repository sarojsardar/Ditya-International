<!-- Favicon -->
<link rel="shortcut icon"
      href="@if (@$setting->site_logo) {{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }} @else {{ asset('assets/images/logo.png') }} @endif"
      type="image/x-icon">
<link rel="icon"
      href="@if (@$setting->site_logo) {{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }} @else {{ asset('assets/images/logo.png') }} @endif"
      type="image/x-icon">
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
    rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/remixicon/remixicon.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

<!-- Menu waves for no-customizer fix -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}"  />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"  />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!-- Form Validation -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}" />

<!-- Custom CSS -->
{{-- <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" /> --}}

<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>







