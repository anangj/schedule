<x-app-layout>
    <div>
        <div class="space-y-8">
            <div class="md:flex justify-between items-center mb-6">
                <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
                <div class="flex flex-wrap ">
                    <a href="{{ route('schedule-dokters.create') }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                        <span class="flex items-center">
                            <span>Tambah Schedule</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        @if (session('message'))
            <x-alert :message="session('message')" :type="'success'" />
        @endif
        <!-- Filter Notification -->
        @if (request()->filled('employee_name') || request()->filled('date'))
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md">
                <p><strong>Notice:</strong> The results are currently filtered.</p>
                <a href="{{ route('nurses.index') }}" class="text-blue-500 underline">Clear Filters</a>
            </div>
        @endif
        <div class="space-y-5">

            <div class="card">
                <div class="card-header noborder -mb-6">
                    <!-- Dropdown Filter Button -->
                    <div class="mb-6">
                        <button id="filterToggle" class="btn btn-dark">Filter Options</button>
                    </div>
                    <!-- Filter Form (Hidden by Default) -->
                    <div id="filterForm" class="card mb-6 p-5 hidden">
                        <form method="POST" action="{{ route('schedule-dokters.index') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Filter by Doctor Name -->
                                <div>
                                    <label for="doctor_name">Doctor</label>
                                    <select name="doctor_name" id="doctor_name" class="form-control">
                                        <option value="">Select a Doctor</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->nama_dokter }}" {{ request('doctor_name') == $doctor->nama_dokter ? 'selected' : '' }}>
                                                {{ $doctor->nama_dokter }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                 <!-- Filter by Specialization (Select Dropdown) -->
                                <div>
                                    <label for="specialization">Specialization</label>
                                    <select name="specialization" id="specialization" class="form-control">
                                        <option value="">Select Specialization</option>
                                        @foreach ($specializations as $specialization)
                                            <option value="{{ $specialization->name }}" {{ request('specialization') == $specialization->name ? 'selected' : '' }}>
                                                {{ $specialization->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter by Day -->
                                <div>
                                    <label for="weekday">Day</label>
                                    <select name="weekday" id="weekday" class="form-control">
                                        <option value="">All Days</option>
                                        @php
                                            $weekdays = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'];
                                        @endphp
                                        @foreach ($weekdays as $day)
                                            <option value="{{ $day }}" {{ request('weekday') == $day ? 'selected' : '' }}>
                                                {{ ucfirst($day) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-dark">Filter</button>
                                <a href="{{ route('schedule-dokters.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            {{-- <th scope="col" class=" table-th ">
                                                Photo
                                            </th> --}}
                                            <th scope="col" class=" table-th ">
                                                Doctor Name
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Days
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Start Time
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                End Time
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Appointment
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Specialization
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="table-td ">
                                                    <div
                                                        class="flex space-x-3 items-center text-left rtl:space-x-reverse">
                                                        <div class="flex-none">
                                                            <div class="h-12 w-12 rounded-full text-sm flex flex-col items-center justify-center font-medium -tracking-[1px]">
                                                                <img src="{{ asset('storage/' . $item->masterDokter->image_url) }}" class="rounded-full">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex-1 font-medium text-sm leading-4 whitespace-nowrap">
                                                            {{ $item->masterDokter->nama_dokter }}
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="table-td ">{{ $item->weekday }}</td>
                                                <td class="table-td ">{{ str_pad($item->start_hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($item->start_minute, 2, '0', STR_PAD_LEFT) }}</td>
                                                <td class="table-td ">{{ str_pad($item->end_hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($item->end_minute, 2, '0', STR_PAD_LEFT) }}</td>
                                                <td class="table-td ">{{ $item->appointment ? 'Yes' : 'No' }}</td>
                                                <td class="table-td ">{{ $item->masterDokter->spesialis }}</td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('schedule-dokters.show', $item->id) }}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('schedule-dokters.edit', $item->id) }}"><iconify-icon
                                                                    icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <form id="deleteForm{{ $item->id }}" method="POST"
                                                            action="{{ route('schedule-dokters.destroy', $item->id) }}"
                                                            class="cursor-pointer">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="action-btn"
                                                                onclick="sweetAlertDelete(event, 'deleteForm{{ $item->id }}')"
                                                                type="submit">
                                                                <iconify-icon
                                                                    icon="fluent:delete-24-regular"></iconify-icon>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="module">
            // data table validation
            $("#data-table, .data-table").DataTable({
                dom: "<'grid grid-cols-12 gap-5 px-6 mt-6'<'col-span-4'l><'col-span-8 flex justify-end'f><'#pagination.flex items-center'>><'min-w-full't><'flex justify-end items-center'p>",
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                lengthChange: true,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: `<iconify-icon icon="ic:round-keyboard-arrow-left"></iconify-icon>`,
                        next: `<iconify-icon icon="ic:round-keyboard-arrow-right"></iconify-icon>`,
                    },
                    search: "Search:",
                },
            });
        </script>
        <script>
            function sweetAlertDelete(event, formId) {
                event.preventDefault();
                let form = document.getElementById(formId);
                Swal.fire({
                    title: '@lang('Are you sure ? ')',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: '@lang('Delete ')',
                    denyButtonText: '@lang(' Cancel ')',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            }
        </script>
        <script type="module">
            $('#imageModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var imageUrl = button.data('image'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body #previewImage').attr('src', imageUrl);
            });
        </script>
        <script>
            document.getElementById('filterToggle').addEventListener('click', function() {
                var filterForm = document.getElementById('filterForm');
                filterForm.classList.toggle('hidden');
            });
        </script>
    @endpush
</x-app-layout>

