<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product');
            $table->integer('product_type')->comment('0 = khóa mềm, 1 = khóa cứng, 2 = học viên, 3 = chứng chỉ');
            $table->integer('qty')->comment('số lượng mua');
            $table->double('price', 20, 2)->comment('đơn giá'); //Để integer bị lỗi khi nhập liệu
            $table->integer('number_day')->nullable()->comment('số ngày dùng');
            $table->integer('key_type')->nullable()->comment('Loại key: thương mại or thử nghiệm');
            $table->string('method')->nullable()->comment('phương thức học on hoặc off');
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
        Schema::dropIfExists('sale_details');
    }
}
