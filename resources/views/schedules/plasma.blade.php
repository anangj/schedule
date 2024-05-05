<x-schedule>
    <div class="card">
        <h1 class="text-center pt-14">PETUGAS KAMI HARI INI</h1>
        <div class="date-schedule">Senin, 6 Mei 2024</div>
        <div class="card mt-24">
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                  <span class=" col-span-8  hidden"></span>
                  <span class="  col-span-4 hidden"></span>
                  <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2" class="shift">PAGI</th>
                                    <th colspan="2" class="shift">SIANG</th>
                                    <th colspan="2" class="shift">MALAM</th>
                                </tr>
                                <tr>
                                    <th>DOKTER</th>
                                    <th>PERAWAT</th>
                                    <th>DOKTER</th>
                                    <th>PERAWAT</th>
                                    <th>DOKTER</th>
                                    <th>PERAWAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 5; $i++)
                                <tr>
                                    <td>{{ $pagi['dokter'][$i] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $pagi['perawat'][$i] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $siang['dokter'][$i] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $siang['perawat'][$i] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $malam['dokter'][$i] ?? 'Tidak tersedia' }}</td>
                                    <td>{{ $malam['perawat'][$i] ?? 'Tidak tersedia' }}</td>
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

