<x-app-layout>
    <div class="space-y-8">
        <div class="flex justify-between flex-wrap items-center mb-6">
            <h4
                class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
                DOCTOR IGD</h4>
            <div class="flex sm:space-x-4 space-x-2 sm:justify-end items-center rtl:space-x-reverse">
                <form class="form-control" action="{{ route('doctors.uploadExcel') }}" method="POST" enctype="multipart/form-data">
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
                <button
                    class="btn leading-0 inline-flex justify-center bg-white text-slate-700 dark:bg-slate-800 dark:text-slate-300 !font-normal">
                    <span class="flex items-center">
                        <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2 font-light"
                            icon="heroicons-outline:filter"></iconify-icon>
                        <span>Select Date</span>
                    </span>
                </button>

                {{-- <div class="relative">
                    <input type="text" name="daterange"
                        class="form-input leading-0 inline-flex justify-center bg-white text-slate-700 dark:bg-slate-800 dark:text-slate-300 !font-normal" />
                    <iconify-icon
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xl ltr:mr-2 rtl:ml-2 font-light"
                        icon="heroicons-outline:filter"></iconify-icon>
                </div> --}}

            </div>
        </div>

         

        <div class=" space-y-5">
            {{-- Alert start --}}
         @if (session('message'))
         <x-alert :message="session('message')" :type="'success'" />
         @endif
         {{-- Alert end --}}
            <div class="card">
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
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
                                        @foreach ($doctors as $item)
                                            <tr>
                                                <td class="table-td">{{ $item['employee_name'] }}</td>
                                                <td class="table-td ">{{ $item['date'] }}</td>
                                                <td class="table-td">{{ $item->shift }}</td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('doctors.show', $item['id']) }}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('doctors.edit', $item['id']) }}"><iconify-icon icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                        </button>
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
    @endpush
</x-app-layout>
