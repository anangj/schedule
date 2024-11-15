<x-lobby>
    <div class="videos" style="width: 100%">
        @foreach ($contentEvents as $item)
            @if(Storage::exists($item->url))
                <video class="promoVideo" width="100%" style="height: 1080px; display: none;" controls autoplay muted>
                    <source src="{{ Storage::url($item->url) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <p>Video not available.</p>
            @endif
        @endforeach
    </div>

    <div class="body" id="body" style="display: none;"> <!-- Initially hidden -->
        <div class="header">
            <p>JADWAL PRAKTEK DOKTER</p>
            <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="bg-logo">
        </div>
        
        {{-- Carousel Container --}}
        <div class="slider carousel-interval owl-carousel owl-theme">
            @foreach ($data->chunk(9) as $chunkedDoctors)
                <div class="doctor-grid">
                    @foreach ($chunkedDoctors as $doctor)
                        <div class="doctor-card-wrapper">
                            @php
                                $imageUrl = isset($doctor['image_url']) && $doctor['image_url'] ? asset('storage/' . $doctor['image_url']) : asset('images/avatar/av-7.svg');
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
                                                            if ($schedule['start_hour'] === '0') {
                                                                return $schedule['appointment'] ? '<span style="color: red;">*</span>' : '<span>*</span>';
                                                            } else {
                                                                $time_str = str_pad($schedule['start_hour'], 2, '0', STR_PAD_LEFT) . ':' .
                                                                            str_pad($schedule['start_minute'], 2, '0', STR_PAD_LEFT) . ' - ' .
                                                                            str_pad($schedule['end_hour'], 2, '0', STR_PAD_LEFT) . ':' .
                                                                            str_pad($schedule['end_minute'], 2, '0', STR_PAD_LEFT);
                                                                return $schedule['appointment'] ? $time_str . ' <span style="color: red;">*</span>' : $time_str;
                                                            }
                                                        });
                                                    @endphp
                                                    {!! $schedule_times->implode(' | ') !!}
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
            <!-- Left Column: Text with Address -->
            <div class="left-column">
                <div>
                    <p>CIPUTRA HOSPITAL | CITRA GARDEN CITY</p>
                    <p class="address">Jl. Boulevard Raya No.1, Kalideres, Kota Jakarta Barat, Daerah Khusus Jakarta 11830</p>
                </div>
            </div>

            <!-- Right Column: Text and QR Code in One Row -->
            <div class="right-column">
                <div class="info-container">
                    <p>Informasi dan Pendaftaran</p>
                    <img src="{{ asset('images/logo/qr-lobby.png') }}" alt="QR Code" class="small">
                </div>
            </div>
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
            items: 1, // Display one "slide" (grid of 9 cards) at a time
            dots: false, // Enable dots for navigation
        });
    </script>
    {{-- <script type="module">
        document.addEventListener("DOMContentLoaded", function() {
            const promoVideo = document.getElementById('promoVideo');
            const body = document.getElementById('body');

            // Event listener for when the video ends
            promoVideo.addEventListener('ended', function() {
                console.log('The video has ended.');
                // Hide the video and show the carousel
                promoVideo.style.display = 'none'; // Hide the video
                body.style.display = 'block'; // Show the carousel
            });

            // Play the video every 5 minutes (300000 milliseconds)
            setInterval(() => {
                // Reset and play the video
                promoVideo.currentTime = 0; // Restart the video
                promoVideo.play(); // Play the video
                promoVideo.style.display = 'block'; // Ensure the video is displayed
                body.style.display = 'none'; // Hide the carousel while video plays
            }, 120000); // 5 minutes in milliseconds
        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const videos = document.querySelectorAll('.promoVideo');
            const carousel = document.getElementById('body');
            let currentVideo = 0;

            function playNextVideo() {
                if (currentVideo < videos.length) {
                    videos[currentVideo].style.display = 'block';
                    videos[currentVideo].play();
                    videos[currentVideo].onended = function() {
                        this.style.display = 'none'; // Hide current video
                        currentVideo++;
                        playNextVideo(); // Recursively play the next video
                    };
                } else {
                    showCarousel();
                }
            }

            function showCarousel() {
                carousel.style.display = 'block'; // Display the carousel
                setTimeout(function() {
                    carousel.style.display = 'none'; // Hide the carousel after 12 minutes
                    currentVideo = 0; // Reset video index
                    playNextVideo(); // Start playing videos again
                }, 300000); // 12 minutes in milliseconds
            }

            playNextVideo(); // Start playing videos
        });
    </script>
@endpush

</x-lobby>
