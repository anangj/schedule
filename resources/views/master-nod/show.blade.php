<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
            <div class="text-end">
                <a href="{{ route('master-nod.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('master-nod.edit', $masterNod->id) }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">Edit</a>
            </div>
        </div>
        <div class="rounded-md overflow-hidden">
            <div class="bg-white dark:bg-slate-800 px-5 py-7">
                <div class="form-group">
                    <label for="employee_name">Nama Nurse</label>
                    <input type="text" id="employee_name" class="form-control" value="{{ $masterNod->employee_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="employee_id">ID Nurse</label>
                    <input type="text" id="employee_id" class="form-control" value="{{ $masterNod->employee_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="image" name="image">Image</label>
                    <img src="{{ $masterNod->image_url ? Storage::url($masterNod->image_url) : '#' }}" alt="Nurse Image" class="block w-32 h-32 object-cover rounded-full mt-2">
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 