<div class="mt-8">
    <x-headers.h3>Pick a winner from an entry</x-headers.h3>
        <x-select wire:model="category_id" name="category" :options="$categories" :selected="$category_id" hasBlank="true"/>
        {{--                    {{ Form::submit('Find Entrants', ['class' => 'button btn btn-primary']) }}--}}

    @if($category_id)
        <x-headers.h3 class="mx-4">Pick a winner from a list of entrants</x-headers.h3>
        <form method="POST" action="{{route('cup.directResultSetWinner',['cup'=>$cup])}}">
            @csrf
            <x-select name="entry_id" :options="$entries->pluck('entrant.numbered_name', 'id')->toArray()" hasBlank="true" />
            <x-buttons.default>Set Winner</x-buttons.default>
        </form>
    @endif
</div>
