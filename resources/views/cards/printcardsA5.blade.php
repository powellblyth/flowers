<link rel="stylesheet" href="{{URL::asset('css/cardPrintA5.css')}}"/>
<div id="everything">
    @php

    $cardCounter = 0;
    $totalEntries = count($card_fronts);

    @endphp
    @for ($pageCounter = 0; $pageCounter < $totalEntries; $pageCounter++)
        <table class="pageset">
            <tr>
                <td class="entrycard">
                    <div class="frontpage">
                        <div class="class_number_box">CLASS <span class="class_number">{{$card_fronts[$cardCounter]['class_number']}}</span></div>
                        <div class="entrant_number_box">
                            Entrant's No. <span class="entrant_number">{{ $card_fronts[$cardCounter]['entrant_number'] }}</span>
                            @if ($card_fronts[$cardCounter]['entrant_age'])
                            <span class="age">Age {{$card_fronts[$cardCounter]['entrant_age']}}</span>
                            @endif
                        </div>

                        <div class="prize_box"><span class="prize">&nbsp;</span> Prize</div>
                        <div class="footer_box">
                            <span class="footer">
                                Petersham Horticultural Society - Summer Show {{$show->name}} - <b>This side up for judging</b>
                            </span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="foldLine">
                        Fold here for judging and <span class="arrow">&darr;</span> hide this side
                        <span class="arrow">&darr;</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="entrycard">
                    <table class="backpage">
                        @if (array_key_exists($cardCounter,$card_backs))
                            <tr>
                                <td><img class="rhs-logo" src="/images/RHS-LOGO-BW-SMALL.jpg" /></td>
                                <td>
                                    <div class="society_name">Petersham Horticultural Society</div>
                                    <div class="prize_box">Affix Prize Sticker Here (if
                                        applicable)
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="card_row class_number"><b>Class</b> {{$card_backs[$cardCounter]['class_number']}}</div>
                                    <div class="card_row class_name"><b>Description</b> {{$card_backs[$cardCounter]['class_name']}}</div>
                                    <div class="card_row exhibitor_name"><b>Exhibitor name</b> {{$card_backs[$cardCounter]['entrant_name']}}
                                        (Entrant #{{$card_backs[$cardCounter]['entrant_number']}})</div>
                                    <div class="card_row gardener_name"><b>Gardener</b> (if any) </div><br />
                                </td>
                            </tr>
                        @else
                            <tr><td><div style="width:535px">&nbsp;</div></td></tr>
                        @endif
                    </table>
                </td>
            </tr>
            @php
                $cardCounter++
            @endphp
        @endfor
    </table>
</div>
