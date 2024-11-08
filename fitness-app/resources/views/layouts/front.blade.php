<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 h-screen flex flex-col">
    <nav class="bg-gray-300 p-4 h-20">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-bold text-gray-800">{{ env('APP_NAME') }}</div>
            <ul class="flex space-x-4">
                <li><a href="#" class="hover:text-gray-600">Home</a></li>
                <li><a href="#" class="hover:text-gray-600">Food</a></li>
                <li><a href="#" class="hover:text-gray-600">Calculator</a></li>
                <li><a href="#" class="hover:text-gray-600">About</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mx-auto p-8 max-w-4xl h-auto grow">
        {{ $slot }}
    </main>

    <footer class="bg-gray-300 p-4 mt-8 h-20">
        <div class="container mx-auto text-center">
            <p class="text-gray-800">{{ date('Y') }}</p>
        </div>
    </footer>
</body>

</html>
