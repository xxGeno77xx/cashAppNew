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
        Schema::create('packagings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pakaging_option_id');
            $table->foreign('pakaging_option_id')->references('id')->on('pakaging_options');
            $table->integer('price');
            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('id')->on('produits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packagings');
    }
};
