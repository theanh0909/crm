<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->integer('sale_id')->after('id');
            $table->integer('discount')->after('price')->comment('số tiền giảm giá')->nullable();
            $table->integer('donate_key')->after('method')->nullable()->comment('1: tặng; 0: không tặng'); //đối với khóa học
            $table->string('donate_product')->after('donate_key')->nullable()->comment('mã sản phẩm tặng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn(['discount', 'donate_key', 'donate_product', 'sale_id']);
        });
    }
}
