<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pruneCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('css/leaflet-draw/leaflet.draw.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.rateit/rateit.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/jquery.barrating/themes/fontawesome-stars.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/jquery.barrating/themes/fontawesome-stars-o.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/jquery.barrating/themes/css-stars.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/jquery.barrating/themes/bootstrap-stars.css') }}" rel="stylesheet"></link>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/fontawesome/all.min.js') }}" ></script>
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script src="{{ asset('js/PruneCluster.js') }}"></script>
    <script src="{{ asset('js/leaflet-draw/leaflet.draw.js') }}"></script>
    <script src="{{ asset('js/jquery.rateit/jquery.rateit.min.js') }}"></script>
    <script src="{{ asset('js/jquery.barrating/jquery.barrating.min.js') }}"></script>
    <script type="text/javascript">
        // rename myToken as you like
        window.myToken =  <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    LBSN
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/property/listing">Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/business/listing">Businesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoice.index') }}">Invoices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transaction.index') }}">Transactions</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication as -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a  class="dropdown-item"
                                        href="{{ route('user.index') }}">My Profile</a>
                                    <a  class="dropdown-item"
                                        href="{{ route('property.index') }}">My Properties</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-3">
            @yield('content')
        </main>
    </div>
</body>
</html>
