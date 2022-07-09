{{--<link rel="stylesheet" href="{{URL::asset('css/cardPrint.css')}}"/>--}}
<style>
    table, td {
        border: 1px solid grey;
    }

    div.result {
        width: 70px;
    }

    div.result_commended {
        width: 150px;
    }

</style>
<div id="everything">
    <div>
        <h2>Judge: {{$judge->name}}, for the {{$show->name}} Petersham Horticultural Society Show</h2>
        <h4>Judging:
            @php
                $judge->judgeAtShow()->with('judgeRole')->where('show_id', $show->id)->get()->each(
                    function(\App\Models\JudgeAtShow $judgeAtShow){
                        echo $judgeAtShow->judgeRole->label .', ';
                        }
                )
            @endphp
        </h4>
        <div>Thank you for judging with us at our {{$show->name}} Show, we really appreciate your time and your
            judgements.
        </div>
        <br/><Br/>

        <div><big>Please enter the entrant number <b>only</b> in the relevant boxes. Commendations are optional but
                welcome especially in the junior categoeries
                <br/>
                Please remember to judge any relevant cups on the final sheet
            </big>
            <br/>
            <br/>
        </div>
    </div>

    <table class="pageset">
        <thead>
        <th>Category</th>
        <th>First</th>
        <th>Second</th>
        <th>Third</th>
        <th>Commended</th>
        </thead>
        @php
            $previousSection = null;
        @endphp
        @foreach ($judge->relatedCategories($show) as $category)
            @if($previousSection !== $category->section_id)
                <thead>
                <tr>
                    <td colspan="5" style="text-align:center"><h3>{{$category->section->display_name}}</h3></td>
                </tr>
                </thead>
                @php
                    $previousSection = $category->section_id;
                @endphp
            @endif
            <tr>
                <td>{{$category->numbered_name}}
                    <br/><small><i>{{$category->notes}}</i></small></td>
                <td>
                    <div class="result">&nbsp;</div>
                </td>
                <td>
                    <div class="result">&nbsp;</div>
                </td>
                <td>
                    <div class="result">&nbsp;</div>
                </td>
                <td>
                    <div class="result_commended">&nbsp;</div>
                </td>
            </tr>
        @endforeach
    </table>

    <h2>Cups</h2>

    @foreach($judge->relatedCups($show) as $cup)
        {{$cup->name}}<br/>
        <div>
            ENTRANT AND CATEGORY NUMBER
            Entrant
            <div class="width:50px;border:1px solid"></div>
            category
            <div class="width:50px;border:1px solid"></div>
        </div>
    @endforeach
    {{--            @for($x=0; $x < 2; $x++)--}}
    {{--                <tr>--}}
    {{--                    @for($q=0; $q < 2; $q++)--}}
    {{--                        @if (array_key_exists($cardcounter,$card_backs))--}}
    {{--                            <td class="entrycard">--}}
    {{--                                <div class="frontpage">--}}
    {{--                                    <div class="class_number_box">CLASS <span class="class_number">{{$card_fronts[$cardcounter]['class_number']}}</span></div>--}}
    {{--                                    <div class="entrant_number_box">--}}
    {{--                                        Entrant's No. <span class="entrant_number">{{ $card_fronts[$cardcounter]['entrant_number'] }}</span>--}}
    {{--                                        @if ($card_fronts[$cardcounter]['entrant_age'])--}}
    {{--                                        <span class="age">Age {{$card_fronts[$cardcounter]['entrant_age']}}</span>--}}
    {{--                                        @endif--}}
    {{--                                    </div>--}}

    {{--                                    <div class="prize_box"><span class="prize">&nbsp;</span> Prize</div>--}}
    {{--                                    <div class="footer_box"><span class="footer">Petersham Horticultural Society - Summer Show {{config('app.year')}} - <b>This side up for judging</b></span></div>--}}
    {{--                                </div>--}}
    {{--                            </td>--}}
    {{--                        @else--}}
    {{--                          <td><div style="width:535px" >&nbsp;</div></td>--}}

    {{--                            @endif--}}
    {{--                        @php--}}
    {{--                        $cardcounter++--}}
    {{--                        @endphp--}}
    {{--                    @endfor--}}
    {{--                </tr>--}}
    {{--            @endfor--}}
    {{--        </table>--}}

    {{--        @php--}}
    {{--            $counter = 0;--}}
    {{--            $cardcounter -= $numPerPage--}}
    {{--        @endphp--}}
    {{--        <table class="pageset">--}}

    {{--            @for($x=0; $x < 2; $x++)--}}
    {{--                <tr>--}}
    {{--                    @for($q=0; $q < 2; $q++)--}}
    {{--                        <td class="entrycard">--}}
    {{--                            @php--}}
    {{--                            if ($q == 1)--}}
    {{--                            {--}}
    {{--                                $y = $cardcounter - 1;--}}
    {{--                            } else {--}}
    {{--                                $y = $cardcounter + 1;--}}
    {{--                            }--}}
    {{--                            @endphp--}}
    {{--                            <table class="backpage--}}
    {{--                                 @if (1 == $q)--}}
    {{--                                 second--}}
    {{--                                 @endif">--}}
    {{--                            @if (array_key_exists($y,$card_backs))--}}
    {{--                                <tr>--}}
    {{--                                    <td><img class="rhs-logo" src="/images/RHS-LOGO-BW-SMALL.jpg" /></td>--}}
    {{--                                    <td>--}}
    {{--                                        <div class="society_name">Petersham Horticultural Society</div>--}}
    {{--                                        <div class="sort_letter">{{$card_backs[$y]['user_sort_letter']}}</div>--}}
    {{--                                        <div class="prize_box">&nbsp;</div>--}}
    {{--                                    </td>--}}
    {{--                                </tr>--}}
    {{--                                <tr>--}}
    {{--                                    <td colspan="2">--}}
    {{--                                            <div class="card_row class_number"><b>Class</b> {{$card_backs[$y]['class_number']}}</div>--}}
    {{--                                            <div class="card_row class_name"><b>Description</b> {{$card_backs[$y]['class_name']}}</div>--}}
    {{--                                            <div class="card_row exhibitor_name"><b>Exhibitor name</b> {{$card_backs[$y]['entrant_name']}} (Entrant #{{$card_backs[$y]['entrant_number']}})</div>--}}
    {{--                                            <div class="card_row gardener_name"><b>Gardener</b> (if any) </div><br />--}}
    {{--                                    </td>--}}
    {{--                                </tr>--}}
    {{--                                @else--}}
    {{--                                <tr><td><div style="width:535px" >&nbsp;</div></td></tr>--}}
    {{--                                @endif--}}
    {{--                            </table>--}}
    {{--                        </td>--}}
    {{--                        @php--}}
    {{--                            $cardcounter++--}}
    {{--                        @endphp--}}
    {{--                    @endfor--}}
    {{--                </tr>--}}
    {{--            @endfor--}}
    {{--        </table>--}}
    {{--    @endforeach--}}

</div>
