{{--<link rel="stylesheet" href="{{URL::asset('css/cardPrint.css')}}"/>--}}
<style>
    td {
        border: 1px solid grey;
        padding: 0;
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
        <div>Thank you for judging and stewarding with us at our {{$show->name}} Show, we really appreciate your time and your
            judgements.
        </div>
        <br/><br/>

        <div>
            <h4>Judging Instructions</h4>
            <ol>
                <li> Please leave the cards with the entrant's name face down until judging of that category is
                    complete
                </li>
                <li> Choose the best three entries</li>
                <li> You may decide that no entry matches any given place, i.e. you may only award 1st and 3rd, or 2nd
                    and 3rd, or 3rd only or none at all.
                </li>
                <li> Commendations are optional but welcome especially in the junior categories.</li>
                <li> Once the section is completely judged, please review the cups that are to be judged below. Note
                    that some cups are awarded on points alone, so do not need to be individually awarded
                </li>
                <li> If there is doubt as to the <b>technical</b> acceptability of an entry, please discuss with your
                    steward, and escalate to the Show Secretary if no decision can be reached
                </li>
            </ol>
            <h4>Stewards' Instructions</h4>
            <ol>
                <li> Once the category is judged, Stewards are to turn the winning cards over with the names exposed,
                    and attach the relevant sticker
                </li>
                <li> In order to record the winners, the Steward need only record the entrant's number into the box on this
                    sheet
                </li>
            </ol>

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
        <h4>{{$cup->name}}</h4>
        {{$cup->winning_criteria}}
        <table>
            <tr>
                <td><h4>Entrant Number</h4></td>
                <td>
                    <div style="display:inline-block;width:100px">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td><h4>Category Number</h4></td>
                <td>
                    <div style="display:inline-block;width:100px">&nbsp;</div>
                </td>
            </tr>
        </table>
        <div class="width:50px;border:1px solid"></div>
        <div class="width:50px;border:1px solid"></div>
        </table>
    @endforeach
</div>
