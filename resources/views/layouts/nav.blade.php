<nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarToggler" aria-controls="navbarToggler"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggler">
        <a class="navbar-brand" href="#">Simple Blog</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="/">{{ __('partials.nav.home') }} <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('partials.nav.about') }}</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @can('index', \App\Tag::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tag.index') }}">{{ __('partials.nav.admin.tags') }}</a>
                </li>
            @endcan
            @can('view', \App\User::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">{{ __('partials.nav.admin.users') }}</a>
                </li>
            @endcan
            @can('index', \App\Image::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('images.admin.index') }}">{{ __('partials.nav.admin.images') }}</a>
                </li>
            @endcan
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('partials.nav.login') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('partials.nav.register') }}</a></li>
            @else
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>
                            @if(auth()->user()->hasAvatar())
                                <img class="avatar small"
                                     src="{{ route('images.avatar', ['image' => auth()->user()->avatar ]) }}">
                            @else
                                <img class="avatar small" src="{{ asset('images/person.png') }}">
                            @endif
                        </span>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu">
                        {{-- User Profile --}}
                        <a class="dropdown-item" href="{{ route('profile.show', ['user' => auth()->user()->id]) }}">
                            {{ __('partials.nav.profile') }}
                        </a>
                        {{-- User Images --}}
                        <a class="dropdown-item" href="{{ route('images.index') }}">
                            {{ __('partials.nav.images') }}
                        </a>
                        {{-- Logout --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('partials.nav.logout') }}
                        </a>

                        <form class="dropdown-item" id="logout-form"
                              action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
