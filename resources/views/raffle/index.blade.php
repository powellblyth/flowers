<x-app-layout>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Raffle Prizes') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="raffle.index" :show="$show"/>

    <x-layout.intro-para>
        <p>
            @lang('We are so grateful to our wonderful donors for providing our show with these wonderful raffle prizes.
            You can visit our friends by following the links, and contact using the phone numbers where appropriate')

        </p>
    </x-layout.intro-para>
    @foreach ($donors as $donor)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>{{ $donor->name }}</x-headers.h2>
            <p>{{$donor->description}}</p>
            @if($donor->website)
                <p>You can visit the website of <b>{{$donor->name}}</b> at <a href="{{$donor->website}}?utm_source=phs&utm_campaign=raffle&utm_value={{$show->name}}">{{$donor->website}}</p>
            @endif
            @if($donor->telephone)
                <p>You can call <b>{{$donor->name}}</b> on <a href="tel:{{str_replace(' ', '', $donor->telephone)}}">{{$donor->telephone}}</p>
            @endif
            <x-headers.h3>Prizes offered for the {{$show->name}} show</x-headers.h3>

        @foreach (
                $donor->rafflePrizes()
                ->forShow($show)
                ->isActive()
                ->get() as $prize
                )
                <x-headers.h4>{{$prize->name}}</x-headers.h4>
                <p>{{$prize->description}}</p>
            @endforeach
        </x-layout.intro-para>

    @endforeach
</x-app-layout>
