<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDecreeInTransactionWatis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_waits', function (Blueprint $table) {
            $table->longText('decree')->after('qualification')->nullable()->comment('Lĩnh vực theo nghị định');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_waits', function (Blueprint $table) {
            $table->dropColumn('decree');
        });
    }
}
