<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="first_name" :value="__('First Name')" />

                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div>
            <div>
                <x-label for="last_name" :value="__('Last Name')" />

                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="mt-4">
            {!! config('static_content.privacy_content') !!}
            </div>
            <div class="mt-4">
               <label for="can_retain_data" class="block">
                <input type="checkbox" {{old('can_retain_data') == '1' ? 'checked="checked"' : ''}} id="can_retain_data" name="can_retain_data" class="m-4" value="1"/>Check here to retain your data for future shows
               </label>
               <label for="can_email" class="block">
                <input type="checkbox" {{old('can_email') == '1' ? 'checked="checked"' : ''}} id="can_email" name="can_email" class="m-4" value="1"/>May we email you occasionally?
               </label>
               <label for="can_sms" class="block">
                <input type="checkbox" {{old('can_sms') == '1' ? 'checked="checked"' : ''}} id="can_sms" name="can_sms" class="m-4" value="1"/>May we Text you occasionally?
               </label>
               <label for="can_post" class="block">
                <input type="checkbox" {{old('can_post') == '1' ? 'checked="checked"' : ''}} id="can_post" name="can_post" class="m-4" value="1"/>May we post the odd letter to you
               </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
