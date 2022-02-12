<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        $hn = $_SESSION["hn"];
        $vaccine_list = DB::connection('mysql_hos')->select('
        SELECT o.vstdate,o.hn,o.vn,pv.vaccine_name,v.vaccine_plan_no,v.vaccine_lot_no,serial_no,vm.vaccine_manufacturer_name,p.cid
        ,IF(v.vaccine_plan_no >= 2,dc.moph_certificate_code,NULL) AS moph_certificate_code
        FROM ovst_vaccine v
        LEFT JOIN ovst o ON v.vn = o.vn
		LEFT JOIN patient p ON p.hn = o.hn
        LEFT JOIN person_vaccine pv ON v.person_vaccine_id = pv.person_vaccine_id
        LEFT JOIN vaccine_inventory_lot vl ON v.vaccine_lot_no = vl.vaccine_lot_no AND v.serial_no = vl.vaccine_serial_no
        LEFT JOIN vaccine_manufacturer vm ON vl.vaccine_manufacturer_id = vm.vaccine_manufacturer_id
		LEFT JOIN (SELECT * FROM doctor_cert_covid19 GROUP BY patient_cid) dc ON dc.patient_cid = p.cid
        WHERE o.hn = "'.$hn.'"
        ORDER BY o.vstdate DESC
        ');

        return view('vaccine.index', [
            'moduletitle' => "ข้อมูลวัคซีน",
            'vaccine_list' => $vaccine_list,
            // 'view_menu' => "disable",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
