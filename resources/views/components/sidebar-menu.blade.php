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
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                <li>
                    <a href="{{ route('dashboard.index') }}" class="navItem {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:home"></iconify-icon>
                            <span>{{ __('Home') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('master-dokters.index') }}" class="navItem {{ (request()->is('master-dokters*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Master Doctor') }}</span>
                        </span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('master-nurses.index') }}" class="navItem {{ (request()->is('master-nurses*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Master Nurses') }}</span>
                        </span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('drivers.index') }}" class="navItem {{ (request()->is('drivers*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="ph:ambulance"></iconify-icon>
                            <span>{{ __('Driver') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nod.index') }}" class="navItem {{ (request()->is('nod*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Nod') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nurses.index') }}" class="navItem {{ (request()->is('nurses*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Nurse') }}</span>
                        </span>
                    </a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'doctors*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Monthly Doctor') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('doctors.index') }}" class="{{ (\Request::route()->getName() == 'doctors.index') ? 'active' : '' }}">{{ __('Doctor IGD') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('doctorSpecialist.index') }}" class="{{ (\Request::route()->getName() == 'doctorSpecialist.index') ? 'active' : '' }}">{{ __('Doctor Specialist') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (\Request::route()->getName() == 'Schedules*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('plasma') }}" class="{{ (\Request::route()->getName() == 'plasma') ? 'active' : '' }}">{{ __('Plasma') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('plasma2') }}" class="{{ (\Request::route()->getName() == 'plasma2') ? 'active' : '' }}">{{ __('Plasma2') }}</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('plasmaSpecialist') }}" class="{{ (\Request::route()->getName() == 'plasmaSpecialist') ? 'active' : '' }}">{{ __('Plasma Specialist') }}</a>
                        </li> --}}
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
            @endif
            @if (Auth::user()->hasRole('marketing'))
                <li>
                    <a href="{{ route('marketing.index') }}" class="navItem {{ (request()->is('marketing*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="nimbus:marketing"></iconify-icon>
                            <span>{{ __('Marketing') }}</span>
                        </span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('igd'))
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
                            <span>{{ __('Plasma') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('plasma') }}" class="{{ (\Request::route()->getName() == 'plasma') ? 'active' : '' }}">{{ __('Plasma') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('plasma2') }}" class="{{ (\Request::route()->getName() == 'plasma2') ? 'active' : '' }}">{{ __('Plasma2') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('plasmaSpecialist') }}" class="{{ (\Request::route()->getName() == 'plasmaSpecialist') ? 'active' : '' }}">{{ __('Plasma Specialist') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->hasRole('hr'))
                <li>
                    <a href="{{ route('master-dokters.index') }}" class="navItem {{ (request()->is('master-dokters*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Master Doctor') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('drivers.index') }}" class="navItem {{ (request()->is('drivers*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="ph:ambulance"></iconify-icon>
                            <span>{{ __('Driver') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nurses.index') }}" class="navItem {{ (request()->is('nurses*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Nurse') }}</span>
                        </span>
                    </a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'doctors*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Monthly Doctor') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('doctors.index') }}" class="{{ (\Request::route()->getName() == 'doctors.index') ? 'active' : '' }}">{{ __('Doctor IGD') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('doctorSpecialist.index') }}" class="{{ (\Request::route()->getName() == 'doctorSpecialist.index') ? 'active' : '' }}">{{ __('Doctor Specialist') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (\Request::route()->getName() == 'Schedules*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('plasma') }}" class="{{ (\Request::route()->getName() == 'plasma') ? 'active' : '' }}">{{ __('Plasma') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('plasma2') }}" class="{{ (\Request::route()->getName() == 'plasma2') ? 'active' : '' }}">{{ __('Plasma2') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('plasmaSpecialist') }}" class="{{ (\Request::route()->getName() == 'plasmaSpecialist') ? 'active' : '' }}">{{ __('Plasma Specialist') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- End: Sidebar -->