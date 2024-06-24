<x-schedule>

    <div class="bg-cover bg-center" style="background-image: url({{ asset('images/logo/background.svg') }}); height: 100%">
        <div class="card">
            <div class="flex items-center">
                <div class="ml-5 mr-36 basis-1/4">
                    <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" width="80%">
                </div>
                <h1 class="basis-1/2 font-bold" style="color: #003974">Petugas Kami Hari Ini</h1>
                <div id="clock" class="font-semibold text-4xl"></div>
            </div>
        </div>
    </div>
    {{-- <div class="card">
        
        <div class="flex pt-10">
            <div class="ml-5 mr-20 basis-1/4">
                <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" width="50%">
            </div>
            <h1 class=" basis-1/2">PETUGAS KAMI HARI INI</h1>
            <div class="font-semibold text-4xl">{{ now()->format('H:i') }} WIB</div>
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
                                    <th style="width: 50%">DOKTER</th>
                                    <th style="width: 50%">PERAWAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($schedules); $i++)
                                <tr>
                                    <td style="width: 50%">{{ $drivers[$i]->employee_name }}</td>
                                    <td style="width: 50%">{{ $schedules[$i]->employee_name }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 50%">DRIVER</th>
                                    <th style="width: 50%">NURSE ON DUTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($drivers); $i++)
                                <tr>
                                    <td style="width: 50%">{{ $drivers[$i]->employee_name }}</td>
                                    <td style="width: 50%">{{ $drivers[$i]->employee_name }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div> --}}
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