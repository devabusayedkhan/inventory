@extends('App')
@section('content')

<div class="h-[80vh] flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <p class="text-xl text-gray-600 mb-6">Oops! Page not found.</p>
        <p class="text-gray-500 mb-8">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
            Go Back Home
        </a>
    </div>
</div>

@endsection