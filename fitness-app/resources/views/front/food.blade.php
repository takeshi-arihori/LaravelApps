<x-front-layout>
    <x-slot:title>MyFitnessTracker Food Items</x-slot:title>

    <h1 class="text-4xl font-bold mb-4 text-blue-500">Food Items</h1>
    <p class="text-lg mb-6">Discover various food items and their nutritional values. Eat healthy and stay fit!</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($foodItems as $foodItem)
            <x-cards.food-item-card :food="$foodItem" color="blue" />
        @endforeach
    </div>
</x-front-layout>
