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
            height: 60px;
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
            height: 160px;
            width: 200px;
            border-radius: 50%;
            object-fit: inherit;
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

        @media screen and (max-width: 1152px) {
            .header {
                display: grid;
                grid-template-columns: 5fr 3fr;
            }

            .header p {
                text-align: center;
                padding: 30px 0;
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
            
            .header .img {
                align-items: center;
            }
        
            .footer {
                position: relative;
            }

            .schedule-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                /* Three columns */
                grid-template-rows: repeat(2, auto);
                /* Four rows */
                gap: 2px;
                /* Space between columns and rows */
            }

            .doctor-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                /* grid-template-rows: repeat(2, auto); */
                /* gap: 32px; */
                row-gap: 8px;
                column-gap: 32px;
                width: 100%;
            }

            .doctor-photo {
                height: 100px;
                width: 100px;
                border-radius: 50%;
                object-fit: cover;
            }

            .spesialis {
                font-size: clamp(14px, 4vw, 18px); /* Resize between 14px and 18px based on viewport */
                font-weight: bold;
                background-color: #464960;
                color: white;
                border-radius: 5px;
                /* padding: 5px; */
                margin-bottom: 5px;
                /* overflow-wrap: break-word; */
                white-space: normal; /* Allow text to wrap */
            }
        }
    </style>

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
