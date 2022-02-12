<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SessionregisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'setting' => Setting::all(),
            'moduletitle' => "User Manager",
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
    public function store(Request $request, UserRegister $model)
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
        SELECT COUNT(*) AS userregist,hn,cid,pname,fname,lname FROM patient 
        WHERE cid = "'.$cid.'" AND birthday = "'.$birthday.'"
        ');
        foreach($check_opduser as $data){
            if ($data->userregist > 0) {
                session_start();
                ob_start();
                $_SESSION["lineid"] = $request->get('lineid');
                $_SESSION["email"] = $request->get('email');
                $_SESSION["tel"] = $request->get('tel');
                $_SESSION["hn"] = $data->hn;
                $_SESSION["birthdate"] = $bdate;
                $_SESSION["cid"] = $data->cid;
                $_SESSION["isadmin"] = "";
                session_write_close();
                // $model->create($request->all());
                $model->create($request->merge(['hn' => $data->hn])->all());
                return redirect()->route('main')->with('session-alert', 'คุณลงทะเบียนใช้บริการออนไลน์สำเร็จแล้ว');
            } else {
                session_start();
                ob_start();
                $_SESSION["lineid"] = $request->get('lineid');
                $_SESSION["email"] = $request->get('email');
                session_write_close();
                return redirect()->route('ptregister.index')->with('session-alert', 'ไม่พบข้อมูลทะเบียนผู้ป่วยของคุณ หรือคุณอาจกรอกข้อมูลไม่ถูกต้อง ! กรุณาตรวจสอบเลขบัตรประชาชน และวันเดือนปีเกิดให้ถูกต้อง... หรือกรอกข้อมูลเพื่อลงทะเบียนทำบัตรใหม่');
            }
        }

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
    public function update(Request $request, UserRegister $model)
    {
        $model->update($request->all());
        return redirect()->route('sessionregister.index')->with('sessionregister-updated','บันทึกสำเร็จ');
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
