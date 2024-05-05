<x-app-layout>
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Horizontal Form</div>
                </div>
            </header>
            <div class="card-text h-full ">
                <form class="space-y-4">
                    <div class="input-area relative pl-28">
                        <label for="largeInput" class="inline-inputLabel">Full Name</label>
                        <input type="text" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="input-area relative pl-28">
                        <label for="largeInput" class="inline-inputLabel">Email</label>
                        <input type="email" class="form-control" placeholder="Enter Your Email">
                    </div>
                    <div class="input-area relative pl-28">
                        <label for="largeInput" class="inline-inputLabel">Phone</label>
                        <input type="tel" class="form-control" placeholder="Phone Number" pattern="[0-9]">
                    </div>
                    <div class="input-area relative pl-28">
                        <label for="largeInput" class="inline-inputLabel">Password</label>
                        <input type="password" class="form-control" placeholder="8+ characters, 1 capitat letter">
                    </div>
                    <div class="checkbox-area ltr:pl-28 rtl:pr-28">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="hidden" name="checkbox">
                            <span class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative
                                    transition-all duration-150 bg-slate-100 dark:bg-slate-900">
                                <img src="images/icon/ck-white.svg" alt="" class="h-[10px] w-[10px] block m-auto opacity-0">
                            </span>
                            <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">Remember me</span>
                        </label>
                    </div>
                    <button class="btn inline-flex justify-center btn-dark ml-28">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

