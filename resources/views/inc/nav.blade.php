<nav class="navbar navbar-expand-lg navbar-dark bg-dark pt pb">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon faz"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
          <li class="nav-item">
            <a class="nav-link active dis-2 navbtn" href="{{route('test.search')}}">Tests</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active dis-4 navbtn" aria-current="page" href="{{route('create')}}">Create</a>
          </li>
        @endauth
        <li class="nav-item">
          <a class="nav-link active dis-1 navbtn" href="{{route('home')}}">Z-TESTER</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active dis-3 navbtn" href="{{route('faq.view')}}">About</a>
        </li>
      </ul>
      @auth
        <a href="{{route('logout')}}"><button class="btn btn-outline-light">Log out</button></a> | 
        <a href="{{route('profile')}}"><button class="btn btn-outline-light">Profile</button></a>
      @else
        <div>
          <a href="{{route('login.view')}}"><button class="btn btn-outline-light">Log in</button></a> | 
          <a href="{{route('register.view')}}"><button class="btn btn-outline-light">Sign in</button></a>
        </div>
      @endauth
    </div>
  </div>
</nav>