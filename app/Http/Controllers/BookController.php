<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        session_start();
        return view('book.index', [
            'setting' => Setting::all(),
            'que_card' => Book::all(),
            'lineid' => $_SESSION["lineid"],
        ]);
    }

    public function calendar()
    {
        session_start();

        if ($_GET['flag'] == "T") {
            $module_color = "bg-green1-dark";
            $module_name = "จองนัดแพทย์แผนไทย";
            $qflag = "T";
        } else if ($_GET['flag'] == "D") {
            $module_color = "bg-yellow2-dark";
            $module_name = "จองนัดทันตกรรม";
            $qflag = "D";
        } else if ($_GET['flag'] == "C") {
            $module_color = "bg-magenta1-dark";
            $module_name = "จองนัดตรวจสุขภาพ";
            $qflag = "C";
        } else {
            $module_color = "bg-blue1-dark";
            $module_name = "จองนัดตรวจโรคทั่วไป";
            $qflag = "A";
        }

        if (isset($_SESSION["lineid"])) {
            $view_page = "book.calendar";
        } else {
            $view_page = "error_close_app";
        }

        return view($view_page, [
            // 'moduletitle' => "Register",
            'module_color' => $module_color,
            'module_name' => $module_name,
            'flag' => $_GET['flag'],
            'qflag' => $qflag,
        ]);
    }

    public function time()
    {
        session_start();
        $hn = $_SESSION["hn"];
        $que_date = $_GET['que_date'];

        if ($_GET['flag'] == "T") {
            $module_color = "bg-green1-dark";
            $module_name = "จองนัดแพทย์แผนไทย";
            $qflag = "T";
        } else if ($_GET['flag'] == "D") {
            $module_color = "bg-yellow2-dark";
            $module_name = "จองนัดทันตกรรม";
            $qflag = "D";
        } else if ($_GET['flag'] == "C") {
            $module_color = "bg-magenta1-dark";
            $module_name = "จองนัดตรวจสุขภาพ";
            $qflag = "C";
        } else {
            $module_color = "bg-blue1-dark";
            $module_name = "จองนัดตรวจโรคทั่วไป";
            $qflag = "A";
        }

        $check_app_user = DB::connection('mysql')->select('
        SELECT count(*) as cc,que_app_flag from que_card WHERE que_date = "'.$que_date.'" AND status = "1" AND hn = "'.$hn.'"
        ');
        foreach ($check_app_user as $data) {
            if($data->cc == 0) {
                $user_app_check = "N";
                $user_app_name = "";
            } else if($data->que_app_flag == "C") {
                $user_app_check = "Y";
                $user_app_name = "ตรวจสุขภาพ";
            } else if($data->que_app_flag == "D") {
                $user_app_check = "Y";
                $user_app_name = "ทันตกรรม";
            } else if($data->que_app_flag == "T") {
                $user_app_check = "Y";
                $user_app_name = "แพทย์แผนไทย";
            } else {
                $user_app_check = "Y";
                $user_app_name = "ตรวจรักษาทั่วไป";
            }
        }

        return view('book.book_time', [
            'module_color' => $module_color,
            'module_name' => $module_name,
            'qflag' => $qflag,
            'flag' => $_GET['flag'],
            'que_date' => $_GET['que_date'],
            'user_app_check' => $user_app_check,
            'user_app_name' => $user_app_name,
        ]);
    }

    public function quecc(Request $request)
    {
        session_start();
        $hn = $_SESSION["hn"];

        $check_opduser = DB::connection('mysql_hos')->select('
        SELECT p.cid,p.hn,p.pname,p.fname,p.lname,p.birthday,p.bloodgrp,p.drugallergy,p.pttype,ptt.`name` AS pttypename,p.clinic,TIMESTAMPDIFF(YEAR,p.birthday,CURDATE()) AS age_year
        FROM patient p LEFT OUTER JOIN pttype ptt ON ptt.pttype = p.pttype WHERE p.hn = "'.$hn.'"
        ');
        foreach($check_opduser as $data){
            $pname = $data->pname;
            $fname = $data->fname;
            $lname = $data->lname;
        }

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

        if ($request->rad == "9") {
            $que_time = "เวลา 09.00-10.30 น.";
            $que_time_c = "";
        } else if ($request->rad == "12") {
            $que_time = "เวลา 10.30-12.00 น.";
            $que_time_c = "";
        } else if ($request->rad == "30") {
            $que_time = "เวลา 13.00-15.00 น.";
            $que_time_c = "";
        } else if ($request->rad == "33") {
            $que_time = "เวลา 15.00-16.30 น.";
            $que_time_c = "";
        } else {
            $que_time = "คุณยังไม่ได้เลือกเวลา<br>กรุณาย้อนกลับไปเลือกช่วงเวลาก่อนค่ะ";
            $que_time_c = "color-highlight";
        }
        
        $que_date = $request->que_date;
        $que_rad = $request->rad;

        return view('book.book_cc', [
            'module_color' => $module_color,
            'module_name' => $module_name,
            'qflag' => $qflag,
            'que_date' => $que_date,
            'que_rad' => $que_rad,
            'que_time' => $que_time,
            'que_time_c' => $que_time_c,
            'qdep' => $qdep,
            'ptname' => $pname.$fname." ".$lname,
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
    public function store(Request $request, Book $model)
    {
        $model->create($request->all());
        return redirect()->route('book')->with('session-alert', $request->que_app_flag);
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
