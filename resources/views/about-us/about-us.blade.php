<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About AISuperChat - Next Generation AI Communication</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="flex flex-col min-h-screen bg-gray-100 text-gray-900 font-sans">
        <nav class="bg-gray-900 text-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">    
                    <div>
                        <a href="/" class="flex items-center hover:text-gray-300">                                                  
                            <span class="font-bold">AISuperChat</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/" class="hover:text-gray-300">Home</a>
                        <a href="/about" class="hover:text-gray-300">About</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="hover:text-gray-300">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="hover:text-gray-300">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="hover:text-gray-300">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <header class="bg-gray-800 text-white" style="height: 30vh;">
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <h1 class="text-4xl font-bold">About AISuperChat</h1>
                    <p class="mt-3 text-lg">Revolutionizing Human-AI Communication</p>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-4xl mx-auto py-12 px-4">
                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        At AISuperChat, we're dedicated to bridging the gap between human intelligence and artificial intelligence. Our platform provides a seamless, intuitive interface for meaningful conversations with advanced AI, making cutting-edge technology accessible to everyone.
                    </p>
                </section>

                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">What We Offer</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-4">Advanced AI Technology</h3>
                            <p class="text-gray-700">
                                Experience conversations with state-of-the-art AI models that understand context, nuance, and complex queries.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-4">User-Friendly Interface</h3>
                            <p class="text-gray-700">
                                Our intuitive platform makes it easy to start meaningful conversations with AI, whether you're a tech expert or newcomer.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-4">Secure & Private</h3>
                            <p class="text-gray-700">
                                Your conversations are protected with enterprise-grade security, ensuring your data remains private and secure.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-4">24/7 Availability</h3>
                            <p class="text-gray-700">
                                Access our AI chat service anytime, anywhere, with reliable uptime and consistent performance.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">Why Choose Us</h2>
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Cutting-edge AI technology for natural conversations
                            </li>
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Regular updates and improvements to our AI models
                            </li>
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Dedicated customer support team
                            </li>
                            <li class="flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Flexible pricing plans for different needs
                            </li>
                        </ul>
                    </div>
                </section>

                <section>
                    <h2 class="text-3xl font-bold mb-6">Get Started Today</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-8">
                        Join thousands of users who are already experiencing the future of AI communication. Sign up now and start your journey with AISuperChat.
                    </p>
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Create Your Account
                        </a>
                    </div>
                </section>
            </div>
        </main>
        <footer class="bg-gray-900 text-white text-center p-4">
            <p>© {!! date('Y') !!} AISuperChat Service. All rights reserved.</p>
        </footer>
    </body>
</html>