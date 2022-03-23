
<div align="right"  class="relative" x-on:click.away="if($wire.get('hidden')==false) { $wire.hide() }">
    @if($hidden)
        <div wire:click="toggle()">
            <button
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                @if(Auth::check())
                    <div>{{ Auth::user()->full_name }} </div>
                @else
                    <div>Welcome, Guest</div>
                @endif

                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </button>
        </div>

    @else
        <div
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 w-20 rounded-md shadow-lg origin-top-right right-0"
            livewire:click="toggle()">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log out') }}
                        </x-dropdown-link>
                    </form>
                @else
                    <x-dropdown-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-dropdown-link>
                @endif
            </div>
        </div>
    @endif
</div>
