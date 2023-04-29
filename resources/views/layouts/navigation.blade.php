<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('family')" :active="request()->routeIs('family')">
                            {{ __('My Family') }}
                        </x-nav-link>
                    @endauth
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                        {{ __('Categories / Results') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cups.index')" :active="request()->routeIs('cups.index')">
                        {{ __('Cups') }}
                    </x-nav-link>
                    <x-nav-link :href="route('raffle.index')" :active="request()->routeIs('raffle.index')">
                        {{ __('Raffle') }}
                    </x-nav-link>
                    <x-nav-link :href="route('marketing.membership')" :active="request()->routeIs('marketing.membership')">
                        {{ __('PHS Membership') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('subscriptions.index')"
                                    :active="request()->routeIs('subscriptions.index')">
                            {{ __('Membership') }}
                            <div><small>(Experimental)</small></div>
                        </x-nav-link>
                    @endauth

                    @can('logInToNova', Auth::user())
                        <x-nav-link :href="config('nova.url')">
                            {{ __('Admin') }}
                        </x-nav-link>

                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:block">
                <x-dropdown></x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden  mt-4 border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('family')" :active="request()->routeIs('family')">
                    {{ __('My Family') }}
                </x-responsive-nav-link>
            @endauth
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                {{ __('Categories / Results') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cups.index')" :active="request()->routeIs('cups.index')">
                {{ __('Cups') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('raffle.index')" :active="request()->routeIs('raffle.index')">
                {{ __('Raffle') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('subscriptions.index')"
                                       :active="request()->routeIs('subscriptions.index')">
                    {{ __('Membership') }}
                    <div><small>(Experimental)</small></div>
                </x-responsive-nav-link>
            @endauth

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log out') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('My Profile') }}
                    </x-responsive-nav-link>
                </form>
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>

                @can('logInToNova', Auth::user())
                    <x-responsive-nav-link :href="config('nova.url')">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>

                @endcan
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @auth
                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                @endauth
            </div>

            @auth
                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>
