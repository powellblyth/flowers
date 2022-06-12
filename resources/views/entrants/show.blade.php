<x-app-layout>
    <x-slot name="header">
        <x-headers.h1>
            {{ $entrant->name }}
        </x-headers.h1>
    </x-slot>
    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">list_alt</i>
                            </div>
                            <p class="card-category">Entries</p>
                            <h3 class="card-title"> &pound;{{number_format($entry_fee/100,2)}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> {{count($entries)}} entries
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-12 text-right">
                            @can('update',$entrant)
                                <a href="{{route('entrants.edit', $entrant)}}"
                                   class="btn btn-primary">Edit {{ucfirst($entrant->first_name)}}</a>
                            @endcan
                            @if ($entrant->user)
                                <a href="{{route('users.show', $entrant->user)}}"
                                   class="btn btn-primary">Show Family Manager</a>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{$entrant->full_name}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Entrant Number: {{ $entrant->getEntrantNumber() }}</b>
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Member Number:</b> {{ $entrant->getMemberNumber() }}
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-12">Name:</b> {{ $entrant->full_name }}</div>
                                    @if(!is_null($entrant->age))
                                        <div class="col-lg-6 col-md-6  col-sm-12">Age:</b> {{ $entrant->age_description }}</div>
                                    @endif

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-12">Family Manager:</b>
                                        @if(!is_null($entrant->user))
                                            <a href="{{route('users.show',['user'=>$entrant->user])}}">{{ $entrant->user->full_name }}</a>
                                        @else
                                            None Set
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">Entries</div>
                        <div class="card-body">
                            @if (count($entries ) <= 0)
                                {{$entrant->first_name}} has not entered any categories yet
                            @else
                                @foreach ($entries as $entry)

                                   {{$entry->category->numbered_name}} ({{$entry->paid}}p)
                                    @if ($entry['is_late'])
                                        (late)

                                    @endif
                                    @if ($entry->hasWon())
                                        <b class="badge-success"><u>{{$entry->winning_label}}</u></b>
                                        (&pound;{{number_format($entry->category->getWinningAmount($entry->winningplace) / 100,2)}})
                                    @endif
                                    <br/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
           <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header-success">Create New Entries</div>
                                <div class="card-body">
                                    <p>Choose the categories you wish to add entries for below</p>

                                    {{ Form::open([
                                        'route' => 'entry.creates'
                                    ]) }}
                                    <div class="row">

                                        {{ Form::hidden('entrant', $entrant->id, ['class' => 'form-control']) }}

                                        @for ($i = 0; $i < 40; $i++)
                                            <div
                                                class="col-sm-3 col-md-2 col-lg-1">{{
    Form::select('categories[]', $categories, null, ['class' => 'form-control','style'=>'width:100px', 'placeholder'=>'Please Select...']) }}</div>
                                        @endfor
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br/>
                                            {{ Form::submit('Create Entry', ['class' => 'button btn btn-primary']) }}
                                        </div>
                                    </div>
                                    {{ Form::close() }}

                                </div>
                            </div>
                        </div>
                    </div>

                @can('create',\App\Models\MembershipPurchase::class)
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header-success">New Membership Purchase</div>
                                <div class="card-body">
                                    <p>Note that your membership will not be processed until the money has been
                                        received</p>
                                    {{ Form::open([
                                        'route' => 'membershippurchases.store'
                                    ]) }}

                                    {{ Form::hidden('entrant', $entrant->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('user', $entrant->user_id, ['class' => 'form-control']) }}

                                    {{ Form::label('number', 'Number:', ['class' => 'control-label']) }}
                                    {{ Form::text('number', null,['class' => 'form-control','style'=>'width:150px'])}}

                                    {{ Form::label('type', 'Type:', ['class' => 'control-label']) }}
                                    {{Form::select('type', $membership_types, null, ['class' => 'form-control','style'=>'width:150px'])}}
                                    <br/>
                                    {{ Form::submit('Purchase Membership', ['class' => 'button btn btn-primary']) }}
                                    <br/><br/><br/>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

            </div>
    </div>
</x-app-layout>>
