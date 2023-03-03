<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/dbc5b98639.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <form action="{{route('home')}}" method="get">
                            {{-- getを使う場合、@csrfはいらない。プライバシーを守る必要がないから。 --}}
                            <input type="text" name="search" placeholder="Search..." class="form-control form-control-sm">
                        </form>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- home --}}
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link">
                                    <i class="fa-solid fa-house text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- add post --}}
                            <li class="nav-item">
                                <a href="{{route('post.create')}}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- user menu or drop-down --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link btn shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" alt="" class="rounded-circle avatar-sm">
                                    @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                              
                                    {{-- admin --}}
                                    @can('admin')
                                    <a href="{{route('admin.users')}}" class="dropdown-item">
                                        <i class="fa-solid fa-user-gear"></i> Admin
                                    </a>
                                    <hr class="dropdown-divider">
                                    @endcan

                                    {{-- profile --}}
                                    <a href="{{ route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket text-dark"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5 container">
            <div class="row justify-content-center">
                {{-- urlがadmin/だった場合 --}}
                @if(request()->is('admin*'))
                <div class="col-3">
                    <div class="list-group">
                        <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users*') ? 'active' : ''}}">
                            {{-- if statement ? true : false --}}
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                        <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts*') ? 'active' : ''}}">
                            <i class="fa-solid fa-newspaper"></i> 
                            Posts
                        </a>
                        <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories*') ? 'active' : ''}}">
                            <i class="fa-solid fa-tags"></i> Categories
                        </a>
                    </div>
                </div>
                @endif

                <div class="col-9">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
