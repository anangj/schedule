<x-schedule>
    <div class="bg-cover bg-center"
        style="background-image: url({{ asset('images/logo/background.svg') }}); height: 100%">
        <div class="card w-full">
            <div class="flex items-center w-full">
                <div class="ml-5 mr-8 sm:mr-36 flex-shrink-0 w-1/4 sm:w-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" class="w-3/4">
                </div>
                {{-- <div id="header-text" class="text-center sm:text-left flex-1 font-bold text-2xl sm:text-4xl text-responsive text-blue-900">
                    PETUGAS KAMI HARI INI
                </div> --}}
                <h1 class="basis-1/2 font-bold" style="color: #003974">Petugas Kami Hari Ini</h1>
                <div id="clock" class="font-bold text-2xl sm:text-4xl w-1/4 sm:w-1/4 text-right"></div>
            </div>
        </div>

        <div class="card mt-3 ml-5 mr-5 text-center items-center text-3xl py-2 text-white"
            style="background-color: #003974">{{ $today }} - {{ $shift }}
        </div>


        <div class="runtext-container">
            <div class="main-text">
                <marquee direction="" onmouseover="this.stop();" onmouseout="this.start();">
                    <div class="holder">
                        <div class="mt-3 ml-5 text-xl font-bold" style="color: #464960">DOKTER </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
                            @foreach ($doctors as $doctor)
                                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                                    <img src="{{ $doctor->image_url ? $doctor->image_url : asset('images/avatar/av-1.svg') }}" alt="{{ $doctor->employee_name }}"
                                        class="h-12 w-12 rounded-full object-cover">
                                    <div class="col-span-6 flex items-center text font-bold">
                                        {{ $doctor->employee_name }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3 ml-5 text-xl font-bold" style="color: #464960">PERAWAT </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
                            @foreach ($nurses as $nurse)
                                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                                    <!-- Image column -->
                                    {{-- <div class="col-span-1 flex items-center"> --}}
                                    <img src="{{ asset('images/avatar/av-1.svg') }}" alt="{{ $nurse->employee_name }}"
                                        class="h-12 w-12 rounded-full object-cover">
                                    {{-- </div> --}}
                                    <!-- Name column -->
                                    <div class="col-span-6 flex items-center text font-bold">
                                        {{ $nurse->employee_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3 ml-5 text-xl font-bold" style="color: #464960">DRIVER</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
                            @foreach ($drivers as $driver)
                                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                                    <img src="{{ asset('images/avatar/av-1.svg') }}" alt="{{ $driver->employee_name }}"
                                        class="h-12 w-12 rounded-full object-cover">
                                    <div class="col-span-6 flex items-center text font-bold">{{ $driver->employee_name }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </marquee>
            </div>
        </div>






        {{-- <div class="mt-3 ml-5 text-xl font-bold" style="color: #464960">NURSE ON DUTY </div> --}}
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
            @foreach ($schedules as $schedule)
                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                    <img src="{{  asset('images/avatar/av-1.svg') }}" alt="{{ $schedules->employee_name }}" class="h-12 w-12 rounded-full object-cover">
                    <div class="col-span-6 flex items-center text font-bold">{{ $schedules[0]->employee_name }}</div>
                </div>
            @endforeach
        </div> --}}

    </div>
</x-schedule>

<script>
    function updateClock() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        var timeString = hours + ':' + minutes + ':' + seconds + ' WIB';
        document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
