@extends('layouts.theme')
@section('menu-active-setting','')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="page-content header-clear-small">

    @if (Session::has('setting-updated'))
    <div class="ml-3 mr-3 alert alert-small rounded-s shadow-xl bg-green1-dark" role="alert">
        <span><i class="fa fa-check"></i></span>
        <strong>{{ Session('setting-updated') }}</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>

    @endif

@foreach ($setting as $data)
<form method="POST" action="{{ route('setting.update', $data->id) }}">
    @csrf
    @method('put')
<div class="card card-style shadow-xl rounded-m">
    <div class="cal-footer">
        <h4 class="cal-title text-center text-uppercase font-25 bg-red2-dark color-white">{{ $moduletitle }}</h4>
        <span class="cal-message mt-3 mb-3">
            <strong class="color-gray-dark">ตั้งค่าพื้นฐานของหน่วยงานและการแสดงผลต่างๆ</strong>
            <strong class="color-gray-dark">Setting and display.</strong>
        </span>
        <div class="divider mb-0"></div>
        <div class="content mb-0">
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">ชื่อโรงพยาบาล</span>
                <input class="form-control" type="text" name="hos_name" value="{{ $data->hos_name }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">เบอร์โทรศัพท์</span>
                <em>(required)</em>
                <input class="form-control" type="tel" name="hos_tel" value="{{ $data->hos_tel }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">เว็บไซต์</span>
                <em>(required)</em>
                <input class="form-control" type="url" name="hos_url" value="{{ $data->hos_url }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Facebook</span>
                <em>(required)</em>
                <input class="form-control" type="url" name="hos_facebook" value="{{ $data->hos_facebook }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Youtube</span>
                <em>(required)</em>
                <input class="form-control" type="url" name="hos_youtube" value="{{ $data->hos_youtube }}">
            </div>
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box1-fac-radio" type="radio" name="slide_status" value="Y" @if ($data->slide_status == "Y") checked @endif>
                    <label for="box1-fac-radio">แสดง</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box2-fac-radio" type="radio" name="slide_status" value="N" @if ($data->slide_status == "N") checked @endif>
                    <label for="box2-fac-radio">ไม่แสดง</label>
                </div>
            </em>
            <strong>สไลด์โฆษณา</strong>
            <div class="content mb-0">
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">หัวข้อ 1</span>
                    <input class="form-control" type="text" name="slide_1_text" value="{{ $data->slide_1_text }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ข้อความ 1</span>
                    <input class="form-control" type="text" name="slide_1_more" value="{{ $data->slide_1_more }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ชื่อภาพ 1 (ต้องอยู่ใน images/pictures/ ขนาด 300x200px)</span>
                    <input class="form-control" type="text" name="slide_1_picture" value="{{ $data->slide_1_picture }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">หัวข้อ 2</span>
                    <input class="form-control" type="text" name="slide_2_text" value="{{ $data->slide_2_text }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ข้อความ 2</span>
                    <input class="form-control" type="text" name="slide_2_more" value="{{ $data->slide_2_more }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ชื่อภาพ 2 (ต้องอยู่ใน images/pictures/ ขนาด 300x200px)</span>
                    <input class="form-control" type="text" name="slide_2_picture" value="{{ $data->slide_2_picture }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">หัวข้อ 3</span>
                    <input class="form-control" type="text" name="slide_3_text" value="{{ $data->slide_3_text }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ข้อความ 3</span>
                    <input class="form-control" type="text" name="slide_3_more" value="{{ $data->slide_3_more }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ชื่อภาพ 3 (ต้องอยู่ใน images/pictures/ ขนาด 300x200px)</span>
                    <input class="form-control" type="text" name="slide_3_picture" value="{{ $data->slide_3_picture }}">
                </div>
            </div>

        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box3-fac-radio" type="radio" name="pr_status" value="Y" @if ($data->pr_status == "Y") checked @endif>
                    <label for="box3-fac-radio">แสดง</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box4-fac-radio" type="radio" name="pr_status" value="N" @if ($data->pr_status == "N") checked @endif>
                    <label for="box4-fac-radio">ไม่แสดง</label>
                </div>
            </em>
            <strong>ประชาสัมพันธ์</strong>
            <div class="content mb-0">
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">ข้อความ 1</span>
                    <input class="form-control" type="text" name="pr_1" value="{{ $data->pr_1 }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ข้อความ 2</span>
                    <input class="form-control" type="text" name="pr_2" value="{{ $data->pr_2 }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">ข้อความ 3</span>
                    <input class="form-control" type="text" name="pr_3" value="{{ $data->pr_3 }}">
                </div>
            </div>
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box7-fac-radio" type="radio" name="ext_q_status" value="Y" @if ($data->ext_q_status == "Y") checked @endif>
                    <label for="box7-fac-radio">มี</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box8-fac-radio" type="radio" name="ext_q_status" value="N" @if ($data->ext_q_status == "N") checked @endif>
                    <label for="box8-fac-radio">ไม่มี</label>
                </div>
            </em>
            <strong>ใช้งานระบบคิวอื่น</strong>
            <div class="content mb-0">
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">ชื่อโปรแกรมระบบคิว</span>
                    <input class="form-control" type="text" name="ext_q_name" value="{{ $data->ext_q_name }}">
                </div>
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">URL แสดงสถานะคิว</span>
                    <input class="form-control" type="text" name="ext_q_url" value="{{ $data->ext_q_url }}">
                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight input-style-1-active">โลโก้โปรแกรมคิว (ต้องอยู่ใน images/)</span>
                    <input class="form-control" type="text" name="ext_q_img" value="{{ $data->ext_q_img }}">
                </div>
            </div>
        </div>
        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box7-fac-radio" type="radio" name="ext_q_status" value="Y" @if ($data->ext_q_status == "Y") checked @endif>
                    <label for="box7-fac-radio">มี</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box8-fac-radio" type="radio" name="ext_q_status" value="N" @if ($data->ext_q_status == "N") checked @endif>
                    <label for="box8-fac-radio">ไม่มี</label>
                </div>
            </em>
            <strong>พิกัด GPS ที่ตั้งโรงพยาบาล</strong>
            <div class="content mb-0">
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">GPS</span>
                    <input class="form-control" type="text" name="location" id="locationPoint" value="{{ $data->location }}">
                </div>
                <a href="#" onclick="getLocation()" class="btn btn-m btn-center-l text-uppercase font-900 bg-blue2-dark rounded-sm shadow-xl mt-4 mb-0">คลิกอ่านพิกัด GPS</a>

            </div>
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box5-fac-radio" type="radio" name="dm_status" value="Y" @if ($data->dm_status == "Y") checked @endif>
                    <label for="box5-fac-radio">แสดง</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box6-fac-radio" type="radio" name="dm_status" value="N" @if ($data->dm_status == "N") checked @endif>
                    <label for="box6-fac-radio">ไม่แสดง</label>
                </div>
            </em>
            <strong>ปุ่มเลือก Dark Mode โหมดกลางคืน</strong>

        </div>

        <button type="submit" class="btn btn-m btn-center-l text-uppercase font-900 bg-red2-dark rounded-sm shadow-xl mt-4 mb-0">บันทึก</button>
        <div class="clear"><br></div>

    </div>
</div>
@endforeach
</form>



</div>
<!-- End of Page Content-->

@endsection


@section('footer_script')

<script>
    var x = document.getElementById("locationPoint");

    async function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
        x.value = position.coords.latitude + "," + position.coords.longitude;
    }

</script>

@endsection
