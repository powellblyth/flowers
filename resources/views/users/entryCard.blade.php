<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entries for :show', ['show'=>$show->name]) }}
        </h2>
    </x-slot>


    <div class="p-20">
        <h3 class=" bg-white text-xl w-full top-0 p-2">{{__('The :family family entry card for :show', ['family'=>$user->lastname,'show'=>$show->name])}}</h3>
        @forelse ($user->entrants as $entrant)


            <div class="bg-white p-3 m-4">
                <h3 class=" bg-white text-xl sticky w-full top-0 p-2">{{__(':name\'s entry card', ['name'=>$entrant->full_name])}} {{$entrant->age_description}}</h3>
                <div>
                    <div class=" p-2 px-4 ">

                        @if($entrant->teams()->wherePivot('show_id', $show->id)->first())
                            A member of team {{$entrant->teams()->wherePivot('show_id', $show->id)->first()}}
                        @else
                            @if($entrant->isChild())
                                Not yet a member of any team
                            @endif
                        @endif
                    </div>
                    <div class="flex flex-wrap">
                        @foreach($show->categories as $category)
                            <div class="flex-initial w-1/5 p-2  flex bg-green-200 m-4 rounded-xl">
                                <label for="{{'cb_' . $category->id . '_' . $entrant->id}}"
                                       class="flex-auto w-80 px-2">{{$category->numbered_name}}</label>
                                <div class="flex-1 2xl:text-xl"><input
                                        id="{{'cb_' . $category->id . '_' . $entrant->id}}"
                                        type="checkbox" class="w-8 h-8 m-2"/></div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>


        @empty
            <div class="table-row">
                There are no family members configured yet. You must have configured at least one
                family member before you can add any show entries
            </div>

        @endforelse




        {{ Form::close() }}
        <div class="row">

        </div>

    </div>
</x-app-layout>>
