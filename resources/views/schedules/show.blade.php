<x-app-layout>
    <div>
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 max-w-4xl m-auto">
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4">

                <div class="input-group">
                    <label for="nama_dokter" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Name') }}
                    </label>
                    <input name="nama_dokter" type="text" id="nama_dokter" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ $data->masterDokter->nama_dokter }}" disabled>
                </div>

                <div class="input-group">
                    <label for="weekday" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Days') }}
                    </label>
                    <input name="weekday" type="weekday" id="weekday" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{$data->weekday}}" required disabled>
                </div>

                <div class="input-group">
                    <label for="start_hour" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Start Time') }}
                    </label>
                    <input name="start_hour" type="start_hour" id="start_hour" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ str_pad($data->start_hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($data->start_minute, 2, '0', STR_PAD_LEFT) }}" required disabled>
                </div>

                <div class="input-group">
                    <label for="end_hour" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('End Time') }}
                    </label>
                    <input name="end_hour" type="end_hour" id="end_hour" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ str_pad($data->end_hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($data->end_minute, 2, '0', STR_PAD_LEFT) }}" required disabled>
                </div>

                <div class="input-group">
                    <label for="spesialis" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Specialization') }}
                    </label>
                    <input name="spesialis" type="text" id="spesialis" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ $data->masterDokter->spesialis }}" disabled>
                </div>

                <div class="input-group">
                    <label for="appointment" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Appointment') }}
                    </label>
                    <input name="appointment" type="appointment" id="appointment" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ $data->appointment ? 'Yes' : 'No' }}" required disabled>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
