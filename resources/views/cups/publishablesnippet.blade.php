@php
    $showAddress = $showAddress && $isAdmin;
    $printableNames = !$showAddress;
@endphp
@foreach ($cups as $cup)
    @php
        if ($cup->id == 13)
        {
            $maxResults = 4;
        }
        else
        {
            $maxResults = 2;
        }

        $lastResult = -1;
    @endphp

    <span style="font-size:18pt">{{ $cup->name }}</span><br/>
    {{$cup->winning_criteria}}<br/>
    @if ((int)$results[$cup->id]['direct_winner'] == 0)

        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
            @php
                $totalPoints = $results[$cup->id]['results'][$x]['totalpoints'];
            @endphp
            @if(0 == $x || $lastResult == $totalPoints)
                <b>Winner:</b>
            @else
                <br/><b>Proxime Accessit:</b>
            @endif
        ({{$results[$cup->id]['results'][$x]['totalpoints'] }} points)
            @php
                $winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
            @endphp

            <span style="font-size:18pt">{{$winners[$winningEntrantId]['entrant']->getName($printableNames)}}</span>

            <br/>
            @if ($showAddress && (0 == $x || $lastResult == $totalPoints))
                @if (!is_null($winners[$winningEntrantId]['entrant']->user))
                    @if(empty($winners[$winningEntrantId]['entrant']->user->getAddress()))
                        <table border>
                            <tr>
                                <td>PLEASE PROVIDE ADDRESS:</td>
                                <td style="width:220px"></td>
                            </tr>
                        </table>
                    @endif
                    {{$winners[$winningEntrantId]['entrant']->user->getAddress()}}<br/>
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
        <big><b>{{$winners[$directWinnerId]['entrant']->getName($printableNames)}}</b></big>
        @if (is_object($results[$cup->id]['winning_category']))
            for category
            <i><b>{{$results[$cup->id]['winning_category']->getNumberedLabel()}}</b></i>
            @endif
            @endif
            </p>
            <hr/>
            @endforeach