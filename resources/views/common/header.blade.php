<nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top">
    <div class="container">
    

        <!-- Logo -->
        <div class="logo" id="pg_logo">
            <img src="{{asset('photos/llm.png')}}" alt="">
        </div>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse d-none d-lg-flex">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item mx-md-3">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>

                <li class="nav-item mx-md-3">
                    <a class="nav-link" href="{{route('about')}}">About Us</a>
                </li>

                <li class="nav-item mx-md-3">
                    <a class="nav-link" href="{{route('amenities')}}">Amenities</a>
                </li>

                <li class="nav-item mx-md-3">
                    <a class="nav-link" href="{{route('rooms')}}">Rooms</a>
                </li>

                <li class="nav-item mx-md-3">
                    <a class="nav-link" href="{{route('contactus')}}">Contact Us</a>
                </li>

                <li class="nav-item dropdown mx-md-3">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Login
                    </a>

                    <ul class="dropdown-menu custom-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{route('registration')}}">
                                Registration
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('login')}}">
                                Login
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <div class="logo" id="pg_logo">
            <img src="{{asset('photos/llm.png')}}" alt="">
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('about')}}">About Us</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('amenities')}}">Amenities</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('rooms')}}">Rooms</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('contactus')}}">Contact Us</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    Login
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('registration')}}">Registration</a></li>
                    <li><a class="dropdown-item" href="{{route('login')}}">Login</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>