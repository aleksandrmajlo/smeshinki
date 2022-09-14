<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     {!! meta()->toHtml() !!} <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="/js/jquery.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"/>
    <link  rel="stylesheet"  href="{{asset('libs/fancy/dist/fancybox.css')}}" />
    <link  rel="stylesheet"  href="{{asset('libs/select2/css/select2.min.css')}}" />
    <link  href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand"  href="/">
                Smeshinki
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
                    aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        @guest
                            <a class="btn btn-outline-primary" href="{{route('login')}}?wecome=1">
                                Прислати своє привітання
                            </a>
                        @else
                            <a class="btn btn-outline-primary link-modal-js"
                               href="#formsend"
                               data-src="#formsend">Надіслати свій контент</a>
                        @endguest
                    </li>
                </ul>
                <ul class="  navbar-nav d-flex flex-row">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('auth.Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('home') }}">
                                    Мої вподобання
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="https://www.facebook.com/smeshinki.net" rel="nofollow" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href=" https://t.me/smeshinki_net" rel="nofollow" target="_blank">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="https://instagram.com/smeshinki_net" rel="nofollow" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div id="app">
    <main class="my-5">
        <div class="container">
            <section >
              @yield('content')
            </section>
        </div>
    </main>
</div>
<footer class="bg-light text-lg-start">
    <div class="text-center py-4 align-items-center">
        <p>Слідкуйте за нами у соціальних мережах</p>
        <a href="https://www.facebook.com/smeshinki.net" class="btn btn-primary m-1" role="button" rel="nofollow"
           target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://t.me/smeshinki_net" class="btn btn-primary m-1" role="button" rel="nofollow"
           target="_blank">
            <i class="fab fa-telegram"></i>
        </a>
        <a href="https://instagram.com/smeshinki_net" class="btn btn-primary m-1" role="button" rel="nofollow"
           target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        ©  @php echo date('Y');  @endphp Copyright:
        <a class="text-dark" href="/">Smeshinki</a>
    </div>
</footer>
<script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
<script src="{{asset('libs/fancy/dist/fancybox.umd.js')}}"></script>
<script src="{{asset('libs/select2/js/select2.min.js')}}"></script>
@include('all.form')
@include('all.form_subscription')
</body>
</html>
