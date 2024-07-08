<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Prepare Merging :user into :mergeInto', ['user' => $user->full_name, 'mergeInto' => $mergeInto->full_name]) }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Prepare Merging :user (:old_id) into :mergeInto (:mergeIntoId)', ['old_id' => $user->id, 'user' => $user->full_name, 'mergeInto' => $mergeInto->full_name, 'mergeIntoId' => $mergeInto->id]) }}
        </x-headers.h1>
    </x-slot>
    <script>
        function showHideEntrants(entrantId) {
            selectBox = document.getElementById('mergeEntrant_select_' + entrantId);

            if (document.getElementById('entrant_choose_radio_' + entrantId).checked) {
                document.getElementById('mergeEntrant_select_' + entrantId).style.display = 'inline-block'
            } else {
                document.getElementById('mergeEntrant_select_' + entrantId).style.display = 'none'
            }
        }

        function mergeUserChosen() {
            document.getElementById('userNergeFields').style.display = 'block';
            document.getElementById('merge_type_merge').checked = true;
        }

        function transferUserChosen() {
            document.getElementById('userNergeFields').style.display = 'none';
            document.getElementById('merge_type_transfer').checked = true;

        }
    </script>
    <x-layout.intro-para class="py-2">
        <form method="post"
              action="{{ route('users.doMerge', [$user, $mergeInto]) }}"
              autocomplete="off"
              class="form-horizontal">
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
                                <input type="radio"
                                       onChange="showHideEntrants({{$entrant->id}})"
                                       id="mergeOptionIgnore_{{$entrant->id}}"
                                       checked="checked"
                                       name="mergeEntrantOptions[{{$entrant->id}}]"
                                       value="ignore"
                                />
                                <label class="pr-4" for="mergeOptionIgnore_{{$entrant->id}}">
                                    Ignore Entrant
                                </label><br/>

                                <input
                                    onChange="showHideEntrants({{$entrant->id}})"
                                    id="entrant_choose_radio_{{$entrant->id}}"
                                    type="radio"
                                    name="mergeEntrantOptions[{{$entrant->id}}]"
                                    value="merge"
                                />
                                <label class="pr-4" for="mergeOptionIgnore_{{$entrant->id}}">
                                    Merge Entrant
                                </label>
                                <x-select
                                    id="mergeEntrant_select_{{$entrant->id}}"
                                    style="display:none"
                                    :name="'mergeEntrant['.$entrant->id.']'"
                                    :options="$mergeInto
                                    ->entrants
                                    ->pluck('full_name', 'id')
                                    ->map(fn($entrant)=>  ' Merge With ' . $entrant)
                                    ->toArray()"
                                >
                                </x-select>
                                <br/>

                                <input type="radio"
                                       onChange="showHideEntrants({{$entrant->id}})"
                                       name="mergeEntrantOptions[{{$entrant->id}}]"
                                       value="add"
                                />
                                <label class="pr-4" for="mergeOptionIgnore_{{$entrant->id}}">
                                    Add as new Entrant
                                </label>
                            </div>
                            <div class="col-span-2">
                                <hr class="my-2 bg-red-900 "/>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-body bg-amber-300 p-4 my-2 grid grid-cols-2">
                    <div>
                        <label for="">Merge the Family Managers <input
                                onChange="mergeUserChosen()"
                                id="merge_type_merge"
                                type="radio"
                                checked="checked"
                                name="user_merge_type"
                                value="merge"
                            /></label>
                    </div>
                    <div>
                        <label for="">Just transfer the entrant(s) <input
                                onChange="transferUserChosen()"
                                id="merge_type_transfer"
                                type="radio"
                                name="user_merge_type"
                                value="transfer"
                            /></label>
                    </div>
                    <div class="col-span-2">
                        <hr class="my-2 bg-red-900  "/>
                    </div>
                </div>
                <div id="userNergeFields" style="display:block"
                     class="card-body bg-amber-300 p-4 my-2 grid grid-cols-2">
                    <div>New First Name</div>
                    <div>
                        <x-select name="first_name" blankLabel="You Must Choose 1"
                                  :options="[$user->first_name => $user->first_name, $mergeInto->first_name => $mergeInto->first_name]"
                                  :selected="!empty($mergeInto->first_name) ? $mergeInto->first_name : $user->first_name"></x-select>
                    </div>
                    <div>New Family Name</div>
                    <div>
                        <x-select name="last_name" blankLabel="You Must Choose 1"
                                  :options="[$user->last_name => $user->last_name, $mergeInto->last_name => $mergeInto->last_name]"
                                  :selected="!empty($mergeInto->last_name) ? $mergeInto->last_name : $user->last_name"
                        ></x-select>
                    </div>
                    <div>New Password</div>
                    <div>
                        <x-select name="password" blankLabel="You Must Choose 1"
                                  :options="[
                                        $user->password => $user->full_name . '\'s password ('.$user->id .')',
                                        $mergeInto->password =>  $mergeInto->full_name . '\'s password ('.$mergeInto->id .')'
                                    ]"
                                  :selected="$mergeInto->password"></x-select>
                    </div>
                    <div>New Email</div>
                    <div>
                        <x-select name="email" blankLabel="You Must Choose 1"
                                  :options="[$user->email => $user->email, $mergeInto->email => $mergeInto->email]"
                                  :selected="!empty($mergeInto->email) ? $mergeInto->email : $user->email"
                        ></x-select>
                    </div>
                    <div>New Address Line 1</div>
                    <div>
                        <x-select name="address_1" blankLabel="You Must Choose 1"
                                  :options="[$user->address_1 => $user->address_1, $mergeInto->address_1 => $mergeInto->address_1]"
                                  :selected="!empty($mergeInto->address_1) ? $mergeInto->address_1 : $user->address_1"
                        ></x-select>
                    </div>
                    <div>New Address Line 2</div>
                    <div>
                        <x-select name="address_2" blankLabel="You Must Choose 1"
                                  :options="[$user->address_2 => $user->address_2, $mergeInto->address_2 => $mergeInto->address_2]"
                                  :selected="!empty($mergeInto->address_2) ? $mergeInto->address_2 : $user->address_2"
                        ></x-select>
                    </div>
                    <div>New Town</div>
                    <div>
                        <x-select name="address_town" blankLabel="You Must Choose 1"
                                  :options="[$user->address_town => $user->address_town, $mergeInto->address_town => $mergeInto->address_town]"
                                  :selected="!empty($mergeInto->address_town) ? $mergeInto->address_town : $user->address_town"
                        ></x-select>
                    </div>
                    <div>New Postcode</div>
                    <div>
                        <x-select name="postcode" blankLabel="You Must Choose 1"
                                  :options="[$user->postcode => $user->postcode, $mergeInto->postcode => $mergeInto->postcode]"
                                  :selected="!empty($mergeInto->postcode) ? $mergeInto->postcode : $user->postcode"
                        ></x-select>
                    </div>
                </div>
                <div class="text-right pr-4  ">
                    <x-button class="align-right">Merge</x-buttons.default>
                </div>
        </form>
    </x-layout.intro-para>

</x-app-layout>
