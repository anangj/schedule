<x-app-layout>
    <div>
        {{--Breadcrumb start--}}
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{--Breadcrumb end--}}

        {{--Create user form start--}}
        <form method="POST" action="{{ route('users.update',$user) }}" class="max-w-4xl m-auto">
            @csrf
            @method('PUT')
            <div class="p-5 pb-6 bg-white rounded-md dark:bg-slate-800">

                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                    {{--Name input end--}}
                    <div class="input-area">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input name="name" type="text" id="name" class="form-control"
                               placeholder="{{ __('Enter your name') }}" value="{{ $user->name }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    {{--Email input start--}}
                    <div class="input-area">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input name="email" type="email" id="email" class="form-control"
                               placeholder="{{ __('Enter your email') }}" value="{{ $user->email }}" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    {{--Password input start--}}
                    <div class="input-area">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input name="password" type="password" id="password" class="form-control"
                               placeholder="{{ __('Enter Password') }}">
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    {{--Role input start--}}
                        <div class="input-area">
                            <label for="role" class="form-label">{{ __('Role') }}</label>
                            <select name="role" class="form-control" @if(!Auth::user()->hasRole('super-admin')) disabled @endif>
                                <option value="" selected disabled>
                                    {{ __('Select Role') }}
                                </option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <iconify-icon class="absolute z-10 text-xl right-3 bottom-3 dark:text-white"
                                        icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                        </div>
                    {{--Role input end--}}
                </div>
                <button type="submit" class="inline-flex justify-center w-full mt-4 btn btn-dark">
                    {{ __('Save Changes') }}
                </button>
            </div>

        </form>
        {{--Create user form end--}}
    </div>
</x-app-layout>
