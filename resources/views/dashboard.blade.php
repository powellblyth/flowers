@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('content')
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">add</i>
              </div>
              <p class="card-category">Family Members</p>
              <h3 class="card-title">{{$entrantCount}}
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                @if (!$isLocked)
                <i class="material-icons text-danger">add</i>
                <a href="{{route('entrants.create')}}">Add another</a>
                  @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Entries</p>
              <h3 class="card-title">{{$entryCount}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
{{--                <i class="material-icons">date_range</i> Last 24 Hours--}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
          @if(Auth::check())
              <div class="card-header card-header-success">
          Welcome, {{ucfirst(Auth::User()->firstname)}}
              </div>
              <div class="card-body">
                @if ($isLocked)
                  <p>Welcome to the entries system for the PHS summer show. </p>
                  <p>Unfortunately, the system is now offline until the show has completed. If you wish to enter please go to <a href="http://www.petershamhorticulturalsociety.org.uk/summer-show/duplicate-entry-forms/"> our website and print off a form</a></p>
                  @else
             <p>This is the <a href="http://www.petershamhorticulturalsociety.org.uk" target="_blank">Petersham Horticultural Society</a>'s system for self-registering membership and entries to the show. Your user account allows you to manage your family members, who are people you
              have the authority to speak for (normally Children, Husband, Wife, Life-Partner etc. etc.</p>
            <p>There's no real limit to the number of family members you can represent, but remember, only one entrant can win any given cup, points are not aggregated to your user account.
             </p>
            <p>Getting Started - Simply go to "Add An Family Member" in the side menu and enter your own personal details, then begin to create the rest of your clan</p>
            <p>Once you have created them all, you can create Entries (i.e. choose which categories you would like to enter) for <em><b>each</b></em> family member.</p>
           <p>Once you have finished, simply bring a cheque or cash to the show to receive your entry cards, which will be printed in advance</p>
                  @endif
              </div>
            @endif
          </div>
        </div>
      </div>
  </div>
@endsection

