<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();              // IDカラム
            $table->string('name')->unique();    // 食品名カラム
            $table->double('protein'); // タンパク質量カラム
            $table->double('carbs');   // 炭水化物量カラム
            $table->double('fat');     // 脂肪量カラム
            $table->timestamps();      // 作成・更新日時カラム
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
