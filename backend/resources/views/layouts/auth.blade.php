<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JakaAja - @yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        <!-- Left Side: Image -->
        <div class="hidden md:block relative">
            <img class="absolute inset-0 w-full h-full object-cover" src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=2787&auto=format&fit=crop" alt="Food background">
            <div class="absolute inset-0 bg-black/50"></div>
            
        </div>

        <!-- Right Side: Form -->
        <div class="flex flex-col justify-center items-center px-6 py-12 sm:px-12">
            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')

</body>
</html>