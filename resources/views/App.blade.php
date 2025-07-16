<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>daskZone</title>

    <!-- loader js -->
    <script src="{{asset('js/loader.js')}}"></script>
    {{-- helper js --}}
    <script src="{{asset('helper/helper.js')}}"></script>
     <!-- tailwind css cdn -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- AlpineJS for toggle -->
    <script defer src="https://unpkg.com/alpinejs" defer></script>

    <!-- jquery -->
    <script src="js/jquery-3.7.1.min.js"></script>
     <link rel="stylesheet" href="{{ asset("css/dataTables.dataTables.min.css") }}">
     <script src="js/dataTables.min.js"></script>
    
    <!-- css link -->
    <link rel="stylesheet" href="{{ asset('css/loginRegister.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- FontAwesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    @include('components/Header')
        @yield('content')
    @include('components/Footer')



        <!-- sweet alert 2 cdn -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>