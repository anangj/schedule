<x-schedule>
    <div class="bg-cover bg-center h-full" style="background-image: url({{ asset('images/logo/background.svg') }});">
        <div class="card w-full">
            <div class="flex items-center w-full">
                <div class="ml-5 sm:mr-36 flex-shrink-0 w-1/4 sm:w-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" class="w-3/4">
                </div>
                {{-- <div id="header-text" class="text-center sm:text-left flex-1 font-bold text-2xl sm:text-4xl text-responsive text-blue-900">
                    PETUGAS KAMI HARI INI
                </div> --}}
                <h1 class="basis-1/2 font-bold" style="color: #003974">Petugas Kami Hari Ini</h1>
                <div id="clock" class="font-bold text-2xl sm:text-4xl w-1/4 sm:w-1/4 text-right mr-5"></div>
            </div>
        </div>
        {{-- <div class="card w-full mt-2">
            <div class="flex flex-wrap items-center w-full">
                <div class="ml-16 mr-8 sm:mr-48 flex-shrink-0 w-1/4 sm:w-1/4">
                </div>
                <div id="header-text" class="text-left sm:text-left flex-1 font-bold text-2xl sm:text-4xl text-responsive text-blue-900">
                    {{ $today }}
                </div>
                <div id="clock" class="font-bold text-2xl sm:text-4xl w-1/4 sm:w-1/4 text-right">
                </div>
            </div>
        </div> --}}
        <div class="card mt-3 ml-5 mr-5 text-center items-center text-3xl py-2 text-white"
            style="background-color: #003974">{{ $today }} - {{ $shift }}
        </div>
        {{-- <div class="card mt-3 mx-5 text-center items-center text-xl sm:text-3xl py-2 text-blue-900">
            {{ $today }}
        </div> --}}

        <!-- Carousel for Schedules and Personnel -->
        <div class="slider carousel-interval owl-carousel -mt-4">
            @foreach ($schedules->chunk(8) as $scheduleChunk)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-1 p-6 mt-3">
                    @foreach ($scheduleChunk as $item)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <div class="text-lg font-bold text-green-600 mb-2">{{ $item->speciality_name }}</div>
                            <div class="grid grid-rows-2 gap-1">
                                @foreach ($item->doctors as $doctor)
                                    <div class="card shadow-md rounded-lg flex items-center p-2">
                                        <div class="relative w-16 h-16 flex-shrink-0">
                                            <img src="{{ asset('images/avatar/av-1.svg') }}" alt="img"
                                                class="w-full h-full object-cover rounded-full">
                                            <div class="absolute bottom-0 left-0 bg-white rounded-full text-xs p-1">
                                                {{ $loop->iteration }}</div>
                                        </div>
                                        <div class="ml-4 text-md font-bold">{{ $doctor }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <!-- Card for Doctors, Nurses, and Drivers -->
            <div class="p-6">
                @foreach ($personnel->groupBy('title') as $title => $group)
                    <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">{{ $title }}</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
                        @foreach ($group as $item)
                            <div class="grid grid-cols-7 gap-1 bg-white p-4 rounded shadow">
                                <img src="{{ asset('images/avatar/av-1.svg') }}"
                                    alt="{{ $item['data']->employee_name }}"
                                    class="h-12 w-12 rounded-full object-cover">
                                <div class="col-span-6 flex items-center text font-bold">
                                    {{ $item['data']->employee_name }}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/plugins/owl.carousel.min.js'])
        <script type="module">
            $(".carousel-interval").owlCarousel({
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                lazyLoad: true,
                loop: true,
                nav: false,
                items: 1,
                dots: false,
            });

            function updateClock() {
                var now = new Date();
                var hours = String(now.getHours()).padStart(2, '0');
                var minutes = String(now.getMinutes()).padStart(2, '0');
                var seconds = String(now.getSeconds()).padStart(2, '0');
                var timeString = hours + ':' + minutes + ':' + seconds + ' WIB';
                document.getElementById('clock').textContent = timeString;

                checkRefreshTime(now);
            }

            function checkRefreshTime(currentTime) {
                // Define refresh times
                var refreshTimes = ['07:01', '13:30', '21:01'];
                var currentTimeString = currentTime.getHours().toString().padStart(2, '0') + ':' + currentTime.getMinutes()
                    .toString().padStart(2, '0');

                // Check if current time matches any refresh time
                if (refreshTimes.includes(currentTimeString)) {
                    window.location.reload(); // Refresh the page
                }
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush
</x-schedule>
