<nav class="navbar navbar-expand-lg bg-transparent">
    <div class="container-fluid">
        <a class="navbar-brand text-purple" href="{{ route('dashboard.index') }}">beWise</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav ml-auto">
            @guest
                <a class="nav-link text-purple" href="{{ route('login') }}">Login</a>
                <a class="nav-link text-purple" href="{{ route('register') }}">Register</a>
            @else
                <div class="dropdown">
                    <button class="btn dropdown-toggle text-purple" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Welcome, {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-purple" href="{{ route('myprofile') }}"><i class="fas fa-user"></i> My Account</a></li>
                        <li><a class="dropdown-item text-purple" href="{{ route('mydonation') }}"><i class="fas fa-donate"></i> My Donation</a></li>
                        <li><a class="dropdown-item text-purple" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>
