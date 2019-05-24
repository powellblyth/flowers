@extends('layouts.app', ['activePage' => 'reports', 'titlePage' => __('Unplaced Categories')])
@section('content')
    <br/>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{__('Unplaced Categories')}}
                            </div>
                            <div class="card-body">
                                These categories have not yet had a winner assigned
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <tr>
                                            <th>Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($unplaced_categories as $categoryID=>$categoryName)
                                            <tr>
                                                <td><a href="/categories/{{$categoryID}}">{{$categoryName}}</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
