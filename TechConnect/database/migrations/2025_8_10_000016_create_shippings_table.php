<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('shippings', function (Blueprint $table) {
        $table->id();
        $table->string('title');          // e.g., Standard, Express
        $table->decimal('price', 8, 2);   // shipping fee
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('shippings');
}

}
