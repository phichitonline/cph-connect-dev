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

        $check_patient = DB::connection('mysql_hos')->select('
            SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic,w.`status` AS q_status
            ,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year,o.vn,w.type,w.qnumber,w.pt_priority,w.room_code,k.department,s.name AS spcltyname,w.time,w.time_complete
            FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype
            LEFT OUTER JOIN ovst o ON o.hn = p.hn AND o.vstdate = CURDATE()
            LEFT OUTER JOIN web_queue w ON w.vn = o.vn
            LEFT OUTER JOIN kskdepartment k ON k.depcode = w.room_code
            LEFT OUTER JOIN spclty s ON s.spclty = k.spclty
            WHERE p.hn = "'.$hn.'"
            ORDER BY w.time DESC LIMIT 1
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

    public function checkin()
    {
        session_start();
        $hn = $_SESSION["hn"];
        $lineid = $_SESSION["lineid"];
        $oappid = $_GET['oappid'];

/*
        $depcode = '307';
        $staff = 'ghost';
        $cc = '';
        $cid = '3660100100201';
        $pttype = '23';
        $pttypeno = '';
        $pttypebegin = '';
        $pttypeexpire = '';
        $pcode = '';
        $sex = '';
        $age_y = '';
        $age_m = '';
        $age_d = '';
        $aid = '';
        $moopart = '';
        $spclty = '01';
        $hcode = '11456';

        DB::connection('mysql_hos')->update("

        SET @visitnumber := CONCAT(SUBSTR(DATE_FORMAT(NOW(),'%Y')+543,3,2),DATE_FORMAT(NOW(),'%m%d'),DATE_FORMAT(NOW(),'%H%i%s'));
        SET @vstdate := DATE_FORMAT(NOW(),'%Y-%m-%d');
        SET @vsttime := DATE_FORMAT(NOW(),'%H:%i:%s');
        SET @visitlocktest := CONCAT('visit-lock-test-',DATE_FORMAT(NOW(),'%d%m'),DATE_FORMAT(NOW(),'%Y')+543);
        SET @serialovstq := CONCAT('ovst-q-',SUBSTR(DATE_FORMAT(NOW(),'%Y')+543,3,2),DATE_FORMAT(NOW(),'%m%d'));

        INSERT INTO vn_insert (vn,clinic_list,hos_guid) VALUES (@visitnumber,NULL,NULL);
        update serial set serial_no=serial_no+1 where name = @visitlocktest;
        update serial set serial_no=serial_no+1 where name = @serialovstq;

        INSERT INTO ovst (hos_guid,vn,hn,an,vstdate,vsttime,doctor,hospmain,hospsub,oqueue,ovstist,ovstost,pttype,pttypeno,rfrics,rfrilct,rfrocs,rfrolct
        ,spclty,rcpt_disease,hcode,cur_dep,cur_dep_busy,last_dep,cur_dep_time,rx_queue,diag_text,pt_subtype,main_dep,main_dep_queue,finance_summary_date
        ,visit_type,node_id,contract_id,waiting,rfri_icd10,o_refer_number,has_insurance,i_refer_number,refer_type,o_refer_dep,staff,command_doctor
        ,send_person,pt_priority,finance_lock,oldcode,sign_doctor,anonymous_visit,anonymous_vn,pt_capability_type_id,at_hospital)
        VALUES (upper(concat('{',uuid(),'}')),@visitnumber,".$hn.",NULL,@vstdate,@vsttime,NULL,'',''
        ,(SELECT serial_no+1 FROM serial WHERE name = CONCAT('ovst-q-',SUBSTR(DATE_FORMAT(NOW(),'%Y')+543,3,2),DATE_FORMAT(NOW(),'%m%d')))
        ,'02','00',".$pttype.",".$pttypeno."
        ,NULL,NULL,NULL,NULL,".$spclty.",NULL,".$hcode.",NULL,NULL,".$depcode.",NULL,NULL,NULL,0,NULL,2,NULL,'O','',NULL,'Y',NULL,NULL,'N',NULL
        ,NULL,NULL,".$staff.",NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

        INSERT INTO ptdepart (vn,depcode,hn,intime,outdepcode,outtime,status,staff,outdate,hos_guid,hos_guid_ext)
        VALUES (@visitnumber,".$depcode.",".$hn.",@vsttime,".$depcode.",@vsttime,NULL,".$staff.",@vstdate,NULL,NULL);

        INSERT INTO visit_pttype (vn,pttype,staff,rcpt_amount,debt_amount,discount_amount,begin_date,expire_date
        ,hospmain,hospsub,pttypeno,pttype_number,pttype_order,discount_percent,company_id,contract_id,max_debt_amount
        ,paid_amount,Claim_Code,hos_guid,limit_hour,check_limit_hour,finance_clear_ok,hos_guid_ext
        ,confirm_and_locked_datetime,confirm_and_locked,confirm_and_locked_staff,nhso_govcode,nhso_govname,nhso_docno
        ,nhso_ownright_pid,nhso_ownright_name,update_datetime,emp_privilege,emp_id,pttype_service_charge,pttype_note
        ,auth_code,rcpno_list)
        VALUES (@visitnumber,".$pttype.",NULL,NULL,NULL,NULL,".$pttypebegin.",".$pttypeexpire.",'','',".$pttypeno.",1,NULL,NULL
        ,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL);

        INSERT INTO ovst_finance (vn,finance_status,department_type,check_pttype,hos_guid,ed_amount,ned_amount
        ,other_amount,paidst_01_amount,paidst_02_amount,paidst_03_amount,paidst_01_03_wait_amount,paidst_04_amount)
        VALUES (@visitnumber,1,'OPD',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

        update serial set serial_no=serial_no+1 where name='opd_regist_sendlist_id';

        INSERT INTO opd_regist_sendlist (opd_regist_sendlist_id,vn,staff,send_to_depcode,send_datetime,send_from_depcode
        ,send_to_spclty,hos_guid)
        VALUES ((SELECT serial_no FROM serial WHERE name='opd_regist_sendlist_id'),@visitnumber,".$staff.",".$depcode.",NOW(),".$depcode.",".$spclty.",NULL);

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
        VALUES (upper(concat('{',uuid(),'}')),@visitnumber,".$hn.",@vstdate,@vsttime,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,@cc,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

        INSERT INTO vn_stat (vn,hn,pdx,gr504,lastvisit,accident_code,dx_doctor,dx0,dx1,dx2,dx3,dx4,dx5,sex,age_y
        ,age_m,age_d,aid,moopart,count_in_month,count_in_year,pttype,income,paid_money,remain_money,uc_money
        ,item_money,dba,spclty,vstdate,op0,op1,op2,op3,op4,op5,rcp_no,print_count,print_done,pttype_in_region
        ,pttype_in_chwpart,pcode,hcode,inc01,inc02,inc03,inc04,inc05,inc06,inc07,inc08,inc09,inc10,inc11,inc12
        ,inc13,inc14,inc15,inc16,hospmain,hospsub,pttypeno,pttype_expire,cid,main_pdx,inc17,inc_drug,inc_nondrug
        ,pt_subtype,rcpno_list,ym,node_id,ill_visit,count_in_day,pttype_begin,lastvisit_hour,rcpt_money
        ,discount_money,old_diagnosis,debt_id_list,vn_guid,lastvisit_vn,hos_guid,rx_license_no,lab_paid_ok
        ,xray_paid_ok)
        VALUES (@visitnumber,".$hn.",'',NULL,NULL,NULL,'','','','','','','',".sex.",".$age_y.",".$age_m.",".$age_d.",".$aid.",".$moopart.",'','',".$pttype."
        ,0,0,0,0,0,NULL,".$spclty.",@vstdate,'','','','','','',NULL,NULL,NULL,'Y','N',".$pcode.",".$hcode.",0,0,0,0,0,0,0,0,0,0
        ,0,0,0,0,0,0,'','',".$pttypeno.",".$pttypeexpire.",".$cid.",'',0,0,0,0,'\"\"',DATE_FORMAT(NOW(),'%Y-%m'),NULL,'Y',0
        ,".$pttypebegin.",NULL,0,0,'Y','',NULL,NULL,NULL,NULL,NULL,NULL);

        INSERT INTO inc_opd_stat (vn,hn,vstdate,pttype,pcode,inc01,inc02,inc03,inc04,inc05,inc06,inc07,inc08,inc09
        ,inc10,inc11,inc12,inc13,inc14,inc15,inc16,inc17,income,inc_drug,inc_nondrug,uinc01,uinc02,uinc03,uinc04
        ,uinc05,uinc06,uinc07,uinc08,uinc09,uinc10,uinc11,uinc12,uinc13,uinc14,uinc15,uinc16,uinc17,uincome,uinc_drug
        ,uinc_nondrug,hos_guid)
        VALUES (@visitnumber,".$hn.",@vstdate,".$pttype.",NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
        ,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL);

        ");
*/
        // DB::connection('mysql_hos')->insert('INSERT INTO ovst (hn,vn) VALUES ('.$hn.'","'.$vn.') ');

        return redirect()->route('statusq')->with('oapp-statusq',$oappid);

    }

    public function statusq()
    {
        session_start();
        $hn = $_SESSION["hn"];
        if (isset($_GET['oappid'])) {
            $oappid = $_GET['oappid'];
        } else {
            $oappid = Session('oapp-statusq');
        }

        $check_patient = DB::connection('mysql_hos')->select('
        SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic,w.`status` AS q_status,o.vstdate,o.vsttime
        ,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year,o.vn,w.type,w.qnumber,w.pt_priority,w.room_code,k.department,s.name AS spcltyname,w.time,w.time_complete
        FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype
        LEFT OUTER JOIN ovst o ON o.hn = p.hn AND o.vstdate = CURDATE()
        LEFT OUTER JOIN web_queue w ON w.vn = o.vn
        LEFT OUTER JOIN kskdepartment k ON k.depcode = w.room_code
        LEFT OUTER JOIN spclty s ON s.spclty = k.spclty
        WHERE p.hn = "'.$hn.'"
        ORDER BY w.time DESC LIMIT 1
        ');
        foreach($check_patient as $data){
            $clinic = $data->clinic;
            $vn = $data->vn;
            $webq = $data->type.$data->qnumber;
            $webqn = $data->qnumber;
            $department = $data->department;
            $spcltyname = $data->spcltyname;
            $pt_priority = $data->pt_priority;
            $q_status = $data->q_status;
            $time = $data->time;
            $time_complete = $data->time_complete;
            $vstdate = $data->vstdate;
            $vsttime = $data->vsttime;
            $room_code3 = $data->room_code;

                if ($data->room_code == "999") {
                    $room_code = 1;
                } else {
                    $room_code = 0;
                }
        }

        $wait_qp = DB::connection('mysql_hos')->select('
        SELECT COUNT(*) AS waitq FROM web_queue
        WHERE room_code = "'.$room_code.'" AND `status` = "1" AND pt_priority <> "0"
        AND type IN ("A","S")
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
        AND type IN ("A","S") AND qnumber < '.$webqn2.'
        ');
        foreach($wait_q as $data){
            $waitq = $data->waitq+$waitqp2;
        }

        $lineid = $_SESSION["lineid"];
        $tel = $_SESSION["tel"];
        $email = $_SESSION["email"];


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
            $regist_number = "ลงทะเบียนคนที่ 1";
        } else if ($patientuser_hn3 == "") {
            $regist_number = "ลงทะเบียนคนที่ 2";
        } else {
            $regist_number = "คุณลงทะเบียนครบแล้ว";
        }

        return view('oapp.oapp_regist_another', [
            'setting' => Setting::all(),
            'app_regist_another' => "ลงทะเบียนบุคคลอื่น",
            'patientuser_hn2' => $patientuser_hn2,
            'patientuser_hn3' => $patientuser_hn3,
            'regist_number' => $regist_number,
            'lineid' => $lineid,
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
                return redirect()->route('ptregister.index')->with('session-alert', 'ไม่พบข้อมูลทะเบียนผู้ป่วยของคุณ หรือคุณอาจกรอกข้อมูลไม่ถูกต้อง ! กรุณาตรวจสอบเลขบัตรประชาชน และวันเดือนปีเกิดให้ถูกต้อง... หรือกรอกข้อมูลเพื่อลงทะเบียนทำบัตรใหม่');
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
