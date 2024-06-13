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
        <div class="mt-3 ml-5 text-xl font-bold" style="color: #008060">DOCTOR SPESIALIS (ON CALL)</div>
        {{-- <div class="mt-3"> --}}
            {{-- @foreach ($doctors as $doctor) --}}
            @for ($i = 0; $i < 3; $i++)
                <div class="grid grid-cols-6">
                    @foreach ($doctors as $doctor)
                        <div>
                            <div class="ml-5 mt-2 text-xl font-bold" style="color: #008060">{{ $doctor->specialty }}</div>
                            <div class="grid grid-rows-2 mt-2 ml-5">
                                <div class="card shadow-md my-1">
                                    <div class="grid grid-cols-4 gap-1">
                                        <div class="relative">
                                            <img src="{{ asset('images/avatar/' . $doctors[0]->photo) }}" alt="img">
                                            <div class="absolute bottom-0 right-0">
                                                <div class="text-sm">1</div>
                                            </div>
                                        </div>
                                        <div class="col-span-3 flex items-center text font-bold">{{ $doctors[0]->name }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card shadow-md">
                                    <div class="grid grid-cols-4 gap-1">
                                        <div class="relative">
                                            <img src="{{ asset('images/avatar/' . $doctors[1]->photo) }}" alt="img">
                                            <div class="absolute bottom-0 right-0">
                                                <div class="text-sm">2</div>
                                            </div>
                                        </div>
                                        <div class="col-span-3 flex items-center text font-bold">{{ $doctors[1]->name }}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            @endfor

            {{-- @endforeach --}}
            {{-- <div class="grid grid-cols-3 gap-4 mt-5">
                @foreach ($specialties as $specialty => $doctors)
                    <div class="col-span-3 text-center text-2xl font-bold mb-2" style="color: #008060">{{ $specialty }}</div>
                    @foreach ($doctors as $doctor)
                        <div class="border p-4">
                            <div class="flex items-center mt-2">
                                <div class="w-1/4">
                                    <img src="{{ asset('images/doctors/' . $doctor->photo) }}" alt="Doctor" class="w-full">
                                </div>
                                <div class="w-3/4 pl-2">
                                    <p class="text-lg font-semibold">{{ $doctor->name }}</p>
                                    <p>{{ $doctor->qualification }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div> --}}
        {{-- </div> --}}
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
