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
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Cups') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show :show="$show"/>

    <x-layout.intro-para>
        <p>
            These are the cups we award during the annual Flower Show and
            the winners of the {{$show->name}} show (when available).
        </p>
    </x-layout.intro-para>
    @php
        $publishMode = false;
    @endphp
    @foreach ($cups as $cup)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>{{ $cup->name . ' '. $cup->id }}</x-headers.h2>
            <div>{{$cup->winning_criteria}}</div>

            @if($show->resultsArePublic()|| Auth::user()?->isAdmin())
                @if ($cup->winning_basis === \App\Models\Cup::WINNING_BASIS_TOTAL_POINTS)
                    <table
                        class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white">
                        <!-- one for each row - required for mobile view -->
                        @for ($x=0; $x < 4; $x++)
                            <tr class="bg-indigo-500  flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
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
                                    {{$winner->entrant->printable_name}}
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    {{$winner->points}} @lang('points')
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <i>@lang('Winner'): </i>
                    @php
                        $directWinnerId = $results[$cup->id]['direct_winner']?? null;
                    @endphp
                    @if (is_object($results[$cup->id]?->entry ?? null))
                        for category
                        <i><b>{{$results[$cup->id]?->entry?->category?->numbered_name}}</b></i>
                    @endif
                @endif
            @endif
        </x-layout.intro-para>

    @endforeach
</x-app-layout>
