<?php

namespace App\Http\Controllers;

use App\Models\Appflag;
use App\Models\Appointment;
use App\Models\Apptime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        session_start();
        $isadmin = $_SESSION["isadmin"];
        $lineid = $_SESSION["lineid"];

        return view('appointment.index', [
            'oapp_wait_confirm' => Appointment::where('status', NULL)->count(),
            'isadmin' => $isadmin,
            'lineid' => $lineid,
            'appflag' => Appflag::where('active', 'Y')->get()
        ]);
    }

    public function calendar()
    {
        session_start();

        $applimit = Apptime::where('que_app_flag', $_GET['flag'])->sum('limitcount');

        $check_q_flag = DB::connection('mysql')->select('
        SELECT que_app_flag,que_app_flag_name,depcode,bgcolor FROM appflags WHERE que_app_flag = "'.$_GET['flag'].'"
        ');
        foreach($check_q_flag as $data){
            $module_color = $data->bgcolor;
            $module_name = "จองนัด".$data->que_app_flag_name;
            $qflag = $data->que_app_flag;
        }

        if (isset($_SESSION["lineid"])) {
            $view_page = "appointment.calendar";
        } else {
            $view_page = "error_close_app";
        }

        return view($view_page, [
            'moduletitle' => "นัดออนไลน์",
            'module_color' => $module_color,
            'module_name' => $module_name,
            'flag' => $_GET['flag'],
            'qflag' => $qflag,
            'applimit' => $applimit,
        ]);
    }

    public function time()
    {
        session_start();
        $hn = $_SESSION["hn"];
        $que_date = $_GET['que_date'];
        $flag = $_GET['flag'];

        $applimit = Apptime::where('que_app_flag', $_GET['flag'])->sum('limitcount');

        $check_q_flag = DB::connection('mysql')->select('
        SELECT que_app_flag,que_app_flag_name,depcode,bgcolor FROM appflags WHERE que_app_flag = "'.$_GET['flag'].'"
        ');
        foreach($check_q_flag as $data){
            $module_color = $data->bgcolor;
            $module_name = "จองนัด".$data->que_app_flag_name;
            $qflag = $data->que_app_flag;
        }

        $app_flag_time = DB::connection('mysql')->select('
        SELECT t.que_app_flag,t.que_time,t.que_time_name,t.que_time_start,t.que_time_end,t.limitcount,a.cc,t.statusday
        FROM apptimes t
        LEFT JOIN (SELECT que_app_flag,que_time,COUNT(*) AS cc FROM appointments WHERE status IS NOT NULL AND que_app_flag = "'.$flag.'" AND que_date = "'.$que_date.'" GROUP BY que_time) a ON a.que_time = t.que_time
        WHERE t.que_app_flag = "'.$flag.'"
        ORDER BY que_time ASC
        ');

        $check_app_user = DB::connection('mysql')->select('
        SELECT COUNT(*) AS cc,a.que_app_flag,a.que_cc,f.que_app_flag_name
        FROM appointments a
        LEFT JOIN appflags f ON f.que_app_flag = a.que_app_flag
        WHERE a.que_date = "'.$que_date.'" AND a.status = "1" AND a.hn = "'.$hn.'"
        ');
        foreach ($check_app_user as $data) {
            if($data->cc == 0) {
                $user_app_check = "N";
                $user_app_name = "";
                $user_app_cc = "";
            } else {
                $user_app_check = "Y";
                $user_app_name = $data->que_app_flag_name;
                $user_app_cc = $data->que_cc;
            }
        }

        return view('appointment.time', [
            'module_color' => $module_color,
            'module_name' => $module_name,
            'qflag' => $qflag,
            'flag' => $_GET['flag'],
            'que_date' => $_GET['que_date'],
            'user_app_check' => $user_app_check,
            'user_app_name' => $user_app_name,
            'user_app_cc' => $user_app_cc,
            'applimit' => $applimit,
            'app_flag_time' => $app_flag_time,
        ]);
    }

    public function quecc(Request $request)
    {
        session_start();
        $hn = $_SESSION["hn"];

        $check_patient = DB::connection('mysql_hos')->select('
        SELECT cid,hn,pname,fname,lname FROM patient WHERE hn = "'.$hn.'"
        ');
        foreach($check_patient as $data){
            $ptname = $data->pname.$data->fname." ".$data->lname;
        }
/*
        $check_q_flag = DB::connection('mysql')->select('
        SELECT que_app_flag,que_app_flag_name,depcode,bgcolor FROM que_app_flag WHERE que_app_flag = "'.$request->flag.'"
        ');
        foreach($check_q_flag as $data){
            $module_color = $data->bgcolor;
            $module_name = "จองนัด".$data->que_app_flag_name;
            $qflag = $data->que_app_flag;
            $qdep = $data->depcode;
        }
        $check_q_time = DB::connection('mysql')->select('
        SELECT que_time,que_app_flag,que_time_name,que_time_start,que_time_end,limitcount FROM que_time WHERE que_app_flag = "'.$request->flag.'" AND que_time = "'.$request->rad.'"
        ');
        foreach($check_q_time as $data){
            $que_time = $data->que_time_name;
            $que_limit = $data->limitcount;
            $que_time_c = "";
        }
*/

        if ($request->flag == "T") {
            $module_color = "bg-green1-dark";
            $module_name = "จองนัดแพทย์แผนไทย";
            $qflag = "T";
            $qdep = "036";
        } else if ($request->flag == "D") {
            $module_color = "bg-yellow2-dark";
            $module_name = "จองนัดทันตกรรม";
            $qflag = "D";
            $qdep = "030";
        } else if ($request->flag == "C") {
            $module_color = "bg-magenta1-dark";
            $module_name = "จองนัดตรวจสุขภาพ";
            $qflag = "C";
            $qdep = "016";
        } else {
            $module_color = "bg-blue1-dark";
            $module_name = "จองนัดตรวจโรคทั่วไป";
            $qflag = "A";
            $qdep = "099";
        }

        if ($request->rad == "1") {
            $que_time = "เวลา 09.00-10.30 น.";
            $que_time_c = "";
        } else if ($request->rad == "2") {
            $que_time = "เวลา 10.30-12.00 น.";
            $que_time_c = "";
        } else if ($request->rad == "3") {
            $que_time = "เวลา 13.00-15.00 น.";
            $que_time_c = "";
        } else if ($request->rad == "4") {
            $que_time = "เวลา 15.00-16.30 น.";
            $que_time_c = "";
        } else {
            $que_time = "คุณยังไม่ได้เลือกเวลา<br>กรุณาย้อนกลับไปเลือกช่วงเวลาก่อนค่ะ";
            $que_time_c = "color-highlight";
        }

        $que_date = $request->que_date;
        $que_rad = $request->rad;

        return view('appointment.cc', [
            'module_color' => $module_color,
            'module_name' => $module_name,
            'qflag' => $qflag,
            'que_date' => $que_date,
            'que_rad' => $que_rad,
            'que_time' => $que_time,
            'que_time_c' => $que_time_c,
            'qdep' => $qdep,
            'ptname' => $ptname,
        ]);
    }

    public function store(Request $request, Appointment $model)
    {
        $model->create($request->all());
        return redirect()->route('appointment')->with('session-alert', $request->que_app_flag);
    }

    public function appman()
    {
        $que_pt_man = DB::connection('mysql')->select('
        SELECT q.*,pt.*,f.*,t.*
        FROM appointments q
        LEFT OUTER JOIN patientusers pt ON pt.hn = q.hn
        LEFT OUTER JOIN appflags f ON f.que_app_flag = q.que_app_flag
        LEFT OUTER JOIN apptimes t ON t.que_app_flag = q.que_app_flag AND t.que_time = q.que_time
        WHERE q.`status` IS NULL
        ');

        return view('appointment.appman', [
            'que_pt_man' => $que_pt_man,
        ]);
    }

    public function appconfirm()
    {
        Appointment::where('id', $_GET['id'])->update(['status' => $_GET['status']]);

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

        return redirect()->route('appman')->with('oapp-updated',$alert_oappman_message);
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
