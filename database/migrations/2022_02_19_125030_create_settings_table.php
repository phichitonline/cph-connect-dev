<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->id();
            $table->string('hos_name', 200);
            $table->string('hos_url', 200);
            $table->string('hos_tel', 50);
            $table->string('hos_facebook', 200);
            $table->string('hos_youtube', 200);
            $table->string('slide_1_text', 200);
            $table->string('slide_2_text', 200);
            $table->string('slide_3_text', 200);
            $table->string('slide_1_more', 200);
            $table->string('slide_2_more', 200);
            $table->string('slide_3_more', 200);
            $table->string('slide_1_picture', 200);
            $table->string('slide_2_picture', 200);
            $table->string('slide_3_picture', 200);
            $table->string('pr_1', 200);
            $table->string('pr_2', 200);
            $table->string('pr_3', 200);
            $table->string('pr_status', 1);
            $table->string('slide_status', 1);
            $table->string('dm_status', 1);
            $table->string('ext_q_name', 200);
            $table->string('ext_q_url', 200);
            $table->string('ext_q_img', 200);
            $table->string('ext_q_status', 1);
            $table->string('module_8', 1);
            $table->string('module_7', 1);
            $table->string('module_6', 1);
            $table->string('module_5', 1);
            $table->string('module_4', 1);
            $table->string('module_3', 1);
            $table->string('module_2', 1);
            $table->string('module_1', 1);
            $table->string('hoslocation', 200);

            $table->timestamps();
        });

        // Insert default data
        DB::table('settings')->insert(
            array(
                'hos_name'=> 'โรงพยาบาลสมเด็จพระยุพราชตะพานหิน',
                'hos_url'=> 'https://www.tphcp.go.th',
                'hos_tel'=> '056621355',
                'hos_facebook'=> 'https://www.facebook.com/tphcp.qandp',
                'hos_youtube'=> 'https://www.youtube.com/user/tphcpgoth/videos',
                'slide_1_text'=> 'ประวัติรับบริการ',
                'slide_2_text'=> 'นัดหมายและการแจ้งเตือน',
                'slide_3_text'=> 'แสดงคิวรับบริการ',
                'slide_1_more'=> 'ดูประวัติ และดูผลตรวจออนไลน์',
                'slide_2_more'=> 'ข้อมูลนัดหมายและการแจ้งเตือน',
                'slide_3_more'=> 'แสดงสถานะคิวรอรับบริการ',
                'slide_1_picture'=> '00001111.jpg',
                'slide_2_picture'=> 'pic03.jpg',
                'slide_3_picture'=> '1592.png',
                'pr_1'=> '“สวม-ห่าง-ล้าง” เกราะเหล็กป้องกันโควิด 19 ระยะยาว',
                'pr_2'=> 'ข่าวสาร ประชาสัมพันธ์ กระกาศรับสมัครงานและข้อมูลสุขภาพ',
                'pr_3'=> 'ติดตามวันฉีดวัคซีนของโรงพยาบาล',
                'pr_status'=> 'Y',
                'slide_status'=> 'N',
                'dm_status'=> 'N',
                'ext_q_name'=> 'NeoQ',
                'ext_q_url'=> 'http://neoq.tphcp.go.th/Patient_Status.aspx?vn=',
                'ext_q_img'=> 'logo-neoq3.png',
                'ext_q_status'=> 'N',
                'module_8'=> 'Y',
                'module_7'=> 'Y',
                'module_6'=> 'Y',
                'module_5'=> 'Y',
                'module_4'=> 'Y',
                'module_3'=> 'Y',
                'module_2'=> 'Y',
                'module_1'=> 'Y',
                'hoslocation'=> ''
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
        Schema::dropIfExists('settings');
    }
}
