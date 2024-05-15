<x-app-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Schedule Driver</div>
                </div>
                <form action="{{ route('schedules.uploadExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="excel_file" accept=".xlsx, .xls" required>
                    <button type="submit">{{__('Upload Schedule')}}</button>
                </form>
            </header>
        </div>
    </div>
</x-app-layout>

