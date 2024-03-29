<x-app-layout>

    <style>
        html,
        body {
            height: 100%;
        }

        @media (min-width: 640px) {
            table {
                display: inline-table !important;
            }

            thead tr:not(:first-child) {
                display: none;
            }
        }

        td:not(:last-child) {
            border-bottom: 0;
        }

        th:not(:last-child) {
            border-bottom: 2px solid rgba(0, 0, 0, .1);
        }
    </style>
    <x-slot name="pageTitle">
        {{ __('Cups for our ' . $show->name.' show') }}
    </x-slot>
    <x-slot name="canonical">{{route('show.cups', [$show]) }}</x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Cups for our ' . $show->name.' show') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show :show="$show" route="show.cups"/>

    <x-layout.intro-para>
        <p>
            These are the cups we award during the annual Flower Show and
            the winners of the {{$show->name}} Show (when available).
        </p>
    </x-layout.intro-para>
    @php
        $publishMode = false;
    @endphp
    @foreach ($cups as $cup)
        <x-layout.intro-para class="py-2">
            <x-headers.h2><a name="cup_{{$cup->id}}">{{ $cup->name }}</a> <x-button><a href="{{ route('cups.show', ['cup'=>$cup, 'show'=>$show]) }}">Details</x-button></x-headers.h2></a>
            <div>{{ $cup->winning_criteria }}</div>
            <div>{{ $cup->getJudgesForThisShow($show, 'Judge: ')  }}</div>

            @if($show->resultsArePublic() || Auth::user()?->isAdmin())
                @if ($cup->is_points_based)
                    <table
                        class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white">
                        <!-- one for each row - required for mobile view -->
                        @for ($x=0; $x < 4; $x++)
                            <tr class="bg-indigo-500 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">@lang('Position')</th>
                                <th class="p-3 text-left">@lang('Name')</th>
                                <th class="p-3 text-left" width="110px">@lang('Points')</th>
                            </tr>
                        @endfor
                        </thead>
                        <tbody class="flex-1 sm:flex-none">
                        @php
                            $winnerPoints = null;
                        @endphp
                        @foreach($results[$cup->id]->winners as $winner)
                            <tr>
                                <td class="border-grey-light border hover:bg-gray-100 p-3">
                                    @if (!$winnerPoints || $winner->points === $winnerPoints)
                                        @lang('Winner')
                                        @php
                                            $winnerPoints = $winner->points;
                                        @endphp
                                    @else
                                        @lang('Proxime Accessit')
                                    @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if(Auth::user() && Auth::user()->isAdmin())
                                        {{ $winner->entrant->full_name }}
                                        @if (!$winnerPoints || $winner->points === $winnerPoints)
                                            <br />
                                            {{ $winner->entrant->user?->address }}<br />
                                            {{ $winner->entrant->user?->email }}<br />
                                            {{ $winner->entrant->user?->telephone }}
                                        @endif
                                    @else
                                        {{$winner->entrant->printable_name}}
                                    @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    {{$winner->points}} @lang('points')
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <i>@lang('Winner'): </i>

                @if (Auth::user() && Auth::user()->isAdmin())
                    {{ $results[$cup->id]->cupWinner?->full_name}}
                        <br />
                    {{ $results[$cup->id]->cupWinner?->user?->address }}<br />
                    {{ $results[$cup->id]->cupWinner?->user?->email }}<br />
                    {{ $results[$cup->id]->cupWinner?->user?->telephone }}

                    @else
                    {{ $results[$cup->id]->cupWinner?->printable_name }}
                    @endif
                    @if (is_object($results[$cup->id]?->entry ?? null))
                        for category
                        <i><b>{{$results[$cup->id]?->entry?->category?->numbered_name}}</b></i>
                    @endif
                @endif
            @endif
        </x-layout.intro-para>

    @endforeach
</x-app-layout>
