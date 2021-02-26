<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionWaitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_waits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_upload'); // tên đợt upload
            $table->string('slug');
            $table->integer('user_id');
            $table->string('product_type'); // vd: htn1 (hnt2,..) và kte1 (kte2)
            $table->integer('retest')->default(0)->nullable()->comment('số lần thi lại, 0 = không thi lại');
            $table->string('customer_account')->nullable()->comment('mã sát hạch, tài khoản thi');
            $table->string('customer_name')->nullable();
            $table->string('customer_birthday')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_city')->nullable();
            $table->integer('status_exam')->default(0)->comment('0=chưa thi, 1=đã thi');
            $table->date('date_exam')->nullable()->comment('ngày thi');
            $table->string('certificate_code')->nullable()->comment('mã chứng chỉ');
            $table->string('id_card')->nullable()->comment('chứng minh thư');
            $table->date('date_card')->nullable()->comment('ngày cấp cmt');
            $table->string('address_card')->nullable()->comment('ngày cấp cmt');
            $table->string('qualification')->nullable()->comment('trình độ chuyên môn');
            $table->longText('type_exam')->nullable()->comment('lĩnh vực thi');
            $table->string('class')->nullable()->comment('hạng');
            $table->string('province_code')->nullable()->comment('mã tỉnh');
            $table->integer('exper_num')->nullable()->comment('số năm kinh nghiệm');
            $table->string('company')->nullable()->comment('đv công tác');
            $table->string('nation')->nullable()->comment('quốc tịch');
            $table->string('edu_system')->nullable()->comment('hệ đào tạo');
            $table->string('school')->nullable()->comment('cơ sở đào tạo');
            $table->float('price', 10, 2)->nullable()->comment('giá');
            $table->float('prepaid', 10, 2)->nullable()->comment('số tiền đã nộp');
            $table->integer('collaborator')->nullable()->comment('cộng tác viên theo cấp 1,2,3');
            $table->float('discount', 10, 2)->nullable()->comment('chiết khấu');
            $table->string('note')->nullable()->comment('ghi chú');
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
        Schema::dropIfExists('transaction_waits');
    }
}
