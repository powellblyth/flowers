@php use App\Models\Membership; @endphp
@php use App\Models\Payment; @endphp
<div>
    @if($succeeded)
        <div>Member Successfully Created</div>
    @else
        <form wire:submit.prevent="submit">
            <!-- Name -->
            <div class="grid-cols-2">
                <div>
                    @error('first_name')<span class="text-red-500">{{ $message }}</span> @enderror
                    <x-label for="first_name" :value="__('First Name')"/>

                    <x-input wire:model="first_name" id="first_name" class="block mt-1 w-full" type="text"
                             name="first_name"
                             :value="old('first_name' )" required autofocus/>
                </div>
                <div>
                    @error('last_name')@enderror
                    <x-label for="last_name" :value="__('Last Name')"/>

                    <x-input wire:model="last_name" id="last_name" class="block mt-1 w-full" type="text"
                             name="last_name"
                             :value="old('last_name')" required autofocus/>
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                @error('email')@enderror
                <x-label for="email" :value="__('Email')"/>

                <x-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email')" required/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                @error('telephone')@enderror
                <x-label for="telephone" :value="__('Telephone')"/>

                <x-input wire:model="telephone" id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                         :value="old('telephone')"/>
            </div>

            <!-- Address -->
            <div class="mt-4">
                @error('address_1')@enderror
                <x-label for="address_1" :value="__('Address')"/>

                <x-input wire:model="address_1" id="address_1" class="block mt-1 w-full" type="text" name="address_1"
                         :value="old('address_1')" placeholder="Address Line 1"/>
                @error('address_2')@enderror
                <x-input wire:model="address_2" id="address_2" class="block w-full" type="text" name="address_2"
                         :value="old('address_2')" placeholder="Address Line 2"/>
                @error('address_town')@enderror
                <x-input wire:model="address_town" id="address_town" class="block w-full" type="text"
                         name="address_town"
                         :value="old('address_town')" placeholder="Town / City"/>
                @error('postcode')@enderror
                <x-input wire:model="postcode" id="postcode" class="block w-full" type="text" name="postcode"
                         :value="old('postcode')" placeholder="Postcode"/>
            </div>
            <div>
                @error('membership')@enderror
                <x-label for="membership" :value="__('Membership')"/>
                <x-select wire:model="membership_type" class="w-40  text-sm" name="membership_type"
                          blankLabel="Membership Type.." :options="Membership::getTypesWithLabels()"
                          hasBlank="true"/>
                <br/>
                <x-select wire:model="payment_type" class="w-40 text-sm" name="payment_type"
                          blankLabel="Payment Type.."
                          :options="Payment::getAllPaymentTypes(false)" hasBlank="true"/>
            </div>

            <div class="mt-4">
                <div class="mt-4">
                    {!! config('static_content.privacy_content') !!}
                </div>
                <div class="mt-4">
                    <label for="can_retain_data" class="block">
                        <input wire:model="can_retain_data" type="checkbox" id="can_retain_data" name="can_retain_data" class="m-4" value="1"/>Check here to retain your data for future shows
                    </label>
                    <label for="can_email" class="block">
                        <input wire:model="can_email" type="checkbox" id="can_email" name="can_email" class="m-4" value="1"/>May we email you occasionally?
                    </label>
                    <label for="can_sms" class="block">
                        <input wire:model="can_sms" type="checkbox" id="can_sms" name="can_sms" class="m-4" value="1"/>May we Text you occasionally?
                    </label>
                    <label for="can_post" class="block">
                        <input wire:model="can_post" type="checkbox" id="can_post" name="can_post" class="m-4" value="1"/>May we post the odd letter to you
                    </label>
                </div>
                <div class="margin-left-auto">
                    <x-buttons.default>Save Member</x-buttons.default>
                </div>
            </div>
        </form>
    @endif
</div>
