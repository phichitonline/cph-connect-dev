<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if (isset($_SESSION["hn"])) {

            $view_page = "card.index";
            $hn = $_SESSION["hn"];

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
            $view_page = "error_close_app";
            $lineid = "";
            $cid = "";
            $hn = "";
            $pname = "";
            $fname = "";
            $lname = "";
            $birthday = "";
            $tel = "";
            $email = "";
            $bloodgrp = "";
            $drugallergy = "";
            $pttypename = "";
            $clinic = "";
            $pic = "";
            $age_year = "";
        }
        return view($view_page, [
            'moduletitle' => "Card",
            'lineid' => $lineid,
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

            // 'ssalert' => session('session-alert'),
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
