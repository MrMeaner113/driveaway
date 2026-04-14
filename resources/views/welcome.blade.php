<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Drive-Away.ca | Vehicle Transport Across Canada</title>


    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/images/fav/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="/images/fav/favicon.svg">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/fav/favicon-96x96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/fav/apple-touch-icon.png">
    <link rel="manifest" href="/images/fav/site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <!-- Navigation -->
    <x-navbar />

    <!-- Hero Section -->
    <div class="hero-banner min-h-100 md:min-h-125 lg:min-h-150 bg-cover bg-center bg-no-repeat relative"
         style="background-image: url('/images/dac0022.jpg');">

        <!-- Get a Quote - bottom left -->
        <div class="absolute bottom-6 left-6 z-10">
            <a href="#QuoteRequest" class="btn-brand">Get a Quote</a>
        </div>

        <!-- Contact Us - bottom right -->
        <div class="absolute bottom-6 right-6 z-10">
            <a href="#features" class="btn-outline-white">Contact Us</a>
        </div>
    </div>

    <!-- Road Divider -->
    <div class="road-divider">
        <div class="road-divider__top"></div>
        <div class="road-divider__stripe"><div class="road-divider__stripe-inner"></div></div>
        <div class="road-divider__bottom"></div>
    </div>

    <!-- Features Section -->
    <section id="features">
        <div style="max-width:1200px; margin:0 auto; padding:0 20px;">
            <div class="section-accent"></div>
            <h2 class="section-title">Why Choose Drive-Away?</h2>
            <p class="text-muted" style="margin-bottom:2rem;">Canada's most trusted vehicle transport network</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <div class="card-green">
                    <div class="card-value">500+</div>
                    <div class="card-label">Vehicles Transported Monthly</div>
                </div>
                <div class="card-green">
                    <div class="card-value">24/7</div>
                    <div class="card-label">Real-Time Tracking</div>
                </div>
                <div class="card-green">
                    <div class="card-value">100%</div>
                    <div class="card-label">Canadian Owned &amp; Operated</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" style="background: var(--bg-soft);">
        <div style="max-width:1200px; margin:0 auto; padding:0 20px;">
            <div class="section-accent"></div>
            <h2 class="section-title">How It Works</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <div class="card">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">📋</div>
                    <h3 style="font-weight:700; margin-bottom:0.5rem;">1. Request a Quote</h3>
                    <p class="text-muted">Tell us your pickup and delivery locations</p>
                </div>
                <div class="card">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">🤝</div>
                    <h3 style="font-weight:700; margin-bottom:0.5rem;">2. We Match You</h3>
                    <p class="text-muted">Get connected with a verified carrier</p>
                </div>
                <div class="card">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">🚚</div>
                    <h3 style="font-weight:700; margin-bottom:0.5rem;">3. Track &amp; Deliver</h3>
                    <p class="text-muted">Real-time updates until arrival</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="QuoteRequest">
        <div style="max-width:800px; margin:0 auto; text-align:center; padding:0 20px;">
            <h2 class="section-title">Ready to Move Your Vehicle?</h2>
            <p class="text-muted" style="margin-bottom:1.5rem;">Join thousands of satisfied customers who trust Drive-Away</p>
            <a href="{{ route('register') }}" class="btn-brand" style="display:inline-block;">Get Your Free Quote</a>
        </div>
    </section>

    <!-- Footer Bar -->
    <div class="footer-bar">
        <p>&copy; {{ date('Y') }} Drive-Away.ca. All rights reserved.</p>
        <div>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </div>
    </div>

    <!-- Fade-in Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            });
            document.querySelectorAll('.card, .card-green').forEach(el => {
                el.classList.add('fade-in');
                observer.observe(el);
            });
        });
    </script>

</body>
</html>
