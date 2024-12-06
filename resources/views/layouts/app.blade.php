<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Highchart App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Vector Map css -->
    {{-- <link href="{{ asset('vendor/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="{{ asset('js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .btn-excel-hidden {
            display: none; /* Sembunyikan tombol */
        }
        .btn-pdf-hidden {
            display: none; /* Sembunyikan tombol */
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    {{-- <div class="wrapper">
        @include('components.app.navbar')
        @include('components.app.sidebar')
        <div class="content-page">
            <div class="content"> --}}

                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div>

            {{-- </div>
        </div>
    </div> --}}
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <!-- Code Highlight js -->
    <script src="{{ asset('vendor/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('vendor/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('js/hyper-syntax.js') }}"></script>

    <!-- Highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script>
        function formatDate(date){
            let d = new Date(date);
            const formattedDate = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);
            return formattedDate;
        }

        function formatCurrency(num) {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return 'IDR ' + num_parts.join(".");
        }
        function divider(num) {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return ' ' + num_parts.join(".");
        }
        function newDivider(num) {
            var numString = num.toString();
            var num_parts = numString.split(".");

            // Memisahkan dua digit terakhir dari bagian desimal
            var lastTwoDecimals = num_parts[1] ? num_parts[1].substr(0, 2) : "00";
            
            // Menggabungkan dua digit pertama desimal ke bagian yang sudah diformat
            var formattedNum = num_parts[0] + "." + lastTwoDecimals;

            // Memformat bagian sebelum titik desimal dengan titik sebagai pemisah ribuan
            formattedNum = formattedNum.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            return formattedNum;
        }
        const loadFile = function (event) {
            const output = document.getElementById("output");
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src); // free memory
            };
        };

        const loadFileMultiple = function (event, idView) {
            const output = document.getElementById(idView);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src); // free memory
            };
        };
    </script>
    @yield('js-page')
</body>

</html>