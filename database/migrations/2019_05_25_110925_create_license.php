<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('license_serial');
            $table->string('license_key');
            $table->integer('license_is_registered')->default(0)->index();
            $table->date('license_created_date');
            $table->integer('type_expire_date')->default(0);
            $table->string('hardware_id');
            $table->integer('license_no_instance')->default(0)->index();
            $table->integer('license_no_computers')->default(0);
            $table->string('product_type')->nullable();
            $table->integer('created_by')->index()->nullable();
            $table->integer('status')->default(0);
            //
            $table->integer('status_register')->default(0);
            $table->string('email_customer')->nullable();
            $table->integer('customer_id')->nullable()->index();
            $table->date('sell_date');
            $table->integer('status_sell')->default(0);
            $table->integer('status_email')->default(0);
            $table->integer('used')->default(0);
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
        Schema::dropIfExists('license');
    }
}
