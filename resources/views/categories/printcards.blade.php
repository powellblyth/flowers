<link rel="stylesheet" href="{{URL::asset('css/categoryCardPrint.css')}}"/>
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
                        @if(array_key_exists($cardcounter, $card_fronts))
                        <td class="entrycard">
                            <div class="frontpage">
                                <div class="strap_line">Petersham Horticultural Society {{(int)env('CURRENT_YEAR') - 1906}}th Show {{env('CURRENT_YEAR')}}</div>
                                <div class="class_number"><span class="class_number">{{$card_fronts[$cardcounter]['class_number']}}</span></div>
                                <div class="class_name">
                                    <span class="class_name">{{ $card_fronts[$cardcounter]['class_name'] }}</span>
                                </div>

                            </div>
                        </td>
@endif
                        @php
                        $cardcounter++
                        @endphp
                    @endfor
                </tr>
            @endfor
        </table>

    @endfor

</div>
