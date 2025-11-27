<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug')->unique()->after('product_name');
            });
            $products = DB::table('products')->select('id', 'product_name')->get();
            foreach ($products as $p) {
                DB::table('products')->where('id', $p->id)->update([
                    'slug' => Str::slug($p->product_name ?? ''),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};

