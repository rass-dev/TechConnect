<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    // Schema::table('orders', function (Blueprint $table) {
    //     $table->unsignedBigInteger('shipping_id')->nullable()->after('post_code');
    // });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('shipping_id');
    });
}

}
