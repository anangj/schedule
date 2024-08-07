<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('ponek.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    </iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('ponek.update', $poneks) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="employee_name">Nama Nurse</label>
                    <input type="text" id="employee_name" name="employee_name" class="form-control" value="{{ $poneks->employee_name }}">
                </div>
                <div class="form-group">
                    <label for="date">Hari</label>
                    <input type="date" id="poldatei" name="date" class="form-control" value="{{ $poneks->date }}">
                </div>
                <div class="form-group">
                    <label for="shift">Shift</label>
                    <input type="text" id="shift" name="shift" class="form-control" value="{{ $poneks->shift }}">
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