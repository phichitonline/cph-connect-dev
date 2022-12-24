<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patientusers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->string('lineid', 255);
            $table->string('cid', 255);
            $table->string('hn', 25);
            $table->string('hn2', 25)->nullable();
            $table->string('hn3', 25)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('tel', 255);
            $table->string('isadmin', 1);
            $table->string('que_app_flag', 2)->nullable();
            $table->string('consent', 1)->nullable();
            $table->string('pincode', 100)->nullable();

            $table->timestamps();
            $table->primary(['lineid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('patientusers');
    }
}
