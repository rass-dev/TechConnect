<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id'); // user who placed order
            $table->boolean('is_active')->default(true)->after('status'); // to activate/deactivate shipping
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'is_active']);
        });
    }
};
