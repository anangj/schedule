<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('master-dokters.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    </iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('master-dokters.update', $masterDokter) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_dokter">Nama Doctor</label>
                    <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" value="{{ $masterDokter->nama_dokter }}">
                </div>
                <div class="form-group">
                    <label for="poli">Poli</label>
                    <input type="text" id="poli" name="poli" class="form-control" value="{{ $masterDokter->poli }}">
                </div>
                <div class="form-group">
                    <label for="spesialis">Spesialis</label>
                    <input type="text" id="spesialis" name="spesialis" class="form-control" value="{{ $masterDokter->spesialis }}">
                </div>
                <div class="form-group">
                    <label for="image_url">Upload Photo</label>
                    <input type="file" id="image_url" name="image_url" class="form-control" onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
                    <img id="image_preview" src="{{ $masterDokter->image_url ? Storage::url($masterDokter->image_url) : '#' }}" alt="Preview Foto Dokter" class="block w-32 h-32 object-cover rounded-full mt-2">
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">
                        <span class="flex items-center">
                            <span> @lang('Save Changes')</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>