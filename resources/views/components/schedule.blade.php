<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light nav-floating">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-favicon />
    <title>{{ config('app.name', 'Schedule') }}</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        } */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* margin: 0; */
            /* padding: 20px; */
            transform: scale(0.8);
            transform-origin: top left;
            /* Optional: Adjust width to prevent horizontal scroll after scaling */
            width: 125%;
        }

        .header {
            background-color: #cfe2f3;
            padding: 10px;
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        .date {
            text-align: center;
            margin-top: 5px;
            font-size: 18px;
            color: #666;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 8px;

        }

        th {
            background-color: #003974;
            color: white;
        }

        .shift {
            background-color: #464960;
            color: white;
            font-size: 16px;
        }
    </style>

    {{-- Scripts --}}
    @vite(['resources/css/app.scss', 'resources/js/custom/store.js'])
</head>

<body class="font-inter">
    {{-- <div class="app-wrapper">
        <div class="page-content">
            <div class="transition-all duration-150 container-fluid">
                <main id="content_layout"> --}}
                    <!-- Page Content -->
                    {{ $slot }}
                {{-- </main>
            </div>
        </div>
    </div> --}}

    @vite(['resources/js/app.js', 'resources/js/main.js'])


    @stack('scripts')
</body>


</html>
