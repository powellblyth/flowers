<x-app-layout>
    <x-slot name="pageTitle">
        @if($entrant->exists)
            {{ __('Editing ') . $entrant->first_name }}
        @else
            {{'Creating a new family member'}}
        @endif
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            @if($entrant->exists)
                {{ __('Editing ') . $entrant->first_name }}
            @else
                {{'Creating a new family member'}}
            @endif
        </x-headers.h1>
    </x-slot>
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                @if($entrant->exists)
                    {{ Form::open(array('url' =>route('entrants.update', ['entrant'=>$entrant]), 'method' => 'PUT')) }}
                @else
                    <form method="POST" action="{{ route('entrants.store') }}">
                    @endif
                    @csrf

                    <!-- Name -->
                        <div class="py-4">
                            <x-label for="first_name" :value="__('First Name')"/>
                            <x-input id="first_name" v-model="entrant.first_name" class="block mt-1 w-full" type="text"
                                     name="first_name" value="{{ old('first_name', $entrant?->first_name) }}" required
                                     autofocus/>
                        </div>
                        <div class="py-4">
                            <x-label for="family_name" :value="__('Last Name')"/>
                            <x-input id="family_name" class="block mt-1 w-full" type="text" name="family_name"
                                     value="{{ old('family_name', $entrant?->family_name ?? $defaultFamilyName) }}"
                                     required autofocus/>
                        </div>
                        <div class="py-4">
                            <x-label for="age" :value="__('Age in years (Children only)')"/>
                            <x-input id="age" class="block mt-1 w-full" type="text" name="age"
                                     value="{{ old('age', $entrant?->age) }}" autofocus/>
                        </div>
                        <div class="py-4">
                            <x-label for="membernumber" :value="__('Member Number (If Known)')"/>
                            <x-input id="membernumber" class="block mt-1 w-full" type="text" name="membernumber"
                                     value="{{ old('membernumber', $entrant?->membernumber) }}" autofocus/>
                        </div>
                        <div class="py-4">
                            <x-label for="team_id" :value="__('Team (optional)')"/>
                            <select name="team_id" class="px-4 py-3 rounded-full">
                                <option value="" selected="selected">None</option>
                                @foreach($teams as $teamId =>$teamName)
                                    <option value="{{$teamId}}">{{$teamName}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="py-4">
                            <x-label for="can_retain_data"
                                     :value="__('Can we retain this information for future shows?')"/>
                            <x-input id="can_retain_data" class="block mt-1 " type="checkbox" name="can_retain_data"
                                     value="1" checked="old('can_retain_data')" autofocus/>
                        </div>
                        <x-button class="ml-4">
                            @if($entrant->exists)
                                {{ __('Update') . ' ' .strip_tags($entrant->first_name) }}
                            @else
                                {{ __('Add this person to My Family') }}
                            @endif
                        </x-button>

                    </form>

                    {{ Form::close() }}
            </div>
        </div>
    </div>
</x-app-layout>>

