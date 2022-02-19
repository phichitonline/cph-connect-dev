<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingemrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settingemrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->id();
            $table->string('emr_visit_limit', 10);
            $table->string('emr_bps', 10);
            $table->string('emr_bpd', 10);
            $table->string('emr_temperature', 10);
            $table->string('emr_pulse', 10);
            $table->string('emr_bw', 10);
            $table->string('emr_height', 10);
            $table->string('emr_bmi1', 10);
            $table->string('emr_bmi2', 10);
            $table->string('emr_checkup_icd10', 10);

            $table->timestamps();
        });

        // Insert default data
        DB::table('settingemrs')->insert(
            array(
                'emr_visit_limit'=> '1',
                'emr_bps'=> '140',
                'emr_bpd'=> '100',
                'emr_temperature'=> '36.5',
                'emr_pulse'=> '100',
                'emr_bw'=> '100',
                'emr_height'=> '120',
                'emr_bmi1'=> '18.5',
                'emr_bmi2'=> '30',
                'emr_checkup_icd10'=> 'Z000'
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
        Schema::dropIfExists('settingemrs');
    }
}
