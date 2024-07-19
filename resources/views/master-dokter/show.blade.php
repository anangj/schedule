<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
            <div class="text-end">
                <a href="{{ route('master-dokters.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('master-dokters.edit', $masterDokter->id) }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">Edit</a>
            </div>
        </div>
        <div class="rounded-md overflow-hidden">
            <div class="bg-white dark:bg-slate-800 px-5 py-7">
                <div class="form-group">
                    <label for="nama_dokter">Nama Doctor</label>
                    <input type="text" id="nama_dokter" class="form-control" value="{{ $masterDokter->nama_dokter }}" readonly>
                </div>
                <div class="form-group">
                    <label for="poli">Poli</label>
                    <input type="text" id="poli" class="form-control" value="{{ $masterDokter->poli }}" readonly>
                </div>
                <div class="form-group">
                    <label for="spesialis">Spesialis</label>
                    <input type="text" id="spesialis" class="form-control" value="{{ $masterDokter->spesialis }}" readonly>
                </div>
                <div class="form-group">
                    <label for="image" name="image">Image</label>
                    <img src="{{ $masterDokter->image_url ? Storage::url($masterDokter->image_url) : '#' }}" alt="Doctor Image" class="block w-32 h-32 object-cover rounded-full mt-2">
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 