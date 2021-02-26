<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusSalaryInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('status_salary')->nullable()->comment('0=chưa trả lương, 1=đã trả lương')->after('name_upload');
            $table->integer('status_vacc')->default(0)->comment('0=chưa trả, 1=đã trả')->after('status_salary');
            $table->integer('status_vace')->default(0)->comment('0=chưa trả, 1=đã trả')->after('status_vacc');
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
            $table->dropColumn(['status_salary', 'status_vacc', 'status_vace']);
        });
    }
}
