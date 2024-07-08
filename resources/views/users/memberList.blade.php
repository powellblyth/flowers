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
                <p>@lang('Please remember to encourage those who are not yet subscribed to the newsletter to subscribe')</p>
                <p>@lang('Please Double-check the email address')</p>
                <p>@lang('Please accurately record the source of payment')</p>
            </div>
            <div class="text-right flex-none"><br /><br /><br /><br />
                {{--                <x-buttons.default><a href="{{config('nova.url') . '/resources/users/new'}}">--}}
{{--                        @lang('Create New Family Manager')--}}
                {{--                    </a></x-buttons.default>--}}

                <x-buttons.default type="button"
                          data-te-toggle="modal"
                          data-te-target="#exampleModalScrollable"
                          data-te-ripple-init
                          data-te-ripple-color="light">
                    Create a Family Manager
                    </x-buttons.default>
{{--                <button--}}
{{--                    type="button"--}}
{{--                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"--}}
{{--                    data-te-toggle="modal"--}}
{{--                    data-te-target="#exampleModalScrollable"--}}
{{--                    data-te-ripple-init--}}
{{--                    data-te-ripple-color="light">--}}
{{--                    Launch demo modal dialog scrollable--}}
{{--                </button>--}}

            </div>


            <!-- Modal -->
            <div
                data-te-modal-init
                class="fixed left-0 top-20 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="exampleModalScrollable"
                tabindex="-1"
                aria-labelledby="exampleModalScrollableLabel"
                aria-hidden="true">
                <div
                    data-te-modal-dialog-ref
                    class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                    <div
                        class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none ">{{-- dark:bg-neutral-600--}}
                        <div
                            class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 ">{{-- dark:border-opacity-50--}}
                            <!--Modal title-->
                            <h5
                                class="text-xl font-medium leading-normal text-neutral-800 " {{-- dark:text-neutral-200--}}
                                id="exampleModalScrollableLabel">
                                @lang('Create a new Family Manager')
                            </h5>
                            <!--Close button-->
                            <button
                                type="button"
                                class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                                data-te-modal-dismiss
                                aria-label="Close">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!--Modal body-->
                        <div class="relative overflow-y-auto p-4">
                            <livewire:new-member-form />
                        </div>

                        <!--Modal footer-->
{{--                        <div--}}
{{--                            class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">--}}
{{--                            <x-button--}}
{{--                                type="button"--}}
{{--                                class="inline-block rounded bg-gray-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"--}}
{{--                                data-te-modal-dismiss--}}
{{--                                data-te-ripple-init--}}
{{--                                data-te-ripple-color="light">--}}
{{--                                Close--}}
                        {{--                            </x-buttons.default>--}}
{{--                            <x-button--}}
{{--                                type="button"--}}
{{--                                class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"--}}
{{--                                data-te-ripple-init--}}
{{--                                data-te-ripple-color="light">--}}
{{--                                Save changes--}}
                        {{--                            </x-buttons.default>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
{{--        </div>--}}



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
        <livewire:member-list/>
{{--            @foreach($members as $member)--}}
{{--                @php--}}
{{--                    $latestMembershipPurchase = $member->getLatestMembershipPurchase();--}}
{{--                @endphp--}}
{{--                <tr class="border-t-2">--}}
{{--                    <td>--}}
{{--                        <form method="POST" id="form_{{$member->id}}"--}}
{{--                              action="{{route('membershippurchases.store', ['user'=> $member])}}">--}}
{{--                            @csrf--}}
{{--                            {{$member->full_name}} / {{$member->postcode}}</td>--}}
{{--                    <td>--}}
{{--                        <x-goodbad--}}
{{--                            :success="$member->membershipIsCurrent()">{{$member->getLatestMembershipEndDate()?->format('Y-m-d') ?? '--'}}</x-goodbad>--}}
{{--                    </td>--}}
{{--                    <td class="text-center">--}}
{{--                        <input form="form_{{$member->id}}" type="checkbox" name="can_retain_data"--}}
{{--                               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!}{!! $member->can_retain_data ? ' checked="checked"' :'' !!}--}}
{{--                        " />--}}
{{--                        --}}{{--                        {!! $member->can_retain_data ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}--}}
{{--                    </td>--}}
{{--                    <td class="text-center">--}}
{{--                        <input form="form_{{$member->id}}" type="checkbox" name="can_email"--}}
{{--                               value="1" {!! $member->membershipIsCurrent() ?' disabled="disabled"' : '' !!} {!! $member->can_email ? 'checked="checked"' :'' !!}--}}
{{--                        " />--}}
{{--                        --}}{{--                        {!! $member->can_email ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        @if(!$member->membershipIsCurrent())--}}
{{--                            <input form="form_{{$member->id}}" type="email" name="email" class="text-sm w-64"--}}
{{--                                   value="{{$member->email}}"/>--}}
{{--                            --}}{{--                            <span class="border-4 inline-block w-64">&nbsp;</span></td>--}}
{{--                        @else--}}
{{--                            {{$member->email}}--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        @if(!$member->membershipIsCurrent())--}}
{{--                            <x-select form="form_{{$member->id}}" class="w-40 text-sm" name="membership_type"--}}
{{--                                      blankLabel="Membership Type.." :options="\App\Models\Membership::getTypes()"--}}
{{--                                      hasBlank="true" :selected="$latestMembershipPurchase?->type"/><br/>--}}
{{--                            <x-select form="form_{{$member->id}}" class="w-40 text-sm" name="payment_method"--}}
{{--                                      blankLabel="Payment Type.."--}}
{{--                                      :options="\App\Models\Payment::getAllPaymentTypes(false)" hasBlank="true"/>--}}

{{--                            --}}{{--                            <select name="payment_method">--}}
{{--                            --}}{{--                                @foreach (\App\Models\Payment::getAllPaymentTypes() as $payment_type => $payment_type_label)--}}
{{--                            --}}{{--                                    <option>{{$payment_type}}</option>--}}
{{--                            --}}{{--                                @endforeach--}}
{{--                            --}}{{--                            </select>--}}
{{--                        @else--}}
{{--                            {{\App\Models\Membership::getTypes()[$latestMembershipPurchase?->type]}}--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        @if(!$member->membershipIsCurrent())--}}
{{--                            <input form="form_{{$member->id}}" type="hidden" name="user_id"--}}
{{--                                   value="{{(int)$member->id}}"/>--}}
        {{--                            <x-button form="form_{{$member->id}}">Renew</x-buttons.default>--}}
{{--                            --}}{{--                        <div class="border-4 w-12">&nbsp;</div>--}}
{{--                        @else--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                </form>--}}
{{--            @endforeach--}}

    </x-layout.intro-para>
</x-app-layout>
