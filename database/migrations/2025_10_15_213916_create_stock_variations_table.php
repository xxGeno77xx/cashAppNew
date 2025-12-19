<?php

use App\Enums\StockVariationsEnums;
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
        Schema::create('stock_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
            $table->integer('current_stock_value');
            $table->integer('variation_stock_value');
            $table->integer('new_stock_value');
            $table->enum('type', [
                StockVariationsEnums::Add()->value,
                StockVariationsEnums::Sub()->value,
            ]);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_variations');
    }
};
