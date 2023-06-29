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

            <x-forms.edit-user :user="$user"/>

    </x-layout.intro-para>

</x-app-layout>
