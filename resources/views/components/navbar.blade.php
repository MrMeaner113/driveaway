<nav class="site-navbar">
    <a href="{{ url('/') }}" class="site-navbar__brand">
        <img src="/images/logo.png" alt="Drive-Away.ca" style="height: 38px; width: auto;">
    </a>

    <ul class="site-navbar__links">
        <li><a href="#features">Why Us</a></li>
        <li><a href="#how-it-works">How It Works</a></li>
        <li><a href="#QuoteRequest">Get a Quote</a></li>
        @auth
            <li>
                <a href="{{ url('/dashboard') }}" class="btn-brand" style="padding: 0.5rem 1.1rem; font-size: 0.9rem;">
                    Dashboard
                </a>
            </li>
        @else
            <li><a href="{{ route('login') }}">Sign In</a></li>
            <li>
                <a href="{{ route('register') }}" class="btn-brand" style="padding: 0.5rem 1.1rem; font-size: 0.9rem;">
                    Register
                </a>
            </li>
        @endauth
    </ul>
</nav>
