<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Judge Sheets for :judge for :show Petersham Horticultural Society Summer Show', ['judge' => $judge->name, 'show' => $show->name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Judge Sheets for :judge for :show PHS Summer Show', ['judge' => $judge->name, 'show' => $show->name]) }}
        </x-headers.h1>
    </x-slot>
    <x-layout.intro-para class="py-2 ">
    <div>
        <x-headers.h3>Judging:
            @php
                $judge->judgeAtShow()->with('judgeRole')->where('show_id', $show->id)->get()->each(
                    function(\App\Models\JudgeAtShow $judgeAtShow){
                        echo $judgeAtShow->judgeRole->label .', ';
                        }
                )
            @endphp
        </x-headers.h3>
        <div class="py-4 text-sm">
            Thank you for judging and stewarding with us at our {{$show->name}} PHS Summer Show, we really appreciate
            your time
            and your judgements.
        </div>
        <x-headers.h3>Judging Instructions</x-headers.h3>
        <ul class="list-disc ml-4 text-sm">
            <li> Please be sure to judge all categories and sections. Note that there may be multiple sheets in this
                clipboard
                </li>
            <li> Please leave the cards with the entrant's name face down until judging of that category is
                complete
            </li>
            <li> Choose the best three entries if you can</li>
            <li> You may decide that no entry matches any given place, i.e. you may choose to award only 1st and
                3rd, or 2nd
                    and 3rd, or 3rd only or none at all.
                </li>
                <li> Commendations are optional but welcome especially in the junior categories.</li>
                <li> Once the section is completely judged, please review the cups that are to be judged below. Note
                    that some cups are awarded on points alone, so do not need to be individually awarded
                </li>
                <li> If there is doubt as to the <b>technical</b> acceptability of an entry, please discuss with your
                    steward, and escalate to the Show Secretary if no decision can be reached
                </li>
        </ul>
        <x-headers.h3 class="pt-4">Stewards' Instructions</x-headers.h3>
        <ol class="list-disc ml-4 text-sm">
                <li> Once the category is judged, Stewards are to turn the winning cards over with the names exposed,
                    and attach the relevant sticker
                </li>
            <li> In order to record the winners, the Steward need only record the entrant's number into the box on
                this
                    sheet
                </li>
            </ol>
            <br/>
        </div>

        <div class="grid grid-cols-7 gap-0 ">
        @php
            $previousSection = null;
        @endphp
            @foreach ($relatedCategories as $category)

                {{--            </thead>--}}
            @if($previousSection !== $category->section_id)
                    @php
                        $previousSection = $category->section_id;
                    @endphp
                    <div class="col-span-7 bg-gray-200 text-bold mt-4">
                        <x-headers.h4>{{$category->section->display_name}}</x-headers.h4>
                    </div>
                    <div class="font-bold col-span-3">Category</div>
                    <div class="font-bold">First</div>
                    <div class="font-bold">Second</div>
                    <div class="font-bold">Third</div>
                    <div class="font-bold">Commended</div>
            @endif
                <div class="col-span-3 text-sm border-2">
                    {{$category->numbered_name}}
                    <br/><small><i>{{$category->notes}}</i></small>
                </div>
                <div class="result border-2 ">&nbsp;</div>
                <div class="result border-2">&nbsp;</div>
                <div class="result border-2">&nbsp;</div>
                <div class="result_commended border-2">&nbsp;</div>
        @endforeach

        </div>

        @if(count($relatedCups) > 0)
            <x-headers.h3 class="mt-4">Cups</x-headers.h3>

            @foreach($relatedCups as $cup)
                <div class="break-inside-avoid grid grid-cols-4 gap-0 w-1/2">
                    <div class="col-span-4 bg-gray-200 border-x-2 text-bold text-sm">
                        <x-headers.h4>{{$cup->name}} - {{$cup->winning_criteria}}</x-headers.h4>
                    </div>
                    <div class="col-span-3 text-sm">
                        <x-headers.h5>Entrant Number</x-headers.h5>
                    </div>
                    <div class="border-2 "></div>
                    <div class="col-span-3 text-sm">
                        <x-headers.h5>Category Number</x-headers.h5>
                    </div>
                    <div class="border-2 "></div>
                </div>
            @endforeach
        @endif
    </x-layout.intro-para>
</x-app-layout>
