<x-lobby>
    <div class="h-full bg-center bg-cover" style="background-image: url({{ asset('images/logo/bg-logo.svg') }})">
        <div class="body">
            <div class="header">
                <p>JADWAL PRAKTEK DOKTER</p>
                <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="bg-logo">
            </div>

            {{-- Carousel Container --}}
            <div class="slider carousel-interval owl-carousel owl-theme">
                @foreach ($data->chunk(9) as $chunkedDoctors) {{-- Chunk doctors into sets of 9 for 3x3 grid --}}
                    <div class="doctor-grid"> {{-- Grid inside each slide --}}
                        @foreach ($chunkedDoctors as $doctor)
                            <div class="doctor-card-wrapper">
                                @php
                                    $imageUrl = isset($doctor['image_url']) && $doctor['image_url'] ? asset('storage/' . $doctor['image_url']) : asset('images/avatar/av-1.svg');
                                @endphp
                                <img class="doctor-photo" src="{{ $imageUrl }}" alt="Doctor Photo">
                                <div class="doctor-card">
                                    <div class="spesialis">{{ $doctor['spesialis'] }}</div>
                                    <div class="doctor">{{ $doctor['nama_dokter'] }}</div>
                                    <div class="schedule">
                                        @php
                                            $ordered_weekdays = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];
                                            $has_appointment = false;
                                        @endphp

                                        @foreach ($ordered_weekdays as $weekday)
                                            <p class="schedule-item">
                                                <strong class="weekday">{{ \Illuminate\Support\Str::ucfirst($weekday) }}:</strong>
                                                <span class="time">
                                                    @if (isset($doctor['schedules'][$weekday]))
                                                        @php
                                                            $schedule_times = $doctor['schedules'][$weekday]->map(function ($schedule) use (&$has_appointment) {
                                                                if ($schedule['appointment']) {
                                                                    $has_appointment = true;
                                                                }
                                                                $time_str = str_pad($schedule['start_hour'], 2, '0', STR_PAD_LEFT) . ':' .
                                                                            str_pad($schedule['start_minute'], 2, '0', STR_PAD_LEFT) . ' - ' .
                                                                            str_pad($schedule['end_hour'], 2, '0', STR_PAD_LEFT) . ':' .
                                                                            str_pad($schedule['end_minute'], 2, '0', STR_PAD_LEFT);
                                                                return $schedule['appointment'] ? $time_str . ' *' : $time_str;
                                                            });
                                                        @endphp
                                                        {{ $schedule_times->implode(' | ') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                        @endforeach

                                        @if ($has_appointment)
                                            <p style="color: red"><small><em>* Appointment</em></small></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="footer">
                <p>CIPUTRA HOSPITAL | CITRA GARDEN CITY</p>
                <div class="footer-content">
                    <div class="footer-text">
                        <p>Informasi dan Pendaftaran</p>
                    </div>
                    <div></div>
                    <img src="{{ asset('images/logo/qr-lobby.png') }}" alt="bg-logo" class="small">

                </div>
            </div>
        </div>
    </div>

@push('scripts')
    @vite(['resources/js/plugins/owl.carousel.min.js'])
    <script type="module">
        $(".carousel-interval").owlCarousel({
            autoplay: true,
            autoplayTimeout: 12000,
            autoplayHoverPause: true,
            lazyLoad: true,
            loop: true,
            nav: true,
            items: 1, // Display one "slide" (grid of 9 cards) at a time
            dots: false, // Enable dots for navigation
        });
    </script>
@endpush

</x-lobby>
