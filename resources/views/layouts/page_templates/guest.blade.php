@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black"
         style="background-image: url('/images/hero/hero-small.png'); background-size: cover; background-position: top center;align-items: center;"
         data-color="purple">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="container" style="height: auto;">
            @yield('content')
        </div>
        @include('layouts.footers.guest')
    </div>
</div>
