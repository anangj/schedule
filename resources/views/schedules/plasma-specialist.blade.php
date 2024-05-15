<x-schedule>
    <div class="card">
        <h1 class="text-center pt-14">PETUGAS KAMI HARI INI</h1>
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
                                @for ($i = 0; $i < 3; $i++)
                                <tr>
                                    <td>{{ $pagi['dokter'][$i]['spesialis'] ?? 'Tidak tersedia' }} - {{ $pagi['dokter'][$i]['nama'] ?? 'Tidak tersedia' }}</td>
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