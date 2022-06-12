<x-app-layout>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Dashboard') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <h1 class="siz">Welcome, {{Auth::User()->first_name}}</h1>
        <p>This is the <a href="http://www.petershamhorticulturalsociety.org.uk" target="_blank">Petersham
                Horticultural Society</a>'s system for self-registering membership and entries to the
            show. Your user account allows you to manage Show Entrants, who are people you
            have the authority to speak for (normally Children, Husband, Wife, Life-Partner etc. etc.
        </p>
        <p>There's no real limit to the number of entrants you can represent, but remember, only
            one entrant can win any given cup, points are not aggregated to your user account.
        </p>
        <p>Getting Started - Simply go to "My Family" in the top menu and create your own
            personal details, then begin to create the rest of your clan</p>
        <p>Once you have created them all, you can create Entries (i.e. choose which categories you
            would like to enter) for <em><b>each</b></em> entrant.</p>
        <p>Once you have finished, simply bring a cheque or cash to the show to receive your entry
            cards, which will be printed in advance</p>
    </x-layout.intro-para>

</x-app-layout>
