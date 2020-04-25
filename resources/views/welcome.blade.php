@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('PHS SUMMER SHOW ENTRY MANAGEMENT')])

@section('content')
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                @if(!$isLocked)
                    <h1 class="text-white text-center">{{ __('Welcome to the PHS Summer Show entry system. Log in or register above to get started') }}</h1>
                    @if(Auth::check())
                        -    <h1>Welcome, {{Auth::User()->firstname}}</h1>
                        -    <p>This is the <a href="http://www.petershamhorticulturalsociety.org.uk" target="_blank">Petersham
                                Horticultural Society</a>'s system for self-registering membership and entries to the
                            show. Your user account allows you to manage Show Entrants, who are people you
                            - have the authority to speak for (normally Children, Husband, Wife, Life-Partner etc. etc.
                        </p>
                        -    <p>There's no real limit to the number of entrants you can represent, but remember, only
                            one entrant can win any given cup, points are not aggregated to your user account.
                            - </p>
                        -    <p>Getting Started - Simply go to "Add An Entrant" in the top menu and create your own
                            personal details, then begin to create the rest of your clan</p>
                        -    <p>Once you have created them all, you can create Entries (i.e. choose which categories you
                            would like to enter) for <em><b>each</b></em> entrant.</p>
                        -    <p>Once you have finished, simply bring a cheque or cash to the show to receive your entry
                            cards, which will be printed in advance</p>
                        -    @endif
                    @else
                    <h1 class="text-white text-center">{{ __('Welcome to the PHS Summer Show entry system.') }}</h1>
                    <p>This is the PHS entry system. Due to the show being due, the system is now offline for data entry</p>
                    <p>You may log in to see your entries, but any new entries must be created at the show</p>
                @endif

            </div>
        </div>
@endsection
@section('extraFooter')
    <p>
        <small>Image copyright Andy Rogers https://www.flickr.com/photos/cobaltfish/7712882294</small>
    </p>
@endsection