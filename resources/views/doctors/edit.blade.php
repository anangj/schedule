<x-app-layout>
    <div class="space-y-8">
        <div class="items-center justify-between block mb-6 sm:flex">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('doctors.index') }}">
                    <iconify-icon class="mr-1 text-lg" icon="ic:outline-arrow-back"></iconify-icon>
                    </iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
        <div class="overflow-hidden rounded-md">
            <div class="px-5 bg-white dark:bg-slate-800 py-7">
                <form method="POST" action="{{ route('doctor.update', $doctors)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="employee_name">Nama Dokter</label>
                        <input type="text" id="employee_name" class="form-control" value="{{ $doctors->employee_name }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" id="shift" name="shift" class="form-control" value="{{ $doctors->shift }}" required>
                        <x-input-error :messages="$errors->get('shift')" class="mt-2"/>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ $doctors->date }}" required>
                        <x-input-error :messages="$errors->get('date')" class="mt-2"/>
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
    </div>
</x-app-layout>
