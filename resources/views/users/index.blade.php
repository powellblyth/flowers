<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Family') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

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
                                            <td>{{ $user->full_name }}</td>
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
                                                    <a rel="tooltip" class="btn btn-success btn-link"
                                                       href="{{ route('entrants.create'}}"
                                                       data-original-title=""
                                                       title="@lang('Add another family member')">
                                                        <i class="material-icons">add</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                            </td>
                                            <td class="td-actions text-right">
                                                <form action="{{ route('users.destroy', $user) }}" method="post">

                                                    @can('update', $user)
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                           href="{{ route('user.edit', $user) }}" data-original-title=""
                                                           title="edit {{$user->first_name}}">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                           href="{{ route('users.show', $user) }}" data-original-title=""
                                                           title="show {{$user->first_name}}">
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
</x-app-layout>>
