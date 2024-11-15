<x-app-layout>
    <div>
        <div class="space-y-8">
            <div class="md:flex justify-between items-center mb-6">
                <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
                <div class="flex flex-wrap ">
                    <a href="{{ route('events.create') }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                        <span class="flex items-center">
                            <span>Tambah Event</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="card">
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">Name</th>
                                            <th scope="col" class="table-th">Position</th>
                                            <th scope="col" class="table-th">Start Date</th>
                                            <th scope="col" class="table-th">End Date</th>
                                            <th scope="col" class="table-th">Status</th>
                                            {{-- <th scope="col" class="table-th">Location</th> --}}
                                            <th scope="col" class="table-th">Order</th>
                                            <th scope="col" class="table-th">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="table-td">{{$item->name}}</td>
                                                <td class="table-td">{{$item->positions->position_name}}</td>
                                                <td class="table-td">{{$item->start_date}}</td>
                                                <td class="table-td">{{$item->end_date}}</td>
                                                <td class="table-td">{{$item->isActive}}</td>
                                                {{-- <td class="table-td">{{$item->position_name}}</td> --}}
                                                <td class="table-td">{{$item->content_order}}</td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        {{-- <button class="action-btn" type="button">
                                                            <a href="{{ route('events.show', $item->id) }}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button> --}}
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('events.edit', $item->id) }}"><iconify-icon
                                                                    icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <form id="deleteForm{{ $item->id }}" method="POST"
                                                            action="{{ route('events.destroy', $item->id) }}"
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
    @endpush
</x-app-layout>