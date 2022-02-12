@extends('layouts.theme')
@section('menu-active-book','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')
                
    <div class="header header-fixed header-logo-center bg-yellow1-dark">
        <a href="#" onclick="goBack()" class="header-title color-white">ย้อนกลับ</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
    </div>

    <div class="page-content header-clear-large">

        <div class="card card-style bg-theme shadow-xl rounded-m">
            <div class="cal-footer">
                <h4 class="cal-title text-center text-uppercase font-25 {{ $module_color }} color-white">{{ $module_name }}</h4>
                <span class="cal-message mt-3 mb-3">
                    <i class="fa fa-bell font-18 color-green1-dark"></i>
                    <strong class="color-gray-dark">- งดรับจองวันหยุดราชการและวันหยุดนักขัตฤกษ์</strong>
                    <strong class="color-gray-dark">- สามารถจองได้เพียงวันละ 1 คิวเท่านั้น</strong>
                </span>
                <span class="cal-message mt-3 mb-3">
                    <strong class="color-gray-dark"><b>เลือกวันที่ ที่ต้องการจองคิวนัด แล้วดำเนินการต่อ</b></strong>
                </span>
                <div class="divider mb-0"></div>

            </div>
        </div>

                @php
                $hostname_dbnurse = config('database.connections.mysql.host');
                $database_dbnurse = config('database.connections.mysql.database');
                $username_dbnurse = config('database.connections.mysql.username');
                $password_dbnurse = config('database.connections.mysql.password');
                $dbnurse = mysqli_connect($hostname_dbnurse, $username_dbnurse, $password_dbnurse) or trigger_error(mysqli_error(),E_USER_ERROR); 
                mysqli_select_db($dbnurse,$database_dbnurse);
                mysqli_set_charset($dbnurse,"utf8");
                date_default_timezone_set("Asia/Bangkok");
                $const_que = 5;//จำนวนคิวต่อรอบ

                $monthNames = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
                if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
    
                $cMonth = $_REQUEST["month"];
                $cYear = $_REQUEST["year"];
                $prev_year = $cYear;
                $next_year = $cYear;
                $prev_month = $cMonth - 1;
                $next_month = $cMonth + 1;
    
                if ($prev_month == 0) {
                    $prev_month = 12;
                    $prev_year = $cYear - 1;
                }
                if ($next_month == 13) {
                    $next_month = 1;
                    $next_year = $cYear + 1;
                }
                $thaiyear = $cYear + 543;
                @endphp

                <div class="card card-style bg-theme shadow-xl rounded-m">
                    <div class="cal-header">
                        <h4 class="cal-title text-center text-uppercase font-800 {{ $module_color }} color-white">{{ $monthNames[$cMonth - 1] . ' ' . $thaiyear }}</h4>
                        <h6 class="cal-title-left color-white"><a class="color-white" href="{{ url('/') }}/bookcalendar/{{ "?qflag=".$qflag."&flag=".$flag."&month=" . $prev_month . "&year=" . $prev_year }}" data-ajax="false"><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i></a></h6>
                        <h6 class="cal-title-right color-white"><a class="color-white" href="{{ url('/') }}/bookcalendar/{{ "?qflag=".$qflag."&flag=".$flag."&month=" . $next_month . "&year=" . $next_year }}" data-ajax="false"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a></h6>
                    </div>
                    <div class="clearfix"></div>
                    <div class="cal-days {{ $module_color }} opacity-80 bottom-0">
                        <a href="#">อา</a>
                        <a href="#">จ</a>
                        <a href="#">อ</a>
                        <a href="#">พ</a>
                        <a href="#">พฤ</a>
                        <a href="#">ศ</a>
                        <a href="#">ส</a>
                        <div class="clearfix"></div>
                    </div>
                    {{-- <div class="cal-dates cal-dates-border"> --}}
                        {{-- <div class="clearfix"></div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}

                    @php
    
                    $reserve = 5;
                    $dtime = 2;
                    $timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
                    $maxday = date("t", $timestamp);
    
                    $thismonth = getdate($timestamp);
                    $startday = $thismonth['wday'];
    
                    $recdate = $cYear . '-0' . $cMonth;
    
                    for ($i = 0; $i < ($maxday + $startday); $i++) {
                        if (strlen($_REQUEST["month"]) == 1) {
                            $nMonth = '0' . $_REQUEST["month"];
                        } else {
                            $nMonth = $_REQUEST["month"];
                        }
                        $chkdate = $cYear . '-' . $nMonth;
                        $ni = $i - $startday + 1;
                        $d = $i - $startday + 1;
                        if ($ni <= 9) {
                            $ni = '-0' . $ni;
                        } else {
                            $ni = '-' . $ni;
                        }
    
                        $chkbook = $chkdate . $ni;
                        $day = ($i % 7);
                        if (($i % 7) == 0) {
                            echo "<div class='cal-dates cal-dates-border'>";
                        }
                        if ($i < $startday) {
                            echo "<a href='#' class='cal-disabled'>&nbsp;<p class='mb-0 mt-n3 font-10'>&nbsp;</p></a>";
                        } else {
                            $sql_holiday = "SELECT count(*) as total_holiday FROM que_holiday WHERE  que_date = '" . $cYear . "-" . $nMonth . $ni . "' limit 1";
                            mysqli_select_db($dbnurse, $database_dbnurse);
                            $chkholiday = mysqli_query($dbnurse, $sql_holiday) or die(mysqli_error());
                            $row_holiday = mysqli_fetch_assoc($chkholiday);
                            if ($row_holiday['total_holiday'] > 0) $is_holiday = true;
                            else $is_holiday = false;
    
                            if(date($chkbook) == date('Y-m-d', time()))
                                if ((date('N', strtotime($chkbook)) >= 6) or $is_holiday) {
                                    echo "<a href='#' class='cal-selected color-highlight'>".$d."<p class='mb-0 mt-n3 font-10'><mark class='highlight pl-2 font-10 pr-2 bg-red2-dark'>วันนี้</mark></p></a>";
                                } else {
                                    echo "<a href='#' class='cal-selected color-blue2-dark'>".$d."<p class='mb-0 mt-n3 font-10'><mark class='highlight pl-2 font-10 pr-2 bg-blue2-dark'>วันนี้</mark></p></a>";
                                }
                            else if(date($chkbook) <= date('Y-m-d', time()))
                                echo "<a href='#' class='cal-disabled'>".$d."<p class='mb-0 mt-n3 font-10'>&nbsp;</p></a>";
                            else if ((date('N', strtotime($chkbook)) >= 6) or $is_holiday) {
                                echo "<a href='#' class='cal-disabled color-highlight'>".$d."<p class='mb-0 mt-n3 font-10 color-highlight'>หยุด</p></a>";
                            } else {
                                $sql_chkque = "SELECT count(que_n) as total_que FROM que_card WHERE DATE(que_date) = '{$chkbook}' and que_app_flag = '{$qflag}' and status = '1' limit 1";
                                mysqli_select_db($dbnurse, $database_dbnurse);
                                $chkque = mysqli_query($dbnurse, $sql_chkque) or die(mysqli_error());
                                $row_chkque = mysqli_fetch_assoc($chkque);
                                if ($row_chkque['total_que'] == 0) {
                                    $total_que = "<p class='mb-0 mt-n3 font-10'>0 ราย</p>";
                                } else {
                                    if ($row_chkque['total_que'] > $const_que*4) {
                                        $total_que = "<p class='mb-0 mt-n3'><mark class='highlight pl-2 font-10 pr-2 bg-red2-dark'>".$row_chkque['total_que']." ราย</mark></p>";
                                    } else {
                                        $total_que = "<p class='mb-0 mt-n3'><mark class='highlight pl-2 font-10 pr-2 bg-green1-dark'>".$row_chkque['total_que']." ราย</mark></p>";
                                    }
                                    
                                }
                                echo "<a href='/booktime/?qflag=".$qflag."&flag=".$flag."&day=".$day."&que_date=".$chkbook."' data-ajax='false'><b>".$d."</b>".$total_que."</a>";
                            }
                        }
                        if (($i % 7) == 6) {
                            echo "</div>";
                        }
                    }
                    @endphp
                </div>
            </div>

        <div class="decoration decoration-margins"></div>

    </div>
    <!-- End of Page Content--> 

@endsection

@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>

@endsection