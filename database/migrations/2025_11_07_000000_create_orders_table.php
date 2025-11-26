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
                $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
                $table->string('receiver_name', 100)->nullable();
                $table->string('receiver_address', 255)->nullable();
                $table->string('receiver_phone', 20)->nullable();
                $table->string('payment_method', 50)->default('UNSPECIFIED');
                $table->boolean('pay')->default(false);
                $table->string('paypal_order_id')->nullable();
                $table->string('payer_id')->nullable();
                $table->string('payer_email')->nullable();
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('currency', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
