<x-app-layout>
    <div>
        <div class=" space-y-8">
            <div class="md:flex justify-between items-center mb-6">
                <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
                @if (Auth::user()->hasRole('super-admin'))
                    <div class="flex flex-wrap ">
                        <form action="{{ route('master-nurses.uploadExcel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="excel_file" accept=".xlsx, .xls" required>
                            <button type="submit" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                                <span class="flex items-center">
                                    <span>Upload Nurse</span>
                                </span>
                            </button>
                        </form>
                        {{-- <button class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 ">
                            <span class="flex items-center">
                                <span>Tambah Dokter</span>
                            </span>
                        </button> --}}
                    </div>
                @endif
                
            </div>
        </div>
        <div class="space-y-5">
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
                                            {{-- <th scope="col" class=" table-th ">
                                                Photo
                                            </th> --}}
                                            
                                            <th scope="col" class=" table-th ">
                                                Nama Nurse
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                ID Karyawan
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
                                                <td class="table-td ">
                                                    <div
                                                        class="flex space-x-3 items-center text-left rtl:space-x-reverse">
                                                        <div class="flex-none">
                                                            <div class="h-12 w-12 rounded-full text-sm flex flex-col items-center justify-center font-medium -tracking-[1px]">
                                                                <img src="{{ asset('storage/' . $item->image_url) }}" class="rounded-full">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex-1 font-medium text-sm leading-4 whitespace-nowrap">
                                                            {{ $item->employee_name }}
                                                        </div>
                                                    </div>

                                                </td>
                                                {{-- <td class="table-td ">{{ $item->poli }}</td> --}}
                                                <td class="table-td ">{{ $item->employee_id }}</td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('master-nurses.show', $item->id) }}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('master-nurses.edit', $item->id) }}"><iconify-icon
                                                                    icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <form id="deleteForm{{ $item->id }}" method="POST"
                                                            action="{{ route('master-nurses.destroy', $item->id) }}"
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
</x-app-layout>