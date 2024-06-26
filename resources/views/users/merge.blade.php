<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Merge :user into another Family', ['user' => $user->full_name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Merge :user into another Family', ['user' => $user->full_name]) }}
        </x-headers.h1>
    </x-slot>
    {{--@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Merge Family Manager')])--}}

    <x-layout.intro-para class="py-2 break-inside-avoid">
        <form method="post" action="{{ route('users.saveMerge', $user) }}" autocomplete="false" class="form-horizontal">
            @csrf

            <div class="card ">
                <div class="card-header card-header-primary">
                    <p class="card-category">
                        <x-headers.h2>Family members belonging to {{ $user->full_name }}</x-headers.h2>
                        @foreach($user->entrants as $entrant)
                            {{ $entrant->full_name }}<br/>
                        @endforeach
                    </p>
                </div>
                <div class="card-body ">

                    <livewire:user-search :existingUser="$user"></livewire:user-search>
                    <div class="card-footer ml-auto mr-auto">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </x-layout.intro-para>

</x-app-layout>
