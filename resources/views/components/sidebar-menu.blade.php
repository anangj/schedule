<!-- BEGIN: Sidebar -->
<div class="sidebar-wrapper group w-0 hidden xl:w-[248px] xl:block">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">

        <!-- Application Logo -->
        <x-application-logo />

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200" icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200" icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="sidebarCloseIcon text-2xl inline-block md:hidden">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0"></div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] z-50" id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">{{ __('MENU') }}</li>
            <li>
                <a href="{{ route('dashboard.index') }}" class="navItem {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>{{ __('Home') }}</span>
                    </span>
                </a>
            </li>
            <!-- Database -->
            <li>
                <a href="{{ route('database-backups.index') }}" class="navItem {{ (request()->is('database-backups*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="iconoir:database-backup"></iconify-icon>
                        <span>{{ __('Database Backup') }}</span>
                    </span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'doctors*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                        <span>{{ __('Dcotor') }}</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('doctors.index') }}" class="{{ (\Request::route()->getName() == 'doctors.index') ? 'active' : '' }}">{{ __('List Doctor') }}</a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('forms.input') }}" class="{{ (\Request::route()->getName() == 'forms.input') ? 'active' : '' }}">{{ __('Input') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.input-group') }}" class="{{ (\Request::route()->getName() == 'forms.input-group') ? 'active' : '' }}">{{ __('Input group') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.input-layout') }}" class="{{ (\Request::route()->getName() == 'forms.input-layout') ? 'active' : '' }}">{{ __('Input layout') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.input-validation') }}" class="{{ (\Request::route()->getName() == 'forms.input-validation') ? 'active' : '' }}">{{ __('Form validation') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.input-wizard') }}" class="{{ (\Request::route()->getName() == 'forms.input-wizard') ? 'active' : '' }}">{{ __('Wizard') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.input-mask') }}" class="{{ (\Request::route()->getName() == 'forms.input-mask') ? 'active' : '' }}">{{ __('Input mask') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.file-input') }}" class="{{ (\Request::route()->getName() == 'forms.file-input') ? 'active' : '' }}">{{ __('File input') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.repeater') }}" class="{{ (\Request::route()->getName() == 'forms.repeater') ? 'active' : '' }}">{{ __('From repeater') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.textarea') }}" class="{{ (\Request::route()->getName() == 'forms.textarea') ? 'active' : '' }}">{{ __('Textarea') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.checkbox') }}" class="{{ (\Request::route()->getName() == 'forms.checkbox') ? 'active' : '' }}">{{ __('Checkbox') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.radio') }}" class="{{ (\Request::route()->getName() == 'forms.radio') ? 'active' : '' }}">{{ __('Radio button') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.switch') }}" class="{{ (\Request::route()->getName() == 'forms.switch') ? 'active' : '' }}">{{ __('Switch') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.select') }}" class="{{ (\Request::route()->getName() == 'forms.select') ? 'active' : '' }}">{{ __('Select') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('forms.date-time-picker') }}" class="{{ (\Request::route()->getName() == 'forms.date-time-picker') ? 'active' : '' }}">{{ __('Date time picker') }}</a>
                    </li> --}}
                </ul>
            </li>
            
            {{-- <li>
                <a href="{{ route('doctors.index') }}" class="navItem {{ (request()->is('doctors*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                        <span>{{ __('Doctor') }}</span>
                    </span>
                </a>
            </li> --}}

            <li>
                <a href="{{ route('nurses.index') }}" class="navItem {{ (request()->is('nurses*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                        <span>{{ __('Nurse') }}</span>
                    </span>
                </a>
            </li>
            <li class="{{ (\Request::route()->getName() == 'Schedules*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                        <span>{{ __('Schedule') }}</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('plasma') }}" class="{{ (\Request::route()->getName() == 'plasma') ? 'active' : '' }}">{{ __('Schedule Plasma') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('schedules.index') }}" class="{{ (\Request::route()->getName() == 'schedules.index') ? 'active' : '' }}">{{ __('List Schedule') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('schedules.create') }}" class="{{ (\Request::route()->getName() == 'schedules.create') ? 'active' : '' }}">{{ __('Create Schedule') }}</a>
                    </li>
                </ul>
            </li>
            <!-- Settings -->
            <li>
                <a href="{{ route('general-settings.show') }}" class="navItem {{ (request()->is('general-settings*')) || (request()->is('users*')) || (request()->is('roles*')) || (request()->is('profiles*')) || (request()->is('permissions*')) ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="material-symbols:settings-outline"></iconify-icon>
                        <span>{{ __('Settings') }}</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End: Sidebar -->