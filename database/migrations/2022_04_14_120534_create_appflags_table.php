<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppflagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appflags', function (Blueprint $table) {
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
            $table->string('app_image', 255);
            $table->string('classcol', 100);
            $table->string('classm', 100);
            $table->string('active', 1);

            $table->primary(['que_app_flag']);
        });

            // Insert default data
            DB::table('appflags')->insert(
                array(
                    [
                        'que_app_flag'=> 'A',
                        'que_app_flag_name'=> 'ตรวจรักษาทั่วไป',
                        'clinic'=> '101',
                        'depcode'=> '016',
                        'spclty'=> '01',
                        'doctor'=> '1298',
                        'bgcolor'=> 'bg-blue1-dark',
                        'app_image'=> 'book_opd.png',
                        'classcol'=> 'pr-0',
                        'classm'=> 'mr-2',
                        'active'=> 'Y'
                    ],
                    [
                        'que_app_flag'=> 'C',
                        'que_app_flag_name'=> 'ตรวจสุขภาพ',
                        'clinic'=> '101',
                        'depcode'=> '016',
                        'spclty'=> '01',
                        'doctor'=> '1298',
                        'bgcolor'=> 'bg-magenta1-dark',
                        'app_image'=> 'book_healthy.png',
                        'classcol'=> 'pl-0',
                        'classm'=> 'ml-2',
                        'active'=> 'Y'
                    ],
                    [
                        'que_app_flag'=> 'D',
                        'que_app_flag_name'=> 'ทันตกรรม',
                        'clinic'=> '030',
                        'depcode'=> '030',
                        'spclty'=> '11',
                        'doctor'=> '1029',
                        'bgcolor'=> 'bg-yellow2-dark',
                        'app_image'=> 'book_dental2.png',
                        'classcol'=> 'pr-0',
                        'classm'=> 'mr-2',
                        'active'=> 'Y'
                    ],
                    [
                        'que_app_flag'=> 'T',
                        'que_app_flag_name'=> 'แพทย์แผนไทย',
                        'clinic'=> '036',
                        'depcode'=> '036',
                        'spclty'=> '16',
                        'doctor'=> '1025',
                        'bgcolor'=> 'bg-green1-dark',
                        'app_image'=> 'book_phanthai2.png',
                        'classcol'=> 'pl-0',
                        'classm'=> 'ml-2',
                        'active'=> 'Y'
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
        Schema::dropIfExists('appflags');
    }
}
