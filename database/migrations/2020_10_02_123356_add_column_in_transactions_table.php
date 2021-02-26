<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('retest')->default(0)->comment('số lần thi lại, 0 = không thi lại');
            $table->string('customer_birthday')->nullable();
            $table->string('customer_account')->nullable()->comment('mã sát hạch, tài khoản thi');
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
            $table->integer('collaborator')->nullable()->comment('cộng tác viên theo cấp 1,2,3');
            $table->string('name_upload')->nullable()->comment('tên đợt upload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['retest', 'customer_birthday', 'customer_account', 'status_exam', 'date_exam']);
        });
    }
}
