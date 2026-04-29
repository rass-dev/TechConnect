<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            if (!Schema::hasColumn('shippings', 'user_id')) {
                $table->bigInteger('user_id')->unsigned()->after('id');
            }

            if (!Schema::hasColumn('shippings', 'is_active')) {
                $table->tinyInteger('is_active')->default(1)->after('status');
            }

            if (!Schema::hasColumn('shippings', 'shipping_fee')) {
                $table->decimal('shipping_fee', 8, 2)->default(0)->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            if (Schema::hasColumn('shippings', 'user_id')) {
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('shippings', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('shippings', 'shipping_fee')) {
                $table->dropColumn('shipping_fee');
            }
        });
    }
};
