<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A database for movies." />
    <meta name="author" content="Edward Peña" />
    <link rel="icon" href="{{asset('favicon.ico')}}" />
    <title>My Movie Bank - @yield('title')</title>

    <!-- Font Awesome for icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <!-- Bootstrap as CSS framework -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />

    <!-- My CSS styles -->
    <link href="{{asset('css/global.css')}}" rel="stylesheet" />
    <link href="{{asset('css/comment.css')}}" rel="stylesheet" />
    <link href="{{asset('css/card.css')}}" rel="stylesheet" />
    <link href="{{asset('css/modal.css')}}" rel="stylesheet" />

    <!-- Bootstrap scripts -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
      defer
    ></script>

    <!-- My scripts -->
    <script src="{{asset('js/navBar.js')}}" defer></script>
  </head>
  <body>
  <div class="container">
      <header class="row">
        <div class="col">
          <img src="{{asset('images/MyMovieDBIcon.png')}}" alt="My Movie DB Icon" />
          <h1>My Movie Bank</h1>
        </div>
      </header>

      <nav class="navBar" id="navigator">
        <a href="{{ route('movies.shownow') }}" <?php if ($activeLink == "index") echo 'class="active"'; ?>>Showing Now</a>
        <a href="{{ route('movies.coming') }}" <?php if ($activeLink == "coming") echo 'class="active"'; ?>>Coming Soon</a>
        <a href="{{ route('movies.top') }}" <?php if ($activeLink == "top") echo 'class="active"'; ?>>Top 10</a>
        <a href="{{ route('movies.popular') }}" <?php if ($activeLink == "popular") echo 'class="active"'; ?>>Most Popular</a>
        
        @auth
        <a href="{{ route('favorite.show') }}" <?php if ($activeLink == "favorites") echo 'class="active"'; ?>>Favorites</a>
        <a href="{{ route('wishlist.show') }}" <?php if ($activeLink == "wishes") echo 'class="active"'; ?>>Wish List</a>
        @endauth

        <a href="{{ route('movies.about') }}" <?php if ($activeLink == "about") echo 'class="active"'; ?>>About Us</a>
        <a href="{{ route('movies.contact') }}" <?php if ($activeLink == "contact") echo 'class="active"'; ?>>Contact Us</a>

        @guest
        <a href="{{ route('login') }}" class="active">Log In</a>
        <a href="{{ route('register') }}" class="registrationButton">Register Now</a>
        @else
        <a id="navbarDropdown" class="dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            @if (Auth::user()->isAdmin == 1)
            <a class="dropdown-item" href="{{ route('admin.controlpanel') }}">Control Panel</a>
            @endif
            <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endguest
        
        <a href="javascript:void(0);" class="icon" onclick="changeNav()">
          <i class="fa fa-bars"></i>
        </a>
      </nav>

      <section class="row gy-2" id="cardContent">
        @yield('content')
      </section>

      <footer class="row">
        <div class="col-12">
          <ul>
            <li>
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa-brands fa-facebook"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa-brands fa-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa-brands fa-google-plus"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </li>
            <li>
              <a href="#"><i class="fa-brands fa-linkedin"></i></a>
            </li>
          </ul>
        </div>

        <div class="col-12 footer-bottom">
          Copyright &copy;<span><?php echo date("Y"); ?></span> <a href="#">Edward Peña</a>
        </div>
      </footer>
    </div>
  </body>
</html>