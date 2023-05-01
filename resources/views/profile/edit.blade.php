<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('My Profile') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('My Profile') }}
        </x-headers.h1>
    </x-slot>
    <x-layout.intro-para>
        <p>@lang('You can adjust your profile settings here')</p>
    </x-layout.intro-para>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    <x-layout.intro-para>
        <form method="POST" action="{{ route('profile.update') }}">
            {{ method_field('PUT') }}
            @csrf

            <!-- Name -->
            <div class="grid-cols-2">
                <div>
                    <x-label for="first_name" :value="__('First Name')"/>

                    <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                             :value="old('first_name', $user->first_name)" required autofocus/>
                </div>
                <div>
                    <x-label for="last_name" :value="__('Last Name')"/>

                    <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                             :value="old('last_name', $user->last_name)" required autofocus/>
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email', $user->email)" required/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="telephone" :value="__('Telephone')"/>

                <x-input id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                         :value="old('telephone', $user->telephone)"/>
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-label for="address_1" :value="__('Address')"/>

                <x-input id="address_1" class="block mt-1 w-full" type="text" name="address_1"
                         :value="old('address_1', $user->address_1)" placeholder="Address Line 1"/>
                <x-input id="address_2" class="block w-full" type="text" name="address_2"
                         :value="old('address_2', $user->address_2)" placeholder="Address Line 2"/>
                <x-input id="address_town" class="block w-full" type="text" name="address_town"
                         :value="old('address_town', $user->address_town)" placeholder="Town / City"/>
                <x-input id="postcode" class="block w-full" type="text" name="postcode"
                         :value="old('postcode', $user->postcode)" placeholder="Postcode"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Change Password (Optional)')"/>

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </x-layout.intro-para>

</x-app-layout>
