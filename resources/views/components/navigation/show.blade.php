<div class="py-4 print:hidden">
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
        <div class="bg-white">
            <nav class="flex flex-col sm:flex-row">
                @foreach ($shows as $showList)
                    <a href="{{route($route ?? 'cups.index', array_merge($routeParams??[], ['show' => $showList]))}}">
                        <button class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none
                            @if ($show->is($showList))
                                text-blue-500 border-b-2 font-medium border-blue-500
                            @endif
                            ">
                            {{$showList->name}}
                        </button>
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</div>
