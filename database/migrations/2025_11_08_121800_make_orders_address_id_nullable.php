<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE orders ALTER COLUMN address_id TYPE CHAR(36)');
            DB::statement('ALTER TABLE orders ALTER COLUMN address_id DROP NOT NULL');
        } else {
            DB::statement('ALTER TABLE `orders` MODIFY `address_id` CHAR(36) NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE orders ALTER COLUMN address_id SET NOT NULL');
        } else {
            DB::statement('ALTER TABLE `orders` MODIFY `address_id` CHAR(36) NOT NULL');
        }
    }
};