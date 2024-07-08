@props(['member'])
<div wire:key="member_list_item_{{$member->id}}" class="grid grid-cols-[250px_120px_80px_80px_300px_170px_120px]">

    <div class=" border-b-2 my-4">
        {{$member->last_name}}, {{$member->first_name}} / {{$member->postcode, $member->address_1}}
    </div>
    <div class=" border-b-2 my-4">
        <x-goodbad
            :success="$member->membershipIsCurrent()">{{$member->getLatestMembershipEndDate()?->format('Y-m-d') ?? '--'}}</x-goodbad>
    </div>
    <div class="ml-8 border-b-2 my-4">
        <input wire:model="can_retain_data" type="checkbox" name="can_retain_data"
               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!}{!! $member->can_retain_data ? ' checked="checked"' :'' !!}
        " />
    </div>
    <div class="ml-8 border-b-2 my-4">
        <input wire:model="can_email" type="checkbox" name="can_email"
               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!} {!! $member->can_email ? 'checked="checked"' :'' !!}
        " />
    </div>
    <div class="border-b-2 my-4">
        @if(!$member->membershipIsCurrent())
            <x-input wire:model="email" autocomplete="off" value="{{$member->email}}" type="email" name="email" class="text-sm w-64"/>
        @else
            {{$member->email}}
        @endif
    </div>
    <div class="border-b-2 my-4 ">
        @if($this->failed)
            <span class="text-red-600">{{$this->failedMessage}}</span>
        @endif
        @if($this->successMessage)
            <span class="text-green-600">{{$this->successMessage}}</span>
        @endif


    @if(!$member->membershipIsCurrent())
            <x-select wire:model="membership_type" class="w-40  text-sm" name="membership_type"
                      blankLabel="Membership Type.." :options="\App\Models\Membership::getTypes()"
                      hasBlank="true" />
            <br/>
            <x-select wire:model="payment_type" class="w-40 text-sm" name="payment_type"
                      blankLabel="Payment Type.."
                      :options="\App\Models\Payment::getAllPaymentTypes(false)" hasBlank="true"/>
        @else
            {{\App\Models\Membership::getTypes()[$latestMembershipPurchase?->type]}}
        @endif
    </div>
    <div class="border-b-2 my-4 flex ">
        @if(!$member->membershipIsCurrent())
            <x-buttons.default wire:click.prevent.stop="renew">@lang('Renew')</x-buttons.default>
        @endif
    </div>

</div>
