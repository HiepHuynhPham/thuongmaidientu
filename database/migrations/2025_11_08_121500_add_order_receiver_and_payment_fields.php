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
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'receiver_name')) {
                $table->string('receiver_name', 100)->nullable();
            }
            if (!Schema::hasColumn('orders', 'receiver_address')) {
                $table->string('receiver_address', 255)->nullable();
            }
            if (!Schema::hasColumn('orders', 'receiver_phone')) {
                $table->string('receiver_phone', 20)->nullable();
            }

            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method', 50)->default('UNSPECIFIED');
            }
            if (!Schema::hasColumn('orders', 'pay')) {
                $table->boolean('pay')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'pay')) {
                $table->dropColumn('pay');
            }
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('orders', 'receiver_phone')) {
                $table->dropColumn('receiver_phone');
            }
            if (Schema::hasColumn('orders', 'receiver_address')) {
                $table->dropColumn('receiver_address');
            }
            if (Schema::hasColumn('orders', 'receiver_name')) {
                $table->dropColumn('receiver_name');
            }
        });
    }
};
