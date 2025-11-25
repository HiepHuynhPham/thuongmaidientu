<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->char('address_id', 36)->nullable();
                $table->bigInteger('total_price')->default(0);
                $table->string('order_status', 50)->default('pending');
                $table->string('receiver_name', 100)->nullable();
                $table->string('receiver_address', 255)->nullable();
                $table->string('receiver_phone', 20)->nullable();
                $table->string('payment_method', 50)->default('UNSPECIFIED');
                $table->boolean('pay')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};