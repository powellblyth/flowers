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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cups') }}
        </h2>
    </x-slot>
    <x-navigation.show :show="$show"/>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>These are the cups we award during the annual Flower Show and
                        the winners of the {{$show->name}} show (when available).</p>
                </div>
            </div>
        </div>
    </div>
    @php
        $publishMode = false;
        $showaddress = $isAdmin;
        $printableNames = !$isAdmin;
        $shortName = false;
    @endphp
    @foreach ($cups as $cup)
        {{--    <div class="py-12">--}}
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @php
                        $lastResult = -1;
                        $maxResults = $cup->num_display_results;
                    @endphp
                    <div class="rounded-l-lg  title text-xl font-medium">{{ $cup->name }}</div>
                    <div>{{$cup->winning_criteria}}</div>

                    @if ((int)$results[$cup->id]['direct_winner'] == 0)
                    <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white">
                        <!-- one for each row - required for mobile view -->
                        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
                        <tr class="bg-indigo-500  flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                            <th class="p-3 text-left">Position</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left" width="110px">Points</th>
                        </tr>
                        @endfor
                        </thead>
                        <tbody class="flex-1 sm:flex-none">
                        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
                            @php
                                $totalPoints = $results[$cup->id]['results'][$x]['totalpoints'];
                                $winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
                            @endphp
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                            <td class="border-grey-light border hover:bg-gray-100 p-3">
                                @if(0 == $x || $lastResult === $totalPoints)
                                    @lang('Winner')
                                @else
                                    @lang('Proxime Accessit')
                                @endif

                            </td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{$winners[$winningEntrantId]['entrant']->getName(true)}}</td>
                            <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{$results[$cup->id]['results'][$x]['totalpoints'] }} points</td>
                        </tr>
                            @php
                                // If we have a matching point then add one to the iterator
                                //if ($lastResult == $totalPoints)
                                //{
                                //    $maxResults++;
                                //}
                                //reset the last result counter
                                //$lastResult = $totalPoints;
                            @endphp
                        @endfor
                        </tbody>
                    </table>

                    @else
                        <i>Winner:</i>
                        @php
                            $directWinnerId = $results[$cup->id]['direct_winner'];
                        @endphp
                        @if ( ! $publishMode && $isAdmin)
                            <b>
                                <a href="{{route('entrants.show', ['entrant'=>$winners[$directWinnerId]['entrant']])}}">{{$winners[$directWinnerId]['entrant']->getName($printableNames)}}</a>
                                @if ($showaddress && (0 == $x || $lastResult == $totalPoints))
                                    {{$winners[$directWinnerId]['entrant']->user->getAddress()}}
                                    <br/>
                                    {{$winners[$directWinnerId]['entrant']->user->telephone}}
                                    , {{$winners[$directWinnerId]['entrant']->user->email}}
                                @endif
                            </b>
                        @elseif(array_key_exists($directWinnerId, $winners))
                            <big><b>{{$winners[$directWinnerId]['entrant']->getName($printableNames)}}</b></big>
                        @endif
                        @if (is_object($results[$cup->id]['winning_category']))
                            for category
                            <i><b>{{$results[$cup->id]['winning_category']->getNumberedLabel()}}</b></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{--    </div>--}}
    @endforeach
</x-app-layout>
