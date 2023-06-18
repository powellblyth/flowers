<div>
    <input name="search" wire:input="filter"></input>
    @foreach($memberList as $member)
        <x-member-list-item :member="$member"></x-member-list-item>
    @endforeach
</div>
