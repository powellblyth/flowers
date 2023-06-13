<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Renewal Sheet') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Renewal Sheet') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <div class="flex">
            <div class="flex-auto">
                <p>Please remember to encourage those who are not yet subscribed to the newsletter to subscribe</p>
                <p>Please Double-check the email address</p>
                <p>Please accurately record the source of payment</p>
            </div>
            <div class="text-right flex-none">
                <x-button><a href="{{config('nova.url') . '/resources/users/new'}}">Create New Family</a></x-button>
            </div>
        </div>
    </x-layout.intro-para>
    @if($errors->any())
        <x-layout.intro-para>
            <h4 class="text-red-500 font-bold">{{$errors->first()}}</h4>
            <script defer="defer" type="text/javascript">
                alert('Error: {{htmlspecialchars($errors->first())}}')
            </script>
        </x-layout.intro-para>
    @endif
    <x-layout.intro-para>
        <table class="table-auto text-sm">
            <tr>
                <th class="px-4">Name</th>
                <th class="px-4">Previous <br/>Membership</th>
                <th class="px-4">Retain Data?<br/><i>Please Ask</i></th>
                <th class="px-4">Email?<br/><i>Please Ask</i></th>
                <th class="px-4">Email Address</th>
                <th class="px-4">Renewing?</th>
            </tr>
            @foreach($members as $member)
                @php
                    $latestMembershipPurchase = $member->getLatestMembershipPurchase();
                @endphp
                <tr class="border-t-2">
                    <td>
                        <form method="POST" id="form_{{$member->id}}"
                              action="{{route('membershippurchases.store', ['user'=> $member])}}">
                            @csrf
                            {{$member->full_name}} / {{$member->postcode}}</td>
                    <td>
                        <x-goodbad
                            :success="$member->membershipIsCurrent()">{{$member->getLatestMembershipEndDate()?->format('Y-m-d') ?? '--'}}</x-goodbad>
                    </td>
                    <td class="text-center">
                        <input form="form_{{$member->id}}" type="checkbox" name="can_retain_data"
                               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!}{!! $member->can_retain_data ? ' checked="checked"' :'' !!}
                        " />
                        {{--                        {!! $member->can_retain_data ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}--}}
                    </td>
                    <td class="text-center">
                        <input form="form_{{$member->id}}" type="checkbox" name="can_email"
                               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!} {!! $member->can_email ? 'checked="checked"' :'' !!}
                        " />
                        {{--                        {!! $member->can_email ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}--}}
                    </td>
                    <td>
                        @if(!$member->membershipIsCurrent())
                            <input form="form_{{$member->id}}" type="email" name="email" class="text-sm w-64"
                                   value="{{$member->email}}"/>
                            {{--                            <span class="border-4 inline-block w-64">&nbsp;</span></td>--}}
                        @else
                            {{$member->email}}
                        @endif
                    </td>
                    <td>
                        @if(!$member->membershipIsCurrent())
                            <x-select form="form_{{$member->id}}" class="w-40 text-sm" name="membership_type"
                                      blankLabel="Membership Type.." :options="\App\Models\Membership::getTypes()"
                                      hasBlank="true" :selected="$latestMembershipPurchase?->type"/><br/>
                            <x-select form="form_{{$member->id}}" class="w-40 text-sm" name="payment_method"
                                      blankLabel="Payment Type.."
                                      :options="\App\Models\Payment::getAllPaymentTypes(false)" hasBlank="true"/>

                            {{--                            <select name="payment_method">--}}
                            {{--                                @foreach (\App\Models\Payment::getAllPaymentTypes() as $payment_type => $payment_type_label)--}}
                            {{--                                    <option>{{$payment_type}}</option>--}}
                            {{--                                @endforeach--}}
                            {{--                            </select>--}}
                        @else
                            {{\App\Models\Membership::getTypes()[$latestMembershipPurchase?->type]}}
                        @endif
                    </td>
                    <td>
                        @if(!$member->membershipIsCurrent())
                            <input form="form_{{$member->id}}" type="hidden" name="user_id"
                                   value="{{(int)$member->id}}"/>
                            <x-button form="form_{{$member->id}}">Renew</x-button>
                            {{--                        <div class="border-4 w-12">&nbsp;</div>--}}
                        @else
                        @endif
                    </td>
                </tr>
                </form>
            @endforeach
        </table>

    </x-layout.intro-para>
</x-app-layout>
