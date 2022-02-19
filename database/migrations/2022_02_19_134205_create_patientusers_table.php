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

            $table->string('lineid', 100);
            $table->string('cid', 13);
            $table->string('hn', 9);
            $table->string('hn2', 9);
            $table->string('hn3', 9);
            $table->string('email', 255);
            $table->string('tel', 10);
            $table->string('isadmin', 1);
            $table->string('consent', 1);

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
        Schema::dropIfExists('patientusers');
    }
}
