<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function food(Request $request): View
    {
        return view('dashboard.food', [
            'foodTypes' => FoodType::all(),
            'food' => Food::query()->orderByDesc('created_at')->paginate(10)
        ]);
    }
}
