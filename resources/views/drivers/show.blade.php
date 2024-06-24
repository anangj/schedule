<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="justify-end flex gap-3 items-center flex-wrap">
                {{-- Refresh Button start --}}
                <a class="defaultButton px-3" href="{{ route('drivers.show', $drivers) }}">
                    <iconify-icon icon="mdi:refresh" class="text-xl "></iconify-icon>
                </a>
                {{-- Back Button start --}}
                <a class="defaultButton" href="{{ route('roles.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
        <div class="rounded-md overflow-hidden"></div>
    </div>
</x-app-layout>