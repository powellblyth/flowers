<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
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
        <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a  class="nav-link" href="{{ url('/home') }}"><i class="material-icons">dashboard</i><p>Home</p></a>
        </li>

      @if(Auth::User()->isAdmin())
          <li class="nav-item{{ $activePage == 'allentrants' ? ' active' : '' }}">
          <a class="nav-link" href="{{route('entrants.searchall')}}"><i class="material-icons">people-outline</i><p>All Entrants</p></a>
          </li>
      @endif
        <li class="nav-item{{ $activePage == 'entrants' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('entrants.index')}}"><i class="material-icons">people</i><p>My Family</p></a>
        </li>

        <li class="nav-item{{ $activePage == 'add-entrant' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('entrants.create')}}"><i class="material-icons">group_add</i><p>Add a family member</p></a>
        </li>

      @else
        <li class="nav-item{{ $activePage == 'sign-in' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('/login') }}"><i class="material-icons">dashboard</i><p>Sign in</p></a>
        </li>

        <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('/register') }}"><i class="material-icons">dashboard</i><p>Register</p></a>
        </li>

      @endif
        <li class="nav-item{{ $activePage == 'categories' ? ' active' : '' }}">
      <a class="nav-link" href="{{route('categories.index')}}"><i class="material-icons">view_list</i><p>Categories / Results</p></a>
        </li>

        <li class="nav-item{{ $activePage == 'cups' ? ' active' : '' }}">
      <a class="nav-link" href="{{ url('/cups') }}"><i class="material-icons">new_releases</i><p>Cups</p></a>
        </li>

      @if(Auth::check() && Auth::User()->isAdmin())
              <li class="nav-item{{ $activePage == 'reports' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('reports.index') }}"><i class="material-icons">dashboard</i><p>Reports</p></a>
              </li>
              <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('users.index') }}"><i class="material-icons">dashboard</i><p>Users</p></a>
              </li>

        @endif

{{--      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('home') }}">--}}
{{--          <i class="material-icons">dashboard</i>--}}
{{--            <p>{{ __('Dashboard') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">--}}
{{--        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">--}}
{{--          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>--}}
{{--          <p>{{ __('Laravel Examples') }}--}}
{{--            <b class="caret"></b>--}}
{{--          </p>--}}
{{--        </a>--}}
{{--        <div class="collapse show" id="laravelExample">--}}
{{--          <ul class="nav">--}}
{{--            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">--}}
{{--              <a class="nav-link" href="{{ route('profile.edit') }}">--}}
{{--                <span class="sidebar-mini"> UP </span>--}}
{{--                <span class="sidebar-normal">{{ __('User profile') }} </span>--}}
{{--              </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">--}}
{{--              <a class="nav-link" href="{{ route('user.index') }}">--}}
{{--                <span class="sidebar-mini"> UM </span>--}}
{{--                <span class="sidebar-normal"> {{ __('User Management') }} </span>--}}
{{--              </a>--}}
{{--            </li>--}}
{{--          </ul>--}}
{{--        </div>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('table') }}">--}}
{{--          <i class="material-icons">content_paste</i>--}}
{{--            <p>{{ __('Table List') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('typography') }}">--}}
{{--          <i class="material-icons">library_books</i>--}}
{{--            <p>{{ __('Typography') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('icons') }}">--}}
{{--          <i class="material-icons">bubble_chart</i>--}}
{{--          <p>{{ __('Icons') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('map') }}">--}}
{{--          <i class="material-icons">location_ons</i>--}}
{{--            <p>{{ __('Maps') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('notifications') }}">--}}
{{--          <i class="material-icons">notifications</i>--}}
{{--          <p>{{ __('Notifications') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('language') }}">--}}
{{--          <i class="material-icons">language</i>--}}
{{--          <p>{{ __('RTL Support') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">--}}
{{--        <a class="nav-link" href="{{ route('upgrade') }}">--}}
{{--          <i class="material-icons">unarchive</i>--}}
{{--          <p>{{ __('Upgrade to PRO') }}</p>--}}
{{--        </a>--}}
{{--      </li>--}}
    </ul>
  </div>
</div>