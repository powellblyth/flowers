@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Family Management')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Families') }}</h4>
                            <p class="card-category"> {{ __('Here you can manage families') }}</p>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="material-icons">close</i>
                                            </button>
                                            <span>{{ session('status') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @can('create', \App\Models\User::class)
                                @if(!$isLocked)
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <a href="{{ route('users.create') }}"
                                               class="btn btn-sm btn-primary">{{ __('Add family') }}</a>
                                        </div>
                                    </div>
                                @endif
                            @endcan
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        {{ __('Name') }}
                                    </th>
                                    <th>Type</th>
                                    <th>
                                        {{ __('Email') }}
                                    </th>
                                    <th>
                                        {{ __('Family Members') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('Actions') }}
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->getName() }}</td>
                                            <td>{{ucfirst($user->type)}}</td>
                                            <td>{{ $user->email }}</td>

                                            <td class="td-actions">
                                                {{ $user->entrants_count }}
                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                   href="{{ route('users.show', $user) }}" data-original-title=""
                                                   title="show family members">
                                                    <i class="material-icons">people</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                @if(!$isLocked)
                                                    <a rel="tooltip" class="btn btn-success btn-link"
                                                       href="{{ route('entrants.create') }}?user_id={{$user->id}}"
                                                       data-original-title=""
                                                       title="add a new family member">
                                                        <i class="material-icons">add</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="td-actions text-right">
                                                <form action="{{ route('users.destroy', $user) }}" method="post">

                                                    @can('update', $user)
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                           href="{{ route('user.edit', $user) }}" data-original-title=""
                                                           title="edit {{$user->firstname}}">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                           href="{{ route('users.show', $user) }}" data-original-title=""
                                                           title="show {{$user->firstname}}">
                                                            <i class="material-icons">person</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    @endcan
                                                    @can ('delete', $user)
                                                            @csrf
                                                            @method('delete')
                                                        <button type="button" class="btn btn-danger btn-link"
                                                                data-original-title="" title=""
                                                                onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection