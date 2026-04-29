<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('banners', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->string('photo')->nullable();
        $table->text('description')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('inactive');

        // Add the missing columns
        $table->boolean('show_title')->default(0);
        $table->boolean('show_description')->default(0);
        $table->boolean('show_button')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
