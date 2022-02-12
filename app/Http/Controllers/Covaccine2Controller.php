<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Covaccine2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('covaccine.cocheck2', [
            'moduletitle' => "ตรวจสอบข้อมูล",
            // 'view_menu' => "disable",
        ]);
    }

    public function cocheck(request $request)
    {
        $cid = $request->get('cid');

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $browser = $_SERVER['HTTP_USER_AGENT'];
        $cid_encode = strtoupper(md5($cid)).":".substr($cid,1,1).substr($cid,-1);

        DB::connection('mysql')->insert('INSERT INTO log_search (id,cid,search_from,search_browser,search_datetime) VALUES (NULL,"'.$cid_encode.'","'.$ip.'","'.$browser.'",NOW())');
        
        $check_phichitprompt = DB::connection('mysql')->select('
        SELECT COUNT(*) AS countpp,c.cid,c.hospvaccine,h.hosname,c.result,c.reg_date,c.agegroup 
        FROM co_vaccine c
        LEFT JOIN chospital h ON h.hoscode = c.hospvaccine
        WHERE c.cid = "'.$cid.'" AND result = "CONFIRM" LIMIT 1
        ');
        foreach($check_phichitprompt as $data){
            if ($data->countpp > 0) {
                $check_pp_bk = 91;
                $chk_message = "คุณลงทะเบียนจองคิวฉีดวัคซีนไว้กับ ".$data->hosname."<br>วันที่ ".$data->reg_date.", กลุ่ม ".$data->agegroup."<br><br>โปรดติดตามและรอการเรียกคิวจากหน่วยที่ลงทะเบียนไว้";
            } else {
                $check_pp_bk = 92;
                $chk_message = "คุณไม่มีรายชื่อจองคิวรับวัคซีนไว้กับพิจิตรพร้อม";
            }
        }

        $check_bkk = DB::connection('mysql')->select('
        SELECT COUNT(*) AS countbkk,bkk_vac2_app.* FROM bkk_vac2_app WHERE cid = "'.$cid.'" LIMIT 1
        ');
        foreach($check_bkk as $data){
            if ($data->countbkk > 0) {
                if ($data->slot_date || NULL) {
                    $check_pp_bk2 = 93;
                    $chk_message2 = "คุณลงทะเบียนรับเข็ม 2 มาจากที่อื่น (เข็ม 1 ".$data->vacc1." - ".$data->vacc_date1." - ".$data->hosv1.")";
                } else {
                    $check_pp_bk2 = 94;
                    $chk_message2 = "คุณลงทะเบียนรับเข็ม 2 มาจากที่อื่น (เข็ม 1 ".$data->vacc1." - ".$data->vacc_date1." - ".$data->hosv1.") นัดเข็ม 2 ที่เดิม ".$data->vacc_date2." แต่ยังไม่ได้วันนัดจากเรา โปรดตรวจสอบวันนัดใหม่จากเราอีกครั้ง";
                }
            } else {
                $check_pp_bk2 = 95;
                $chk_message2 = "";
            }
        }
        
        
        $check_register = DB::connection('mysql')->select('
        SELECT COUNT(*) AS coregist,t.* FROM (
            SELECT r.*,s.slot_date,s.slot_time,s.dose,IF(r.visit_immun LIKE "%เข็ม2%","Y","N") AS dose2
            FROM reg_pprompt r LEFT JOIN slot_covid_19 s ON r.cid = s.cid
            WHERE r.cid = "'.$cid.'" AND s.slot_date IS NOT NULL ORDER BY s.dose DESC LIMIT 1
        ) AS t
        ');
        foreach($check_register as $data){
            if ($data->coregist > 0) {
                if ($data->visit_immun || NULL) {
                    if ($data->agegroup == "ลงทะเบียนจากบางซื่อ") {
                        $result_check = 1;
                        $date_register = $check_msg_bkk;
                        $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                    } else {
                        if ($data->dose == "2") {
                            if ($data->dose2 == "Y") {
                                $result_check = 212;
                                $date_register = "คุณ".$data->name." ได้รับการฉีดวัคซีนแล้ว ". $data->visit_immun."";
                                $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                            } else {
                                $result_check = 211;
                                $date_register = $check_msg_bkk;
                                $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                            }
                            
                            
                        } else {
                            $result_check = 220;
                            $date_register = "คุณ".$data->name." ได้รับการฉีดวัคซีนแล้ว ". $data->visit_immun."";
                            $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                        }
                    }
                } else {
                    if ($data->agegroup == "ลงทะเบียนจากบางซื่อ") {
                        if ($data->dose == "2") {
                            $result_check = 31;
                            $date_register = $check_msg_bkk;
                            $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                        } else {
                            $result_check = 32;
                            $date_register = "คุณลงทะเบียนรับเข็ม 2 มาจากที่อื่น แต่ยังไม่ได้วันนัด โปรดตรวจสอบวันนัดอย่างต่อเนื่องต่อไป";
                            $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                        }
                    } else {
                        if ($data->dose == "2") {
                            $result_check = 4;
                            $date_register = $check_msg_bkk;
                            $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                        } else {
                            if ($data->dose == "1") {
                                $result_check = 41;
                                $date_register = "คุณยังไม่ได้ลงทะเบียนพิจิตรพร้อม";
                                $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                            } else {
                                $result_check = 5;
                                $date_register = "คุณลงทะเบียนรับการฉีดวัคซีนกับเราแล้ว แต่ยังไม่มีวันนัด โปรดตรวจสอบวันนัดอย่างต่อเนื่องต่อไป";
                                $session_check = "<a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";
                            }

                        }
                        
                    }

                }
            } else {
                $result_check = 6;
                $date_register = "".$chk_message."";
                $session_check = "<a href='https://phichitprompt.ppho.go.th/' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-pink2-dark font-800 text-uppercase'>ตรวจสอบและลงทะเบียนกับพิจิตรพร้อม</a> <a href='https://smarthospital.tphcp.go.th/mophiccheck.php?cid=".$cid."' type='button' class='btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-green2-dark font-800 text-uppercase'>ตรวจสอบกับหมอพร้อม</a>";

            }
        }


        $check_slot = DB::connection('mysql')->select('
        SELECT COUNT(*) AS userregist,t.* FROM (
            SELECT r.*,s.slot_date,s.slot_time,s.dose
            FROM reg_pprompt r LEFT JOIN slot_covid_19 s ON r.cid = s.cid
            WHERE r.cid = "'.$cid.'" AND s.slot_date IS NOT NULL ORDER BY s.dose DESC LIMIT 1
        ) AS t
        ');

        foreach($check_slot as $data){
        
            if ($result_check == 1 OR $result_check == 211 OR $result_check == 31 OR $result_check == 4 OR $result_check == 41) {
                session_start();
                ob_start();
                $_SESSION["cid"] = $data->cid;
                $_SESSION["prename"] = $data->prename;
                $_SESSION["name"] = $data->name;
                $_SESSION["age"] = $data->age;
                $_SESSION["agegroup"] = $data->agegroup;
                $_SESSION["dose"] = $data->dose;
                $_SESSION["slotdate"] = $data->slot_date;
                $_SESSION["slottime"] = $data->slot_time;
                $_SESSION["visit_immun"] = $data->visit_immun;
                $_SESSION['date_register'] = $date_register;
                session_write_close();
                return redirect()->route('coinfo2')->with(
                    'session-alert', 'คุณมีนัดแล้ว'
                );
            } else {
                if (valid_citizen_id($cid) == 1) {
                    return redirect()->route('covaccine2.index')->with([
                        'session-alert' => ''.$date_register.'',
                        'session-cid' => ''.$session_check.''
                    ]);
                    
                } else {
                    return redirect()->route('covaccine2.index')->with(
                        'session-alert-cid', 'เลขบัตรประชาชน '.$cid.' ไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง'
                    );
                }
            }
            
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function coinfo(Request $request)
    {
        session_start();
        $cid = $_SESSION["cid"];
        $prename = $_SESSION["prename"];
        $name = $_SESSION["name"];
        $age = $_SESSION["age"];
        $agegroup = $_SESSION["agegroup"];
        $dose = $_SESSION["dose"];
        $visit_immun = $_SESSION["visit_immun"];
        $slotdate = $_SESSION["slotdate"];
        $slottime = $_SESSION["slottime"];
        $stime_h = substr($slottime,0,2);
        $stime_m = substr($slottime,3,2);
        $date_register = $_SESSION["date_register"];

        return view('covaccine.coinfo', [
            'moduletitle' => "ข้อมูลนัดของคุณ",
            'view_menu' => "disable",
            'cid' => $cid,
            'age' => $age,
            'agegroup' => $agegroup,
            'dose' => $dose,
            'visit_immun' => $visit_immun,
            'prename' => $prename,
            'name' => $name,
            'slotdate' => $slotdate,
            'slottime' => $stime_h.".".$stime_m,
            'date_register' => $date_register,
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
