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
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'paypal_order_id')) {
                $table->string('paypal_order_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            }
            if (!Schema::hasColumn('orders', 'payer_id')) {
                $table->string('payer_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'payer_email')) {
                $table->string('payer_email')->nullable();
            }
            if (!Schema::hasColumn('orders', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('orders', 'currency')) {
                $table->string('currency', 10)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $cols = ['paypal_order_id', 'status', 'payer_id', 'payer_email', 'amount', 'currency'];
            foreach ($cols as $c) {
                if (Schema::hasColumn('orders', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
