<x-app-layout>
    <div>
        <div class=" space-y-8">
            {{-- <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" /> --}}
        </div>
        <div class="space-y-5">
            <div class="card">
                <header class="card-header noborder">
                    <h4 class="card-title">Master Dokter</h4>
                    <form action="{{ route('master-dokters.storeJson') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="json_file" accept=".json" required>
                        <button type="submit" class="btn inline-flex justify-center btn-outline-primary">Upload
                            Dokter</button>
                    </form>
                </header>
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
                                                Nama Dokter
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Poli
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Spesialis
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="table-td ">{{ $item->nama_dokter }}</td>
                                                <td class="table-td ">{{ $item->poli }}</td>
                                                <td class="table-td ">{{ $item->spesialis }}</td>
                                                <td class="table-td">
                                                    <div class="dropstart relative">
                                                    <button class="inline-flex justify-center items-center" type="button" id="tableDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <iconify-icon class="text-xl ltr:ml-2 rtl:mr-2" icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                    </button>
                                                    <ul class="dropdown-menu min-w-max absolute text-sm text-slate-700 dark:text-white hidden bg-white dark:bg-slate-700 shadow z-[2] float-left overflow-hidden list-none text-left rounded-lg mt-1 m-0 bg-clip-padding border-none">
                                                        <li>
                                                        <a href="{{ route('master-dokters.show', $item->id) }}" class="hover:bg-slate-900 dark:hover:bg-slate-600 dark:hover:bg-opacity-70 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm dark:text-slate-300  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex space-x-2 items-center capitalize  rtl:space-x-reverse">
                                                            <iconify-icon icon="heroicons-outline:eye"></iconify-icon>
                                                            <span>View</span></a>
                                                        </li>
                                                        <li>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" class="hover:bg-slate-900 dark:hover:bg-slate-600 dark:hover:bg-opacity-70 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm dark:text-slate-300 last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex space-x-2 items-center capitalize rtl:space-x-reverse">
                                                            <iconify-icon icon="clarity:note-edit-line"></iconify-icon>
                                                            <span>Edit</span></a>
                                                        </li>
                                                        <li>
                                                        <a href="#" class="hover:bg-slate-900 dark:hover:bg-slate-600 dark:hover:bg-opacity-70 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm dark:text-slate-300 last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex space-x-2 items-center capitalize rtl:space-x-reverse">
                                                            <iconify-icon icon="fluent:delete-28-regular"></iconify-icon>
                                                            <span>Delete</span></a>
                                                        </li>
                                                    </ul>
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
