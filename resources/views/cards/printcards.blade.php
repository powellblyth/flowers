<link rel="stylesheet" href="{{URL::asset('css/cardPrint.css')}}"/>
<div id="everything">
    @php
    $numPerPage = 4;

    $cardcounter = 0;
    $totalEntries = count($card_fronts);
    $pagesComplete = 0;
    $pagesRequired = ceil(count($card_fronts)/$numPerPage);

    @endphp
    @for ($pageCounter = 0; $pageCounter < $pagesRequired; $pageCounter++)
        <table class="pageset">
            @for($x=0; $x < 2; $x++)
                <tr>
                    @for($q=0; $q < 2; $q++)
                        @if (array_key_exists($cardcounter,$card_backs))
                            <td class="entrycard">
                                <div class="frontpage">
                                    <div class="class_number_box">CLASS <span class="class_number">{{$card_fronts[$cardcounter]['class_number']}}</span></div>
                                    <div class="entrant_number_box">
                                        Entrant's No. <span class="entrant_number">{{ $card_fronts[$cardcounter]['entrant_number'] }}</span>
                                        @if ($card_fronts[$cardcounter]['entrant_age'])
                                        <span class="age">Age {{$card_fronts[$cardcounter]['entrant_age']}}</span>
                                        @endif
                                    </div>

                                    <div class="prize_box"><span class="prize">&nbsp;</span> Prize</div>
                                    <div class="footer_box"><span class="footer">Petersham Horticultural Society - Summer Show {{config('app.year')}} - <b>This side up for judging</b></span></div>
                                </div>
                            </td>
                        @else
                          <td><div style="width:535px" >&nbsp;</div></td>

                            @endif
                        @php
                        $cardcounter++
                        @endphp
                    @endfor
                </tr>
            @endfor
        </table>

        @php
            $counter = 0;
            $cardcounter -= $numPerPage
        @endphp
        <table class="pageset">

            @for($x=0; $x < 2; $x++)
                <tr>
                    @for($q=0; $q < 2; $q++)
                        <td class="entrycard">
                            @php
                            if ($q == 1)
                            {
                                $y = $cardcounter - 1;
                            } else {
                                $y = $cardcounter + 1;
                            }
                            @endphp
                            <table class="backpage
                                 @if (1 == $q)
                                 second
                                 @endif">
                            @if (array_key_exists($y,$card_backs))
                                <tr>
                                    <td><img class="rhs-logo" src="/images/RHS-LOGO-BW-SMALL.jpg" /></td>
                                    <td>
                                        <div class="society_name">Petersham Horticultural Society</div>
                                        <div class="sort_letter">{{$card_backs[$y]['user_sort_letter']}}</div>
                                        <div class="prize_box">&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                            <div class="card_row class_number"><b>Class</b> {{$card_backs[$y]['class_number']}}</div>
                                            <div class="card_row class_name"><b>Description</b> {{$card_backs[$y]['class_name']}}</div>
                                            <div class="card_row exhibitor_name"><b>Exhibitor name</b> {{$card_backs[$y]['entrant_name']}} (Entrant #{{$card_backs[$y]['entrant_number']}})</div>
                                            <div class="card_row gardener_name"><b>Gardener</b> (if any) </div><br />
                                    </td>
                                </tr>
                                @else
                                <tr><td><div style="width:535px" >&nbsp;</div></td></tr>
                                @endif
                            </table>
                        </td>
                        @php
                            $cardcounter++
                        @endphp
                    @endfor
                </tr>
            @endfor
        </table>
    @endfor

</div>
