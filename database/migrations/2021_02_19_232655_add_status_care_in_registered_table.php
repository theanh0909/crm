<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusCareInRegisteredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registered', function (Blueprint $table) {
            $table->integer('status_care')->default(0)->comment('0=chưa chăm sóc, 1=đã chăm sóc')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registered', function (Blueprint $table) {
            $table->dropColumn('status_care');
        });
    }
}
