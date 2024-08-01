<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
            <div class="flex flex-wrap ">
                <button class="btn btn-dark block w-full add-event">
                    add Shift
                </button>
            </div>
        </div>

        <div class=" space-y-5">
            <div class="card">
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
                                                Mulai
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Selesai
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        {{-- @foreach ($drivers as $item)
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
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=" addmodal-wrapper " id="addeventModal">
            <div class=" modal-overlay"></div>
            <!-- opacity -->
            <div class="modal-content">
                <div class="flex min-h-full justify-center text-center p-6 items-start ">
                    <div class="w-full transform overflow-hidden rounded-md bg-white dark:bg-slate-800 text-left align-middle shadow-xl
                            transition-alll max-w-xl opacity-100 scale-100">
                        <div class="relative overflow-hidden py-4 px-5 text-white flex justify-between bg-slate-900 dark:bg-slate-800 dark:border-b
                                dark:border-slate-700">
                            <h2 class="capitalize leading-6 tracking-wider font-medium text-base text-white">Event</h2>
                            <button class="text-[22px] close-event-modal">
                                <iconify-icon icon="heroicons:x-mark"></iconify-icon>
                            </button>
                        </div>
                        <!-- end modal header -->
                        <div class="px-6 py-8">
                            <form id="add-event-form" class="space-y-5">
                                <div class="fromGroup">
                                    <label for="event-title" class=" form-label">Title:</label>
                                    <input type="text" id="event-title" name="event-title" placeholder="Add Title" class="form-control" required></div>
                                <div class="fromGroup">
                                    <label for="event-start-date" class=" form-label">Start Date</label>
                                    <input class="form-control py-2 startdate" id="event-start-date" type="text"></div>
                                <div class="fromGroup">
                                    <label for="event-end-date" class=" form-label">End Date</label>
                                    <input class="form-control py-2 enddate" id="event-end-date" type="text"></div>
                                <div class="fromGroup">
                                    <label for="event-category" class="form-label">Category:</label>
                                    <select id="event-category" name="event-category" required class="form-control">
                                        <option value="">Select a category</option>
                                        <option value="business">Business</option>
                                        <option value="personal">Personal</option>
                                        <option value="holiday">Holiday</option>
                                        <option value="family">Family</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="etc">Etc</option>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="submit-button" class="btn btn-dark">Add Event</button>
                                </div>
                            </form>
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
