<x-app-layout>
    <div>
        <div class=" mb-6">
            {{-- <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" /> --}}
        </div>

        <div class="card">
            <form>
                <div class="form-group my-2">
                    <label>Nama Dokter:</label>
                    <input type="text" class="form-control" value="{{$masterDokter->nama_dokter}}" readonly>
                </div>
                <div class="form-group">
                    <label>Jadwal:</label>
                    @foreach ($masterDokter->schedule as $item)
                        <input type="text" class="form-control mb-2" value="{{$item->weekday}} {{$item->start_hour}}:{{$item->start_minute}} - {{$item->end_hour}}:{{$item->end_minute}}" readonly>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</x-app-layout>