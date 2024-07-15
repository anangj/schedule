<x-schedule>
    <div class="bg-cover bg-center"
        style="background-image: url({{ asset('images/logo/background.svg') }}); height: 100%">
        <div class="card">
            <div class="flex items-center">
                <div class="ml-5 mr-36 basis-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" width="80%">
                </div>
                <h1 class="basis-1/2 font-bold" style="color: #003974">Petugas Kami Hari Ini</h1>
                <div id="clock" class="font-semibold text-4xl"></div>
            </div>
        </div>
        <div class="card mt-3 ml-5 mr-5 text-center items-center text-3xl py-2 text-white"
            style="background-color: #003974">{{ $today }} - {{ $shift }}</div>

        <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">DOKTER </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
            @foreach ($doctors as $doctor)
                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                    <img src="{{  asset('images/avatar/av-1.svg') }}" alt="{{ $doctor->employee_name }}" class="h-12 w-12 rounded-full object-cover">
                    <div class="col-span-6 flex items-center text font-bold">{{ $doctor->employee_name }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">PERAWAT </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
            @foreach ($nurses as $nurse)
            <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                <!-- Image column -->
                {{-- <div class="col-span-1 flex items-center"> --}}
                    <img src="{{  asset('images/avatar/av-1.svg') }}" alt="{{ $nurse->employee_name }}" class="h-12 w-12 rounded-full object-cover">
                {{-- </div> --}}
                <!-- Name column -->
                <div class="col-span-6 flex items-center text font-bold">
                    {{ $nurse->employee_name }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">DRIVER</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
            @foreach ($drivers as $driver)
                <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                    <img src="{{  asset('images/avatar/av-1.svg') }}" alt="{{ $driver->employee_name }}" class="h-12 w-12 rounded-full object-cover">
                    <div class="col-span-6 flex items-center text font-bold">{{ $driver->employee_name }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">NURSE ON DUTY </div>
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
