<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                      <h1 class="siz">Welcome, {{Auth::User()->firstname}}</h1>
                        <p>This is the <a href="http://www.petershamhorticulturalsociety.org.uk" target="_blank">Petersham
                            Horticultural Society</a>'s system for self-registering membership and entries to the
                        show. Your user account allows you to manage Show Entrants, who are people you
                         have the authority to speak for (normally Children, Husband, Wife, Life-Partner etc. etc.
                    </p>
                     <p>There's no real limit to the number of entrants you can represent, but remember, only
                        one entrant can win any given cup, points are not aggregated to your user account.
                         </p>
                        <p>Getting Started - Simply go to "Add An EntrantResource" in the top menu and create your own
                        personal details, then begin to create the rest of your clan</p>
                     <p>Once you have created them all, you can create Entries (i.e. choose which categories you
                        would like to enter) for <em><b>each</b></em> entrant.</p>
                        <p>Once you have finished, simply bring a cheque or cash to the show to receive your entry
                        cards, which will be printed in advance</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
