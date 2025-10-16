<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Roles Table
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Để hàm constrained() tự nhận diện
            $table->string('role_name');
            $table->string('role_description');
            $table->timestamps();
        });

        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Để hàm constrained() tự nhận diện
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->string('user_password');
            $table->string('user_phone', 20)->nullable();
            $table->string('user_address');
            $table->text('user_avatar')->nullable();
            $table->foreignId('role_id')->constrained('roles'); // Khóa ngoại đúng định dạng
            $table->timestamps();
        });

        // UserAddresses Table
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->uuid('address_id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->text('address');
            $table->string('address_type');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_detailDesc')->nullable();
            $table->text('product_shortDesc')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->text('product_factory')->nullable();
            $table->text('product_target')->nullable();
            $table->text('product_type')->nullable();
            $table->integer('product_quantity');
            $table->text('product_image_url');
            $table->timestamps();
        });

        // ProductDiscounts Table
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('discount_price', 10, 2);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
        });

        // Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->uuid('address_id');
            $table->decimal('total_price', 10, 2);
            $table->string('order_status', 50);
            $table->timestamps();
        });

        // Shippings Table
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders');
            $table->uuid('address_id');
            $table->string('shipping_method', 50);
            $table->string('shipping_status', 50)->default('Đang chuẩn bị');
            $table->timestamp('estimated_delivery_date')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });

        // OrderDetails Table
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->boolean('pay')->default(false);
            $table->text('payment_method')->nullable();
            $table->decimal('price', 10, 2);
        });

        // Cart Table
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_sum')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // CartDetails Table
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->boolean('cartDetails_checkbox')->default(false);
            $table->bigInteger('cartDetails_quantity');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('cart_id')->constrained('cart');
        });

        // Reviews Table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('rating')->checkBetween(1, 5);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('cart_details');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('shippings');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('product_discounts');
        Schema::dropIfExists('products');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};