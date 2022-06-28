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
        <x-headers.h1>
            {{ __('Categories for the '  . $show->name . ' show') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.show route="categories.index" :show="$show"/>

    <x-layout.intro-para>
        <p>
            You can see the categories for this show, along with all winners from the {{$show->name}}
            show, if available, here.
        </p>
    </x-layout.intro-para>
    @php
        $publishMode = false;
        $shortName = false;
    @endphp
    @foreach ($sections as $section)
        <x-layout.intro-para class="py-2">
            <x-headers.h2>
                Section {{$section->display_name}}
            </x-headers.h2>
            <table
                class="w-full flex flex-row flex-no-wrap bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                <thead class="text-white">
                <tr class="bg-indigo-500 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                    <th class="p-3 text-left">Category</th>
                    <th class="p-3 text-left">Entries</th>
                    @if($show->resultsArePublic() || Auth::user()?->isAdmin())
                        <th class="p-3 text-left" colspan="4" width="110px">Winner</th>
                    @endif
                </tr>
                </thead>
                <tbody class="flex-1 sm:flex-none">
                @foreach ($show->categories()->with(['section', 'entries', 'entries.entrant'])->forSection($section)->get()->sortBy('sortorder') as $category)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                        <td class="border-grey-light border hover:bg-gray-100 p-3">
                            {{$category->numbered_name}}
                            @if($category->notes)
                                <span class="italic text-sm">{{ $category->notes }}</span>
                            @endif
                        </td>
                        <td class="border-grey-light border hover:bg-gray-100 p-3 font-weight-bold">
                            <nobr>
                                <b>
                                    {{$category->entries->count()}}
                                    {{\Illuminate\Support\Str::plural('entry', $category->entries)}}
                                </b>
                            </nobr>
                        </td>
                        @if($show->resultsArePublic() || Auth::user()?->isAdmin())
                            @foreach ($category
                                ->entries
                                ->reject(fn(\App\Models\Entry $entry) => empty($entry->winningplace))
                                ->sortBy(fn(\App\Models\Entry $entry, $key) => $entry->precedence_sorter)
                                 as $entry)
                                <td class="border-grey-light border hover:bg-gray-100 p-3">
                                    {{ $entry->winning_label }}
                                    <br/>{{$entry->entrant->printable_name}}
                                </td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            </table>

        </x-layout.intro-para>
    @endforeach
</x-app-layout>
