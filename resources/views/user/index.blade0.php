@extends('layouts.theme')
@section('header_script')
{{-- header --}}
header("Content-type: image/jpeg");
@endsection

@section('content')

<div class="header header-fixed header-logo-center bg-red2-dark">
    <a href="#" class="header-title color-white"> </a>

    <a href="#" onclick="closed()" class="header-icon header-icon-1"><i class="fas fa-times"></i></a>

    <a href="#" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();"
    class="header-icon header-icon-4"><i class="fas fa-sign-out-alt"></i></a>
    <form id="logout-form" action="#" method="POST" class="d-none">
        @csrf
    </form>
</div>

@foreach ($setting as $data)
@php
    $hos_name = $data->hos_name;
    $hos_tel = $data->hos_tel;
@endphp
@endforeach

<div class="page-content header-clear-large">

    <div class="card card-style">
        <div class="content">
            <h3>สมาชิก Line OA {{ $data->hos_name }}</h3>
            <p>ระบบบริหารจัดการผู้ป่วยที่ลงทะเบียน LineOA สำหรับผู้ดูแลระบบ</p>

            @foreach ($userregister as $data)
            @php
            if ($data->image || NULL) {
                $pic = "user_images.php?hn=".$data->hn."";
            } else {
                switch ($data->sex) {
                    case 1 : if ($data->age_y<=15) $pic="images/boy.jpg"; else $pic="images/male.jpg";break;
                    case 2 : if ($data->age_y<=15) $pic="images/girl.jpg"; else $pic="images/female.jpg";break;
                    default : $pic="images/boy.jpg";break;
                }
            }
            @endphp

            <div class="divider mt-3"></div>
            <div class="user-slider owl-carousel">
                <div class="user-left">
                    <div class="d-flex">
                        <div><img src="{{ $pic }}" class="mr-3 rounded-circle shadow-l" width="50"></div>
                        <div>
                            <h5 class="mt-1 mb-0">{{ $data->pname.$data->fname." ".$data->lname }}</h5>
                            <p class="font-10 mt-n1 color-blue2-dark">อายุ {{ $data->age_y }} ปี โทรศัพท์: <a href="tel:{{ $data->tel }}">{{ $data->tel }}</a></p>
                        </div>
                        <div class="ml-auto"><span class="next-slide-user badge bg-blue2-dark mt-2 p-2 font-8">เพิ่มเติม</span></div>
                    </div>
                </div>
                <div class="user-right">
                    <div class="d-flex">
                        <div>
                            <h5 class="mt-1 mb-0">HN: {{ $data->hn }}</h5>
                            <p class="font-10 mt-n1 color-red2-dark">เลขบัตรประชาชน: {{ $data->cid }}</p>
                        </div>
                        <div class="ml-auto">
                            <a href="tel:{{ $data->tel }}" class="icon icon-xs rounded-circle shadow-l bg-phone"><i class="fa fa-phone"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-facebook mr-2 ml-2"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- <div class="divider mt-3"></div> --}}
{{--
            <div class="user-slider owl-carousel">
                <div class="user-left">
                    <div class="d-flex">
                        <div><img src="images/pictures/faces/2s.png" class="mr-3 rounded-circle shadow-l" width="50"></div>
                        <div>
                            <h5 class="mt-1 mb-0">Alexander Mac</h5>
                            <p class="font-10 mt-n1 color-green1-dark">Support Team Manager</p>
                        </div>
                        <div class="ml-auto"><span class="next-slide-user badge bg-green1-dark mt-2 p-2 font-8">TAP FOR MORE</span></div>
                    </div>
                </div>
                <div class="user-right">
                    <div class="d-flex">
                        <div>
                            <h5 class="mt-1 mb-0">Alexander Mac</h5>
                            <p class="font-10 mt-n1 color-green1-dark">Support Team Manager</p>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-phone"><i class="fa fa-phone"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-facebook mr-2 ml-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-twitter"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider mt-3"></div>


            <div class="user-slider owl-carousel">
                <div class="user-left">
                    <div class="d-flex">
                        <div><img src="images/pictures/faces/3s.png" class="mr-3 rounded-circle shadow-l" width="50"></div>
                        <div>
                            <h5 class="mt-1 mb-0">Johnatan Unixer</h5>
                            <p class="font-10 mt-n1 color-blue2-dark">Executive Officer</p>
                        </div>
                        <div class="ml-auto"><span class="next-slide-user badge bg-blue2-dark mt-2 p-2 font-8">TAP FOR MORE</span></div>
                    </div>
                </div>
                <div class="user-right">
                    <div class="d-flex">
                        <div>
                            <h5 class="mt-1 mb-0">Johnatan Doe</h5>
                            <p class="font-10 mt-n1 color-blue2-dark">Executive Officer</p>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-phone"><i class="fa fa-phone"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-facebook mr-2 ml-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-twitter"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider mt-3"></div>

            <div class="user-slider owl-carousel">
                <div class="user-left">
                    <div class="d-flex">
                        <div><img src="images/pictures/faces/4s.png" class="mr-3 rounded-circle shadow-l" width="50"></div>
                        <div>
                            <h5 class="mt-1 mb-0">Vincent Mobi</h5>
                            <p class="font-10 mt-n1 color-gray2-dark">Back End Developer</p>
                        </div>
                        <div class="ml-auto"><span class="next-slide-user badge bg-blue2-dark mt-2 p-2 font-8">TAP FOR MORE</span></div>
                    </div>
                </div>
                <div class="user-right">
                    <div class="d-flex">
                        <div>
                            <h5 class="mt-1 mb-0">Vincent Mobi</h5>
                            <p class="font-10 mt-n1 color-gray2-dark">Back End Developer</p>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-phone"><i class="fa fa-phone"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-facebook mr-2 ml-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="icon icon-xs rounded-circle shadow-l bg-twitter"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
             --}}
        </div>
    </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">กำหนดเจ้าหน้าที่</span></a>
        <p class="footer-text">
        <span class="font-12">
            <br>- แสดงรายชื่อเจ้าหน้าที่ที่มีชื่อผู้ใช้งานในโปรแกรม HIS และลงทะเบียนใช้งานแอปนี้แล้วเท่านั้น
            <br>- กำหนดเจ้าหน้าที่ ให้เป็นผู้ดูแลระบบจองนัดออนไลน์ ในคลินิกที่รับผิดชอบ
        </span>
        <span class="font-16">
            <br><br><b>หากมีปัญหาข้อสงสัย โปรดติดต่อ Admin</a>
        </span>
        </p>
    </div>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
