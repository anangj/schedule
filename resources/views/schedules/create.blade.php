<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('schedule-dokters.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('schedule-dokters.store') }}">
                @csrf

                <!-- Doctor Selection -->
                <div class="form-group mb-4">
                    <label for="doctor_id">Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                        <option value="">Select a doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->nama_dokter }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Day Selection -->
                <div class="form-group mb-4">
                    <label for="weekday">Days</label>
                    <select name="weekday" id="weekday" class="form-control" required>
                        @php
                            $weekdays = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];
                        @endphp
                        @foreach ($weekdays as $day)
                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Time -->
                <div class="form-group mb-4">
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                </div>

                <!-- End Time -->
                <div class="form-group mb-4">
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                </div>

                <!-- Appointment Checkbox -->
                <div class="form-group mb-4">
                    <label for="appointment">Appointment</label>
                    <input type="checkbox" name="appointment" id="appointment" class="form-checkbox">
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn btn-dark">
                        Create Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
