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
        <p>These are the cups we award during the annual Flower Show and
            the winners of the {{$show->name}} show (when available).</p>
    </x-layout.intro-para>
    @php
        $publishMode = false;
    @endphp
    @foreach ($cups as $cup)
        <x-layout.intro-para class="py-2">
            @php
                $lastResult = -1;
                $maxResults = $cup->num_display_results;
            @endphp
            <x-headers.h2>{{ $cup->name }}</x-headers.h2>
            <div>{{$cup->winning_criteria}}</div>

            @if(Auth::user()?->isAdmin())
                @if ($cup->winning_basis === \App\Models\Cup::WINNING_BASIS_TOTAL_POINTS)
                    <table
                        class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white">
                        <!-- one for each row - required for mobile view -->
                        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
                            <tr class="bg-indigo-500  flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">Position</th>
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Address</th>
                                <th class="p-3 text-left">Phone</th>
                                <th class="p-3 text-left">Email</th>
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
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    {{$winners[$winningEntrantId]['entrant']->full_name}}
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if(0 == $x || $lastResult === $totalPoints)
                                        {{$winners[$winningEntrantId]['entrant']->user->address}}
                                        @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if(0 == $x || $lastResult === $totalPoints)
                                    {{$winners[$winningEntrantId]['entrant']->user->telephone}}
                                        @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if(0 == $x || $lastResult === $totalPoints)
                                        {{$winners[$winningEntrantId]['entrant']->user->email}}
                                        @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    {{$results[$cup->id]['results'][$x]['totalpoints'] }} points
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>

                @else
                    <i>@lang('Winner'):</i>
                    @php
                        $directWinnerId = $results[$cup->id]['direct_winner']?? null;
                    @endphp
                    @if(array_key_exists($directWinnerId, $winners))
                        @if (  $isAdmin)
                            <b>
                                <a href="{{route('entrants.show', ['entrant'=>$winners[$directWinnerId]['entrant']])}}">{{$winners[$directWinnerId]['entrant']->full_name}}</a>
                                <br />
                                {{$winners[$winningEntrantId]['entrant']->user->address}}<br />
                                {{$winners[$winningEntrantId]['entrant']->user->telephone}}<br />
                                {{$winners[$winningEntrantId]['entrant']->user->email}}<br />

                            </b>
                        @else
                            <big><b>{{$winners[$directWinnerId]['entrant']->printable_name}}</b></big>
                        @endif
                    @endif
                    @if (is_object($results[$cup->id]['winning_category'] ?? null))
                        for category
                        <i><b>{{$results[$cup->id]['winning_category']->numbered_name}}</b></i>
                    @endif
                @endif
            @endif
        </x-layout.intro-para>

    @endforeach
</x-app-layout>
