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
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @can('index', \App\Tag::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tag.index') }}">Tags</a>
                </li>
            @endcan
            @can('view', \App\User::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                </li>
            @endcan
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
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
                            Profile
                        </a>
                        {{-- User Images --}}
                        <a class="dropdown-item" href="{{ route('images.index') }}">
                            Images
                        </a>
                        {{-- Logout --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
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
