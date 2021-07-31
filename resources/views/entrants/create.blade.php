<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div>
            Add a new member of your family so they can represent themselves at the show.
        </div>

        <form method="POST" action="{{ route('entrants.store') }}">
        @csrf

        <!-- Name -->
            <div class="py-4">
                <x-label for="firstname" :value="__('First Name')" />

                <input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
            </div>
            <div class="py-4">
                <x-label for="familyname" :value="__('Last Name')" />
                <input id="familyname" class="block mt-1 w-full" type="text" name="familyname" :value="old('familyname')" required autofocus />
            </div>
            <div class="py-4">
                <x-label for="age" :value="__('Age in years (Children only)')" />
                <x-input id="age" class="block mt-1 w-full" type="text" name="age" :value="old('age')" autofocus />
            </div>
            <div class="py-4">
                <x-label for="membernumber" :value="__('Member Number (If Known)')" />
                <x-input id="membernumber" class="block mt-1 w-full" type="text" name="membernumber" :value="old('membernumber')"  autofocus />
            </div>
            <div class="py-4">
                <x-label for="team" :value="__('Team (optional)')" />
                <select name=""team_id" class="px-4 py-3 rounded-full">
                        <option value="" selected="selected">None</option>
                    @foreach($teams as $teamId =>$teamName)
                        <option value="{{$teamId}}">{{$teamName}}</option>

                    @endforeach
                </select>
            </div>
            <div class="py-4">
                <x-label for="can_retain_data" :value="__('Can we retain this information for future shows?')" />
                <x-input id="can_retain_data" class="block mt-1 " type="checkbox" name="can_retain_data" :value="old('can_retain_data')"  autofocus />
            </div>
            <x-button class="ml-4">
                {{ __('Add this person to My Family') }}
            </x-button>

        </form>
    </x-auth-card>
</x-guest-layout>

{{--{{ Form::open(['route' => 'entrants.store']) }}--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header card-header-success">Enter your Family Member's Entrant details</div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12"><p>Use this page to add yourself and your family as entrants.--}}
{{--                                    No need to enter the address each time, as you set it when you registered</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                {{ Form::label('firstname', 'First Name: * ', ['class' => 'control-label']) }}--}}
{{--                                {{ Form::text('firstname', null, ['class' => 'form-control']) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                {{ Form::label('familyname', 'Family Name: *', ['class' => 'control-label']) }}--}}
{{--                                {{ Form::text('familyname',$defaultFamilyName, ['class' => 'form-control']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                {{ Form::label('age', 'Age in years (Children only):', ['class' => 'control-label']) }}--}}
{{--                                {{ Form::text('age', null, ['class' => 'form-control']) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                {{ Form::label('membernumber', 'Member Number (If you have one):', ['class' => 'control-label']) }}--}}
{{--                                {{ Form::text('membernumber', null, ['class' => 'form-control']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @if(!empty($teams))--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-12">--}}
{{--                                    {{ Form::label('team_id', 'Team::', ['class' => 'control-label']) }}--}}
{{--                                    {{ Form::select('team_id', array_merge([0=>'Please Select... '],$teams), old('team_id'), ['class' => 'form-control']) }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                {!! $privacyContent !!}--}}
{{--                                <p>{{ Form::checkbox('can_retain_data', 1) }} {{ Form::label('can_retain_data', 'Check here to allow retain your information for future shows?:', ['class' => 'control-label']) }}</p>--}}
{{--                                --}}{{--                                                                <p>{{ Form::checkbox('can_email', 1) }} {{ Form::label('can_email', 'Check here to allow us to contact you by email (up ot a few times a year)?:', ['class' => 'control-label']) }}</p>--}}
{{--                                --}}{{--                                                                <p>{{ Form::checkbox('can_sms', 1) }} {{ Form::label('can_sms', 'Check here to allow us contact you by SMS (very infrequent)?:', ['class' => 'control-label']) }}</p>--}}
{{--                                {{ Form::submit('Create New Member', ['class' => 'button btn btn-primary']) }}--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    {{ Form::close() }}--}}

