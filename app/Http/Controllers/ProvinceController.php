<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    public function index()
    {
        $thaiaddress_provinces = DB::connection('mysql_hos')->table('thaiaddress_provinces')
        ->orderBy('PROVINCE_NAME','ASC')->get();

        return view('patient.province', [
            'moduletitle' => "ลงทะเบียนผู้ป่วยใหม่",
            'view_menu' => "disable",
            'thaiaddress_provinces' => $thaiaddress_provinces,
        ]);
    }

    public function amphure(Request $request)
    {
        $thaiaddress_amphures = DB::connection('mysql_hos')->table('thaiaddress_amphures')
        ->where('PROVINCE_ID','=',$request->province_id)
        ->orderBy('AMPHUR_NAME','ASC')->get();

        $json = array();
        foreach($thaiaddress_amphures as $data) {
            array_push($json, $data);
        }
        echo json_encode($json);
    }

    public function district(Request $request)
    {
        $thaiaddress_districts = DB::connection('mysql_hos')->table('thaiaddress_districts')
        ->where('AMPHUR_ID','=',$request->amphure_id)
        ->orderBy('DISTRICT_NAME','ASC')->get();

        $json = array();
        foreach($thaiaddress_districts as $data) {
            array_push($json, $data);
        }
        echo json_encode($json);
    }
}
