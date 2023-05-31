<x-app-layout>
    <x-slot name="canonical">{{route('show.raffle', [$show]) }}</x-slot>
    <x-slot name="pageTitle">
        {{ __('Raffle Prizes') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Raffle Prizes') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="show.raffle" :show="$show"/>

    <x-layout.intro-para>
        <p>
            @lang('We are so grateful to our wonderful donors for providing our show with these wonderful raffle prizes.
            You can visit our friends by following the links, and contact using the phone numbers where appropriate')

        </p>
    </x-layout.intro-para>
    @foreach ($donors as $donor)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>{{ $donor->name }}</x-headers.h2>
            @if($donor->website)
                <p><a href="{{$donor->website}}?utm_source=phs&utm_campaign=raffle&utm_value={{urlencode($show->name)}}">{{$donor->website}}</a>
                </p>
                    @endif
            <p>{{$donor->description}}</p>
            @if($donor->telephone)
                <p>You can call <b>{{$donor->name}}</b> on <a href="tel:{{str_replace(' ', '', $donor->telephone)}}">{{$donor->telephone}}</p>
            @endif
            <x-headers.h3>Prize offered for the {{$show->name}} show</x-headers.h3>

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
