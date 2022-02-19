<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('que_card', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->id();
            $table->bigInteger('que_n');
            $table->bigInteger('que_r');
            $table->string('que_flag');
            $table->date('que_date');
            $table->bigInteger('que_time');
            $table->time('call_time');
            $table->string('cid', 13);
            $table->string('hn', 9);
            $table->string('pname', 255);
            $table->string('content');
            $table->string('que_app_flag', 1);
            $table->string('que_source', 5);
            $table->datetime('que_insert');
            $table->string('que_dep', 255);
            $table->string('que_time_text', 255);
            $table->string('que_cc', 255);
            $table->string('screen_status',255);
            $table->string('screen_type', 255);
            $table->string('screen_other', 255);
            $table->bigInteger('speak_count');
            $table->string('status', 1);

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
        Schema::dropIfExists('que_card');
    }
}
