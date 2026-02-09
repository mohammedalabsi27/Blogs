@php
  $headerCategories = App\Models\Category::get();
@endphp

<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="{{ route('theme.index') }}"><img src="{{ asset('assets') }}/img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav justify-content-center">
              
              
              {{-- @php
                $route = Illuminate\Support\Facades\Route::currentRouteName();
                $language = request()->segment(1) == 'ar' ? 'en' : 'ar'
              @endphp
              <li class="nav-item"><a class="nav-link" href="{{ route($route, ['locale' => $language]) }}" >{{ strtoupper($language) }}</a></li>  --}}
              @php
                $language = request()->segment(1) == 'ar' ? 'en' : 'ar'
              @endphp
              <li class="nav-item"><a class="nav-link" href="{{ LaravelLocalization::getLocalizedURL($language) }}" >{{ strtoupper($language) }}</a></li>  
              <li class="nav-item @yield('home-active')"><a class="nav-link" href="{{ route('theme.index') }}">{{ __('keywords.home') }}</a></li> 
              <li class="nav-item submenu dropdown  @yield('categories-active')">
                <a href="#{{-- route('theme.category') --}}" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">{{ __('keywords.categories') }}</a>
                  @if (count($headerCategories))
                    <ul class="dropdown-menu">
                      @foreach ($headerCategories as $category)
                      <li class="nav-item"><a class="nav-link" href="{{ route('theme.category', $category->id) }}">{{ $category->name }}</a></li>
                      @endforeach
                    </ul> 
                  @endif

              </li>
              <li class="nav-item @yield('contact-active')"><a class="nav-link" href="{{ route('theme.contact') }}">{{ __('keywords.contact') }}</a></li>
            </ul>
            
            <!-- Add new blog -->
            @if (Auth::check())
              <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-primary mr-2">Add New</a>
            @endif
            <!-- End - Add new blog -->

            <ul class="nav navbar-nav navbar-right navbar-social">
              @if (!Auth::check())
              <a href="{{ route('register') }}" class="btn btn-sm btn-warning">Register / Login</a> 
               @else
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">{{ Auth::user()->name }}</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="{{ route('blogs.my-blogs') }}">My Blogs</a></li>
                  <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post" id="form_logout">
                      @csrf
                      <a href="javascript:$('form#form_logout').submit();" class="nav-link" >Logout</a>
                    </form>
                  </li>
                </ul>
              </li>
              @endif
              
            </ul>
          </div> 
        </div>
      </nav>
    </div>
  </header>