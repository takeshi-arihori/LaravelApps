<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = []; // 全てのカラムがマスアサインメント可能

    // カロリー計算メソッドの追加
    public function getTotalCalories(): float
    {
        return ($this->protein * 4) + ($this->carbs * 4) + ($this->fat * 9);
    }
}
