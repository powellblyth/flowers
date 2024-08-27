<div>
    <div>
        <b>Search:</b>
        <x-input name="search" type="text" wire:model="filter"></x-input>
    </div>
    <div class="grid grid-cols-[250px_120px_80px_80px_300px_170px_120px]">
        <div class="py-8 border-b-2 font-bold">Name</div>
        <div class="px-4 border-b-2 font-bold">Previous <br/>Membership</div>
        <div class="px-4 border-b-2 font-bold">Retain Data?<br/><i>Please Ask</i></div>
        <div class="px-4 border-b-2 font-bold">Can<br/>We<br>Email<br/>you?</div>
        <div class="px-4 border-b-2 font-bold">Email Address</div>
        <div class="px-4 border-b-2 font-bold">Renewing?</div>
        <div class="px-4 border-b-2 font-bold"></div>
    </div>
    @foreach($memberList as $member)
        <livewire:member-list-item :member="$member" wire:key="list_item_{{$member->id}}_{{microtime(true)}}"/>
    @endforeach
</div>
