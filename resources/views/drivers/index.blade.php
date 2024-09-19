<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
            <div class="flex justify-end">
                <a href="{{ route('drivers.downloadTemplate') }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                    <span class="flex items-center">
                        <span>Template</span>
                    </span>
                </a>
                <form id="uploadForm" class="form-control" action="{{ route('drivers.uploadExcel') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx, .xls" required>
                    <button type="submit"
                        class="btn leading-0 inline-flex justify-center bg-white text-slate-700 dark:bg-slate-800 dark:text-slate-300 !font-normal">
                        <span class="flex items-center">
                            <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2 font-light"
                                icon="heroicons-outline:upload"></iconify-icon>
                            <span>Upload</span>
                        </span>
                    </button>
                </form>
                <div id="progressContainer" class="hidden fixed inset-0 flex flex-col items-center justify-center bg-gray-100 bg-opacity-75 z-50">
                    <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-32 w-32 mb-4"></div>
                    <p class="text-lg font-semibold text-gray-700">Loading...</p>
                </div>
            </div>
        </div>

        <div class=" space-y-5">
            <div class="card">
                <div class="card-header noborder -mb-6">
                    <!-- Dropdown Filter Button -->
                    <div class="mb-6">
                        <button id="filterToggle" class="btn btn-dark">Filter Options</button>
                    </div>
                    <!-- Filter Form (Hidden by Default) -->
                    <div id="filterForm" class="card mb-6 p-5 hidden">
                        <form method="POST" action="{{ route('drivers.index') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Filter by Nurse Name -->
                                <div>
                                    <label for="employee_name">Driver Name</label>
                                    <select name="employee_name" id="employee_name" class="form-control">
                                        <option value="">Select a Driver</option>
                                        @foreach ($listDriver as $item)
                                            <option value="{{ $item->employee_name }}" {{ request('employee_name') == $item->employee_name ? 'selected' : '' }}>
                                                {{ $item->employee_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <!-- Filter by Date -->
                                <div>
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                                </div>

                                <!-- Filter by Shift -->
                                <div>
                                    <label for="name_shift">Shift Name</label>
                                    <select name="name_shift" id="name_shift" class="form-control">
                                        <option value="">Select a Shift</option>
                                        @foreach ($shift as $item)
                                            <option value="{{ $item->name_shift }}" {{ request('name_shift') == $item->name_shift ? 'selected' : '' }}>
                                                {{ $item->name_shift }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-dark">Filter</button>
                                <a href="{{ route('drivers.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        {{-- <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span> --}}
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class=" table-th ">
                                                Nama
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Tanggal
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Shift
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        @foreach ($drivers as $item)
                                            <tr>
                                                <td class="table-td">{{ $item->employee_name }}</td>
                                                <td class="table-td">{{ $item->date }}</td>
                                                <td class="table-td">{{ $item->shift }}</td>

                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <button class="action-btn" type="button">
                                                            <a href="{{route('drivers.show', $item['id'])}}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('drivers.edit', $item['id']) }}"><iconify-icon
                                                                    icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <form id="deleteForm{{ $item['id'] }}" method="POST" action="{{ route('drivers.destroy', $item['id']) }}" class="cursor-pointer">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="action-btn" onclick="sweetAlertDelete(event, 'deleteForm{{ $item['id'] }}')" type="submit">
                                                                <iconify-icon icon="fluent:delete-24-regular"></iconify-icon>
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
                lengthMenu: [10, 25, 50, 100, 200],
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
                    icon : 'question',
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
        <script>
            document.getElementById('uploadForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);
                let xhr = new XMLHttpRequest();

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.addEventListener('progress', function (e) {
                    document.getElementById('progressContainer').classList.remove('hidden');
                });

                xhr.addEventListener('load', function () {
                    document.getElementById('progressContainer').classList.add('hidden');
                    if (xhr.status === 200) {
                        Swal.fire({
                            title: 'Upload successful!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Upload failed!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                xhr.send(formData);
            });
        </script>
        <script>
            document.getElementById('filterToggle').addEventListener('click', function() {
                var filterForm = document.getElementById('filterForm');
                filterForm.classList.toggle('hidden');
            });
        </script>
    @endpush
    @push('styles')
        <style>
            .loader {
                border-top-color: #3498db;
                -webkit-animation: spin 1s linear infinite;
                animation: spin 1s linear infinite;
            }

            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
</x-app-layout>
