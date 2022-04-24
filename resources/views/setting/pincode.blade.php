@extends('layouts.theme')
@section('menu-active-modulecustom','')
@section('header_script')
{{-- header --}}

<link rel="stylesheet" href="css/app.css" />

@endsection

@section('content')

<!-- Start Page Content-->

<!-- End of Page Content-->

    @if ($pincode1 || "")

        @if ($pincodeconfirm == "TRUE")

            <!-- Start PIN code login page -->
            <a href="#" data-menu="login-pin-confirm" data-timed-ad="0" data-auto-show-ad="0"> </a>
            <div id="login-pin-confirm" class="menu menu-box-modal menu-box-detached round-large" data-menu-width="100vw" data-menu-height="100vh" data-menu-effect="menu-over">
                <div class="card bg-17" data-card-height="100vh">
                    <div class="card-top">
                        <a href="#" onclick="closed()" class="close-menu ad-time-close color-highlight"><i class="fa fa-times disabled"></i><span></span></a>
                    </div>
                    <div class="card-top">
                        <span class="color-white bg-black font-10 opacity-70 pb-1 pt-1 pl-2 pr-2 ml-1">ตั้งรหัส PIN สำเร็จ</span>
                    </div>
                    <div class="card-center text-center">
                        <h1 class="color-white text-center text-uppercase font-700 fa-3x mb-3">ตั้งรหัส PIN สำเร็จ</h1>
                        <div class="color-white text-center fa-1x mb-3">
                            กรุณาปิดและเข้าใช้งานอีกครั้ง
                        </div>

                        <a href="#" onclick="closed()" class="close-menu mr-3 ml-3 mt-5 btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-red2-dark">ปิด</a>

                    </div>
                    <div class="card-overlay bg-black opacity-70"></div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="js/pinpad.js"></script>
            <!-- Start PIN code login page -->

        @else

            <!-- Start PIN code login page -->
            <a href="#" data-menu="login-pin-register2" data-timed-ad="0" data-auto-show-ad="0"> </a>
            <div id="login-pin-register2" class="menu menu-box-modal menu-box-detached round-large" data-menu-width="100vw" data-menu-height="100vh" data-menu-effect="menu-over">
                <div class="card bg-17" data-card-height="100vh">
                    <div class="card-top">
                        <a href="#" onclick="closed()" class="close-menu ad-time-close color-highlight"><i class="fa fa-times disabled"></i><span></span></a>
                    </div>
                    <div class="card-top">
                        <span class="color-white bg-black font-10 opacity-70 pb-1 pt-1 pl-2 pr-2 ml-1">ยืนยันรหัส PIN</span>
                    </div>
                    <div class="card-center text-center">
                        <h1 class="color-white text-center text-uppercase font-700 fa-3x mb-3">ยืนยันรหัส PIN</h1>
                        <form name="loginpin" id="loginpin" action="{{ url('/') }}/pinconfirm" method="GET">
                            <input type="hidden" name="pincode1" value="{{ $pincode1 }}">
                            <input type="password" name="pincode2" id="password" /></br></br>
                            <input type="button" value="1" id="1" class="pinButton calc"/>
                            <input type="button" value="2" id="2" class="pinButton calc"/>
                            <input type="button" value="3" id="3" class="pinButton calc"/><br>
                            <input type="button" value="4" id="4" class="pinButton calc"/>
                            <input type="button" value="5" id="5" class="pinButton calc"/>
                            <input type="button" value="6" id="6" class="pinButton calc"/><br>
                            <input type="button" value="7" id="7" class="pinButton calc"/>
                            <input type="button" value="8" id="8" class="pinButton calc"/>
                            <input type="button" value="9" id="9" class="pinButton calc"/><br>
                            <input type="button" value="ลบ" id="clear" class="pinButton clear"/>
                            <input type="button" value="0" id="0 " class="pinButton calc"/>
                            <input type="button" onclick="submitform()" value="ตกลง" id="enter" class="pinButton enter"/>
                        </form>

                        <a href="#" onclick="closed()" class="close-menu mr-3 ml-3 mt-5 btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-red2-dark">ปิด</a>

                    </div>
                    <div class="card-overlay bg-black opacity-70"></div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="js/pinpad.js"></script>
            <!-- Start PIN code login page -->

        @endif

    @else

    <!-- Start PIN code login page -->
    <a href="#" data-menu="login-pin-register" data-timed-ad="0" data-auto-show-ad="0"> </a>
    <div id="login-pin-register" class="menu menu-box-modal menu-box-detached round-large" data-menu-width="100vw" data-menu-height="100vh" data-menu-effect="menu-over">
        <div class="card bg-17" data-card-height="100vh">
            <div class="card-top">
                <a href="#" onclick="closed()" class="close-menu ad-time-close color-highlight"><i class="fa fa-times disabled"></i><span></span></a>
            </div>
            <div class="card-top">
                <span class="color-white bg-black font-10 opacity-70 pb-1 pt-1 pl-2 pr-2 ml-1">ตั้งรหัส PIN</span>
            </div>
            <div class="card-center text-center">
                <h1 class="color-white text-center text-uppercase font-700 fa-3x mb-3">ตั้งรหัส PIN</h1>
                <form name="loginpin" id="loginpin" action="{{ url('/') }}/pinregister" method="GET">
                    <input type="password" name="pincode1" id="password" /></br></br>
                    <input type="button" value="1" id="1" class="pinButton calc"/>
                    <input type="button" value="2" id="2" class="pinButton calc"/>
                    <input type="button" value="3" id="3" class="pinButton calc"/><br>
                    <input type="button" value="4" id="4" class="pinButton calc"/>
                    <input type="button" value="5" id="5" class="pinButton calc"/>
                    <input type="button" value="6" id="6" class="pinButton calc"/><br>
                    <input type="button" value="7" id="7" class="pinButton calc"/>
                    <input type="button" value="8" id="8" class="pinButton calc"/>
                    <input type="button" value="9" id="9" class="pinButton calc"/><br>
                    <input type="button" value="ลบ" id="clear" class="pinButton clear"/>
                    <input type="button" value="0" id="0 " class="pinButton calc"/>
                    <input type="button" onclick="submitform()" value="ตกลง" id="enter" class="pinButton enter"/>
                </form>

                <a href="#" onclick="closed()" class="close-menu mr-3 ml-3 mt-5 btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-red2-dark">ปิด</a>

            </div>
            <div class="card-overlay bg-black opacity-70"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/pinpad.js"></script>
    <!-- Start PIN code login page -->

    @endif


@endsection


@section('footer_script')


@endsection
