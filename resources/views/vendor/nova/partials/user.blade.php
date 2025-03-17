<dropdown-trigger class="h-9 flex items-center">
    @isset($user->email)
        <img
            src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($user->email)) }}?size=512"
            class="rounded-full w-8 h-8 mr-3"
        />
    @endisset

    <span class="text-90">
        {{ $user->name ?? $user->email ?? __('Nova UserResource') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            <a href="{{ route('members.list') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Membership Renewal Tool') }}
            </a>
        </li>
        <li>
            <a href="{{ route('family') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Your Family Page') }}
            </a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Categories') }}
            </a>
        </li>
        <li>
            <a href="{{ route('cups.index') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Cups') }}
            </a>
        </li>
        <li>
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Log out') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
