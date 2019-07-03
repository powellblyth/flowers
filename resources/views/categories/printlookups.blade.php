<link rel="stylesheet" href="{{URL::asset('css/categoryCardLookups.css')}}"/>
<div id="everything">
    @php

    $lastSection = null;
    @endphp
    @foreach ($card_fronts as $card_front)
        @if ($lastSection != $card_front['section'])
            @if($lastSection !== null)
            </div>
                @endif
           <div class="section"> <span class="section_name">{{$card_front['section_name']}}</span>
            @php
            $lastSection = $card_front['section']
            @endphp
            @endif
                <p><span class="class_number">{{$card_front['class_number']}}</span>

                    <span class="class_name">{{ $card_front['class_name'] }}</span></p>


    @endforeach
           </div>

</div>
