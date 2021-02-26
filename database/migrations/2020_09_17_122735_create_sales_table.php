<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('note')->nullable();
            $table->double('total', 20, 2);  //Để integer bị lỗi khi nhập liệu
            $table->double('prepaid', 20, 2)->nullable();  //Để integer bị lỗi khi nhập liệu
            $table->integer('status_prepaid')->default(0)->comment('0 = trả đủ, 1 = thiếu, 2=đợi sếp duyệt');
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
        Schema::dropIfExists('sales');
    }
}
