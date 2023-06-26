@props(['member'])

@php
    $latestMembershipPurchase = $member->getLatestMembershipPurchase();
@endphp

<div class=" border-b-2 my-4">
    <form method="POST" id="form_{{$member->id}}"
          action="{{route('membershippurchases.store', ['user'=> $member])}}">
        @csrf
       {{$member->last_name}}, {{$member->first_name}} / {{$member->postcode, $member->address_1}}
    </form>
</div>
<div class=" border-b-2 my-4">
    <x-goodbad
        :success="$member->membershipIsCurrent()">{{$member->getLatestMembershipEndDate()?->format('Y-m-d') ?? '--'}}</x-goodbad>
</div>
<div class="ml-8 border-b-2 my-4">
    <input form="form_{{$member->id}}" type="checkbox" name="can_retain_data"
           value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!}{!! $member->can_retain_data ? ' checked="checked"' :'' !!}
    " />
</div>
<div class="ml-8 border-b-2 my-4">
    <input form="form_{{$member->id}}" type="checkbox" name="can_email"
           value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!} {!! $member->can_email ? 'checked="checked"' :'' !!}
    " />
</div>
<div class=" border-b-2 my-4">
    @if(!$member->membershipIsCurrent())
        <x-input form="form_{{$member->id}}" type="email" name="email" class="text-sm w-64"
                 value="{{$member->email}}"/>
    @else
        {{$member->email}}
    @endif
</div>
<div class=" border-b-2 my-4">
    @if(!$member->membershipIsCurrent())
        <x-select form="form_{{$member->id}}" class="w-40  text-sm" name="membership_type"
                  blankLabel="Membership Type.." :options="\App\Models\Membership::getTypes()"
                  hasBlank="true" :selected="$latestMembershipPurchase?->type"/><br/>
        <x-select form="form_{{$member->id}}" class="w-40 text-sm" name="payment_method"
                  blankLabel="Payment Type.."
                  :options="\App\Models\Payment::getAllPaymentTypes(false)" hasBlank="true"/>
    @else
        {{\App\Models\Membership::getTypes()[$latestMembershipPurchase?->type]}}
    @endif
</div>
<div class=" border-b-2 my-4">
    @if(!$member->membershipIsCurrent())
        <input form="form_{{$member->id}}" type="hidden" name="user_id"
               value="{{(int)$member->id}}"/>
        <x-button form="form_{{$member->id}}">Renew</x-button>
        {{--                        <div class="border-4 w-12">&nbsp;</div>--}}
    @else

    @endif
</div>

