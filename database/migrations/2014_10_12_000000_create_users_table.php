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
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('role_name');
                $table->string('role_description');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('user_name');
                $table->string('user_email')->unique();
                $table->string('user_password');
                $table->string('user_phone', 20)->nullable();
                $table->string('user_address');
                $table->text('user_avatar')->nullable();
                $table->foreignId('role_id')->constrained('roles');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_addresses')) {
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->uuid('address_id')->primary();
                $table->foreignId('user_id')->constrained('users');
                $table->text('address');
                $table->string('address_type');
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
