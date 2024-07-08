@props(['user' => null, 'action' =>  route('profile.update')])

<form method="POST" :action="$route">
    {{ method_field('PUT') }}
    @csrf
    <!-- Name -->
    <div class="grid-cols-2">
        <div>
            <x-label for="first_name" :value="__('First Name')"/>

            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                     :value="old('first_name', $user?->first_name )" required autofocus/>
        </div>
        <div>
            <x-label for="last_name" :value="__('Last Name')"/>

            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                     :value="old('last_name', $user?->last_name)" required autofocus/>
        </div>
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-label for="email" :value="__('Email')"/>

        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                 :value="old('email', $user?->email)" required/>
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-label for="telephone" :value="__('Telephone')"/>

        <x-input id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                 :value="old('telephone', $user?->telephone)"/>
    </div>

    <!-- Address -->
    <div class="mt-4">
        <x-label for="address_1" :value="__('Address')"/>

        <x-input id="address_1" class="block mt-1 w-full" type="text" name="address_1"
                 :value="old('address_1', $user?->address_1)" placeholder="Address Line 1"/>
        <x-input id="address_2" class="block w-full" type="text" name="address_2"
                 :value="old('address_2', $user?->address_2)" placeholder="Address Line 2"/>
        <x-input id="address_town" class="block w-full" type="text" name="address_town"
                 :value="old('address_town', $user?->address_town)" placeholder="Town / City"/>
        <x-input id="postcode" class="block w-full" type="text" name="postcode"
                 :value="old('postcode', $user?->postcode)" placeholder="Postcode"/>
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-label for="password"
                 :value="__('Change Password (Optional - leave blank if you do not wish to change this)')"/>

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
    <div class="mt-4">
        <div class="mt-4">
            {!! config('static_content.privacy_content') !!}
        </div>
        <div class="mt-4">
            <label for="can_retain_data" class="block">
                <input type="checkbox" {{$user?->can_retain_data == '1' ? 'checked="checked"' : ''}} id="can_retain_data" name="can_retain_data" class="m-4" value="1"/>Check here to retain your data for future shows
            </label>
            <label for="can_email" class="block">
                <input type="checkbox" {{$user?->can_email == '1' ? 'checked="checked"' : ''}} id="can_email" name="can_email" class="m-4" value="1"/>May we email you occasionally?
            </label>
            <label for="can_sms" class="block">
                <input type="checkbox" {{$user?->can_sms == '1' ? 'checked="checked"' : ''}} id="can_sms" name="can_sms" class="m-4" value="1"/>May we Text you occasionally?
            </label>
            <label for="can_post" class="block">
                <input type="checkbox" {{$user?->can_post == '1' ? 'checked="checked"' : ''}} id="can_post" name="can_post" class="m-4" value="1"/>May we post the odd letter to you
            </label>
        </div>

    </div>

    <div class="flex items-center justify-end mt-4">
        <x-buttons.default class="ml-4">
            {{ __('Update') }}
        </x-buttons.default>
    </div>
</form>
