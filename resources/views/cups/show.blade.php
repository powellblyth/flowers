<x-app-layout>
    <x-slot name="pageTitle">
        {{ __( $cup->name . ' cup in ' . $show->name) }}
    </x-slot>
    <x-slot name="canonical">{{route('cups.show', [$show]) }}</x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Cup ' . $cup->name . ' ' . $show->name) }}
        </x-headers.h1>
    </x-slot>
    {{--    <x-navigation.show route="cups.show" :show="$show" />--}}

    <x-layout.intro-para>
        {{--        <p>--}}
        {{--            These are the cups we award during the annual Flower Show and--}}
        {{--            the winners of the {{$show->name}} Show (when available).--}}
        {{--        </p>--}}
        <ul>
            <li>@lang('Name'): {{ $cup->name }}</li>
            <li>@lang('Show'): {{ $show->name }}</li>
            <li>@lang('Criteria'): {{ $cup->winning_criteria }}</li>
        </ul>
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


    </x-layout.intro-para>
</x-app-layout>

