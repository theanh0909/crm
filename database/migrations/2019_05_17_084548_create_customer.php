<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('license_serial')->nullable();
            $table->string('license_original')->nullable();
            $table->string('hardware_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_address')->nullable();
            $table->date('license_activation_date')->nullable();
            $table->date('last_runing_date')->nullable();
            $table->date('license_expire_date')->nullable();
            $table->integer('product_type_id')->nullable()->index();
            $table->integer('province_id')->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->text('attribute')->nullable();
            $table->integer('point')->default(0)->index();
            $table->integer('user_support_id')->nullable()->index();
            $table->integer('status_mail')->default(0)->index();
            $table->integer('status')->default(1)->index();
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
        Schema::dropIfExists('customer');
    }
}
