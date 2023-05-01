<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('My Family') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('My Family') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="family" :show="$show"/>

    <x-layout.intro-para>

        <div class="flex flex-row w-full h-20">
            <div class="w-1/4">
                Membership Purchases<br/>
                &pound;{{number_format($membership_fee/100,2)}}
            </div>
            <div class="w-1/4">
                Entries <br/>
                &pound;{{number_format($entry_fee/100,2)}}
            </div>
            <div class="w-1/4">
                Payments <br/>
                &pound;{{number_format($paid,2)}}
            </div>
            <div class="w-1/4">
                Balance <br/>
                &pound;{{number_format((($entry_fee + $membership_fee)/100) - $paid,2)}}
            </div>
        </div>

        <div class="h-10">
            <a href="{{route('entries.entryCard', ['show'=>$show])}}" class="bg-green-200  p-4 rounded-xl">
                @lang('Entry Card for :show', ['show'=>$show->name])
            </a>
        </div>

        <div class="table border-4 p-4">
            <div class="table-header-group">
                <div class="table-cell p-2">@lang('Name')</div>
                <div class="table-cell p-2">@lang('Age')</div>
{{--                <div class="table-cell p-2">@lang('Manage')</div>--}}
                <div class="table-cell p-2">@lang('Team')</div>
                <div class="table-cell p-2"></div>
            </div>
            @forelse ($user['entrants'] as $entrant)

                <div class="table-row">
                    <div class="table-cell p-2 px-4 ">
                        <div class="table-cell"><h4>{{$entrant['name']}}</h4></div>
                    </div>
                    <div class="table-cell p-2 px-4 ">
                        @if ($entrant['age'])
                            @lang(':age years', ['age'=>$entrant['age']])
                        @endif
                    </div>
{{--                    <div class="table-cell p-2 px-4 ">--}}
{{--                        <a href="{{route('entrants.show', $entrant['id'])}}">Manage Entries</a>--}}
{{--                    </div>--}}

                    <div class="table-cell p-2 px-4 ">

                        @if($entrant['team'] instanceof \App\Models\Team)
                            A member of team {{$entrant['team']->name}}
                        @else
                            @if($entrant['age'])
                                Not yet a member of any team
                            @endif
                        @endif
                    </div>
                    <div class="table-cell p-2 px-4 ">
                        <a class="bg-gray-300 p-1 rounded" href="{{route('entrants.edit', $entrant['id'])}}">Edit</a>
                    </div>
                </div>

                @php
                    $entry_data = $entrant['entries'];
                    $totalFee = 0;
                @endphp
            @empty
                <div class="table-row">
                    @lang('There are no family members configured yet. You must have configured at least one
                    family member before you can add any show entries')
                </div>

            @endforelse

            <div>
                <x-button><a href="{{route('entrants.create')}}"
                             class="bg-primary-200 hover:bg-primary text-white font-bold py-2 px-4 rounded">@lang('Add another family member')</a>
                </x-button>
            </div>
        {{ Form::close() }}
    </x-layout.intro-para>
</x-app-layout>
