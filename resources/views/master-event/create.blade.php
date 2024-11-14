<x-app-layout>
    <div class="space-y-8">
        <div class="block sm:flex items-center justify-between mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />

            <div class="text-end">
                <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('events.index') }}">
                    <iconify-icon class="text-lg mr-1" icon="ic:outline-arrow-back"></iconify-icon>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="rounded-md overflow-hidden">
        <div class="bg-white dark:bg-slate-800 px-5 py-7">
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="position_id" class="form-label">{{ __('Select Position') }}</label>
                    <select name="position_id" id="position_id" class="form-control" required>
                        <option value="">{{ __('Choose Position') }}</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">
                                {{ $position->position_name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('position_id')" class="mt-2" />
                </div>

                <div class="form-group mb-4">
                    <label for="name">{{ __('Event Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="start_date">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="end_date">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="isActive">{{ __('Status') }}</label>
                    <select name="isActive" id="isActive" class="form-control" required>
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0">{{ __('Inactive') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('isActive')" class="mt-2" />
                </div>

                <div class="form-group mb-4">
                    <label for="order">{{ __('Order') }}</label>
                    <input type="number" name="order" id="order" class="form-control" required min="1">
                </div>

                <h3 class="text-lg font-semibold mb-4">{{ __('Content Event') }}</h3>

                <div class="form-group mb-4">
                    <label for="type">{{ __('Content Type') }}</label>
                    <select name="type" id="type" class="form-control">
                        <option value="photo">{{ __('Photo') }}</option>
                        <option value="video">{{ __('Video') }}</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="file">{{ __('File Content (Video)') }}</label>
                    <input type="file" name="file" id="file" class="form-control" accept="video/*" required>
                    <small class="text-muted">{{ __('Supported formats: mp4, avi, mov, etc.') }}</small>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn btn-dark">
                        {{ __('Create Event') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
