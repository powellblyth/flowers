<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entries for :show', ['show'=>$show->name]) }}
        </h2>
    </x-slot>
    <x-navigation.show route="entries.entryCard" :show="$show"/>

    @if ($can_enter)
        {{ Form::open(
        [
            'route' => ['entries.store']]
            )
            }}
    @endif
    <div class="p-20">
        <div class=" bg-white w-full top-0 sticky p-2 float-right"><h3
                class="inline-block w-1/2 text-xl ">@lang('The :family family entry card for :show', ['family'=>$user->last_name,'show'=>$show->name])</h3>
            @if ($can_enter)
                <div class="w-1/2 inline-block float-right"><input type="submit" value="Save"
                                                                   class="text-white bg-green-500 px-3 py-1 rounded">
                </div>
            @endif
        </div>
        @forelse ($user->entrants as $entrant)
            <div class="bg-white p-3 m-4">
                <h3 class=" bg-white text-xl sticky w-full top-10 p-2 font-bold">@lang(':name\'s entry card', ['name'=>$entrant->full_name]) {{$entrant->age_description}}</h3>
                <div>
                    <div class=" p-2 px-4">
                        @php
                            $teams = $entrant->teams()->wherePivot('show_id', $show->id)->first();
                        @endphp
                        @if($teams)
                            @lang('A member of team :teamname', ['teamname'=>$teams])
                        @else
                            @if($entrant->isChild())
                                @lang('Not yet a member of any team')
                            @endif
                        @endif
                    </div>
                    <div>
                        @foreach($sections as $section)
                            <div class="pl-2 text-xl font-bold bg-pink-200 rounded-md">{{$section->display_name}}</div>
                            <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2">
                            @forelse($categories->where('section_id', $section->id)->sortBy('sortorder') as $category)
                                @if($category->canEnter($entrant))
                                    <!-- TODO dont bother showing unentered historic categories -->
                                        <div class="p-2 flex bg-green-200 mx-2 my-3 rounded-xl">
                                            <label for="{{'cb_' . $category->id . '_' . $entrant->id}}"
                                                   class="flex-auto w-80 px-2">{{$category->numbered_name}}</label>
                                            <div class="2xl:text-xl">
                                                <input
                                                    id="{{'cb_' . $category->id . '_' . $entrant->id}}"
                                                    @if(!$can_enter)
                                                    disabled="disabled"
                                                    @endif
                                                    @if($entrant->entries->where('category_id', $category->id)->first())
                                                    checked="checked"
                                                    @endif
                                                    type="checkbox" name="entries[{{$entrant->id}}][{{$category->id}}]"
                                                    class="w-6 h-6 m-1"/>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="p-2">
                                        @lang('No categories have been created for this section yet. Watch this space!')
                                    </div>
                                @endforelse
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @empty
            <div class="table-row">
                @lang('There are no family members configured yet. You must have configured at least one
                family member before you can add any show entries')
            </div>

        @endforelse

        @if ($can_enter)

            {{ Form::close() }}

        @endif
        <div class="row">

        </div>

    </div>
</x-app-layout>>
