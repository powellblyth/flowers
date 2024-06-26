<div>
    <input wire:model.laze="firstName" wire:change.debounce.150ms="doSearch" type="text">
    <input wire:model.laze="familyName" wire:change.debounce.150ms="doSearch" type="text">
{{--        @dump($results)--}}
    <form>
        <div class="grid grid-cols-2">
            @foreach ($results ?? [] as $result)
                <div
                    class=" bg-lime-300  p-2 mb-2">
                    <b>Family Manager</b><br/> {{$result->full_name}} ({{$result->id}})<br/>
                    {{$result->address}}<br/>
                    {{$result->email}}
                </div>
                <div class=" p-2 border-t border-b border-lime-300">
                    <b>{{$result->full_name}}'s entrants:</b><br/>
                    @foreach($result->entrants as $entrant)
                        {{$entrant->full_name}}]
                        @if($entrant->isChild())
                            age {{$entrant->age}}
                        @endif
                        <br/>
                    @endforeach
                </div>
            @endforeach
        </div>
    </form>
    {{--                        <x-select blankLabel="Create New Entrant"--}}
    {{--                                  :options="$result--}}
    {{--                                    ->entrants--}}
    {{--                                    ->pluck('full_name', 'id')--}}
    {{--                                    ->map(fn($entrant)=>  ' Merge With ' . $entrant)--}}
    {{--                                    ->toArray()--}}
    {{--                                    "--}}
    {{--                                  hasBlank="true">--}}

    {{--                        </x-select>--}}
</div>
