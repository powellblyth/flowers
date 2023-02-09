
<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="w-48">
        @auth
            {{ Auth::user()->full_name }}
        @endauth
        @guest
            Welcome, Guest
        @endguest

        <div class="relative inline-block ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 w-64 mt-2 rounded-md shadow-lg origin-top-right right-0"
         @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('My Profile') }}
                        </x-dropdown-link>
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
                    <x-dropdown-link :href="route('register')">
                        {{ __('Register') }}
                    </x-dropdown-link>
                @endif
            </div>
        </div>
    </div>
</div>
