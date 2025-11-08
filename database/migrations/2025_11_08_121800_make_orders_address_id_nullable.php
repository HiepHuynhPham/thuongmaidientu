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
        // Đổi cột address_id thành cho phép NULL để phù hợp với logic tạo đơn
        DB::statement('ALTER TABLE `orders` MODIFY `address_id` CHAR(36) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Trả lại NOT NULL nếu cần (lưu ý có thể lỗi nếu dữ liệu đang NULL)
        DB::statement('ALTER TABLE `orders` MODIFY `address_id` CHAR(36) NOT NULL');
    }
};