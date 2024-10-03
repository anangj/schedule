<x-schedule>
    <div class="h-full bg-center bg-cover" style="background-image: url({{ asset('images/logo/bg-logo.svg') }});">
        <div class="w-full card">
            <div class="flex items-center w-full">
                <div class="flex-shrink-0 w-1/4 ml-5 sm:mr-36 sm:w-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" class="w-3/4">
                </div>
                <h1 class="font-bold basis-1/2" style="color: #003974">Petugas Kami Hari Ini</h1>
                <div id="clock" class="w-1/4 mr-5 text-2xl font-bold text-right sm:text-4xl sm:w-1/4" style="color: #000"></div>
            </div>
        </div>
        <div class="items-center py-2 mt-3 ml-5 mr-5 text-3xl text-center text-white card"
            style="background-color: #464960">{{ $today }} - {{ $shift }}
        </div>

        <!-- Carousel for Schedules and Personnel -->
        @php
            // Group the schedules by category
            $groupedSchedules = $schedules->groupBy('category');
        @endphp

        <div class="-mt-6 slider carousel-interval owl-carousel">
            @foreach ($groupedSchedules as $category => $schedules)
                <div class="item">
                    {{-- <h3 class="mb-4 text-xl font-bold">{{ $category }}</h3> --}}
                    @foreach ($schedules->chunk(8) as $scheduleChunk)
                        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 md:grid-cols-4">
                            @foreach ($scheduleChunk as $item)
                                <div class="p-4 bg-transparent rounded-lg">
                                    <div class="bg-transparent rounded-lg">
                                        <div class="text-lg font-bold text-green-600 speciality-name">{{ $item->speciality_name }}</div>
                                    </div>

                                    <div class="flex flex-col h-full">
                                        <div class="flex flex-col flex-grow">
                                            @foreach ($item->doctors as $index => $doctor)
                                                <div class="flex items-center p-2 mb-4 rounded-lg shadow-xl card h-36">
                                                    <div class="relative flex-shrink-0 w-40 h-32">
                                                        <img src="{{ $item->image_url[$index] ? asset('storage/' . $item->image_url[$index]) : asset('images/avatar/av-1.svg') }}" alt="img"
                                                            class="object-cover w-32 h-32 rounded-full">
                                                        <div class="absolute bottom-0 left-0 p-1 text-xs bg-white rounded-full">
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
                <div class="grid grid-cols-1 gap-4 mx-5 mt-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ($columns as $column)
                        <div>
                            @php
                                $displayedTitles = [];
                            @endphp
                            @foreach ($column as $item)
                                @if (!in_array($item['title'], $displayedTitles))
                                    <div class="mt-3 text-xl font-bold" style="color: #464960">{{ $item['title'] }}</div>
                                    @php
                                        $displayedTitles[] = $item['title'];
                                    @endphp
                                @endif
                                <div class="flex items-center p-2 mb-4 bg-white rounded-lg shadow-xl card h-36">
                                    <div class="relative flex-shrink-0 w-32 h-32">
                                        @php
                                            $imageUrl = isset($item['data']->image_url) && $item['data']->image_url ? asset('storage/' . $item['data']->image_url) : asset('images/avatar/av-1.svg');
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="img" class="object-cover w-32 h-32 rounded-full">

                                        @if(str_contains($item['data']->shift, 'PJ') || str_contains($item['data']->shift, 'KP') || str_contains($item['data']->shift, 'Office'))
                                            <div class="absolute bottom-0 left-0 p-1 text-xs bg-white rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 17.27l6.18 3.73-1.64-7.19 5.46-4.73-7.26-.61L12 2 9.26 8.47l-7.26.61 5.46 4.73-1.64 7.19L12 17.27z"/>
                                                </svg>
                                            </div>
                                        @endif
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
