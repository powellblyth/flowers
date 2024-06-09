<x-app-layout>
    <x-slot name="pageTitle">
        {{ __( $cup->name . ' cup in ' . $show->name) }}
    </x-slot>
    <x-slot name="canonical">{{route('cups.show', ['show' => $show, 'cup' => $cup]) }}</x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __($cup->name . ' ' . $show->name) }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <div class="flex">
            @if($cup->image)
                <div class="flex-initial pr-4 ">
                    <img src="/images/cups/{{$cup->image}}" class="max-w-200"
                         alt="Image of {{$cup->name}}"
                         title="Image of {{$cup->name}}"/>
                </div>
            @endif

            <ul class="flex-1">
            <li><b>@lang('Show')</b>: {{ $show->name }}</li>
            <li><b>@lang('Name')</b>: {{ $cup->name }}</li>
            <li><b>@lang('Criteria')</b>: {{ $cup->winning_criteria }}
                <i>{{ $cup->getSectionsOrCategoriesDescription($show) }}</i></li>
            @if($cup->prize_description)
                <li><b>Prize</b>: {{$cup->prize_description}}</li>
            @endif
                <li><b>Judges for {{$show->name}}</b>: {{ $cup->getJudgesDescriptionForThisShow($show)  }}</li>
        </ul>
        </div>
    </x-layout.intro-para>
    <x-layout.intro-para>
        <b>
            @if ($cup->is_points_based)
                @lang('For the most points in ')
            @else
                @lang('The Judge\'s choice from ')
            @endif
            {{(count($categories) > 1 ? 'these categories': 'this category') }}</b><br/>

        @foreach ($categories as $category)
            <p>{{$category->numbered_name}} <small>{{$category->notes}}</small></p>
        @endforeach

        @can('storeResults', $show)
            @if($cup->is_points_based)
                @foreach ($cup->getWinnersForShow($show)->winners()  as $winner)
                    {{$winner->full_name}}
                @endforeach
            @else
                <livewire:cup-winner-chooser
                    :cup="$cup"
                    :categories="$categories->pluck('numbered_name', 'id')"
                    :show="$show"
                ></livewire:cup-winner-chooser>
            @endif
        @endcan

    </x-layout.intro-para>
</x-app-layout>

