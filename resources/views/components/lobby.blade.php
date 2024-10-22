<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light nav-floating">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-favicon />
    <title>{{ config('app.name', 'Lobby') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            /* padding-top: 20px; */
            width: 100%;
            height: 100%;
            padding-bottom: 100px;
        }

        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
        }

        .header {
            display: grid;
            grid-template-columns: 12fr 3fr;
        }
        .footer {
            display: grid;
            grid-template-columns: 12fr 4fr;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            /* background: linear-gradient(135deg, #003974, #008060); */
            background-color: #464960;
            color: white;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            height: 100px;
        }

        .footer .left-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .footer .left-column .address {
            font-size: 20px; /* Smaller font for the address */
            margin-top: 5px; /* Add spacing between the main text and the address */
        }

        .footer .right-column {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer .right-column .info-container {
            display: flex;
            align-items: center; /* Align items vertically in the center */
        }

        .footer .right-column .info-container p {
            margin-right: 10px; /* Add some space between the text and the image */
        }

        .footer .right-column .info-container img.small {
            width: 80px; /* Adjust size of the QR code */
        }

        .header p {
            text-align: center;

            padding: 20px 0;
            /* background: linear-gradient(135deg, #003974, #008060); */
            background-color: #464960;
            color: white;
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 4px;
            /* border-radius: 10px; */
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .footer p {
            text-align: center;

            /* padding: 10px 0; */
            /* background: linear-gradient(135deg, #003974, #008060); */
            color: white;
            font-size: 24px;
            font-weight: bold;
            /* margin-bottom: 10px; */
            /* border-radius: 10px; */
        }
        .footer img.small {
            width: 100px;
            height: auto;
            margin-left: 10px;
        }

        .footer-content {
            display: flex;
            align-items: center;
        }

        .footer-text {
            text-align: left; /* Align the text to the left of the QR code */
        }

        .footer-text p {
            margin-left: 0;
            font-size: 20px;
        }

        .spesialis {
            flex-grow: 1;
            background-color: #464960;
            border-radius: 4px;
            color: white;
            text-align: center;
            font-size: 24px;
            /* border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px; */
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* Three columns */
            grid-template-rows: repeat(4, auto);
            /* Four rows */
            gap: 2px;
            /* Space between columns and rows */
        }

        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(4, auto);
            /* gap: 32px; */
            row-gap: 8px;
            column-gap: 32px;
            width: 100%;
        }

        .doctor-card-wrapper {
            display: flex;
            align-items: center;
            background-color: transparent;
            border-radius: 8px;
            padding: 2px;
        }

        .doctor-photo {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
        }

        .doctor-card {
            flex-grow: 1;
            background-color: #fff;
            border-radius: 20px;
        }

        /* .doctor-card h3 {
            font-size: 22px;
            color: #000;
            font-weight: 700;
        } */
        .spesialis {
            font-size: clamp(14px, 4vw, 18px); /* Resize between 14px and 18px based on viewport */
            font-weight: bold;
            background-color: #464960;
            color: white;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            overflow-wrap: break-word; /* Break long words if necessary */
            white-space: normal; /* Allow text to wrap */
        }

        .doctor {
            /* font-size: clamp(16px, 4vw, 22px); Resize between 16px and 22px based on viewport */
            color: #000;
            font-weight: 700;
            text-decoration: underline;
            margin-left: 6px;
            /* margin-bottom: 10px; */
            overflow-wrap: break-word; /* Break long words if necessary */
            white-space: normal; /* Allow text to wrap */
        }

        .doctor-card p {
            margin: 2px 0;
            /* Compact spacing */
            color: #000;
        }


        .schedule {
            background-color: #fff;
            color: white;
            padding-bottom: 4px;
            /* padding-top: 4px; */
            border-radius: 8px;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            /* margin-top: 8px; */
        }

        .schedule p {
            font-size: 16px;
            padding-left: 6px;
        }

        .schedule-item {
            display: flex;
        }
        .weekday {
            width: 100px;
            text-align: left;
        }
        .time {
            flex-grow: 1;
            text-align: left;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1024px) {
            .schedule-grid {
                grid-template-columns: repeat(2, 1fr);
                /* Two columns on medium screens */
                grid-template-rows: auto;
                /* Rows will adjust automatically */
            }
        }

        @media screen and (max-width: 768px) {
            .schedule-grid {
                grid-template-columns: 1fr;
                /* One column on small screens */
                grid-template-rows: auto;
                /* Rows will adjust automatically */
            }
        }
    </style>

    {{-- <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            width: 100vw;
            height: 100vh;
            overflow: hidden; /* Prevent scrolling */
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 1392px;
            margin: auto;
            padding: 20px;
            height: 100%;
        }

        .header {
            display: grid;
            grid-template-columns: 7fr 3fr;
            align-items: center;
            margin-bottom: 10px;
        }

        .footer {
            display: grid;
            grid-template-columns: 7fr 4fr;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #003974, #008060);
            color: white;
            text-align: center;
            font-size: clamp(16px, 1.5vw, 18px); /* Responsive font size */
            font-weight: bold;
            height: 100px;
            max-height: 15vh; /* Adjust to a max height of 15% of the viewport height */
        }

        .footer .left-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 10px;
        }

        .footer .left-column .address {
            font-size: clamp(14px, 1.5vw, 16px); /* Responsive font size */
            margin-top: 5px;
        }

        .footer .right-column {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer .right-column .info-container {
            display: flex;
            align-items: center;
        }

        .footer .right-column .info-container p {
            margin-right: 10px;
        }

        .footer .right-column .info-container img.small {
            width: 80px;
            height: auto;
        }

        .header p {
            text-align: center;
            padding: 20px 0;
            background: linear-gradient(135deg, #003974, #008060);
            color: white;
            font-size: clamp(20px, 2vw, 24px); /* Responsive font size */
            font-weight: bold;
            margin: 0;
            border-radius: 10px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
            max-width: 100%;
            height: calc(100vh - 200px); /* Adjust grid height to fill available space */
        }

        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(4, auto);
            gap: 2px;
        }

        .doctor-card-wrapper {
            display: flex;
            align-items: center;
            background-color: transparent;
            border-radius: 8px;
            padding: 4px;
        }

        .doctor-photo {
            height: clamp(80px, 10vw, 100px); /* Responsive image size */
            width: clamp(80px, 10vw, 100px); /* Keep image aspect ratio */
            border-radius: 50%;
            object-fit: cover;
        }

        .doctor-card {
            flex-grow: 1;
            background-color: #fff;
            border-radius: 20px;
            padding: 10px;
        }

        .spesialis {
            font-size: clamp(14px, 1.5vw, 18px); /* Responsive font size */
            font-weight: bold;
            background-color: #008464960060;
            color: white;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            overflow-wrap: break-word;
        }

        .doctor {
            font-size: clamp(16px, 2vw, 20px); /* Responsive font size */
            color: #000;
            font-weight: 700;
            margin-bottom: 10px;
            overflow-wrap: break-word;
        }

        .schedule {
            background-color: #fff;
            color: black;
            padding: 5px;
            border-radius: 8px;
        }

        .schedule p {
            font-size: clamp(12px, 1vw, 16px); /* Responsive font size */
            padding-left: 6px;
        }

        .schedule-item {
            display: flex;
            align-items: center;
        }

        .weekday {
            width: 100px;
            text-align: left;
        }

        .time {
            flex-grow: 1;
            text-align: left;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1024px) {
            .schedule-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 768px) {
            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }

    </style> --}}

    {{-- Scripts --}}
    @vite(['resources/css/app.scss', 'resources/js/custom/store.js'])
</head>

<body class="font-inter">
    {{-- <div class=" app-wrapper">
    <div class="page-content">
        <div class="transition-all duration-150 container-fluid">
            <main id="content_layout"> --}}
                <!-- Page Content -->
                {{ $slot }}
                {{--
            </main>
        </div>
    </div>
    </div> --}}

    @vite(['resources/js/app.js', 'resources/js/main.js'])


    @stack('scripts')
</body>


</html>
