<x-app-layout>
    <div>
        <div class=" space-y-8">
            <div class="md:flex justify-between items-center mb-6">
                <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbsItems" />
                <div class="flex flex-wrap">
                    <a href="{{ route('lobby.create') }}" class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1">
                        <span class="flex items-center">
                            <span>Tambah Konten</span>
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
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            
                                            <th scope="col" class=" table-th ">
                                                Nama Event
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Mulai Event
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Selesai Event
                                            </th>
                                            <th scope="col" class=" table-th ">
                                                Status
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
                                                <td class="table-td "> {{$item->event_name}} </td>
                                                {{-- <td class="table-td ">{{ $item->poli }}</td> --}}
                                                <td class="table-td ">{{ $item->start_date }}</td>
                                                <td class="table-td ">{{ $item->end_date }}</td>
                                                <td class="table-td ">{{ $item->status }}</td>
                                                <td class="table-td ">
                                                    <div class="flex space-x-3 rtl:space-x-reverse">
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('lobby.show', $item->id) }}"
                                                                class="action-btn">
                                                                <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                            </a>
                                                        </button>
                                                        <button class="action-btn" type="button">
                                                            <a href="{{ route('lobby.edit', $item->id) }}"><iconify-icon
                                                                    icon="heroicons:pencil-square"></iconify-icon></a>
                                                        </button>
                                                        <form id="deleteForm{{ $item->id }}" method="POST"
                                                            action="{{ route('lobby.destroy', $item->id) }}"
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
    @endpush
</x-app-layout>