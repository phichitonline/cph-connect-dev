<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueAppFlagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('que_app_flag', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->string('que_app_flag', 1);
            $table->string('que_app_flag_name', 100);
            $table->string('clinic', 10);
            $table->string('depcode', 10);
            $table->string('spclty', 10);
            $table->string('doctor', 10);
            $table->string('bgcolor', 100);

            $table->primary(['que_app_flag']);
        });

            // Insert default data
            DB::table('que_app_flag')->insert(
                array(
                    [
                        'que_app_flag'=> 'A',
                        'que_app_flag_name'=> 'ตรวจรักษาทั่วไป',
                        'clinic'=> '101',
                        'depcode'=> '016',
                        'spclty'=> '01',
                        'doctor'=> '1298',
                        'bgcolor'=> 'bg-blue1-dark'
                    ],
                    [
                        'que_app_flag'=> 'C',
                        'que_app_flag_name'=> 'ตรวจสุขภาพ',
                        'clinic'=> '101',
                        'depcode'=> '016',
                        'spclty'=> '01',
                        'doctor'=> '1298',
                        'bgcolor'=> 'bg-magenta1-dark'
                    ],
                    [
                        'que_app_flag'=> 'D',
                        'que_app_flag_name'=> 'ทันตกรรม',
                        'clinic'=> '030',
                        'depcode'=> '030',
                        'spclty'=> '11',
                        'doctor'=> '1029',
                        'bgcolor'=> 'bg-yellow2-dark'
                    ],
                    [
                        'que_app_flag'=> 'T',
                        'que_app_flag_name'=> 'แพทย์แผนไทย',
                        'clinic'=> '036',
                        'depcode'=> '036',
                        'spclty'=> '16',
                        'doctor'=> '1025',
                        'bgcolor'=> 'bg-green1-dark'
                    ]
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
        Schema::dropIfExists('que_app_flag');
    }
}
