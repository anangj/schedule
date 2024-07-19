<x-app-layout>
    <div>
        <div class=" space-y-8">
            <div class="md:flex justify-between items-center mb-6">
                <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
                <div class="flex flex-wrap ">
                    <form action="{{ route('master-nurses.storeJson') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="json_file" required>
                        <button type="submit" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                            <span class="flex items-center">
                                <span>Upload Nurse</span>
                            </span>
                        </button>
                    </form>
                    {{-- <button class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 ">
                        <span class="flex items-center">
                            <span>Tambah Dokter</span>
                        </span>
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>