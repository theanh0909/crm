<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('birthday')->nullable();
            $table->string('company')->nullable();
            $table->string('edu_system')->nullable(); // hệ đào tạo
            $table->integer('exper_num')->nullable();
            $table->string('school')->nullable();
            $table->string('nation')->nullable();
            $table->string('id_card')->nullable(); // số cmt
            $table->string('address_card')->nullable(); // địa chỉ cấp cmt
            $table->string('qualification')->nullable();
            $table->string('date_card')->nullable(); // ngày cấp cmt
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
        Schema::dropIfExists('customers');
    }
}
