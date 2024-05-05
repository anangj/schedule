<x-app-layout>
    <div class="space-y-8">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white"> Form</div>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="input-area relative">
                            <div>
                                <label for="time-date-picker" class="form-label">Tanggal & Jam</label>
                                <input class="form-control py-2 flatpickr flatpickr-input active" id="time-date-picker"
                                    data-enable-time="true" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="input-area relative">
                            <div>
                                <label for="shift" class="form-label">Shift</label>
                                <select name="shift" id="shift" class="form-control w-full mt-2">
                                    <option selected="Selected" disabled="disabled" value="none"
                                        class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">Pilih
                                        Shift</option>
                                    <option value="pagi"
                                        class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">Pagi
                                    </option>
                                    <option value="siang"
                                        class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">Siang
                                    </option>
                                    <option value="malam"
                                        class="py-1 inline-block font-Inter font-normal text-sm text-slate-600">Malam
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="input-area relative">
                            <div>
                                <label for="dokterSelect" class="form-label">Dokter</label>
                                <select name="dokterSelect" id="dokterSelect"
                                    class="select2 form-control w-full mt-2 py-2" multiple="multiple">
                                    <option selected="selected" value="option1"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 1
                                    </option>
                                    <option value="option2"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 2
                                    </option>
                                    <option value="option3"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 3
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="input-area relative">
                            <div>
                                <label for="perawatSelect" class="form-label">Perawat</label>
                                <select name="perawatSelect" id="perawatSelect"
                                    class="select2 form-control w-full mt-2 py-2" multiple="multiple">
                                    <option selected="selected" value="option1"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 1
                                    </option>
                                    <option value="option2"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 2
                                    </option>
                                    <option value="option3"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 3
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button class="btn inline-flex justify-center btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/plugins/flatpickr.js'])
        @vite(['resources/js/plugins/Select2.min.js'])
        <script type="module">
            // Form Select Area
            $(".select2").select2({
                placeholder: "Select an Option",
            });
            // flatpickr
            $(".flatpickr").flatpickr({
                dateFormat: "Y-m-d",
                defaultDate: "today",
            });


            $(".flatpickr.time").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            });

            $("#humanFriendly_picker").flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
            });

            $("#inline_picker").flatpickr({
                inline: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
            });
        </script>
    @endpush

</x-app-layout>
