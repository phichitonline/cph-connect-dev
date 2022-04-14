<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApptimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apptimes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->string('que_time', 2);
            $table->string('que_app_flag', 2);
            $table->string('que_time_name', 100);
            $table->time('que_time_start');
            $table->time('que_time_end');
            $table->bigInteger('limitcount');
            $table->string('statusday', 100);

            $table->primary(['que_time','que_app_flag']);
        });

        // Insert default data
        DB::table('apptimes')->insert(
            array(
                [
                    'que_time'=> '2',
                    'que_app_flag'=> 'A',
                    'que_time_name'=> 'เช้า 10.30-12.00 น.',
                    'que_time_start'=> '10:30:00',
                    'que_time_end'=> '12:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '2',
                    'que_app_flag'=> 'C',
                    'que_time_name'=> 'เช้า 10.30-12.00 น.',
                    'que_time_start'=> '10:30:00',
                    'que_time_end'=> '12:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '2',
                    'que_app_flag'=> 'D',
                    'que_time_name'=> 'เช้า 10.30-12.00 น.',
                    'que_time_start'=> '10:30:00',
                    'que_time_end'=> '12:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '2',
                    'que_app_flag'=> 'T',
                    'que_time_name'=> 'เช้า 10.30-12.00 น.',
                    'que_time_start'=> '10:30:00',
                    'que_time_end'=> '12:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '3',
                    'que_app_flag'=> 'A',
                    'que_time_name'=> 'บ่าย 13.00-15.00 น.',
                    'que_time_start'=> '13:00:00',
                    'que_time_end'=> '15:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '3',
                    'que_app_flag'=> 'C',
                    'que_time_name'=> 'บ่าย 13.00-15.00 น.',
                    'que_time_start'=> '13:00:00',
                    'que_time_end'=> '15:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '3',
                    'que_app_flag'=> 'D',
                    'que_time_name'=> 'บ่าย 13.00-15.00 น.',
                    'que_time_start'=> '13:00:00',
                    'que_time_end'=> '15:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '3',
                    'que_app_flag'=> 'T',
                    'que_time_name'=> 'บ่าย 13.00-15.00 น.',
                    'que_time_start'=> '13:00:00',
                    'que_time_end'=> '15:00:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '4',
                    'que_app_flag'=> 'A',
                    'que_time_name'=> 'บ่าย 15.00-16.30 น.',
                    'que_time_start'=> '15:00:00',
                    'que_time_end'=> '16:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '4',
                    'que_app_flag'=> 'C',
                    'que_time_name'=> 'บ่าย 15.00-16.30 น.',
                    'que_time_start'=> '15:00:00',
                    'que_time_end'=> '16:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '4',
                    'que_app_flag'=> 'D',
                    'que_time_name'=> 'บ่าย 15.00-16.30 น.',
                    'que_time_start'=> '15:00:00',
                    'que_time_end'=> '16:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '4',
                    'que_app_flag'=> 'T',
                    'que_time_name'=> 'บ่าย 15.00-16.30 น.',
                    'que_time_start'=> '15:00:00',
                    'que_time_end'=> '16:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '1',
                    'que_app_flag'=> 'A',
                    'que_time_name'=> 'เช้า 09.00-10.30 น.',
                    'que_time_start'=> '09:00:00',
                    'que_time_end'=> '10:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '1',
                    'que_app_flag'=> 'C',
                    'que_time_name'=> 'เช้า 09.00-10.30 น.',
                    'que_time_start'=> '09:00:00',
                    'que_time_end'=> '10:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '1',
                    'que_app_flag'=> 'D',
                    'que_time_name'=> 'เช้า 09.00-10.30 น.',
                    'que_time_start'=> '09:00:00',
                    'que_time_end'=> '10:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
                ],
                [
                    'que_time'=> '1',
                    'que_app_flag'=> 'T',
                    'que_time_name'=> 'เช้า 09.00-10.30 น.',
                    'que_time_start'=> '09:00:00',
                    'que_time_end'=> '10:30:00',
                    'limitcount'=> '5',
                    'statusday'=> '12345'
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
        Schema::dropIfExists('apptimes');
    }
}
