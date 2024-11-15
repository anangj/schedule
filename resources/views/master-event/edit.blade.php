<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3"
                    href="{{ route('events.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('events.update', $event->id) }}">
                @csrf
                @method('PUT')



                {{-- Position Selection --}}
                <div class="form-group mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Position') }}</label>
                    <select name="position_id" id="position_id" class="form-control mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($allPositions as $position)
                            <option value="{{ $position->id }}" {{ $position->id == $event->position_id ? 'selected' : '' }}>
                                {{ $position->position_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group mb-4">
                    <label for="name">{{ __('Event Name') }}</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ $event->name }}">
                </div>

                {{-- Name Input --}}
                {{-- <div class="mb-4">
                    <label for="name" class="form-control  block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Event Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div> --}}

                {{-- Start Date Input --}}
                <div class="form-group mb-4">
                    <label for="start_date">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', $event->start_date) }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>

                </div>

                {{-- End Date Input --}}
                <div class="form-group mb-4">
                    <label for="end_date"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date) }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('end_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="isActive" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active') }}</label>
                    <select name="isActive" id="isActive" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="1" {{ $event->isActive ? 'selected' : '' }}>{{ __('Yes') }}</option>
                        <option value="0" {{ !$event->isActive ? 'selected' : '' }}>{{ __('No') }}</option>
                    </select>
                    @error('isActive')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Order Input --}}
                <div class="mb-4">
                    <label for="content_order"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Order') }}</label>
                    <input type="number" name="content_order" id="content_order" value="{{ old('content_order', $event->content_order) }}"
                        min="1"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('content_order')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                        class="btn inline-flex justify-center btn-dark dark:bg-slate-700 dark:text-slate-300 m-1 mt-4 !px-3 !py-2">
                        <span class="flex items-center">
                            <span> @lang('Save Changes')</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
