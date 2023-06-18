@props(['member'])

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
                    </td>
                    <td class="text-center">
                        <input form="form_{{$member->id}}" type="checkbox" name="can_email"
                               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!} {!! $member->can_email ? 'checked="checked"' :'' !!}
                        " />
                    </td>
                    <td>
                        @if(!$member->membershipIsCurrent())
                            <input form="form_{{$member->id}}" type="email" name="email" class="text-sm w-64"
                                   value="{{$member->email}}"/>
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
