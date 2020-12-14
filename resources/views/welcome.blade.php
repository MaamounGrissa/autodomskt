<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Work DZ</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <!-- Styles -->
    </head>
    <body>

        <header class="welcom-header">
            <div class="container">
                <div class="left-head">
                    <div class="logo">
                        <a href="/">
                    <img src="{{ asset('images/logo.png')}}" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="right-head">
                    @if (Route::has('login'))
                    <div class="head-links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                    @endif
                </div>
            </div>
        </header>

    <section class="welcom-slider" style="background-image: url({{ asset('images/home-bg.png') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Work DZ</h1>
                    <p>We make it easy</p>

                    @if (Route::has('login'))
                    <div class="slide-links">
                        @auth
                            <a class="mybtn" href="{{ url('/home') }}">Rejoindre</a>
                        @else
                        <div class="link-group flex-start">
                            <a class="mybtn" href="{{ route('login') }}">Connecter</a>
    
                            @if (Route::has('register'))
                                <a class="mybtn" href="{{ route('register') }}">S'inscrire</a>
                            @endif
                        </div>
                        @endauth
                    </div>
                    @endif

                </div>

                <div class="col-md-6">
                    <img src="{{ asset('images/idea.png')}}" alt="Slide">
                </div>
            </div>
        </div>
    </section>

    <section class="categories">
        <div class="container">
            <h2>Découvrez notre catégories</h2>
            <div class="categories-container">
                @foreach ($mainCategories as $mainCategory)
                <div class="category">
                    <div class="content">
                        <div class="icon">
                            <img src="{{ asset('images/admin/' . $mainCategory->image->filename) }}" alt="Icon">
                        </div>
                        <div class="title">
                            <h3>{{ $mainCategory->name }}</h3>
                        </div>
                        <div class="subcategories">
                            <ul>
                                @foreach ($categories as $category)
                                    @if ($category->parent == $mainCategory->id)
                                        <li>{{ $category->name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="{{ asset('js/app.js')}}"></script>
    </body>
</html>
