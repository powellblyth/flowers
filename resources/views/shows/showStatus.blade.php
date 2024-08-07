<x-app-layout>

    <x-slot name="pageTitle">
        {{ __('Show Status for the '  . $show->name . ' show') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Show Status for the '  . $show->name . ' show')}}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="shows.status" :show="$show"/>

    <x-layout.intro-para>
        <p>
            Check the show data status to see if anything needs fixed
        </p>
        @if(!$show->isCurrent())
            <p class="text-red-500 font-bold">Note that the validation for PAST shows may note reflect the current validation rules.</p>
        @endif
    </x-layout.intro-para>


    @foreach ($show->sections()->inOrder()->get() as $section)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>
                @lang('Section') {{$section->display_name}}
            </x-headers.h2>

            @foreach ($show->categories()->with(['judgeRoles','section','section.judgeRole', 'entries', 'entries.entrant'])->forSection($section)->get()->sortBy('sortorder') as $category)
                <div>
                    {{$category->numbered_name}}
                    <x-goodbad :success="$category->isPriceCorrect()">Price: {{$category->price}}</x-goodbad>
                    <x-goodbad :success="$category->isLatePriceCorrect()">Late
                        Price: {{$category->late_price}}</x-goodbad>
                    <x-goodbad :success="$category->judgeRoles?->first() || $category->section?->judgeRole">
                        Judge: {{$category->judgeRoles->first()->label ??$category->section->judgeRole?->label }}</x-goodbad>
                </div>

                @endforeach
        </x-layout.intro-para>
    @endforeach

    @foreach (\App\Models\Cup::with(['section'])->inOrder()->get() as $cup)
        <x-layout.intro-para class="py-2">
            <div>{{ $cup->name }}[{{$cup->id}}]<br />
                {{\App\Models\Cup::getWinningBasisOptions()[$cup->winning_basis]}}<br/>
                {{$cup->winning_criteria}}<br/>
                @if($cup->winning_basis == \App\Models\Cup::WINNING_BASIS_JUDGES_CHOICE  )
                    @php $judges = $cup->getJudgesForThisShow($show)->pluck('name')->toArray();
                    @endphp
                    <x-goodbad
                        :success="count($judges) > 0">
                        <b>Judges:</b> {{implode(', ' , $judges)}}
                    </x-goodbad>
                @endif
            </div>

            @php
                $sections = $cup->sections()->withPivotValue('show_id', $show->id)->inOrder()->get();
            @endphp

            <div class="my-2">
            <x-goodbad
                :success="$cup->categories()->forShow($show)->count() > 0 || $sections->count() > 0">
                {{$cup->categories()->forShow($show)->count() }}
                {{Str::plural('category', $cup->categories()->forShow($show)->count())}}
                , {{count($sections) . ' ' . Str::plural('section', $sections->count())}}
            </x-goodbad>
            </div>
            @foreach ($cup->categories()->forShow($show)->inOrder()->get() as $category)
                {{$category->numbered_name}}<br />
            @endforeach
            @foreach ($sections as $section)
                {{$section->display_name}}<br/>
            @endforeach
            @if($cup->section?->categories()->forShow($show)->count() > 0)
                <x-goodbad
                    :success="$cup->categories()->forShow($show)->count() > 0 || $cup->section?->categories()->forShow($show)->count() > 0">
                    {{$cup->section?->categories()->forShow($show)->count()}} categories through
                    section {{$cup->section->name}}
                </x-goodbad>
            @endif

        </x-layout.intro-para>

    @endforeach
</x-app-layout>
