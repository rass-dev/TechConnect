<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->double('price', 8, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

}
