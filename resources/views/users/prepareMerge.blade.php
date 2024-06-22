<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Prepare Merging :user into :mergeInto', ['user' => $user->full_name, 'mergeInto' => $mergeInto->full_name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Prepare Merging :user (:old_id) into :mergeInto (:mergeIntoId)', ['old_id' => $user->id, 'user' => $user->full_name, 'mergeInto' => $mergeInto->full_name, 'mergeIntoId' => $mergeInto->id]) }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para class="py-2">
        <form method="post" action="{{ route('users.saveMerge', $user) }}" autocomplete="false" class="form-horizontal">
            @csrf

            <div class="card ">
                <div class="card-header card-header-primary">
                </div>
                <div class="card-body bg-amber-300 p-4 my-2">
                    <x-headers.h2>Merge or create new entrants</x-headers.h2>
                    <div class="grid grid-cols-2">
                        @foreach($user->entrants as $entrant)
                            <div class="w-64 flex-none">
                                {{ $entrant->full_name }}
                            </div>
                            <div>
                                <x-select :name="'mergeEntrant['.$entrant->id.']'" blankLabel="Create New Entrant"
                                          :options="$mergeInto
                                    ->entrants
                                    ->pluck('full_name', 'id')
                                    ->map(fn($entrant)=>  ' Merge With ' . $entrant)
                                    ->toArray()
                                    "
                                          hasBlank="true">
                                </x-select>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-body bg-amber-300 p-4 my-2 grid grid-cols-2">

                    <div>New First Name</div>
                    <div>
                        <x-select name="first_name" blankLabel="You Must Choose 1"
                                  :options="[$user->first_name => $user->first_name, $mergeInto->first_name => $mergeInto->first_name]"></x-select>
                    </div>
                    <div>New Family Name</div>
                    <div>
                        <x-select name="last_name" blankLabel="You Must Choose 1"
                                  :options="[$user->last_name => $user->last_name, $mergeInto->last_name => $mergeInto->last_name]"></x-select>
                    </div>
                    <div>New Password</div>
                    <div>
                        <x-select name="password" blankLabel="You Must Choose 1"
                                  :options="[$user->password => $user->full_name . '\'s password ('.$user->id .')', $mergeInto->password =>  $mergeInto->full_name . '\'s password ('.$mergeInto->id .')']"></x-select>
                    </div>
                    <div>New Email</div>
                    <div>
                        <x-select name="email" blankLabel="You Must Choose 1"
                                  :options="[$user->email => $user->email, $mergeInto->email => $mergeInto->email]"></x-select>
                    </div>
                    <div>New Address Line 1</div>
                    <div>
                        <x-select name="addresss_1" blankLabel="You Must Choose 1"
                                  :options="[$user->addresss_1 => $user->addresss_1, $mergeInto->addresss_1 => $mergeInto->addresss_1]"></x-select>
                    </div>
                    <div>New Address Line 2</div>
                    <div>
                        <x-select name="addresss_2" blankLabel="You Must Choose 1"
                                  :options="[$user->addresss_2 => $user->addresss_2, $mergeInto->addresss_2 => $mergeInto->addresss_2]"></x-select>
                    </div>
                    <div>New Town</div>
                    <div>
                        <x-select name="address_town" blankLabel="You Must Choose 1"
                                  :options="[$user->address_town => $user->address_town, $mergeInto->address_town => $mergeInto->address_town]"></x-select>
                    </div>
                    <div>New Postcode</div>
                    <div>
                        <x-select name="postcode" blankLabel="You Must Choose 1"
                                  :options="[$user->postcode => $user->postcode, $mergeInto->postcode => $mergeInto->postcode]"></x-select>
                    </div>
                </div>
                <div class="text-right pr-4  ">
                    <x-button class="align-right">Merge</x-button>
                </div>
        </form>
    </x-layout.intro-para>

</x-app-layout>
