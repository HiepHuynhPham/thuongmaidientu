<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('product_name');
                $table->text('product_detailDesc')->nullable();
                $table->text('product_shortDesc')->nullable();
                $table->bigInteger('product_price')->default(0);
                $table->string('product_factory')->nullable();
                $table->string('product_target')->nullable();
                $table->string('product_type')->nullable();
                $table->integer('product_quantity')->default(0);
                $table->string('product_image_url')->nullable();
                $table->integer('star')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};