<!-- BEGIN: Sidebar -->
<div class="sidebar-wrapper group w-0 hidden xl:w-[248px] xl:block">
    <div id="bodyOverlay" class="fixed top-0 z-10 hidden w-screen h-screen bg-opacity-50 bg-slate-900 backdrop-blur-sm">
    </div>
    <div class="logo-segment">

        <!-- Application Logo -->
        <x-application-logo />

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="text-lg cursor-pointer text-slate-900 dark:text-white">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200" icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200" icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="inline-block text-2xl sidebarCloseIcon md:hidden">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0"></div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] z-50" id="sidebar_menus">
        <ul class="sidebar-menu">
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                {{-- <li>
                    <a href="{{ route('articles.index') }}" class="navItem {{ (request()->is('articles*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:home"></iconify-icon>
                            <span>{{ __('Article') }}</span>
                        </span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('dashboard.index') }}" class="navItem {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class="nav-icon" icon="heroicons-outline:home"></iconify-icon>
                            <span>{{ __('Home') }}</span>
                        </span>
                    </a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'doctors*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="material-symbols:database"></iconify-icon>
                            <span>{{ __('Master') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-dokters.index') }}" class="{{ (\Request::route()->getName() == 'master-dokters.index') ? 'active' : '' }}">{{ __('Master Dokter') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-nod.index') }}" class="{{ (\Request::route()->getName() == 'master-nod.index') ? 'active' : '' }}">{{ __('Master NOD') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-nurses.index') }}" class="{{ (\Request::route()->getName() == 'master-nurses.index') ? 'active' : '' }}">{{ __('Master Nurse') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-ponek.index') }}" class="{{ (\Request::route()->getName() == 'master-ponek.index') ? 'active' : '' }}">{{ __('Master Ponek') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-driver.index') }}" class="{{ (\Request::route()->getName() == 'master-driver.index') ? 'active' : '' }}">{{ __('Master Driver') }}</a>
                        </li>
                    </ul>
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
                <li>
                    <a href="{{ route('ponek.index') }}" class="navItem {{ (request()->is('poneks*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Ponek') }}</span>
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
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
                </li>
                {{-- <li class="{{ (\Request::route()->getName() == 'lobbies*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="mdi:projector-screen-variant"></iconify-icon>
                            <span>{{ __('Lobby') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('lobby.index') }}" class="{{ (\Request::route()->getName() == 'lobby.index') ? 'active' : '' }}">{{ __('Videotron') }}</a>
                        </li>
                    </ul>
                </li> --}}
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
            @if (Auth::user()->hasRole('igd'))
                {{-- <li>
                    <a href="{{ route('master-nurses.index') }}" class="navItem {{ (request()->is('master-nurses*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Master Nurse') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('master-ponek.index') }}" class="navItem {{ (request()->is('master-poneks*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Master Ponek') }}</span>
                        </span>
                    </a>
                </li> --}}
                <li class="{{ (\Request::route()->getName() == 'masters*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="material-symbols:database"></iconify-icon>
                            <span>{{ __('Master') }}</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-dokters.index') }}" class="{{ (\Request::route()->getName() == 'master-dokters.index') ? 'active' : '' }}">{{ __('Master Dokter') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-nod.index') }}" class="{{ (\Request::route()->getName() == 'master-nod.index') ? 'active' : '' }}">{{ __('Master NOD') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-nurses.index') }}" class="{{ (\Request::route()->getName() == 'master-nurses.index') ? 'active' : '' }}">{{ __('Master Nurse') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-ponek.index') }}" class="{{ (\Request::route()->getName() == 'master-ponek.index') ? 'active' : '' }}">{{ __('Master Ponek') }}</a>
                        </li>
                    </ul>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('master-driver.index') }}" class="{{ (\Request::route()->getName() == 'master-driver.index') ? 'active' : '' }}">{{ __('Master Driver') }}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('nurses.index') }}" class="navItem {{ (request()->is('nurses*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Upload Jadwal Nurse') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ponek.index') }}" class="navItem {{ (request()->is('poneks*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Upload Jadwal Ponek') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nod.index') }}" class="navItem {{ (request()->is('nods*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Upload Jadwal Nod') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('drivers.index') }}" class="navItem {{ (request()->is('drivers*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="ph:ambulance"></iconify-icon>
                            <span>{{ __('Upload Jadwal Driver') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('doctors.index') }}" class="navItem {{ (request()->is('doctors*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="raphael:calendar"></iconify-icon>
                            <span>{{ __('Upload Jadwal Dokter IGD') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
                            <span>{{ __('Upload Jadwal Driver') }}</span>
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

                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
            @if (Auth::user()->hasRole('nod'))
                <li>
                    <a href="{{ route('master-nod.index') }}" class="navItem {{ (request()->is('master-nods*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Master Nod') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nod.index') }}" class="navItem {{ (request()->is('nods*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="tabler:nurse"></iconify-icon>
                            <span>{{ __('Upload Jadwal Nod') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
            @if (Auth::user()->hasRole('driver'))
                <li>
                    <a href="{{ route('master-driver.index') }}" class="navItem {{ (request()->is('master-drivers*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="ph:ambulance"></iconify-icon>
                            <span>{{ __('Master Driver') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('drivers.index') }}" class="navItem {{ (request()->is('drivers*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="ph:ambulance"></iconify-icon>
                            <span>{{ __('Upload Jadwal Driver') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
            @if (Auth::user()->hasRole('dokter'))
                <li>
                    <a href="{{ route('master-dokters.index') }}" class="navItem {{ (request()->is('master-dokters*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Master Dokter') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('doctors.index') }}" class="navItem {{ (request()->is('doctors*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="raphael:calendar"></iconify-icon>
                            <span>{{ __('Upload Jadwal IGD') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
            @if (Auth::user()->hasRole('spesialis'))
                <li>
                    <a href="{{ route('master-dokters.index') }}" class="navItem {{ (request()->is('master-dokters*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Master Dokter') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('doctorSpecialist.index') }}" class="navItem {{ (request()->is('doctorSpecialists*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="raphael:calendar"></iconify-icon>
                            <span>{{ __('Upload Jadwal Spesialis') }}</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plasma') }}" class="navItem {{ (request()->is('plasmas*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Plasma') }}</span>
                        </span>
                    </a>
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
            @can('menu lobby')
                <li>
                    <a href="{{ route('lobby.index') }}" class="navItem {{ (request()->is('lobbys*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="maki:doctor"></iconify-icon>
                            <span>{{ __('Lobby') }}</span>
                        </span>
                    </a>
                </li>
            @endcan
            @can('menu schedule')
                <li>
                    <a href="{{ route('schedule-dokters.index') }}" class="navItem {{ (request()->is('schedule-dokterss*')) ? 'active' : '' }}">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="uil:schedule"></iconify-icon>
                            <span>{{ __('Schedule') }}</span>
                        </span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
<!-- End: Sidebar -->
