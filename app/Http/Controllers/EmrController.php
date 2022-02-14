<?php

namespace App\Http\Controllers;

use App\Models\Settingemr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmrController extends Controller
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
        
        $settingemr = Settingemr::all();
        foreach ($settingemr as $data) {
            $emr_visit_limit = $data->emr_visit_limit;
            $emr_checkup_icd10 = $data->emr_checkup_icd10;
        }
        
        $visit_count = DB::connection('mysql_hos')->select('
        SELECT COUNT(*) AS countvisit FROM (
            SELECT od.icd10,v.vn,v.hn,v.vstdate,v.vsttime,v.doctor,v.ovstist,v.ovstost,v.pttype,v.spclty,v.visit_type,v.staff
            ,s.bps,s.bpd,s.bw,s.cc,s.pulse,s.temperature,s.rr,s.height,s.fbs,s.bmi,s.tg,s.hdl,s.ldl,s.bun,s.creatinine,s.ua,s.hba1c
            ,s.checkup,s.found_allergy,s.hpi,s.pmh,s.tc,s.ast,s.alt,s.symptom,s.waist,s.creatinine_kidney_percent,s.egfr,s.hb
            ,s.advice7_note,p.pname,p.fname,p.lname,v.an
                    FROM ovst v
                    LEFT JOIN opdscreen s ON v.vn = s.vn
                    LEFT JOIN patient p ON v.hn = p.hn
                    LEFT JOIN ovstdiag od ON v.vn = od.vn
                    WHERE v.hn = "'.$hn.'" AND v.vstdate > DATE_ADD(NOW(), INTERVAL -"'.$emr_visit_limit.'" YEAR)
            UNION
            SELECT od.icd10,v.vn,v.hn,v.vstdate,v.vsttime,v.doctor,v.ovstist,v.ovstost,v.pttype,v.spclty,v.visit_type,v.staff
            ,s.bps,s.bpd,s.bw,s.cc,s.pulse,s.temperature,s.rr,s.height,s.fbs,s.bmi,s.tg,s.hdl,s.ldl,s.bun,s.creatinine,s.ua,s.hba1c
            ,s.checkup,s.found_allergy,s.hpi,s.pmh,s.tc,s.ast,s.alt,s.symptom,s.waist,s.creatinine_kidney_percent,s.egfr,s.hb
            ,s.advice7_note,p.pname,p.fname,p.lname,v.an
                    FROM ovst v
                    LEFT JOIN opdscreen s ON v.vn = s.vn
                    LEFT JOIN patient p ON v.hn = p.hn
                    LEFT JOIN ovstdiag od ON v.vn = od.vn
                    WHERE v.hn = "'.$hn.'" AND od.icd10 = "'.$emr_checkup_icd10.'"
            ) AS t1
        ');
        foreach ($visit_count as $data) {
            $countvisit = $data->countvisit;
        }
        
        $visit_list = DB::connection('mysql_hos')->select('
        SELECT t1.*,GROUP_CONCAT(t1.icd10) AS visitdiag,count(*) AS countvisit FROM (
            SELECT od.icd10,v.vn,v.hn,v.vstdate,v.vsttime,v.doctor,v.ovstist,v.ovstost,v.pttype,v.spclty,v.visit_type,v.staff
            ,s.bps,s.bpd,s.bw,s.cc,s.pulse,s.temperature,s.rr,s.height,s.fbs,s.bmi,s.tg,s.hdl,s.ldl,s.bun,s.creatinine,s.ua,s.hba1c
            ,s.checkup,s.found_allergy,s.hpi,s.pmh,s.tc,s.ast,s.alt,s.symptom,s.waist,s.creatinine_kidney_percent,s.egfr,s.hb
            ,s.advice7_note,p.pname,p.fname,p.lname,v.an
                    FROM ovst v
                    LEFT JOIN opdscreen s ON v.vn = s.vn
                    LEFT JOIN patient p ON v.hn = p.hn
                    LEFT JOIN ovstdiag od ON v.vn = od.vn
                    WHERE v.hn = "'.$hn.'" AND v.vstdate > DATE_ADD(NOW(), INTERVAL -"'.$emr_visit_limit.'" YEAR)
            UNION
            SELECT od.icd10,v.vn,v.hn,v.vstdate,v.vsttime,v.doctor,v.ovstist,v.ovstost,v.pttype,v.spclty,v.visit_type,v.staff
            ,s.bps,s.bpd,s.bw,s.cc,s.pulse,s.temperature,s.rr,s.height,s.fbs,s.bmi,s.tg,s.hdl,s.ldl,s.bun,s.creatinine,s.ua,s.hba1c
            ,s.checkup,s.found_allergy,s.hpi,s.pmh,s.tc,s.ast,s.alt,s.symptom,s.waist,s.creatinine_kidney_percent,s.egfr,s.hb
            ,s.advice7_note,p.pname,p.fname,p.lname,v.an
                    FROM ovst v
                    LEFT JOIN opdscreen s ON v.vn = s.vn
                    LEFT JOIN patient p ON v.hn = p.hn
                    LEFT JOIN ovstdiag od ON v.vn = od.vn
                    WHERE v.hn = "'.$hn.'" AND od.icd10 = "'.$emr_checkup_icd10.'"
            ) AS t1
            GROUP BY t1.vn
            ORDER BY t1.vstdate DESC
        ');
        foreach ($visit_list as $data) {
            $pname = $data->pname;
            $fname = $data->fname;
            $lname = $data->lname;
        }

        if ($countvisit > 0) {
            $ptname = $pname.$fname." ".$lname;
        } else {
            $ptname = "ไม่พบข้อมูลการรับบริการ";
        }
            
        $images_user = DB::connection('mysql_hos')->select('
        SELECT pm.image,TIMESTAMPDIFF(YEAR,pt.birthday,CURDATE()) AS age_y,pt.sex
        FROM patient pt LEFT OUTER JOIN patient_image pm ON pt.hn = pm.hn WHERE pt.hn = "'.$hn.'"
        ');
        foreach($images_user as $data){
            if ($data->image || NULL) {
                $pic = "show_image.php";
            } else {
                switch ($data->sex) {
                    case 1 : if ($data->age_y<=15) $pic="images/boy.jpg"; else $pic="images/male.jpg";break;
                    case 2 : if ($data->age_y<=15) $pic="images/girl.jpg"; else $pic="images/female.jpg";break;
                    default : $pic="images/boy.jpg";break;
                }
            }
        }

        return view('emr.index', [
            'moduletitle' => "ประวัติรับบริการ",
            'visit_list' => $visit_list,
            'pic' => $pic,
            'hn' => $hn,
            'ptname' => $ptname,
            'isadmin' => $_SESSION["isadmin"],
            'emr_visit_limit' => $emr_visit_limit,
            'emr_checkup_icd10' => $emr_checkup_icd10,
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
        $visit_header = DB::connection('mysql_hos')->select('
        SELECT v.hn,v.vn,v.vstdate,IF(v.an IS NOT NULL,"IPD",IF(GROUP_CONCAT(d.icd10) LIKE "%Z000%","CHK","NOR")) AS status_type
        FROM ovst v
        LEFT JOIN ovstdiag d ON v.vn = d.vn
        WHERE v.vn = "'.$id.'"
        ');
        foreach ($visit_header as $data) {
            $hn = $data->hn;
            $vn = $data->vn;
            $vstdate = $data->vstdate;
            $status_type = $data->status_type;
        }
        
        $visit_detail = DB::connection('mysql_hos')->select('
        SELECT v.*,s.*
        FROM ovst v
		LEFT JOIN opdscreen s ON v.vn = s.vn
        WHERE v.vn = "'.$id.'"
        ');
        $visit_diag = DB::connection('mysql_hos')->select('
        SELECT d.hn,d.vn,d.icd10,i.name,i.tname
        FROM ovstdiag d
        LEFT JOIN icd101 i ON d.icd10 = code
        WHERE d.vn = "'.$id.'" AND d.icd10 REGEXP "[a-z]"
        ');
        $visit_drug = DB::connection('mysql_hos')->select('
        SELECT o.vn,oi.icode,oi.qty,d.`name`,d.units
        FROM ovst o
        LEFT JOIN opitemrece oi ON o.vn = oi.vn
        LEFT JOIN drugitems d ON oi.icode = d.icode
        WHERE o.vn = "'.$id.'" AND (oi.icode LIKE "15%" OR oi.icode LIKE "16%")
        ');
        $visit_lab = DB::connection('mysql_hos')->select('
        SELECT lh.lab_order_number,lh.hn,lh.vn,lo.lab_items_code,li.lab_items_name,li.lab_items_group,lg.lab_items_group_name
        ,li.lab_items_normal_value,lo.lab_order_result,li.range_check_min,li.range_check_max,li.range_check_min_female
        ,li.range_check_max_female,li.specimen_code,ls.specimen_name
        FROM lab_head lh
        LEFT JOIN lab_order lo ON lh.lab_order_number = lo.lab_order_number
        LEFT JOIN lab_items li ON lo.lab_items_code = li.lab_items_code
        LEFT JOIN lab_items_group lg ON li.lab_items_group = lg.lab_items_group_code
        LEFT JOIN lab_specimen_items ls ON li.specimen_code = ls.specimen_code
        WHERE vn = "'.$id.'" AND lo.lab_order_result IS NOT NULL AND li.specimen_code IN (9,10,11,12,15)
        ORDER BY li.lab_items_group ASC,li.lab_items_code ASC
        ');
        $visit_lab5 = DB::connection('mysql_hos')->select('
        SELECT lh.lab_order_number,lh.hn,lh.vn,lo.lab_items_code,li.lab_items_name,li.lab_items_group,lg.lab_items_group_name
        ,li.lab_items_normal_value,lo.lab_order_result,li.range_check_min,li.range_check_max,li.range_check_min_female
        ,li.range_check_max_female,li.specimen_code,ls.specimen_name
        FROM lab_head lh
        LEFT JOIN lab_order lo ON lh.lab_order_number = lo.lab_order_number
        LEFT JOIN lab_items li ON lo.lab_items_code = li.lab_items_code
        LEFT JOIN lab_items_group lg ON li.lab_items_group = lg.lab_items_group_code
        LEFT JOIN lab_specimen_items ls ON li.specimen_code = ls.specimen_code
        WHERE vn = "'.$id.'" AND lo.lab_order_result IS NOT NULL AND li.specimen_code IN (5,8)
        ORDER BY li.lab_items_group ASC,li.lab_items_code ASC
        ');
        $visit_lab_other = DB::connection('mysql_hos')->select('
        SELECT lh.lab_order_number,lh.hn,lh.vn,lo.lab_items_code,li.lab_items_name,li.lab_items_group,lg.lab_items_group_name
        ,li.lab_items_normal_value,lo.lab_order_result,li.range_check_min,li.range_check_max,li.range_check_min_female
        ,li.range_check_max_female,li.specimen_code,ls.specimen_name
        FROM lab_head lh
        LEFT JOIN lab_order lo ON lh.lab_order_number = lo.lab_order_number
        LEFT JOIN lab_items li ON lo.lab_items_code = li.lab_items_code
        LEFT JOIN lab_items_group lg ON li.lab_items_group = lg.lab_items_group_code
        LEFT JOIN lab_specimen_items ls ON li.specimen_code = ls.specimen_code
        WHERE vn = "'.$id.'" AND lo.lab_order_result IS NOT NULL AND li.specimen_code NOT IN (5,8,9,10,11,12,15)
        ORDER BY li.lab_items_group ASC,li.lab_items_code ASC
        ');
        $visit_xray = DB::connection('mysql_hos')->select('SELECT vn,hn,xray_list,confirm_all FROM xray_head WHERE vn = "'.$id.'" ');
        
        return view('emr.emr', [
            'moduletitle' => "ประวัติรับบริการ",
            'visit_detail' => $visit_detail,
            'visit_diag' => $visit_diag,
            'visit_drug' => $visit_drug,
            'visit_lab' => $visit_lab,
            'visit_lab5' => $visit_lab5,
            'visit_lab_other' => $visit_lab_other,
            'visit_xray' => $visit_xray,
            'status_type' => $status_type,
            'hn' => $hn,
            'vn' => $vn,
            'vstdate' => $vstdate,
            'settingemr' => Settingemr::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settingemr = Settingemr::find($id);
        
        return view('emr.setting', compact('settingemr'));
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
        $settingemr = Settingemr::find($id);
        
        $settingemr->emr_visit_limit =  $request->get('emr_visit_limit');
        $settingemr->emr_checkup_icd10 =  $request->get('emr_checkup_icd10');
        $settingemr->emr_bps =  $request->get('emr_bps');
        $settingemr->emr_bpd =  $request->get('emr_bpd');
        $settingemr->emr_temperature =  $request->get('emr_temperature');
        $settingemr->emr_pulse =  $request->get('emr_pulse');
        $settingemr->emr_bw =  $request->get('emr_bw');
        $settingemr->emr_height =  $request->get('emr_height');
        $settingemr->emr_bmi1 =  $request->get('emr_bmi1');
        $settingemr->emr_bmi2 =  $request->get('emr_bmi2');
        $settingemr->save();
        
        return redirect()->route('emr.edit', 1)->with('settingemr-updated','บันทึกสำเร็จ');
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
