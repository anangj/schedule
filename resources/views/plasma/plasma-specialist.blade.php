<x-schedule>
    <div class="bg-cover bg-center h-full"
        style="background-image: url({{ asset('images/logo/background.svg') }});">
        <div class="card w-full">
            <div class="flex flex-wrap items-center w-full">
                <div class="ml-5 mr-8 sm:mr-36 flex-shrink-0 w-1/4 sm:w-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" class="w-3/4">
                </div>
                <div id="header-text" class="text-center sm:text-left flex-1 font-bold text-2xl sm:text-4xl text-responsive text-blue-900">
                    DOKTER SPESIALIS (ON CALL)
                </div>
                <div id="clock" class="font-semibold text-2xl sm:text-4xl w-1/4 sm:w-1/4 text-right"></div>
            </div>
        </div>
        <div class="card mt-3 mx-5 text-center items-center text-xl sm:text-3xl py-2 text-blue-900">
            {{ $today }}
        </div>
        <div class="slider carousel-interval owl-carousel -mt-4">
            @foreach ($schedules->chunk(8) as $scheduleChunk)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-1 p-6">
                    @foreach ($scheduleChunk as $item)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <div class="text-lg font-bold text-green-600 mb-2">{{ $item->speciality_name }}</div>
                            <div class="grid grid-rows-2 gap-1">
                                @foreach ($item->doctors as $doctor)
                                    <div class="card shadow-md rounded-lg flex items-center p-2">
                                        <div class="relative w-16 h-16 flex-shrink-0">
                                            <img src="{{ asset('images/avatar/av-1.svg') }}" alt="img" class="w-full h-full object-cover rounded-full">
                                            <div class="absolute bottom-0 left-0 bg-white rounded-full text-xs p-1">{{ $loop->iteration }}</div>
                                        </div>
                                        <div class="ml-4 text-md font-bold">{{ $doctor }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/plugins/owl.carousel.min.js'])
        <script type="module">
            $(".carousel-interval").owlCarousel({
                autoplay: true,
                autoplayTimeout: 10000,
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
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush
</x-schedule>

<script></script>

{{-- <x-schedule>

    <div class="text-center mt-5">
                <h2 class="text-2xl">Senin, 10 Juni 2024 - PAGI</h2>
            </div>
            <div class="mt-10 px-10">
                <h3 class="text-xl font-bold text-green-700">DOKTER SPESIALIS (ON CALL)</h3>
                <div class="grid grid-cols-3 gap-4 mt-5">
                    @for ($i = 0; $i < 9; $i++)
                        <div class="border p-4">
                            <h4 class="text-lg font-semibold">Spesialis Anak</h4>
                            <div class="flex items-center mt-2">
                                <div class="w-1/4">
                                    <img src="{{ asset('images/doctor-placeholder.png') }}" alt="Doctor" class="w-full">
                                </div>
                                <div class="w-3/4 pl-2">
                                    <p>dr. William Soeryaatmadja, Sp.PD, FPCP</p>
                                    <p>dr. Diyas Anugrah, Sp.A</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>


    <div class="card">
        
        <div class="flex pt-10">
            <div class="ml-5 mr-20 basis-1/4">
                <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" width="80%">
            </div>
            <h1 class=" basis-1/2">PETUGAS KAMI HARI INI</h1>
            <div id="clock" class="font-semibold text-4xl"></div>
        </div>
        <div class="date-schedule">{{ $today }} - {{ $shift }}</div>
        <div class="card mt-12">
            <div class="card-body ">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                  <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 5%">DOKTER</th>
                                    <th style="width: 15%">PERAWAT</th>
                                    <th style="width: 15%">DOKTER SPESIALIS (ON CALL)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($schedules); $i++)
                                <tr>
                                    <td style="width: 15%">{{ $drivers[$i]->employee_name }}</td>
                                    <td style="width: 15%">{{ $schedules[$i]->employee_name }}</td>
                                    <td style="width: 15%">{{ $schedules[$i]->employee_name }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 25%">DRIVER</th>
                                    <th style="width: 25%">NURSE ON DUTY</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($drivers); $i++)
                                <tr>
                                    <td style="width: 25%">{{ $drivers[$i]->employee_name }}</td>
                                    <td style="width: 25%">{{ $drivers[$i]->employee_name }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
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
</script> --}}
