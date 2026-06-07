<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowFieldsToBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('banners', function (Blueprint $table) {
        $table->boolean('show_title')->default(0);
        $table->boolean('show_description')->default(0);
        $table->boolean('show_button')->default(0);
    });
}

public function down()
{
    Schema::table('banners', function (Blueprint $table) {
        $table->dropColumn(['show_title', 'show_description', 'show_button']);
    });
}


}
