<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Restaurant and cafe management program and create a digital menu for the restaurant or cafe">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
</head>
<body class="bg-body" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
    <div id="app">
        @if (Route::currentRouteName() != 'store' && Route::currentRouteName() != 'store.menu' && Route::currentRouteName() != 'invoice.print')
        <nav class="navbar navbar-expand-md  navbar-dark bg-dark  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                    {{-- {{Route::currentRouteName()}} --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"> @lang('site.login') </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"> @lang('site.register') </a>
                                </li>
                            @endif
                        @else
                            @empty (!Auth::user()->where('id', Auth::id())->with('positions.store')->first()->positions)
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-store mr-1 ml-1"></i> @lang('site.your_store')
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        {{-- @foreach (Auth::user()->where('id', Auth::id())->with('positions.store')->first()->positions as $position)
                                            <li><a class="dropdown-item mt-1 ml-1" target="_blank" href="{{route('store', $position->store_id)}}"> {{$position->store->name}} </a></li>
                                        @endforeach --}}
                                    </ul>
                                </div>
                            @endempty

                            <li class="nav-item mr-2 ml-2">
                                <a class="nav-link text-light" href="{{ route('home.create-store') }}"> <i class="fas fa-shop mr-1 ml-"></i> Create Store</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        @lang('site.logout')
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
        @endif

        <main>
            @yield('content')
        </main>
        {{-- Language Box --}}
        <div class="dropdown btn-group dropup dropdown-btn-position" style=" {{app()->getLocale() == 'ar' ? 'left: 20px; right:auto' : '' }}">
            <button class="btn btn-warning bg-new-warning bold text-uppercase " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
            >
                {{-- <i class="fas fa-globe mr-1 ml-1"></i> --}}
                    {{app()->getLocale()}}
            </button>
            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenuLink">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li>
                        <a rel="alternate" class="dropdown-item text-center mt-1 mb-1" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        {{-- End Language Box --}}
        @if ( Route::currentRouteName() != 'invoice.print')
        <div>
            <footer>
                <div
                    class="col-md-12 d-fixed bottom-0 bg-d-blue text-light text-center p-3 row"
                >
                    <div class="col-md-4 p-0">
                        &copy; Copyright 2022, S K o K r e Y Platform
                    </div>
                    <div class="col-md-8 p-0">
                        <div class="row">
                            <div class="col-md-4">Contact The Company :</div>
                            <div class="col-md-4">
                                <a
                                    href="mailto:abdoshokrey68@gmail.com"
                                    class="text-light link"
                                    >abdoshokrey68@gmail.com</a
                                >
                            </div>
                            <div class="col-md-4">
                                <a href="tel:+201129899520" class="text-light link"
                                    >+201129899520</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @endif

    </div>
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
