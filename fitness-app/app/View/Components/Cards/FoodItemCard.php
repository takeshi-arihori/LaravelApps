<?php

namespace App\View\Components\Cards;

use App\Models\Food;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FoodItemCard extends Component
{
    public Food $food;
    public string $color;

    /**
     * Create a/ new component instance.
     */
    public function __construct(Food $food, string $color)
    {
        $this->food = $food;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.food-item-card');
    }
}
