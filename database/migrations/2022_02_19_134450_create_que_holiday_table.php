<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('que_holiday', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->date('que_date');
            $table->string('que_holiday');

            $table->primary(['que_date']);
        });

        // Insert default data
        DB::table('que_holiday')->insert(
            array(
                'que_date'=> '2022-01-01',
                'que_holiday'=> 'วันขึ้นปีใหม่'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('que_holiday');
    }
}
