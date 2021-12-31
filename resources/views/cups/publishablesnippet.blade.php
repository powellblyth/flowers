@php
    $showAddress = $showAddress && $isAdmin;
    $printableNames = !$showAddress;
@endphp
@foreach ($cups as $cup)
    @php
        $lastResult = -1;
    $maxResults = $cup->num_display_results;
    @endphp

    <h3><b>{{ $cup->name }}</b></h3>
    {{$cup->winning_criteria}}<br/>
    @if ((int)$results[$cup->id]['direct_winner'] == 0)

        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
            @php
                $totalPoints = $results[$cup->id]['results'][$x]['totalpoints'];
            @endphp
            @if(0 == $x || $lastResult == $totalPoints)
                <b>Winner:</b>
            @else
                <b>Proxime Accessit:</b>
            @endif
        ({{$results[$cup->id]['results'][$x]['totalpoints'] }} points)
            @php
                $winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
            @endphp

            <span style="font-size:18pt">{{$winners[$winningEntrantId]['entrant']->printable_name}}</span>

            <br/>
            @if ($showAddress && (0 == $x || $lastResult == $totalPoints))
                @if (!is_null($winners[$winningEntrantId]['entrant']->user))
                    @if(empty($winners[$winningEntrantId]['entrant']->user->address))
                        <table border>
                            <tr>
                                <td>PLEASE PROVIDE AN ADDRESS:</td>
                                <td style="width:220px"></td>
                            </tr>
                        </table>
                    @endif
                    {{$winners[$winningEntrantId]['entrant']->user->address}}<br/>
                    @if(empty($winners[$winningEntrantId]['entrant']->user->telephone))
                        <table border>
                            <tr>
                                <td>PLEASE PROVIDE PHONE NUMBER:</td>
                                <td style="width:220px"></td>
                            </tr>
                        </table>
                    @endif
                    {{$winners[$winningEntrantId]['entrant']->user->telephone}}
                    @if(empty($winners[$winningEntrantId]['entrant']->user->email))
                        <table border>
                            <tr>
                                <td>PLEASE PROVIDE EMAIL:</td>
                                <td style="width:220px"></td>
                            </tr>
                        </table>
                    @endif
                    , {{$winners[$winningEntrantId]['entrant']->user->email}}
                @endif
            @endif
            @php
                // If we have a matching point then add one to the iterator
                if ($lastResult == $totalPoints)
                {
                    $maxResults++;
                }
                //reset the last result counter
                $lastResult = $totalPoints;

            @endphp
        @endfor
    @else
        <i>Winner:</i>
        @php
            $directWinnerId = $results[$cup->id]['direct_winner'];
        @endphp
        <big><b>{{$winners[$directWinnerId]['entrant']->printable_name}}</b></big>
        @if (is_object($results[$cup->id]['winning_category']))
            for category
            <i><b>{{$results[$cup->id]['winning_category']->numbered_name}}</b></i>
            @endif
            @endif
            </p>
            <hr/>
            @endforeach
