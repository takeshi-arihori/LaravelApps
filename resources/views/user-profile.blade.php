<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - AISuperChat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-900 font-sans">
    <header class="bg-gray-800 text-white" style="height: 30vh;">
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <h1 class="text-3xl font-bold">Welcome to {{ $userInfo['username'] }}'s Profile</h1>
                <p class="mt-3 text-lg">Here you can see profile information.</p>
            </div>
        </div>
    </header>
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto py-12 px-4">
            <!-- Profile Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    <div class="h-24 w-24 rounded-full"><img src="{{ $userInfo['profileImageLink'] }}" alt="">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $userInfo['username'] }}</h2>
                        <p class="mt-2 text-gray-600">{{ $userInfo['description'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-gray-900 text-white text-center p-4">
        <p>© {!! date('Y') !!} AISuperChat Service. All rights reserved.</p>
    </footer>
</body>

</html>
