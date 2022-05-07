
<div class="sidebar" data-color="orange" data-background-color="white"
     data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo">
        <a href="/" onclick="return false" class="simple-text logo-normal">
            {{ __('PHS Entries') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @if (Auth::check())
                <li class="nav-item{{ $activePage == 'entrants' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('family') }}"><i class="material-icons">dashboard</i>
                        <p>Home</p></a>
                </li>

                @can('create',\App\Models\Entrant::class)
                    <li class="nav-item{{ $activePage == 'add-entrant' ? ' active' : '' }}">
                        <a class="nav-link" href="{{route('entrants.create')}}"><i class="material-icons">group_add</i>
                            <p>@lang('Add another family member')</p></a>
                    </li>
                @endcan

            @else
                <li class="nav-item{{ $activePage == 'sign-in' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}"><i class="material-icons">dashboard</i>
                        <p>Log in</p></a>
                </li>

                    <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('register') }}"><i class="material-icons">dashboard</i>
                            <p>Register</p></a>
                    </li>

            @endif
            <li class="nav-item{{ $activePage == 'categories' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('categories.index')}}"><i class="material-icons">view_list</i>
                    <p>Categories / Results</p></a>
            </li>
            <li class="nav-item{{ $activePage == 'cups' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('cups.index') }}"><i class="material-icons">new_releases</i>
                    <p>Cups</p></a>
            </li>
               @if(Auth::check() && Auth::User()->isAdmin())
                   <li class="nav-item">
                           <a class="nav-link" href="{{ config('nova.url') }}"><i class="material-icons">dashboard</i>
                                   <p>admin</p></a>
                       </li>
                @endif
        </ul>
    </div>
</div>
