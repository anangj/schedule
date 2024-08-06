<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
            <div class="text-end">
                <a href="{{ route('nod.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('nod.edit', $nods->id) }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">Edit</a>
            </div>
        </div>
        <div class="rounded-md overflow-hidden">
            <div class="bg-white dark:bg-slate-800 px-5 py-7">
                <div class="form-group">
                    <label for="employee_name">Nama Nod</label>
                    <input type="text" id="employee_name" class="form-control" value="{{ $nods->employee_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Hari</label>
                    <input type="date" id="date" class="form-control" value="{{ $nods->date }}" readonly>
                </div>
                <div class="form-group">
                    <label for="shift">Shift</label>
                    <input type="text" id="shift" class="form-control" value="{{ $nods->shift }}" readonly>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 