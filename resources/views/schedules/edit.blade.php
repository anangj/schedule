<x-app-layout>
    <div>
        <div class="items-center justify-between block mb-6 sm:flex">
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('schedule-dokters.index') }}">
                    <iconify-icon class="mr-1 text-lg" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 max-w-4xl m-auto">
            {{-- <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4"> --}}
                <form method="POST" action="{{ route('schedule-dokters.update', $data->id) }}">
                    @csrf
                    @method('PUT')


                    <div class="form-group mb-4">
                        <label for="nama_dokter">Nama Dokter</label>
                        <input type="text" id="nama_dokter" class="form-control" value="{{ $data->masterDokter->nama_dokter }}" readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="weekday">Days</label>
                        <select name="weekday" id="weekday" class="form-control">
                            @php
                                $weekdays = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];
                            @endphp

                            @foreach ($weekdays as $day)
                                <option value="{{ $day }}" {{ $data->weekday == $day ? 'selected' : '' }}>
                                    {{ ucfirst($day) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control"
                               value="{{ str_pad($data->start_hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($data->start_minute, 2, '0', STR_PAD_LEFT) }}">
                    </div>

                    <div class="form-group mb-4">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control"
                               value="{{ str_pad($data->end_hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($data->end_minute, 2, '0', STR_PAD_LEFT) }}">
                    </div>

                    <div class="form-group mb-4">
                        <label for="spesialis">Spesialis</label>
                        <input type="text" id="spesialis" name="spesialis" class="form-control"
                               value="{{$data->masterDokter->spesialis}}" readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="appointment">Appointment</label>
                        <input type="checkbox" name="appointment" id="appointment" class="form-checkbox"
                            {{ $data->appointment ? 'checked' : '' }}>
                    </div>

                    {{-- Loop through the schedules for editing --}}
                    {{-- @foreach ($data as $index => $schedule)
                        <div class="form-group mb-4">
                            <label for="weekday">Day</label>
                            <input type="text" id="weekday" class="form-control" value="{{ $schedule->weekday }}" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="start_time_{{ $index }}">Start Time</label>
                            <input type="time" name="schedules[{{ $index }}][start_time]" id="start_time_{{ $index }}" class="form-control"
                                value="{{ str_pad($schedule->start_hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($schedule->start_minute, 2, '0', STR_PAD_LEFT) }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="end_time_{{ $index }}">End Time</label>
                            <input type="time" name="schedules[{{ $index }}][end_time]" id="end_time_{{ $index }}" class="form-control"
                                value="{{ str_pad($schedule->end_hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($schedule->end_minute, 2, '0', STR_PAD_LEFT) }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="appointment_{{ $index }}">Appointment</label>
                            <input type="checkbox" name="schedules[{{ $index }}][appointment]" id="appointment_{{ $index }}" class="form-checkbox"
                                {{ $schedule->appointment ? 'checked' : '' }}>
                        </div>

                        <input type="hidden" name="schedules[{{ $index }}][id]" value="{{ $schedule->id }}">
                    @endforeach --}}

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">
                            <span class="flex items-center">
                                <span> @lang('Save Changes')</span>
                            </span>
                        </button>
                    </div>
                </form>
            {{-- </div> --}}
        </div>


    </div>
</x-app-layout>
