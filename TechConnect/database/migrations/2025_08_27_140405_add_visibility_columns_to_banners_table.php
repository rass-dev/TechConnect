<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Check if table exists first
        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->boolean('show_title')->default(1)->after('status');
                $table->boolean('show_description')->default(1)->after('show_title');
                $table->boolean('show_button')->default(0)->after('show_description');
                $table->string('button_url')->nullable()->after('show_button');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->dropColumn(['show_title', 'show_description', 'show_button', 'button_url']);
            });
        }
    }
};
