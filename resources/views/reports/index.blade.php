@extends('layouts.app', ['activePage' => 'reports', 'titlePage' => __('Reports')])
@section('pagetitle', 'Reports')
@section('content')
    <br/>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{__('Reports')}}
                            </div>
                            <div class="card-body">
                                @can('viewAny',\App\Models\MembershipPurchase::class)
                                    <a href="{{route('reports.members')}}">&raquo; Memberships Purchased report</a><br/>
                            @endcan
                                    @can('viewAny',\App\Models\Entry::class)
                                <a href="{{route('reports.entries')}}">&raquo; Entries report</a><br/>
                                <a href="{{route('reports.categories')}}">&raquo; Unplaced categories report</a>
                                    @endcan

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

