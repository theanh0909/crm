<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisteredEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registered_edits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registered_id');
            $table->integer('license_id');
            $table->integer('type_key')->comment('0=thử nghiệm, 1=thương mại, 2=lớp học');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('registered_edits');
    }
}
