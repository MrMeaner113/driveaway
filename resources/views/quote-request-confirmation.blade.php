<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quote Request Received | Drive-Away.ca</title>

    <link rel="icon" type="image/svg+xml" href="/images/fav/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

    <x-navbar />

    <div class="max-w-2xl mx-auto px-4 py-20 text-center">

        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-3">Quote Request Received!</h1>
        <p class="text-lg text-gray-600 mb-2">
            Thank you for contacting Drive-Away.ca.
        </p>
        <p class="text-gray-500 mb-6">
            Our team will review your request and get back to you as soon as possible.
            Please check your email (or phone) for updates.
        </p>

        @if (session('quote_number'))
            <div class="inline-block bg-gray-50 border border-gray-200 rounded-lg px-6 py-4 mb-10">
                <p class="text-lg font-bold text-gray-900">
                    Your quote reference: <span class="text-red-600">{{ session('quote_number') }}</span>
                </p>
                <p class="text-sm text-gray-500 mt-1">Please keep this number for your records.</p>
            </div>
        @else
            <div class="mb-10"></div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="btn-brand px-8 py-3 text-base">
                Back to Home
            </a>
            <a href="{{ route('quote-request.create') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors underline">
                Submit another request
            </a>
        </div>

    </div>

    @fluxScripts
</body>
</html>
