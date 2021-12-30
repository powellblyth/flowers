<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Family') }}
        </h2>
    </x-slot>
    <x-navigation.show route="family" :show="$show"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-wrap overflow-hidden">

                        <div class="w-full overflow-hidden sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/4">
                            Membership Purchases<br/>
                            &pound;{{number_format($membership_fee/100,2)}}
                        </div>

                        <div class="w-full overflow-hidden sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/4">
                            Entries <br/>
                            &pound;{{number_format($entry_fee/100,2)}}
                        </div>

                        <div class="w-full overflow-hidden sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/4">
                            Payments <br/>
                            &pound;{{number_format($paid,2)}}
                        </div>
                        <div class="w-full overflow-hidden sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/4">
                            Balance <br/>
                            &pound;{{number_format((($entry_fee + $membership_fee)/100) - $paid,2)}}
                        </div>

                    </div>


                </div>
                <div class="w-full h-20">
                    <a href="{{route('entries.entryCard', ['show'=>$show])}}" class="bg-green-200 12m-4 p-4 rounded-xl">@lang('Our Entry Card for :show', ['show'=>$show->name])</a>
                </div>

                <div class="table border-4 p-4">
                    <div class="table-header-group">
                        <div class="table-cell p-2">Name</div>
                        <div class="table-cell p-2">Age</div>
                        <div class="table-cell p-2">Manage</div>
                        <div class="table-cell p-2">Team</div>
                        <div class="table-cell p-2"></div>
                    </div>
                    @forelse ($user['entrants'] as $entrant)

                        <div class="table-row">
                            <div class="table-cell p-2 px-4 " >
                                <div class="table-cell"><h4>{{$entrant['name']}}</h4></div>
                            </div>
                            <div class="table-cell p-2 px-4 ">
                                @if ($entrant['age'])
                                    {{$entrant['age']}} years
                                @endif
                            </div>
                            <div class="table-cell p-2 px-4 ">
                                <a href="{{route('entrants.show', $entrant['id'])}}">Manage Entries</a>
                            </div>

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
                        There are no family members configured yet. You must have configured at least one
                            family member before you can add any show entries
                        </div>

                    @endforelse

                    <div>
                        <a href="{{route('entrants.create')}}"
                           class="bg-primary-200 hover:bg-primary text-white font-bold py-2 px-4 rounded">@lang('Add another family member')</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
</x-app-layout>>
