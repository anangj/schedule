<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('lobby.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('master-dokters.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_tera">ID Tera</label>
                    <input type="text" id="id_tera" name="id_tera" class="form-control" value="{{ old('id_tera') }}" placeholder="kosongkan saja">
                </div>
                <div class="form-group">
                    <label for="nama_dokter">Nama Doctor</label>
                    <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" value="{{ old('nama_dokter') }}" required>
                </div>
                <div class="form-group">
                    <label for="poli">Poli</label>
                    <input type="text" id="poli" name="poli" class="form-control" value="{{ old('poli') }}" required>
                </div>
                <div class="form-group">
                    <label for="spesialis">Spesialis</label>
                    <input type="text" id="spesialis" name="spesialis" class="form-control" value="{{ old('spesialis') }}" required>
                </div>
                <div class="form-group">
                    <label for="image_url">Upload Photo</label>
                    <input type="file" id="image_url" name="image_url" class="form-control" onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
                    <img id="image_preview" src="#" alt="Preview Foto Dokter" class="block w-32 h-32 object-cover rounded-full mt-2">
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">
                        <span class="flex items-center">
                            <span> @lang('Create Doctor')</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
