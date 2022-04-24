<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // session_start();
        // session_destroy();

        if (isset($_GET["userId"])) {

            $userid = $_GET["userId"];
            $email = $_GET["decodedIDToken2"];

            $check_register = DB::connection('mysql')->select('
            SELECT COUNT(*) AS countregist,cid,hn,tel,email,isadmin FROM patientusers WHERE lineid = "'.$userid.'"
            ');

            foreach($check_register as $data){
                if ($data->countregist > 0) {
                    $view_page = "home";
                    $view_menu = "anable";
                    $userid = $_GET["userId"];
                    $email = $data->email;
                    session_start();
                    ob_start();
                    $_SESSION["lineid"] = $_GET["userId"];
                    $_SESSION["email"] = $data->email;
                    $_SESSION["hn"] = $data->hn;
                    $_SESSION["cid"] = $data->cid;
                    $_SESSION["tel"] = $data->tel;
                    $_SESSION["isadmin"] = $data->isadmin;
                    session_write_close();
                } else {
                    $view_page = "consent";
                    $view_menu = "disable";
                    $userid = $_GET["userId"];
                    $email = $_GET["decodedIDToken2"];
                }
            }

        } else {
            $view_page = "error_close_app";
            $view_menu = "disable";
            $userid = "";
            $email = "";
        }

        if ($view_page == "home") {
            DB::connection('mysql')->insert('INSERT INTO log_liffapp (id,userid,event,log_datetime) VALUES (NULL,"'.$userid.'","home",NOW())');
        } else if ($view_page == "consent") {
            DB::connection('mysql')->insert('INSERT INTO log_liffapp (id,userid,event,log_datetime) VALUES (NULL,"'.$userid.'","consent",NOW())');
        } else {
            DB::connection('mysql')->insert('INSERT INTO log_liffapp (id,userid,event,log_datetime) VALUES (NULL,"'.$userid.'","error",NOW())');
        }

        return view($view_page, [
            'moduletitle' => "Home",
            'view_menu' => $view_menu,
            'userid' => $userid,
            'email' => $email,
            // 'session_alert' => session('session-alert'),
        ]);
    }

    public function register()
    {

        if (isset($_GET["userId"])) {
            $userid = $_GET["userId"];
            $email = $_GET["decodedIDToken2"];
            $consent = $_GET["consent"];
            $view_page = "register";
            $view_menu = "disable";
        } else {
            $view_page = "error_close_app";
            $view_menu = "disable";
            $userid = "";
            $email = "";
        }

        return view($view_page, [
            'moduletitle' => "Home",
            'view_menu' => $view_menu,
            'userid' => $userid,
            'email' => $email,
            'consent' => $consent,
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
