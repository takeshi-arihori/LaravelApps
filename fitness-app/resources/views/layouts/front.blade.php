<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 h-screen flex flex-col">

    @include('layouts.front.nav')

    <main class="container mx-auto p-8 max-w-4xl h-auto grow">
        {{ $slot }}
    </main>

    @include('layouts.front.footer')

    @isset($js)
        {{ $js }}
    @endisset

</body>

</html>
