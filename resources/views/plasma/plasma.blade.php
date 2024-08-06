<x-schedule>
    <div class="bg-cover bg-center h-full" style="background-image: url({{ asset('images/logo/bg-logo.svg') }});">
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
        @php
            // Group the schedules by category
            $groupedSchedules = $schedules->groupBy('category');
        @endphp

        <div class="slider carousel-interval owl-carousel -mt-6">
            @foreach ($groupedSchedules as $category => $schedules)
                <div class="item">
                    {{-- <h3 class="text-xl font-bold mb-4">{{ $category }}</h3> --}}
                    @foreach ($schedules->chunk(8) as $scheduleChunk)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-6">
                            @foreach ($scheduleChunk as $item)
                                <div class="bg-transparent rounded-lg p-4">
                                    <div class="bg-transparent rounded-lg">
                                        <div class="speciality-name text-lg font-bold text-green-600">{{ $item->speciality_name }}</div>
                                    </div>

                                    <div class="flex flex-col h-full">
                                        <div class="flex flex-col flex-grow">
                                            @foreach ($item->doctors as $index => $doctor)
                                                <div class="card shadow-xl rounded-lg flex items-center p-2 mb-4 h-36">
                                                    <div class="relative w-40 h-32 flex-shrink-0">
                                                        <img src="{{ $item->image_url[$index] ? asset('storage/' . $item->image_url[$index]) : asset('images/avatar/av-1.svg') }}" alt="img"
                                                            class="w-32 h-32 object-cover rounded-full">
                                                        <div class="absolute bottom-0 left-0 bg-white rounded-full text-xs p-1">
                                                            {{ $loop->iteration }}</div>
                                                    </div>
                                                    <div class="ml-4 text-xl font-bold">{{ $doctor }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            @endforeach

            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mx-5 mt-2">
                    @foreach ($columns as $column)
                        <div>
                            @php
                                $displayedTitles = [];
                            @endphp
                            @foreach ($column as $item)
                                @if (!in_array($item['title'], $displayedTitles))
                                    <div class="mt-3 text-xl font-bold" style="color: #008060">{{ $item['title'] }}</div>
                                    @php
                                        $displayedTitles[] = $item['title'];
                                    @endphp
                                @endif
                                <div class="card shadow-xl rounded-lg flex items-center p-2 mb-4 h-36 bg-white">
                                    <div class="relative w-32 h-32 flex-shrink-0">
                                        @php
                                            $imageUrl = isset($item['data']->image_url) && $item['data']->image_url ? asset('storage/' . $item['data']->image_url) : asset('images/avatar/av-1.svg');
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="img" class="w-32 h-32 object-cover rounded-full">
                                    </div>
                                    <div class="ml-6 text-lg font-bold">{{ $item['data']->employee_name }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/plugins/owl.carousel.min.js'])
        <script type="module">
            $(".carousel-interval").owlCarousel({
                autoplay: true,
                autoplayTimeout: 5000,
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

            }

            function scheduleRefresh() {
                var now = new Date();
                var nextRefresh = getNextRefreshTime(now);
                var delay = nextRefresh - now;

                setTimeout(function() {
                    window.location.reload();
                }, delay);
            }

            function getNextRefreshTime(currentTime) {
                var refreshTimes = ['07:02', '08:00', '13:32', '21:02', '16:02', '17:02']; // Define refresh times
                var nextRefresh = new Date(currentTime.toISOString().slice(0,
                    10)); // Set to today's date with time reset to midnight

                refreshTimes = refreshTimes.map(time => {
                    var [hours, minutes] = time.split(':');
                    var date = new Date(nextRefresh.getTime());
                    date.setHours(hours, minutes);
                    return date;
                });

                // Find the next refresh time that is later than the current time
                var futureTimes = refreshTimes.filter(time => time > currentTime);
                if (futureTimes.length === 0) {
                    // If all times are past, set the next refresh for the first refresh time tomorrow
                    nextRefresh.setDate(nextRefresh.getDate() + 1);
                    nextRefresh.setHours(refreshTimes[0].getHours(), refreshTimes[0].getMinutes());
                    return nextRefresh;
                }

                // Return the nearest future refresh time
                return futureTimes[0];
            }

            // Initialize the refresh schedule
            scheduleRefresh();
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush
</x-schedule>
