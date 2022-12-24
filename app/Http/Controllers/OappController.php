<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OappController extends Controller
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
        $que_card = Book::where('hn','=',$hn)->where('status','=',NULL)->orderBy('que_date', 'DESC')->orderBy('que_time', 'DESC')->get();

        $oapp = DB::connection('mysql_hos')->select('
        SELECT o.oapp_id,o.nextdate,o.nexttime,o.note,o.note1,o.note2,o.app_cause,o.contact_point,o.clinic,o.depcode
        ,o.app_user,d.name as doctor_name,o.oapp_status_id,o.opd_queue_slot_id
        FROM oapp o
        LEFT OUTER JOIN doctor d ON d.code = o.doctor
        WHERE o.hn = "'.$hn.'" ORDER BY o.nextdate DESC,o.nexttime DESC LIMIT 10
        ');

        return view('oapp.index', [
            'setting' => Setting::all(),
            'que_card' => $que_card,
            'oapp' => $oapp,
        ]);

    }

    public function detail()
    {
        session_start();
    if (isset($_SESSION["hn"])) {

        $view_page = "card.index";
        $hn = $_SESSION["hn"];

        $ext_q_status = Setting::where('id', 1)->first(['ext_q_status'])->ext_q_status;

        if ($ext_q_status == "Y") {
            $q_select = ",w.type,w.qnumber,w.pt_priority,w.room_code,w.time,w.time_complete,k.department,s.name AS spcltyname,w.`status` AS q_status";
            $q_join = "LEFT OUTER JOIN web_queue w ON w.vn = o.vn LEFT OUTER JOIN kskdepartment k ON k.depcode = w.room_code LEFT OUTER JOIN spclty s ON s.spclty = k.spclty";
            $q_order = "ORDER BY w.time DESC LIMIT 1";
        } else {
            $q_select = "";
            $q_join = "";
            $q_order = "";
        }

        $check_patient = DB::connection('mysql_hos')->select('
            SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic
            ,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year,o.vn
			'.$q_select.'
            FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype
            LEFT OUTER JOIN ovst o ON o.hn = p.hn AND o.vstdate = CURDATE()
            '.$q_join.'
            WHERE p.hn = "'.$hn.'"
            '.$q_order.'
            ');
        foreach($check_patient as $data){
            $vn = $data->vn;
        }

        $check_opduser = DB::connection('mysql_hos')->select('
        SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year
        FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype WHERE p.hn = "'.$hn.'"
        ');
        foreach($check_opduser as $data){
            $cid = $data->cid;
            $pname = $data->pname;
            $fname = $data->fname;
            $lname = $data->lname;
            $birthday = $data->birthday;
            $bloodgrp = $data->bloodgrp;
            $drugallergy = $data->drugallergy;
            $pttypename = $data->pttypename;
            $clinic = $data->clinic;
            $age_year = $data->age_year;
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
        $lineid = $_SESSION["lineid"];
        $tel = $_SESSION["tel"];
        $email = $_SESSION["email"];
    } else {
    }

        $oapp_detail = DB::connection('mysql_hos')->select('
        SELECT o.*,concat(p.pname,p.fname,"  ",p.lname) as ptname,p.cid as cid,d.name as doctor_name ,
        c.name as clinic_name,k.department,ov.icd10 as diag,icd.name as tname,os.oapp_status_name
        from oapp o
        left outer join oapp_status os on os.oapp_status_id=o.oapp_status_id
        left outer join patient p on p.hn=o.hn
        left outer join doctor d on d.code=o.doctor
        left outer join clinic c on c.clinic=o.clinic
        left outer join kskdepartment k on k.depcode=o.depcode
        left outer join ovstdiag ov on ov.vn=o.vn and ov.diagtype = "1"
        left outer join icd101 icd on icd.code=ov.icd10
        WHERE o.oapp_id = "'.$_GET['oappid'].'"
        ');

        return view('oapp.detail', [
            'setting' => Setting::all(),
            'oapp_detail' => $oapp_detail,
            'cid' => $cid,
            'hn' => $hn,
            'pname' => $pname,
            'fname' => $fname,
            'lname' => $lname,
            'birthday' => $birthday,
            'tel' => $tel,
            'email' => $email,
            'ptname' => $pname.$fname." ".$lname,
            'bloodgrp' => $bloodgrp,
            'drugallergy' => $drugallergy,
            'pttypename' => $pttypename,
            'clinic' => $clinic,
            'pic' => $pic,
            'age_year' => $age_year,
            'oappid' => $_GET['oappid'],
            'vn' => $vn,
        ]);

    }

    public function checkin(Request $request)
    {
        session_start();
        $hn = $_SESSION["hn"];
        // $lineid = $_SESSION["lineid"];
        $gps_stamp = explode(",", $request->input('gps_stamp'));
        $gps_latitude = substr($gps_stamp[0],0,6);
        $gps_longitude = substr($gps_stamp[1],0,7);

        $setting = Setting::all();
        foreach($setting as $data){
            $hoslocation = $data->hoslocation;
        }
        $locationsplit = explode(",", $hoslocation);
        $hos_latitude = substr($locationsplit[0],0,6);
        $hos_longitude = substr($locationsplit[1],0,7);
        $lat1 = $hos_latitude-0.003;
        $lat2 = $hos_latitude+0.003;
        $lon1 = $hos_longitude-0.003;
        $lon2 = $hos_longitude+0.003;

        if (($gps_latitude > $lat1 && $gps_latitude < $lat2) && ($gps_longitude > $lon1 && $gps_longitude < $lon2)) {
            $islocation = "true";
        } else {
            $islocation = "false";
        }

        // ไม่ทำงานหากไม่ได้อยู่ในพิกัดของโรงพยาบาล
        if ($islocation == "true") {

            $oappid = $request->input('oappid');

            $oappdata = DB::connection('mysql_hos')->select('
            SELECT * FROM oapp WHERE oapp_id = "'.$oappid.'"');
            foreach($oappdata as $data){
                $cc = $data->note;
                $spclty = $data->spclty;
                $depcode = $data->depcode;
            }
            $pttypedata = DB::connection('mysql_hos')->select('
            SELECT p.pttype,ptt.pttypeno,ptt.begindate,ptt.expiredate,ptt.hospmain,ptt.hospsub,ptt1.pcode,p.addressid,p.moopart
            ,p.cid,p.birthday,p.sex,p.pname,p.fname,p.lname
            ,timestampdiff(year,p.birthday,curdate()) AS cnt_year
            ,timestampdiff(month,p.birthday,curdate())-(timestampdiff(year,p.birthday,curdate())*12) AS cnt_month
            ,timestampdiff(day,date_add(p.birthday,interval (timestampdiff(month,p.birthday,curdate())) month),curdate()) AS cnt_day
            ,LPAD(ps.person_id,6,0) AS person_id
            FROM patient p
            LEFT JOIN pttype ptt1 ON p.pttype = ptt1.pttype
            LEFT JOIN pttypeno ptt ON p.hn = ptt.hn
            LEFT JOIN person ps ON p.hn = ps.patient_hn
            WHERE p.hn = "'.$hn.'" AND ptt.pttype = p.pttype
            ');
            foreach($pttypedata as $data){
                $pttype = $data->pttype;
                $pttypeno = $data->pttypeno;
                $pttypebegin = $data->begindate;
                $pttypeexpire = $data->expiredate;
                $hospmain = $data->hospmain;
                $hospsub = $data->hospsub;
                $pcode = $data->pcode;
                $aid = $data->addressid;
                $moopart = $data->moopart;
                $cid = $data->cid;
                $sex = $data->sex;
                $age_y = $data->cnt_year;
                $age_m = $data->cnt_month;
                $age_d = $data->cnt_day;
                $ptname = $data->pname.$data->fname." ".$data->lname;
                $person_id = $data->person_id;
            }

            $hospitalconfig = DB::connection('mysql_hos')->select("SELECT hospitalcode,hospitalname FROM opdconfig");
            foreach($hospitalconfig as $data){
                $hcode = $data->hospitalcode; // รหัส 5 หลักหน่วยบริการ
            }

            $staff = 'onlineapp';   // รหัสผู้ใช้ opduser

            $visitvar = DB::connection('mysql_hos')->select("SELECT
            CONCAT(SUBSTR(DATE_FORMAT(NOW(),'%Y')+543,3,2),DATE_FORMAT(NOW(),'%m%d'),DATE_FORMAT(NOW(),'%H%i%s')) AS visitnumber
            ,DATE_FORMAT(NOW(),'%Y-%m-%d') AS vstdate
            ,DATE_FORMAT(NOW(),'%H:%i:%s') AS vsttime
            ,DATE_FORMAT(NOW(),'%d%m%Y%H%i%s') AS logdatetime
            ,CONCAT('visit-lock-test-',DATE_FORMAT(NOW(),'%d%m'),DATE_FORMAT(NOW(),'%Y')+543) AS visitlocktest
            ,CONCAT('ovst-q-',SUBSTR(DATE_FORMAT(NOW(),'%Y')+543,3,2),DATE_FORMAT(NOW(),'%m%d')) AS serialovstq
            ,upper(concat('{',uuid(),'}')) AS hos_guid
            ");
            foreach($visitvar as $data){
                $visitnumber = $data->visitnumber;
                $vstdate = $data->vstdate;
                $vsttime = $data->vsttime;
                $visitlocktest = $data->visitlocktest;
                $serialovstq = $data->serialovstq;
                $hos_guid = $data->hos_guid;
                $ksklog_detail = $hn.$data->logdatetime.":VN".$data->visitnumber;
            }

            //*** GEN ovst_key ***//
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode=".$hcode."&vn=".$visitnumber."&computer_name=".$staff."&app_name='OPD'",
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $content = $response;
            $result = json_decode($content, true);
            $ovstkey = $result['result']['ovst_key'];
            //*** GEN ovst_key ***//

            $visitvar2 = DB::connection('mysql_hos')->select("SELECT
            upper(concat('{',uuid(),'}')) AS hos_guid2
            ");
            foreach($visitvar2 as $data){
                $hos_guid2 = $data->hos_guid2;
            }

            $serialvar = DB::connection('mysql_hos')->select('
            SELECT serial_no FROM serial WHERE name = "'.$serialovstq.'"
            ');
            foreach($serialvar as $data){
                if ($data->serial_no > 0) {
                    DB::connection('mysql_hos')->update('UPDATE serial set serial_no = serial_no+1 where name = "'.$serialovstq.'" ');
                } else {
                    DB::connection('mysql_hos')->insert('INSERT INTO serial (name,serial_no) VALUES ("'.$serialovstq.'",1) ');
                }
            }

            $ovst_seq = DB::connection('mysql_hos')->select('
            SELECT serial_no+1 AS serial_no2 FROM serial WHERE name = "ovst_seq_id"
            ');
            foreach($ovst_seq as $data){
                $ovst_seq_id = $data->serial_no2;
            }
            $ksklog = DB::connection('mysql_hos')->select('
            SELECT serial_no+1 AS serial_no3 FROM serial WHERE name = "ksklog_id"
            ');
            foreach($ksklog as $data){
                $ksklog_id = $data->serial_no3;
            }

            DB::connection('mysql_hos')->update('UPDATE serial set serial_no = serial_no+1 where name = "'.$visitlocktest.'" ');

            DB::connection('mysql_hos')->insert('INSERT INTO vn_insert (vn,clinic_list,hos_guid) VALUES ("'.$visitnumber.'",NULL,NULL) ');
            DB::connection('mysql_hos')->insert('
            INSERT INTO ovst (hos_guid,vn,hn,an,vstdate,vsttime,doctor,hospmain,hospsub,oqueue,ovstist,ovstost,pttype,pttypeno,rfrics,rfrilct,rfrocs,rfrolct
            ,spclty,rcpt_disease,hcode,cur_dep,cur_dep_busy,last_dep,cur_dep_time,rx_queue,diag_text,pt_subtype,main_dep,main_dep_queue,finance_summary_date
            ,visit_type,node_id,contract_id,waiting,rfri_icd10,o_refer_number,has_insurance,i_refer_number,refer_type,o_refer_dep,staff,command_doctor
            ,send_person,pt_priority,finance_lock,oldcode,sign_doctor,anonymous_visit,anonymous_vn,pt_capability_type_id,at_hospital,ovst_key)
            VALUES ("'.$hos_guid.'","'.$visitnumber.'","'.$hn.'",NULL,"'.$vstdate.'","'.$vsttime.'",NULL,"","","'.$serialovstq.'","02","00","'.$pttype.'","'.$pttypeno.'",NULL,NULL,NULL,NULL,"'.$spclty.'",NULL,"'.$hcode.'","'.$depcode.'",NULL,NULL,NULL,NULL,NULL,0,"'.$depcode.'",2,NULL,"O","",NULL,"Y",NULL,NULL,"N",NULL,NULL,NULL,"'.$staff.'",NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"'.$ovstkey.'")
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO ptdepart (vn,depcode,hn,intime,outdepcode,outtime,status,staff,outdate,hos_guid,hos_guid_ext)
            VALUES ("'.$visitnumber.'","'.$depcode.'","'.$hn.'","'.$vsttime.'","'.$depcode.'","'.$vsttime.'",NULL,"'.$staff.'","'.$vstdate.'",NULL,NULL)
            ');
            DB::connection('mysql_hos')->insert('
            INSERT INTO visit_pttype (vn,pttype,staff,rcpt_amount,debt_amount,discount_amount,begin_date,expire_date
            ,hospmain,hospsub,pttypeno,pttype_number,pttype_order,discount_percent,company_id,contract_id,max_debt_amount
            ,paid_amount,Claim_Code,hos_guid,limit_hour,check_limit_hour,finance_clear_ok,hos_guid_ext
            ,confirm_and_locked_datetime,confirm_and_locked,confirm_and_locked_staff,nhso_govcode,nhso_govname,nhso_docno
            ,nhso_ownright_pid,nhso_ownright_name,update_datetime,emp_privilege,emp_id,pttype_service_charge,pttype_note
            ,auth_code,rcpno_list)
            VALUES ("'.$visitnumber.'","'.$pttype.'",NULL,NULL,NULL,NULL,"'.$pttypebegin.'","'.$pttypeexpire.'","","","'.$pttypeno.'",1,NULL,NULL
            ,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL)
            ');
            DB::connection('mysql_hos')->insert('
            INSERT INTO ovst_finance (vn,finance_status,department_type,check_pttype,hos_guid,ed_amount,ned_amount
            ,other_amount,paidst_01_amount,paidst_02_amount,paidst_03_amount,paidst_01_03_wait_amount,paidst_04_amount)
            VALUES ("'.$visitnumber.'",1,"OPD","'.$pttype.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)
            ');

            DB::connection('mysql_hos')->update('UPDATE serial set serial_no = serial_no+1 where name="opd_regist_sendlist_id" ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO opd_regist_sendlist (opd_regist_sendlist_id,vn,staff,send_to_depcode,send_datetime,send_from_depcode
            ,send_to_spclty,hos_guid)
            VALUES ((SELECT serial_no FROM serial WHERE name="opd_regist_sendlist_id"),"'.$visitnumber.'","'.$staff.'","'.$depcode.'",NOW(),"'.$depcode.'","'.$spclty.'",NULL)
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO opdscreen (hos_guid,vn,hn,vstdate,vsttime,begintime,outtime,endtime,bpd,bps,bw,cc,hr,pe,pulse
            ,temperature,note,rr,cc_begin_date,cc_cause_of_visit,cc_sign,cc_duration,cc_position,cc_note,his_begin_date
            ,his_frequency,his_severity,his_cause,his_expand,his_cause_increase,his_cause_decrease,his_related_sign,height
            ,screen_dep,waiting,fbs,help1,help2,help3,help4,help1_time,help1_bps,help1_bpd,help2_time,help2_temp,help3_icode
            ,help3_time,help3_qty,help4_note,advice1,advice2,advice3,advice4,advice5,advice6,advice7,cradle,pe_ga,pe_heent
            ,pe_heart,pe_lung,pe_ab,pe_ext,pe_neuro,pe_ga_text,pe_heent_text,pe_heart_text,pe_lung_text,pe_ab_text
            ,pe_neuro_text,pe_ext_text,bmi,tg,hdl,glucurine,blank1,bun,creatinine,ua,hba1c,riskdm,skin_color,found_amphetamine
            ,pregnancy,advice7_note,checkup,er_note,found_allergy,hpi,pmh,fh,sh,ros,tc,ldl,ast,alt,symptom,walk_id,peak_flow
            ,cholesterol,waist,advice8,breast_feeding,cradle_lie,pain_score,pefr,opdscreen_patient_type_id
            ,creatinine_kidney_percent,sodium,chloride,potassium,tco2,smoking_type_id,drinking_type_id
            ,pulse_regulation_type_id,spo2,urine_albumin,urine_creatinine,pefr_percent,macro_albumin,micro_albumin,egfr
            ,hb,upcr,bicarb,phosphate,pth,pe_gy,pe_gy_text,pe_gu,pe_gu_text,pe_gi,pe_gi_text,bsa,pe_head,pe_head_text
            ,pe_skin,pe_skin_text,g6pd,pe_rtf,o2sat,pe_pv,pe_pv_text,pe_pr,pe_pr_text,pe_gen,pe_gen_text,pre_pain_score
            ,post_pain_score,head_cricumference,fev1_percent,pe_rtf_blob,bp_stable,pe_chest,pe_chest_text,lmp_date
            ,opdscreen_bp_loc_type_id,menstrual_cycle_type_id,adherence_percent,fev1_fevc,vaccine_screen_type_id
            ,development_screen_type_id,ambu,update_datetime)
            VALUES ("'.$hos_guid2.'","'.$visitnumber.'","'.$hn.'","'.$vstdate.'","'.$vsttime.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"'.$cc.'",1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
            ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO vn_stat (vn,hn,pdx,gr504,lastvisit,accident_code,dx_doctor,dx0,dx1,dx2
                    ,dx3,dx4,dx5,sex,age_y,age_m,age_d,aid,moopart,count_in_month
                    ,count_in_year,pttype,income,paid_money,remain_money,uc_money,item_money
                    ,dba,spclty,vstdate,op0,op1,op2,op3,op4,op5
                    ,rcp_no,print_count,print_done,pttype_in_region,pttype_in_chwpart,pcode,hcode
                    ,inc01,inc02,inc03,inc04,inc05,inc06,inc07,inc08,inc09,inc10,inc11,inc12,inc13,inc14,inc15,inc16
                    ,hospmain,hospsub,pttypeno,pttype_expire,cid,main_pdx
                    ,inc17,inc_drug,inc_nondrug,pt_subtype,rcpno_list,ym,node_id
                    ,ill_visit,count_in_day,pttype_begin,lastvisit_hour,rcpt_money,discount_money,old_diagnosis,debt_id_list,vn_guid,lastvisit_vn
                    ,hos_guid,rx_license_no,lab_paid_ok,xray_paid_ok)

            VALUES ("'.$visitnumber.'","'.$hn.'","",NULL,NULL,NULL,"","","","","","",""
                    ,"'.$sex.'","'.$age_y.'","'.$age_m.'","'.$age_d.'","'.$aid.'","'.$moopart.'",""
                    ,"","'.$pttype.'",0,0,0,0,0
                    ,NULL,"'.$spclty.'","'.$vstdate.'","","","","","",""
                    ,NULL,NULL,NULL,"Y","N","'.$pcode.'","'.$hcode.'"
                    ,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
                    ,"'.$hospmain.'","'.$hospsub.'","'.$pttypeno.'","'.$pttypeexpire.'","'.$cid.'",""
                    ,0,0,0,0,"",DATE_FORMAT(NOW(),"%Y-%m"),NULL
                    ,"Y",0,"'.$pttypebegin.'",NULL,0,0,"N","",NULL,""
                    ,NULL,NULL,NULL,NULL)
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO inc_opd_stat (vn,hn,vstdate,pttype,pcode,inc01,inc02,inc03,inc04,inc05,inc06,inc07,inc08,inc09
            ,inc10,inc11,inc12,inc13,inc14,inc15,inc16,inc17,income,inc_drug,inc_nondrug,uinc01,uinc02,uinc03,uinc04
            ,uinc05,uinc06,uinc07,uinc08,uinc09,uinc10,uinc11,uinc12,uinc13,uinc14,uinc15,uinc16,uinc17,uincome,uinc_drug
            ,uinc_nondrug,hos_guid)
            VALUES ("'.$visitnumber.'","'.$hn.'","'.$vstdate.'","'.$pttype.'",NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
            ,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL)
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO service_time (vn,hn,vstdate,vsttime,service1,service2,service3,service4,service5,service6,service7,service8,staff,service9,service10,rx_time_type,service11,service12,service13,service14,service15,service16,service17,service18,service19,last_send_time,service1_dep,service2_dep,service3_dep,service4_dep,service5_dep,service6_dep,service7_dep,service8_dep,service9_dep,service10_dep,service11_dep,service12_dep,service13_dep,service14_dep,service15_dep,service16_dep,service17_dep,service18_dep,service19_dep,service20,service20_dep,hos_guid)
            VALUES ("'.$visitnumber.'","'.$hn.'","'.$vstdate.'","'.$vsttime.'",NULL,NULL,DATE_FORMAT(NOW(),"%H:%i:%s"),NULL,NULL,NULL,NULL,NULL,"'.$staff.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s"),NULL,NULL,"'.$depcode.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)
            ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO visit_name (vn,hn,patient_name,hos_guid)
            VALUES ("'.$visitnumber.'","'.$hn.'","'.$ptname.'",NULL)
            ');

            DB::connection('mysql_hos')->update('
            UPDATE patient_stat SET last_vn="'.$visitnumber.'" WHERE hn="'.$hn.'"
            ');

            // DB::connection('mysql_hos')->insert('
            // INSERT INTO ovst_seq (vn,seq_id,pttype_check,pttype_check_datetime,pttype_check_staff,pcu_person_id,last_opdcard_depcode,protect_sensitive_data,rx_queue_no,stock_department_id,stock_department_queue_no,last_stock_department_id,nhso_seq_id,update_datetime,promote_visit,hos_guid,service_cost,last_rx_operator_staff,last_check_datetime,pttype_check_status_id,hospital_department_id,register_depcode,register_computer,doctor_list_text,er_pt_type,er_emergency_type,sub_spclty_id,doctor_patient_type_id,finance_status_flag,has_arrear,rx_ok,has_scan_doc,rx_queue_list,rx_queue_time,dx_text_list,opd_qs_slot_id,rx_transaction_id,doctor_dx_list_text,doctor_rx_list_text,pttype_list_text,hospmain_list_text,edc_approve_list_text,rx_priority_id,ovst_doctor_list_text)
            // VALUES ("'.$visitnumber.'","'.$ovst_seq_id.'","N",NULL,NULL,"'.$person_id.'",NULL,NULL,NULL,NULL,NULL,NULL,0,DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s"),"N",NULL,NULL,NULL,DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s"),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)
            // ');

            DB::connection('mysql_hos')->insert('
            INSERT INTO data_synchronize (vn,vn_guid,hn_guid,cid,last_update,last_sync,sync_complete,sync_mode,department,hos_guid)
            VALUES ("'.$visitnumber.'","'.$hos_guid.'",NULL
            ,"'.$cid.'",DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s"),NULL,"N","UPDATE",NULL,NULL)
            ');

            DB::connection('mysql_hos')->update('
            UPDATE oapp SET visit_vn="'.$visitnumber.'" WHERE oapp_id="'.$oappid.'"
            ');

            // DB::connection('mysql_hos')->insert('
            // INSERT INTO ksklog (ksklog_id,logtime,loginname,tablename,modifytype,detail,old_delta,new_delta,log_id,computer_name,hos_guid)
            // VALUES ("'.$ksklog_id.'",DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s"),"'.$staff.'","OVST","EDIT","'.$ksklog_detail.'"
            // ,NULL,NULL,NULL,"LINEAPP",NULL)
            // ');

            DB::connection('mysql_hos')->update('
            DELETE FROM pttypehistory WHERE hn = "'.$hn.'" AND pttype = "'.$pttype.'"
            ');
            DB::connection('mysql_hos')->insert('
            INSERT INTO pttypehistory (hn,expiredate,hospmain,hospsub,pttype,pttypeno,begindate,hos_guid,hos_guid_ext)
            VALUES ("'.$hn.'","'.$pttypeexpire.'","'.$hospmain.'","'.$hospsub.'","'.$pttype.'","'.$cid.'","'.$pttypebegin.'",NULL,NULL)
            ');

        } else {
            $oappid = "ขออภัย... คุณยังไม่ได้อยู่ที่โรงพยาบาล กรุณายืนยันเข้ารับบริการเมื่อมาถึงโรงพยาบาลแล้วเท่านั้น";
            // $oappid = $gps_stamp." : ".$hoslocation;
        }

        return redirect()->route('statusq')->with('oapp-statusq',$oappid);

    }

    public function statusq()
    {
        session_start();
        $hn = $_SESSION["hn"];
        $ext_q_status = Setting::where('id', 1)->first(['ext_q_status'])->ext_q_status;

        if (isset($_GET['oappid'])) {
            $oappid = $_GET['oappid'];
        } else {
            $oappid = Session('oapp-statusq');
        }

        if ($ext_q_status == "Y") {
            $q_select = ",w.type,w.qnumber,w.pt_priority,w.room_code,w.time,w.time_complete,k.department,s.spclty,s.name AS spcltyname,w.`status` AS q_status";
            $q_join = "LEFT OUTER JOIN web_queue w ON w.vn = o.vn LEFT OUTER JOIN kskdepartment k ON k.depcode = w.room_code LEFT OUTER JOIN spclty s ON s.spclty = k.spclty";
            $q_order = "ORDER BY w.time DESC LIMIT 1";
        } else {
            $q_select = ",s.name AS spclty,o.main_dep,k.department";
            $q_join = "LEFT OUTER JOIN spclty s ON s.spclty = o.spclty LEFT OUTER JOIN kskdepartment k ON k.depcode = o.main_dep";
            $q_order = "";
        }

        $check_patient = DB::connection('mysql_hos')->select('
        SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic,o.vstdate,o.vsttime
        ,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year,o.vn
        '.$q_select.'
        FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype
        LEFT OUTER JOIN ovst o ON o.hn = p.hn AND o.vstdate = CURDATE()
        '.$q_join.'
        WHERE p.hn = "'.$hn.'"
        '.$q_order.'
        ');
        foreach($check_patient as $data){
            $vstdate = $data->vstdate;
            $vsttime = $data->vsttime;
            $vn = $data->vn;
            $spclty = $data->spclty;
            $department = $data->department;

            if ($ext_q_status == "Y") {
                $webq = $data->type.$data->qnumber;
                $webqn = $data->qnumber;
                $department = $data->department;
                $spcltyname = $data->spcltyname;
                $pt_priority = $data->pt_priority;
                $q_status = $data->q_status;
                $time = $data->time;
                $room_code3 = $data->room_code;

                if ($data->room_code == "999") {
                    $room_code = 1;
                } else {
                    $room_code = 0;
                }
            }
        }

        if ($ext_q_status == "Y") {

            $wait_qp = DB::connection('mysql_hos')->select('
            SELECT COUNT(*) AS waitq FROM web_queue
            WHERE room_code = "'.$room_code.'" AND `status` = "1" AND pt_priority <> "0"
            ');
            foreach($wait_qp as $data){
                $waitqp = $data->waitq;
            }

            if ($room_code == 0) {
                if ($room_code3 == "") {
                    $room_code2 = "0";
                    $webqn2 = 0;
                } else {
                    $room_code2 = $room_code3;
                    $webqn2 = $webqn;
                }
            } else {
                $room_code2 = "0";
                $webqn2 = 0;
            }

            if ($pt_priority == "1") {
                $waitqp2 = 0;
                $priority = "1";
                $pri_color = "yellow";
            } else if ($pt_priority == "2") {
                $waitqp2 = 0;
                $priority = "2";
                $pri_color = "red";
            } else {
                $waitqp2 = $waitqp;
                $priority = "0";
                $pri_color = "green";
            }

            $wait_q = DB::connection('mysql_hos')->select('
            SELECT COUNT(*) AS waitq FROM web_queue
            WHERE room_code = "'.$room_code2.'" AND `status` = "1" AND pt_priority = "'.$priority.'"
            AND qnumber < '.$webqn2.'
            ');
            foreach($wait_q as $data){
                $waitq = $data->waitq+$waitqp2;
            }

        } else {
                $webq = "";
                $webqn = "";
                // $department = "";
                $spcltyname = "";
                $waitq = "";
                $pri_color = "";
                $q_status = "";
                $time = "";
                $room_code = 0;
        }

        $oapp_detail = DB::connection('mysql_hos')->select('
        SELECT o.*,concat(p.pname,p.fname,"  ",p.lname) as ptname,p.cid as cid,d.name as doctor_name ,
        c.name as clinic_name,k.department,ov.icd10 as diag,icd.name as tname,os.oapp_status_name
        from oapp o
        left outer join oapp_status os on os.oapp_status_id=o.oapp_status_id
        left outer join patient p on p.hn=o.hn
        left outer join doctor d on d.code=o.doctor
        left outer join clinic c on c.clinic=o.clinic
        left outer join kskdepartment k on k.depcode=o.depcode
        left outer join ovstdiag ov on ov.vn=o.vn and ov.diagtype = "1"
        left outer join icd101 icd on icd.code=ov.icd10
        WHERE o.oapp_id = "'.$oappid.'"
        ');

        return view('oapp.statusq', [
            'setting' => Setting::all(),
            'oapp_detail' => $oapp_detail,
            'oappid' => $oappid,
            'vn' => $vn,
            'webq' => $webq,
            'webqn' => $webqn,
            'department' => $department,
            'spcltyname' => $spcltyname,
            'spclty' => $spclty,
            'waitq' => $waitq,
            'pri_color' => $pri_color,
            'q_status' => $q_status,
            'time' => $time,
            'vstdate' => $vstdate,
            'vsttime' => $vsttime,
            'room_code' => $room_code,
        ]);

    }

    public function oappman()
    {
        session_start();
        $hn = $_SESSION["hn"];

        $check_user = DB::connection('mysql')->select('
        SELECT * FROM patientusers WHERE hn = "'.$hn.'"
        ');
        foreach($check_user as $data){
            if ($data->que_app_flag == NULL) {
                $user_flag =  ' ';
            } else {
                $user_flag =  'AND f.que_app_flag = "'.$data->que_app_flag.'" ';
            }
        }

        $que_pt_man = DB::connection('mysql')->select('
        SELECT q.*,pt.*,f.*,t.*
        FROM que_card q
        LEFT OUTER JOIN patientusers pt ON pt.hn = q.hn
        LEFT OUTER JOIN que_app_flag f ON f.que_app_flag = q.que_app_flag
        LEFT OUTER JOIN que_time t ON t.que_app_flag = q.que_app_flag AND t.que_time = q.que_time
        WHERE q.`status` IS NULL '.$user_flag.'
        ');

        return view('oapp.oappman', [
            'setting' => Setting::all(),
            'que_pt_man' => $que_pt_man,
            'lineid' => $_SESSION["lineid"],
        ]);
    }

    public function oappconfirm()
    {
        // $que_add_oapp_table = DB::connection('mysql_hos')->select('');

        DB::connection('mysql')->update('
        UPDATE que_card SET status = "'.$_GET['status'].'" WHERE id = "'.$_GET['id'].'"
        ');

        $lineidpt = $_GET['lineid'];
        if ($_GET['status'] == "1") {

            $que_add_oapp_table1 = DB::connection('mysql_hos')->select('SELECT (SELECT serial_no+1 FROM serial WHERE `name` = "oapp_id") AS oapp_id,hn,MAX(o.vn) AS vn,o.vstdate
            ,DATE_FORMAT(NOW(),"%Y-%m-%d") AS datenow,DATE_FORMAT(NOW(),"%h:%i:%s") AS timenow,o.pttype
            FROM ovst o WHERE o.hn = "'.$_GET['hn'].'" ');
            foreach($que_add_oapp_table1 as $data){
                $oapp_id = $data->oapp_id;
                $hn = $data->hn;
                $vn = $data->vn;
                $vstdate = $data->vstdate;
                $datenow = $data->datenow;
                $timenow = $data->timenow;
                $pttype = $data->pttype;
            }

            DB::connection('mysql_hos')->update('
            UPDATE serial SET serial_no = '.$oapp_id.' WHERE `name` = "oapp_id"
            ');

            DB::connection('mysql_hos')->insert('INSERT INTO oapp (oapp_id,hn,vn,vstdate,nextdate,nexttime
            ,clinic,depcode,doctor,note,spclty,app_user,app_cause,contact_point,note1,app_no,endtime,nexttime_end,next_pttype
            ,entry_date,entry_time,operation_appointment,operation_note,oapp_status_id)
            VALUES ('.$oapp_id.',"'.$hn.'","'.$vn.'","'.$vstdate.'","'.$_GET['date'].'"
            ,"'.$_GET['stime'].'","'.$_GET['clinic'].'","'.$_GET['dep'].'","'.$_GET['doctor'].'","'.$_GET['cc'].'","'.$_GET['spclty'].'","นัดออนไลน์","ตรวจรักษา","ห้องบัตร","กรุณามายืนยันเข้ารับบริการก่อนเวลานัดอย่างน้อย 30 นาที",1
            ,"'.$_GET['etime'].'","'.$_GET['etime'].'","'.$pttype.'","'.$datenow.'","'.$timenow.'","N","OperationNoteEdit",9)
            ');

            $alert_oappman_message = "จองนัด".$_GET['flag']."@".$_GET['ptname']."@วันที่ ".DateThaiFull($_GET['date'])."@เวลา ".$_GET['time']."@ได้รับการยืนยันแล้ว@".$lineidpt." ";
        } else {
            $alert_oappman_message = "จองนัด".$_GET['flag']."@".$_GET['ptname']."@วันที่ ".DateThaiFull($_GET['date'])."@เวลา ".$_GET['time']."@***ยกเลิกแล้ว***@".$lineidpt." ";
        }

        return redirect()->route('oappman')->with('oapp-updated',$alert_oappman_message);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session_start();
        $lineid = $_SESSION["lineid"];
        $patientuser = DB::connection('mysql')->select('SELECT * FROM patientusers WHERE lineid = "'.$lineid.'" ');
        foreach($patientuser as $data){
            $patientuser_hn2 = $data->hn2;
            $patientuser_hn3 = $data->hn3;
        }

        if ($patientuser_hn2 == "") {
            $pname2 = "";
            $fname2 = "";
            $lname2 = "";
            $birthday2 = "";
            $cid2 = "";
            $hn2 = "";
            $pname3 = "";
            $fname3 = "";
            $lname3 = "";
            $birthday3 = "";
            $cid3 = "";
            $hn3 = "";
            $regist_number = "ลงทะเบียนคนที่ 1";
        } else if ($patientuser_hn3 == "") {
            $pt_hn2 = DB::connection('mysql_hos')->select('
                SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname,birthday FROM patient
                WHERE hn = "'.$patientuser_hn2.'"
                ');
            foreach($pt_hn2 as $data){
                $pname2 = $data->pname;
                $fname2 = $data->fname;
                $lname2 = $data->lname;
                $birthday2 = $data->birthday;
                $cid2 = $data->cid;
                $hn2 = $data->hn;
                $pname3 = "";
                $fname3 = "";
                $lname3 = "";
                $birthday3 = "";
                $cid3 = "";
                $hn3 = "";
            }
            $regist_number = "ลงทะเบียนคนที่ 2";
        } else {
            $pt_hn2 = DB::connection('mysql_hos')->select('
                SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname,birthday FROM patient
                WHERE hn = "'.$patientuser_hn2.'"
                ');
            foreach($pt_hn2 as $data){
                $pname2 = $data->pname;
                $fname2 = $data->fname;
                $lname2 = $data->lname;
                $birthday2 = $data->birthday;
                $cid2 = $data->cid;
                $hn2 = $data->hn;
            }
            $pt_hn3 = DB::connection('mysql_hos')->select('
                SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname,birthday FROM patient
                WHERE hn = "'.$patientuser_hn3.'"
                ');
            foreach($pt_hn3 as $data){
                $pname3 = $data->pname;
                $fname3 = $data->fname;
                $lname3 = $data->lname;
                $birthday3 = $data->birthday;
                $cid3 = $data->cid;
                $hn3 = $data->hn;
            }
            $regist_number = "คุณลงทะเบียนครบแล้ว";
        }

        return view('oapp.oapp_regist_another', [
            'setting' => Setting::all(),
            'app_regist_another' => "ลงทะเบียนบุคคลอื่น",
            'patientuser_hn2' => $patientuser_hn2,
            'patientuser_hn3' => $patientuser_hn3,
            'regist_number' => $regist_number,
            'lineid' => $lineid,
            'pname2' => $pname2,
            'fname2' => $fname2,
            'lname2' => $lname2,
            'birthday2' => $birthday2,
            'cid2' => $cid2,
            'hn2' => $hn2,
            'pname3' => $pname3,
            'fname3' => $fname3,
            'lname3' => $lname3,
            'birthday3' => $birthday3,
            'cid3' => $cid3,
            'hn3' => $hn3,
        ]);
    }

    public function updatecheck(Request $request)
    {
        session_start();
        $lineid = $_SESSION["lineid"];
        $regist_number = $request->get('regist_number');
        $patientuser_hn2 = $request->get('patientuser_hn2');
        $patientuser_hn3 = $request->get('patientuser_hn3');

        $acid = $request->get('acid');
        $bdate = $request->get('abirthday');
        $dd = substr($bdate,0,2);
        $mm = substr($bdate,2,2);
        $yyyy = substr($bdate,4,4)-543;
        $birthday = $yyyy."-".$mm."-".$dd;
        $birthday = trim($birthday);

        $check_opduser = DB::connection('mysql_hos')->select('
        SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname,birthday FROM patient
        WHERE cid = "'.$acid.'" AND birthday = "'.$birthday.'"
        ');

        foreach($check_opduser as $data){
            if ($data->userregist > 0) {
                return view('oapp.oapp_regist_check', [
                    'setting' => Setting::all(),
                    'app_regist_another' => "ลงทะเบียนบุคคลอื่น",
                    'patientuser_hn2' => $patientuser_hn2,
                    'patientuser_hn3' => $patientuser_hn3,
                    'regist_number' => $regist_number,
                    'lineid' => $lineid,
                    'pname' => $data->pname,
                    'fname' => $data->fname,
                    'lname' => $data->lname,
                    'birthday' => $data->birthday,
                    'cid' => $data->cid,
                    'hn' => $data->hn,
                ]);
            } else {
                return redirect()->route('oapp')->with('session-alert', 'ไม่พบข้อมูลทะเบียนผู้ป่วย หรือคุณอาจกรอกข้อมูลไม่ถูกต้อง ! กรุณาตรวจสอบเลขบัตรประชาชน และวันเดือนปีเกิดให้ถูกต้อง...');
            }
        }
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
    public function update(Request $request)
    {
        session_start();
        $lineid = $_SESSION["lineid"];

        $acid = $request->get('acid');
        $birthday = $request->get('abirthday');

        $check_opduser = DB::connection('mysql_hos')->select('
        SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname FROM patient
        WHERE cid = "'.$acid.'" AND birthday = "'.$birthday.'"
        ');

        foreach($check_opduser as $data){
            if ($data->userregist > 0) {
                if ($request->regist_number == "ลงทะเบียนคนที่ 1") {
                    DB::connection('mysql')->update('UPDATE patientusers SET hn2 = "'.$data->hn.'" WHERE lineid = "'.$lineid.'" ');
                } else {
                    DB::connection('mysql')->update('UPDATE patientusers SET hn3 = "'.$data->hn.'" WHERE lineid = "'.$lineid.'" ');
                }
                return redirect()->route('oapp')->with('session-alert', 'คุณลงทะเบียนบุคคลอื่นสำเร็จแล้ว');
            } else {
                return redirect()->route('ptregister.index')->with('session-alert', 'ไม่พบข้อมูลทะเบียนผู้ป่วยของคุณ หรือคุณอาจกรอกข้อมูลไม่ถูกต้อง ! กรุณาตรวจสอบเลขบัตรประชาชน และวันเดือนปีเกิดให้ถูกต้อง... หรือกรอกข้อมูลเพื่อลงทะเบียนทำบัตรใหม่');
            }
        }
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
