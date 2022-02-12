<?php

namespace App\Http\Controllers;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PtRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        session_destroy();
        return view('patient.check', [
            'moduletitle' => "ลงทะเบียนผู้ป่วยใหม่",
            'view_menu' => "disable",
        ]);
    }

    public function ptcheck(request $request)
    {
        $cid = $request->get('cid');
        $bdate = $request->get('birthday');
        session_start();
        ob_start();
        $_SESSION["cid"] = $request->get('cid');
        $_SESSION["birthdate"] = $request->get('birthday');
        session_write_close();
        $dd = substr($bdate,0,2);
        $mm = substr($bdate,2,2);
        $yyyy = substr($bdate,4,4)-543;
        $birthday = $yyyy."-".$mm."-".$dd;
        $birthday = trim($birthday);

        $check_opduser = DB::connection('mysql_hos')->select('
        SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname,birthday FROM patient
        WHERE cid = "'.$cid.'"
        ');
        // $check_opduser = DB::connection('mysql_hos')->select('
        // SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname FROM patient
        // WHERE cid = "'.$cid.'" AND birthday = "'.$birthday.'"
        // ');
        foreach($check_opduser as $data){
            if ($data->userregist > 0) {
                session_start();
                ob_start();
                $_SESSION["hn"] = $data->hn;
                $_SESSION["pname"] = $data->pname;
                $_SESSION["fname"] = $data->fname;
                $_SESSION["lname"] = $data->lname;
                $_SESSION["birthday"] = $data->birthday;
                session_write_close();
                return redirect()->route('ptinfo')->with(
                    'session-alert', 'คุณมีบัตรผู้ป่วยแล้ว'
                );
            } else {
                if (valid_citizen_id($cid) == 1) {
                    return redirect()->route('ptregister.create')->with(
                        'session-alert', 'คุณยังไม่มีประวัติโรงพยาบาล กรอกข้อมูลเพื่อลงทะเบียนใหม่'
                    );
                } else {
                    return redirect()->route('ptregister.index')->with(
                        'session-alert-cid', 'เลขบัตรประชาชน '.$cid.' ไม่ถูกต้อง กรุณาตรวจสอบ'
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
    public function ptinfo(Request $request)
    {
        session_start();
        $cid = $_SESSION["cid"];
        $birthdate = $_SESSION["birthdate"];
        $hn = $_SESSION["hn"];
        $pname = $_SESSION["pname"];
        $fname = $_SESSION["fname"];
        $lname = $_SESSION["lname"];
        $birthday = $_SESSION["birthday"];

        $dd = substr($birthdate,0,2);
        $mm = substr($birthdate,2,2);
        $yyyy = substr($birthdate,4,4)-543;
        $birthday2 = $yyyy."-".$mm."-".$dd;
        // $birthday = trim($birthday);

        return view('patient.ptinfo', [
            'moduletitle' => "ข้อมูลผู้ป่วยของคุณ",
            'view_menu' => "disable",
            'cid' => $cid,
            'birthdate' => $birthday2,
            'birthday' => $birthday,
            'hn' => $hn,
            'pname' => $pname,
            'fname' => $fname,
            'lname' => $lname,
        ]);
    }

    public function create(Request $request)
    {
        session_start();

        if (isset($_SESSION["lineid"])) {
            $lineid = $_SESSION["lineid"];
            $email = $_SESSION["email"];
        } else {
            $lineid = "";
            $email = "";
        }
        
        if (!isset($_GET['cid'])) {
            $cid = $_SESSION["cid"];
            $birthdate = $_SESSION["birthdate"];
        } else {
            $cid = $_GET['cid'];
            $birthdate = $_GET["birthdate"];
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $fromip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $fromip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $fromip = $_SERVER['REMOTE_ADDR'];
        }

        $osbrowser = $_SERVER['HTTP_USER_AGENT'];
        $cid_encode = strtoupper(md5($cid)).":".substr($cid,1,1).substr($cid,-1);
        
        DB::connection('mysql')->insert('INSERT INTO log_ptregister (id,cid,fromip,osbrowser,log_datetime) VALUES (NULL,"'.$cid_encode.'","'.$fromip.'","'.$osbrowser.'",NOW())');

        if (!isset($_SESSION["get_uuid"])) {
            $get_hos_value = DB::connection('mysql_hos')->select('
                SELECT upper(concat("{",uuid(),"}")) AS get_uuid,LPAD((select serial_no as chn from serial where name="HN")+1,9,"0") AS get_hn
                ,(select serial_no as chn from serial where name="HN")+1 AS get_serial_no
            ');
            foreach ($get_hos_value as $data) {
                $hos_guid = $data->get_uuid;
                $serial_no = $data->get_serial_no;
                $hn = $data->get_hn;
                ob_start();
                $_SESSION["get_uuid"] = $data->get_uuid;
                $_SESSION["get_serial_no"] = $data->get_serial_no;
                $_SESSION["get_hn"] = $data->get_hn;
                session_write_close();
            }
            DB::connection('mysql_hos')->insert('INSERT INTO hnlock (hn,optype,onlineid,lock_datetime) VALUES ("'.$hn.'","GetHN","'.$cid.'",NOW())');
            DB::connection('mysql_hos')->update('UPDATE serial SET serial_no = "'.$serial_no.'" WHERE name = "HN"');
        } else {
            $hos_guid = $_SESSION["get_uuid"];
            $serial_no = $_SESSION["get_serial_no"];
            $hn = $_SESSION["get_hn"];
        }


        $occupation = DB::connection('mysql_hos')->table('occupation')
        ->orderBy('name','ASC')->get();
        $nationality = DB::connection('mysql_hos')->table('nationality')
        ->orderBy('name','ASC')->get();
        $religion = DB::connection('mysql_hos')->table('religion')
        ->orderBy('name','ASC')->get();
        $emp_citizenship = DB::connection('mysql_hos')->table('emp_citizenship')
        ->orderBy('emp_citizenship_name','ASC')->get();
        $pname = DB::connection('mysql_hos')->table('pname')
        ->orderBy('provis_code','ASC')->get();
        $thaiaddress_provinces = DB::connection('mysql_hos')->table('thaiaddress_provinces')
        ->orderBy('PROVINCE_NAME','ASC')->get();
        $blood_group = DB::connection('mysql_hos')->table('blood_group')
        ->orderBy('blood_id','ASC')->get();
        $marrystatus = DB::connection('mysql_hos')->table('marrystatus')
        ->orderBy('code','ASC')->get();

        return view('patient.ptregister', [
            'moduletitle' => "ลงทะเบียนผู้ป่วยใหม่",
            'view_menu' => "disable",
            'cid' => $cid,
            'birthday' => $birthdate,
            'occupation' => $occupation,
            'nationality' => $nationality,
            'religion' => $religion,
            'emp_citizenship' => $emp_citizenship,
            'pname' => $pname,
            'thaiaddress_provinces' => $thaiaddress_provinces,
            'blood_group' => $blood_group,
            'marrystatus' => $marrystatus,
            'hos_guid' => $hos_guid,
            'serial_no' => $serial_no,
            'hn' => $hn,
            'lineid' => $lineid,
            'email' => $email,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request, UserRegister $model)
    {
        session_start();
        
        $request->validate(
            [
                'cid' => ['required', 'string', 'min:13'],
                'birthday' => ['required', 'string', 'min:8'],
                'sexprename' => 'required',
                'fname' => ['required', 'string', 'min:3'],
                'lname' => ['required', 'string', 'min:3'],
                'fathername' => ['required', 'string', 'min:3'],
                'mathername' => ['required', 'string', 'min:3'],
                'marrystatus' => 'required',
                'bloodgrp' => 'required',
                'occupation' => 'required',
                'nationality' => 'required',
                'citizenship' => 'required',
                'religion' => 'required',
                'addrpart' => ['required', 'string', 'min:1'],
                'province' => 'required',
                'amphure' => 'required',
                'catpart' => 'required',
                'hometel' => ['required', 'string', 'min:9'],
            ],
            [
                'cid.required'=> 'กรุณาระบุเลขบัตรประชาชน 13 หลัก',
                'birthday.required'=> 'กรุณาระบุวันเกิดตามรูปแบบ ววดดปปปป (พ.ศ.)',
                'sexprename.required'=> 'กรุณาเลือกคำนำหน้าชื่อ',
                'fname.required'=> 'กรอกชื่อ(อย่างน้อย 3 ตัวอักษร)',
                'lname.required'=> 'กรอกนามสกุล',
                'fathername.required'=> 'กรุณาระบุชื่อบิดา',
                'mathername.required'=> 'กรุณาระบุชื่อมารดา',
                'marrystatus.required'=> 'กรุณาเลือกสภาพสมรส',
                'bloodgrp.required'=> 'กรุณาเลือกหมู่เลือด',
                'occupation.required'=> 'กรุณาเลือกอาชีพ',
                'nationality.required'=> 'กรุณาเลือกเชื้อชาติ',
                'citizenship.required'=> 'กรุณาเลือกสัญชาติ',
                'religion.required'=> 'กรุณาเลือกศาสนา',
                'addrpart.required'=> 'ระบุเลขที่ ที่อยู่',
                'province.required'=> 'กรุณาเลือกจังหวัด',
                'amphure.required'=> 'กรุณาเลือกอำเภอ',
                'catpart.required'=> 'กรุณาเลือกตำบล',
                'hometel.required'=> 'กรุณาระบุเบอร์โทรศัพท์ที่ติดต่อได้',
            ]
        );

        // Patientregister::create($request->all());

        $dd = substr($request->birthday,0,2);
        $mm = substr($request->birthday,2,2);
        $yyyy = substr($request->birthday,4,4)-543;
        $birthday = $yyyy."-".$mm."-".$dd;

        $chwpart = substr($request->catpart,0,2);
        $amppart = substr($request->catpart,2,2);
        $tmbpart = substr($request->catpart,4,2);

        $pname = substr($request->sexprename,1,25);
        $sex = substr($request->sexprename,0,1);

        // DB::connection('mysql_hos')->insert('INSERT INTO hnlock (onlineid,hn,optype) VALUES ("'.$serial_no.'","'.$hn.'","GetHN")');
        DB::connection('mysql_hos')->insert('INSERT INTO pttypeno (hn,expiredate,pttype,pttypeno,begindate,hospmain,hospsub,hos_guid,hos_guid_ext)
            VALUES ("'.$request->hn.'",NULL,"10","",NULL,"","",NULL,NULL)');
        DB::connection('mysql_hos')->insert('INSERT INTO ptcardno (hn,cardtype,cardno,expiredate,hos_guid,hos_guid_ext) VALUES ("'.$request->hn.'","01","'.$request->cid.'",NULL,NULL,NULL)');
        DB::connection('mysql_hos')->insert('INSERT INTO patient_pttype_lock (hn,lock_pttype,lock_opdcard,hos_guid,hos_guid_ext) VALUES ("'.$request->hn.'","N",NULL,NULL,NULL)');
        DB::connection('mysql_hos')->insert('INSERT INTO patient_eng (hn,eng_pname,eng_fname,eng_mname,eng_lname,eng_addrpart,eng_moopart,eng_road,eng_province,eng_district
            ,eng_subdistrict,eng_pcode,eng_full_address1,eng_full_address2) VALUES ("'.$request->hn.'","","","","",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"","")');

        DB::connection('mysql_hos')->insert('INSERT INTO patient (hos_guid,hn,pname,fname,lname,occupation,citizenship,birthday,addrpart,moopart,tmbpart,amppart
        ,chwpart,bloodgrp,clinic,deathday,drugallergy,familyno,fathername,firstday,hometel,informaddr
        ,informname,informrelation,informtel,marrystatus,mathername,hn_int,nationality,opdlocation,pttype
        ,religion,sex,spsname,truebirthday,workaddr,worktel,hcode,cid,hid,educate,family_status,labor_type
        ,last_update,type_area,road,father_cid,mother_cid,couple_cid,person_type,private_doctor_name
        ,legal_action,death_code504,death_diag,node_id,admit,midname,po_code,fatherlname,motherlname
        ,spslname,country,email,birthtime,mother_hn,last_visit,death,height,inregion,reg_time,oldcode
        ,lang,gov_chronic_id,in_cups,patient_type_id,addr_soi,work_addr,father_hn,alias_name,destroyed
        ,old_addr,fname_soundex,lname_soundex,bloodgroup_rh,passport_no,addressid,mobile_phone_number
        ,anonymous_person,ec_fname,ec_lname,hospital_department_id,membercard_no,ec_relation_type_id
        ,patient_color_id,number_of_relatives,birth_order,person_labor_type_id,is_card_destroy
        ,card_destroy_date,g6pd,vid)
        VALUES ("'.$request->hos_guid.'","'.$request->hn.'","'.$pname.'","'.$request->fname.'","'.$request->lname.'","'.$request->occupation.'","'.$request->citizenship.'","'.$birthday.'","'.$request->addrpart.'"
        ,"'.$request->moopart.'","'.$tmbpart.'","'.$amppart.'","'.$chwpart.'","'.$request->bloodgrp.'","",NULL,"",NULL,"'.$request->mathername.'",DATE(NOW()),"'.$request->hometel.'","","","","","'.$request->marrystatus.'","'.$request->mathername.'",NULL
        ,"'.$request->nationality.'",NULL,"10","'.$request->religion.'","'.$sex.'","","N",NULL,NULL,"11456","'.$request->cid.'",NULL,NULL,"2",NULL,NOW(),NULL,"'.$request->road.'","","","",NULL
        ,"",NULL,NULL,NULL,"",NULL,"","","","","","99","","00:00:00","",NULL,"N",NULL,"N",TIME(NOW()),"ลงทะเบียนออนไลน์","TH","","N",NULL,NULL,"",NULL,"",NULL,NULL,"","","","",NULL,NULL,NULL
        ,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)');

        DB::connection('mysql_hos')->insert('INSERT INTO patient_regiment (hn,main_regiment,sub_regiment,officer_id,regiment_type,hos_guid,hos_guid_ext,patient_regiment_type_id)
        VALUES ("'.$request->hn.'","","","",NULL,NULL,NULL,NULL)');
        DB::connection('mysql_hos')->insert('INSERT INTO hninsert (hn,inserttype,hos_guid,hos_guid_ext) VALUES ("'.$request->hn.'","SUCCESS",NULL,NULL)');

        // DB::connection('mysql_hos')->update('
        // UPDATE serial SET serial_no = (SELECT onlineid FROM hnlock WHERE hn = (SELECT MAX(hn) FROM patient) AND optype = "GetHN") WHERE name = "HN"
        // ');

        DB::connection('mysql_hos')->table('hnlock')->where('hn', '=', $request->hn)->delete();

        if (isset($_SESSION["lineid"])) {
            $model->create($request->merge([
                'tel' => $request->hometel,
                'consent' => "R"
            ])->all());
        }
        
        
        $get_ptnote_id = DB::connection('mysql_hos')->select('SELECT MAX(ptnote_id)+1 AS ptnote_id FROM ptnote');
        foreach ($get_ptnote_id as $data) {
            $ptnote_id = $data->ptnote_id;
        }
        DB::connection('mysql_hos')->insert('INSERT INTO ptnote (ptnote_id,hn,noteflag,ptnote,vstdate,vsttime,groupname
        ,plain_text,prsc_note_text,note_datetime,note_staff,username_list,has_expired,expire_date,public_note,encrypt_note
        ,hos_guid,show_all_dep,check_group,ptnote_html)
        VALUES ("'.$ptnote_id.'","'.$request->hn.'","[OPDCARD][REGIST][SCREEN]"
        ,"ข้อมูลจาก...ลงทะเบียนออนไลน์\r\n\r\nกรุณาตรวจสอบข้อมูลกับผู้รับบริการอีกครั้ง และจัดทำแฟ้มเวชระเบียนจัดเก็บตามระบบ\r\n\r\n(หากดำเนินการแล้วให้ลบ note นี้ด้วย)\r\n"
        ,NULL,NULL,""
        ,"ข้อมูลจาก...ลงทะเบียนออนไลน์\r\n\r\nกรุณาตรวจสอบข้อมูลกับผู้รับบริการอีกครั้ง และจัดทำแฟ้มเวชระเบียนจัดเก็บตามระบบ\r\n\r\n(หากดำเนินการแล้วให้ลบ note นี้ด้วย)\r\n"
        ,NULL,NOW(),"OnlineRegister",NULL,NULL,NULL,"Y",NULL,NULL,NULL,NULL,NULL)
        ');

        DB::connection('mysql_hos')->update('
        UPDATE serial SET serial_no = "'.$ptnote_id.'" WHERE name = "ptnote_id"
        ');
        
        ob_start();
        $_SESSION["patienthn"] = $request->hn;
        $_SESSION["ptbirthday"] = $birthday;
        $_SESSION["patienttel"] = $request->hometel;
        $_SESSION["patientcid"] = $request->cid;
        $_SESSION["patientname"] = $pname.$request->fname." ".$request->lname;
        session_write_close();

        return redirect()->route('ptregisted')->with('session-alert-store', 'ลงทะเบียนสำเร็จแล้ว');
    }

    public function registed()
    {
        session_start();
        $patientcid = $_SESSION["patientcid"];
        $ptbirthday = $_SESSION["ptbirthday"];
        $patienttel = $_SESSION["patienttel"];
        $patienthn = $_SESSION["patienthn"];
        $patientname = $_SESSION["patientname"];

        if (isset($_SESSION["lineid"])) {
            $view_menu = "";
        } else {
            $view_menu = "disable";
        }
        
        return view('patient.ptcard', [
            'moduletitle' => "ลงทะเบียนผู้ป่วยใหม่สำเร็จ",
            'view_menu' => $view_menu,
            'patientcid' => $patientcid,
            'ptbirthday' => $ptbirthday,
            'patienttel' => $patienttel,
            'patienthn' => $patienthn,
            'patientname' => $patientname,
        ]);
        
        session_destroy();
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
