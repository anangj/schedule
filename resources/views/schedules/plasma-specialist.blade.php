<x-schedule>
    <div class="card">
        <div class="flex pt-10">
            <div class="ml-5 mr-20 basis-1/4">
                <img src="{{ asset('images/logo/logo-hospital-general.png') }}" alt="Logo" width="50%">
            </div>
            <h1 class=" basis-1/2">PETUGAS KAMI HARI INI</h1>
            <div class="font-semibold text-4xl">{{ now()->format('H:i') }} WIB</div>
        </div>
        <div class="date-schedule">{{$today}} - {{$shift}}</div>
        <div class="card mt-24">
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                  <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table>
                            <thead>
                                <tr>
                                    <th>DOKTER SPECIALIST (ON CALL)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($schedules); $i++)
                                <tr>
                                    <td style="width: 10%">{{ $schedules[$i]->employee_name }}</td>
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