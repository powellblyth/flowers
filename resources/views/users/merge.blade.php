<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Merge :user into another Family', ['user' => $user->full_name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Merge :user into another Family', ['user' => $user->full_name]) }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para class="py-2">
        <div class="card ">
            <div class="card-header card-header-primary">
                <div class="card-category border border-gray-300 p-2">

                    <x-headers.h2>{{ $user->full_name }}'s details</x-headers.h2>
                    <div>{{$user->full_name}} (id={{$user->id}})<br/>
                        <x-headers.h3>Address (if known)</x-headers.h3>
                        <br/>
                        {{$user->address}}<br/>
                        {{$user->email}}</div>

                    <x-headers.h2>
                        {{$user->entrants->count()}} Family {{Str::plural('member', $user->entrants)}} belonging
                        to {{ $user->full_name }}
                    </x-headers.h2>
                    <ol class="list-decimal list-inside">
                        @foreach($user->entrants as $entrant)
                            <li>{{ $entrant->full_name }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="card-body ">
                <x-headers.h2>Find a family to merge into</x-headers.h2>
                <livewire:user-search :existingUser="$user"></livewire:user-search>
                <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </x-layout.intro-para>

</x-app-layout>
