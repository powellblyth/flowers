<x-app-layout>
    <x-slot name="canonical">{{route('show.raffle', [$show]) }}</x-slot>
    <x-slot name="pageTitle">
        {{ __('Raffle Prizes for the :show show', ['show'=>$show->name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Raffle Prizes for the :show show', ['show'=>$show->name]) }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="show.raffle" :show="$show"/>

    <x-layout.intro-para>
        <p>
            @lang('We are so grateful to our wonderful donors for providing our :show show with these wonderful raffle prizes.
            You can visit our friends by following the links, and contact using the phone numbers where appropriate', ['show' => $show->name])

        </p>
    </x-layout.intro-para>
    @foreach ($donors as $donor)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>{{ $donor->name }}</x-headers.h2>
            <p>{{$donor->description}}</p>
            @if($donor->website)
                <p>
                    <a href="{{$donor->website}}?utm_source=phs&amp;utm_campaign=raffle&amp;utm_value={{urlencode($show->name)}}">
                        {{$donor->website}}
                    </a>
                </p>
            @endif
            @if($donor->telephone)
                <p>You can call <b>{{$donor->name}}</b> on <a
                        href="tel:{{str_replace(' ', '', $donor->telephone)}}">{{$donor->telephone}}</p>
            @endif

            <x-headers.h3>
                {{ __('Prize offered for the :show show', ['show'=>$show->name]) }}
            </x-headers.h3>

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
