<x-app-layout>
    <div class="space-y-8">
        <div class="card xl:col-span-2">
            <div class="card-header flex justify-between">
                <div>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('doctors.edit', $doctors->id) }}" class="btn btn-primary">Edit</a>
                </div>
                <h2 class="card-title">Detail Dokter</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-5 mb-5">
                    <div class="form-group">
                        <label for="employee_id">ID Pegawai</label>
                        <input type="text" id="employee_id" class="form-control" value="{{ $doctors->employee_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="employee_name">Nama Pegawai</label>
                        <input type="text" id="employee_name" class="form-control" value="{{ $doctors->employee_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" id="shift" class="form-control" value="{{ $doctors->shift }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="text" id="date" class="form-control" value="{{ $doctors->date }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>