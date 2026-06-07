<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::dropIfExists('shippings');
}

public function down()
{
    Schema::create('shippings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->decimal('price', 8, 2);
        $table->timestamps();
    });
}

}
