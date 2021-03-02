<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionIdInSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->integer('transaction_id')->nullable()->after('sale_id'); // liên kết tới bảng transaction để khi xóa đơn thì không còn nợ nữa
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
            $table->dropColumn('transaction_id');
        });
    }
}
