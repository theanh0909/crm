<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('full_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('identify_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('major')->nullable();
            $table->string('proffessional')->nullable();
            $table->string('level')->nullable();
            $table->string('province_code')->nullable();
            $table->integer('experience')->nullable();
            $table->string('company')->nullable();
            $table->date('identify_date')->nullable();
            $table->string('indentify_place')->nullable();
            $table->string('nation')->nullable();
            $table->string('form_of_training')->nullable();
            $table->string('facility')->nullable();
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
        Schema::dropIfExists('certifications');
    }
}
