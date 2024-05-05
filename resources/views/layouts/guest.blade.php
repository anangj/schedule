<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Schedule') }}</title>
        <x-favicon/>
        {{-- Scripts --}}
        @vite(['resources/css/app.scss', 'resources/js/custom/store.js'])
    </head>
    <body>

        <div class="loginwrapper">
            <div class="lg-inner-column">
                
                <div class="right-column  relative">
                    <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>


        @vite(['resources/js/app.js'])
    </body>
</html>
