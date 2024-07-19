<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
            <div class="text-end">
                <a href="{{ route('nurses.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('nurses.edit', $nurses->id) }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">Edit</a>
            </div>
        </div>
        <div class="rounded-md overflow-hidden">
            <div class="bg-white dark:bg-slate-800 px-5 py-7">
                <div class="form-group">
                    <label for="employee_name">Nama Nurse</label>
                    <input type="text" id="employee_name" class="form-control" value="{{ $nurses->employee_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Hari</label>
                    <input type="date" id="date" class="form-control" value="{{ $nurses->date }}" readonly>
                </div>
                <div class="form-group">
                    <label for="shift">Shift</label>
                    <input type="text" id="shift" class="form-control" value="{{ $nurses->shift }}" readonly>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 