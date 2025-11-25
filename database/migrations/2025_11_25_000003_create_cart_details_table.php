<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cart_details')) {
            Schema::create('cart_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cart_id')->nullable();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->boolean('cartDetails_checkbox')->default(false);
                $table->integer('cartDetails_quantity')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_details');
    }
};