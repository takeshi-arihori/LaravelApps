<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;

    // 主キーを`name`に設定
    protected $primaryKey = 'name';
    public $incrementing = false; // 自動インクリメントを無効化
    protected $keyType = 'string'; // キーのデータ型を`string`に設定
    protected $guarded = []; // 全カラムのマスアサインメントを許可
}
