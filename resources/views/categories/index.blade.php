<x-app-layout>

    <style>
        html,
        body {
            height: 100%;
        }

        @media (min-width: 640px) {
            table {
                display: inline-table !important;
            }

            thead tr:not(:first-child) {
                display: none;
            }
        }

        td:not(:last-child) {
            border-bottom: 0;
        }

        th:not(:last-child) {
            border-bottom: 2px solid rgba(0, 0, 0, .1);
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories for the '  . $show->name . ' show') }}
        </h2>
    </x-slot>
    <x-navigation.show route="categories.index" :show="$show" />

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>You can see the categories for this show, along with all winners from the {{$show->name}}
                        show, if available, here.</p>
                </div>
            </div>
        </div>
    </div>
    @php
        $publishMode = false;
//        $showaddress = $isAdmin;
//        $printableNames = !$isAdmin;
        $shortName = false;
    @endphp
    @foreach ($sections as $section)
        {{--    <div class="py-12">--}}
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="rounded-l-lg  title text-xl font-medium">
                        Section {{$section->display_name}}
                    </div>
                    <table
                        class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white">
                            <tr class="bg-indigo-500  flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">Category</th>
                                <th class="p-3 text-left">Entries</th>
                                <th class="p-3 text-left" colspan="4" width="110px">Winner</th>
                            </tr>
                        </thead>
                        <tbody class="flex-1 sm:flex-none">
                        @foreach ($section->categories->where('show_id', $show->id)->sortBy('sortorder') as $category)
                            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <td class="border-grey-light border hover:bg-gray-100 p-3">
                                    {{$category->numbered_name}}
                                    @if($category->notes)
                                        <span class="italic text-sm">{{$category->notes}}</span>
                                        @endif
                                </td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 font-weight-bold">
                                    <b>
                                        <nobr>
                                            {{$category->entries->count()}}
                                            {{\Illuminate\Support\Str::plural('entry', $category->entries)}}
                                        </nobr>
                                    </b>

                                </td>
                                @foreach ($category->entries->whereNotNull('winningplace')->sortBy(
    function ($entry, $key){
        if ($entry->winningplace === 'commended'){
            return 4;
        }
        if (empty($entry->winningplace)){
            return 5;
        }
        return $entry->winningplace;
    }
) as $entry)
                                    <td class="border-grey-light border hover:bg-gray-100 p-3">
                                        @if($entry->winningplace == 1)
                                            First:
                                        @elseif ($entry->winningplace == 2)
                                            Second:
                                        @elseif ($entry->winningplace == 3)
                                            Third:
                                        @else
                                            {{ucfirst($entry->winningplace)}}
                                        @endif
                                        <br/>{{$entry->entrant->printable_name}}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>

                </div>

            </div>
        </div>

        {{--    </div>--}}
    @endforeach
</x-app-layout>
