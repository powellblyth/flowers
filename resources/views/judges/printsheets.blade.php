{{--<link rel="stylesheet" href="{{URL::asset('css/cardPrint.css')}}"/>--}}
<style>
    td {
        border: 1px solid grey;
        padding:0;
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
        <br /><br />

        <div><big>Please enter the entrant number <b>only</b> in the relevant boxes. Commendations are optional but
                welcome especially in the junior categoeries
                <br />
                Please remember to judge any relevant cups on the final sheet
            </big>
            <br />
            <br />
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
                    <br /><small><i>{{$category->notes}}</i></small></td>
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
                <td><h4>Entrant Number</h4></td><td><div style="display:inline-block;width:100px">&nbsp;</div></td></tr>
            <tr><td><h4>Category Number</h4></td><td><div style="display:inline-block;width:100px">&nbsp;</div></td></tr>
        </table>
            <div class="width:50px;border:1px solid"></div>
            <div class="width:50px;border:1px solid"></div>
        </table>
    @endforeach
</div>
