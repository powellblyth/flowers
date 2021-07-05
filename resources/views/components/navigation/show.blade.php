<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white">
            <nav class="flex flex-col sm:flex-row">
                @foreach ($shows as $showNav)
                    <a href="{{route($route ?? 'cups.index', ['show'=>$showNav])}}">
                        <button class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none
                            @if ($show->id === $showNav->id)
                                text-blue-500 border-b-2 font-medium border-blue-500
                            @endif
                            ">
                            {{$showNav->name}}
                        </button>
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</div>
