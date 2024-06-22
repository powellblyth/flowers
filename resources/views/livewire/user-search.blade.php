<div>
    <input wire:model.laze="firstName" placeholder="First Name" wire:change.debounce.150ms="doSearch" type="text">
    <input wire:model.laze="familyName" placeholder="Family Name" wire:change.debounce.150ms="doSearch" type="text">
    {{--        @dump($results)--}}
    <form>
        @if($results)
            <x-headers.h3 class=" mt-8">Results</x-headers.h3>
            <div class="grid grid-cols-3">
                @foreach ($results ?? [] as $familyManager)
                    <div
                        class=" bg-lime-300  p-2 mb-2">
                        {{$familyManager->full_name}} ({{$familyManager->id}})<br/>
                        {{$familyManager->address}}<br/>
                        {{$familyManager->email}}
                    </div>
                    {{--                    <div class="">--}}
                    <div class="p-2 border-t mb-2 border-b border-lime-300">

                        <x-headers.h4>Entrants</x-headers.h4>
                        @foreach($familyManager->entrants as $entrant)

                            {{$entrant->full_name}}<br/>

                        @endforeach
                    </div>
                    <div class="p-2 border-t mb-2 border-b border-lime-300">
                        <x-button>
                            <a href="{{route('users.prepareMerge', ['user' => $existingUser, 'mergeInto' => $familyManager])}}">
                                Merge {{$existingUser->first_name}} into {{$familyManager->full_name}}
                            </a>
                        </x-button>
                    </div>
                @endforeach
            </div>
        @endif
    </form>
</div>
