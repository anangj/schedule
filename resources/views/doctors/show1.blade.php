<x-app-layout>
    <div class="space-y-8">
        <div class="card xl:col-span-2">
            <div class="card-header">
                <a href="{{ route('doctors.index') }}" class="btn inline-flex justify-center btn-primary rounded-[25px]">Kembali</a>
            </div>
            <div class="card flex flex-col p-6">
                <div class="card-text h-full">
                    <div>
                        <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4"
                            id="tabs-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-personal"
                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent active dark:text-slate-300"
                                    id="tabs-personal-tab" data-bs-toggle="tab" data-bs-target="#tabs-personal"
                                    role="tab" aria-controls="tabs-personal" aria-selected="true">Personal</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-contact"
                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                    id="tabs-contact-tab" data-bs-toggle="tab" data-bs-target="#tabs-contact" role="tab"
                                    aria-controls="tabs-contact" aria-selected="false">Contact</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-job"
                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                    id="tabs-job-tab" data-bs-toggle="tab" data-bs-target="#tabs-job" role="tab"
                                    aria-controls="tabs-job" aria-selected="false">Job</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="tabs-personal" role="tabpanel"
                                aria-labelledby="tabs-personal-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                                    <div class="input-area relative">
                                        <label for="idCard" class="form-label">ID Card</label>
                                        <input type="text" class="form-control" >
                                    </div>
                                    <div class="input-area relative">
                                        <label for="namaDokter" class="form-label">Nama
                                            Dokter</label>
                                        <input type="text" class="form-control" value="" readonly>
                                    </div>
                                    <div class="input-area relative">
                                        <label for="titleDokter" class="form-label">Title
                                            Dokter</label>
                                        <input type="text" name="titleDokter" id="titleDokter" class="form-control" placeholder="Dr / Drs">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="specialities" class="form-label">Specialities</label>
                                        <input type="text" name="specialities" id="specialities" class="form-control" placeholder="Specialities">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="medicalEducation" class="form-label">Medical
                                            Education</label>
                                        <input type="text" name="medicalEducation" id="medicalEducation" class="form-control"
                                            placeholder="Harvard Medical School">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="medicalDegree" class="form-label">Medical Degree</label>
                                        <input type="text" name="medicalDegree" id="medicalDegree" class="form-control" placeholder="MD">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="medicalLicense" class="form-label">Medical License</label>
                                        <input type="text" name="medicalLicense" id="medicalLicense" class="form-control" placeholder="Medical License">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="certification" class="form-label">Certification</label>
                                        <input type="text" name="certification" id="certification" class="form-control" placeholder="Certification">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="experience" class="form-label">Experience</label>
                                        <input type="text" name="experience" id="experience" class="form-control" placeholder="Experience">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="bankAccount" class="form-label">Bank Account</label>
                                        <input type="text" name="bankAccount" id="bankAccount" class="form-control" placeholder="Bank Account">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="bankName" class="form-label">Bank Name</label>
                                        <input type="text" name="bankName" id="bankName" class="form-control" placeholder="Bank Name">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="bankBranch" class="form-label">Bank Branch</label>
                                        <input type="text" name="bankBranch" id="bankBranch" class="form-control" placeholder="Bank Branch">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="bankAccountName" class="form-label">Bank Account Name</label>
                                        <input type="text" name="bankAccountName" id="bankAccountName" class="form-control" placeholder="Bank Account Name">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="fee" class="form-label">fee</label>
                                        <input type="text" name="fee" id="fee" class="form-control" placeholder="Fee">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="language" class="form-label">language</label>
                                        <input type="text" name="language" id="language" class="form-control" placeholder="Language">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="npwp" class="form-label">npwp</label>
                                        <input type="text" name="npwp" id="npwp" class="form-control" placeholder="Npwp">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-contact" role="tabpanel"
                                aria-labelledby="tabs-contact-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                                    <div class="input-area relative">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Mobile">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" id="country" class="form-control" placeholder="Country">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="postalCode" class="form-label">Postal Code</label>
                                        <input type="text" name="postalCode" id="postalCode" class="form-control" placeholder="Postal Code">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-job" role="tabpanel"
                                aria-labelledby="tabs-job-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                                    <div class="input-area relative">
                                        <label for="joinDate" class="form-label">Join Date</label>
                                        <input type="date" name="joinDate" id="joinDate" class="form-control" placeholder="Date">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="schedule" class="form-label">Schedule</label>
                                        <input type="text" name="schedule" id="schedule" class="form-control" placeholder="Schedule">
                                    </div>

                                    {{-- weekday --}}
                                    <div class="input-area relative">
                                        <label for="weekday" class="form-label">Weekday</label>
                                        <input type="text" name="weekday" id="weekday" class="form-control" placeholder="Weekday">
                                    </div>

                                    {{-- start time --}}
                                    <div class="input-area relative">
                                        <label for="startTime" class="form-label">Start Time</label>
                                        <input type="text" name="startTime" id="startTime" class="form-control" placeholder="Start Time">
                                    </div>

                                    {{-- end time --}}
                                    <div class="input-area relative">
                                        <label for="endTime" class="form-label">End Time</label>
                                        <input type="text" name="endTime" id="endTime" class="form-control" placeholder="End Time">
                                    </div>

                                    {{-- break time --}}
                                    <div class="input-area relative">
                                        <label for="breakTime" class="form-label">Break Time</label>
                                        <input type="text" name="breakTime" id="breakTime" class="form-control" placeholder="Break Time">
                                    </div>

                                    {{-- duration per patient --}}
                                    <div class="input-area relative">
                                        <label for="durationPerPatient" class="form-label">Duration Per Patient</label>
                                        <input type="text" name="durationPerPatient" id="durationPerPatient" class="form-control" placeholder="Duration Per Patient">
                                    </div>

                                    {{-- room --}}
                                    <div class="input-area relative">
                                        <label for="room" class="form-label">Room</label>
                                        <input type="text" name="room" id="room" class="form-control" placeholder="Room">
                                    </div>

                                    {{-- attend boolean --}}
                                    <div class="input-area relative">
                                        <label for="attend" class="form-label">Attend</label>
                                        <input type="text" name="attend" id="attend" class="form-control" placeholder="Attend">
                                    </div>

                                    {{-- status --}}
                                    <div class="input-area relative">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" name="status" id="status" class="form-control" placeholder="Status">
                                    </div>

                                    {{-- department --}}
                                    <div class="input-area relative">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" name="department" id="department" class="form-control" placeholder="Department">
                                    </div>

                                    {{-- salary --}}
                                    <div class="input-area relative">
                                        <label for="salary" class="form-label">Salary</label>
                                        <input type="text" name="salary" id="salary" class="form-control" placeholder="Salary">
                                    </div>

                                    {{-- doctor type --}}
                                    <div class="input-area relative">
                                        <label for="doctorType" class="form-label">Doctor Type</label>
                                        <input type="text" name="doctorType" id="doctorType" class="form-control" placeholder="Doctor Type">
                                    </div>

                                    {{-- transport fee --}}
                                    <div class="input-area relative">
                                        <label for="transportFee" class="form-label">Transport Fee</label>
                                        <input type="text" name="transportFee" id="transportFee" class="form-control" placeholder="Transport Fee">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
