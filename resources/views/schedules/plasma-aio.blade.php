<x-schedule>
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
                                    <th style="width: 5%">PERAWAT</th>
                                    <th style="width: 5%">DOKTER SPESIALIS (ON CALL)</th>
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
                        
                        {{-- <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Dr. Specialist</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 5; $i++)
                                <tr>
                                    <td>{{ $pagi['dokter'][$i]['spesialis'] ?? 'Tidak tersedia' }} - {{ $pagi['dokter'][$i]['nama'] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $pagi['perawat'][$i]['spesialis'] ?? 'Tidak tersedia' }} - {{ $pagi['perawat'][$i]['nama'] ?? 'Tidak tersedia' }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table> --}}
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
    updateClock(); // initial call to display clock immediately
</script>