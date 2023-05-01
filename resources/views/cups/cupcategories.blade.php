<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Categories allocated to cups') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Categories allocated to cups') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show :show="$show"/>

    <x-layout.intro-para>
        <p>Categories associated with cups for {{$show->name}} show.</p>
    </x-layout.intro-para>
    @foreach ($cups as $cup)
        <x-layout.intro-para class="py-2">
            @php
                $lastResult = -1;
                $maxResults = $cup->num_display_results;
            @endphp
            <x-headers.h2>{{ $cup->name }}</x-headers.h2>
            <div>{{$cup->winning_criteria}}</div>

            <div>
            @foreach ($cup->relatedCategories($show) as $category)
                {{$category->numbered_name}}<br />
            @endforeach
            </div>

            @if($show->resultsArePublic() || Auth::user()?->isAdmin())
            @endif
        </x-layout.intro-para>

    @endforeach
</x-app-layout>
