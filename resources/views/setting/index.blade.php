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
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">พิกัด GPS ที่ตั้งโรงพยาบาล</span>
                <input class="form-control" type="text" name="hoslocation" id="locationPoint" value="{{ $data->hoslocation }}">
                <div class="text-center">
                <a target="_blank" href="https://www.google.co.th/maps/&#64;{{ $data->hoslocation }},15z?hl=th">คลิกดูตัวอย่างแผนที่</a></div>
                <a href="#" onclick="getLocation()" class="btn btn-m btn-center-l font-900 bg-gray2-dark rounded-sm shadow-xl mt-2 mb-2">คลิกอ่านพิกัด GPS</a>
            </div>
        </div>
        <div class="divider mb-0"></div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box905-fac-radio" type="radio" name="pinlogin" value="Y" @if ($data->pinlogin == "Y") checked @endif>
                    <label for="box905-fac-radio">ใช้</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box906-fac-radio" type="radio" name="pinlogin" value="N" @if ($data->pinlogin == "N") checked @endif>
                    <label for="box906-fac-radio">ไม่ใช้</label>
                </div>
            </em>
            @if ($data->pinlogin == "N")
                <strong class="color-red2-dark">ระบบความปลอดภัยด้วย PIN login</strong>
            @else
                <strong>ระบบความปลอดภัยด้วย PIN login</strong>
            @endif
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box1005-fac-radio" type="radio" name="active_ptregister" value="Y" @if ($data->active_ptregister == "Y") checked @endif>
                    <label for="box1005-fac-radio">ใช้</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box1006-fac-radio" type="radio" name="active_ptregister" value="N" @if ($data->active_ptregister == "N") checked @endif>
                    <label for="box1006-fac-radio">ไม่ใช้</label>
                </div>
            </em>
            @if ($data->active_ptregister == "N")
                <strong class="color-red2-dark">ระบบลงทะเบียนผู้ป่วยใหม่</strong>
            @else
                <strong>ระบบลงทะเบียนผู้ป่วยใหม่</strong>
            @endif
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box1007-fac-radio" type="radio" name="active_checkin" value="Y" @if ($data->active_checkin == "Y") checked @endif>
                    <label for="box1007-fac-radio">ใช้</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box1008-fac-radio" type="radio" name="active_checkin" value="N" @if ($data->active_checkin == "N") checked @endif>
                    <label for="box1008-fac-radio">ไม่ใช้</label>
                </div>
            </em>
            @if ($data->active_checkin == "N")
                <strong class="color-red2-dark">ระบบ Checkin เข้ารับบริการ (ออก visit)</strong>
            @else
                <strong>ระบบ Checkin เข้ารับบริการ (ออก visit)</strong>
            @endif
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
            @if ($data->ext_q_status == "N")
                <strong class="color-red2-dark">ใช้งานระบบคิวอื่น</strong>
            @else
                <strong>ใช้งานระบบคิวอื่น</strong>
            @endif
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
                    <input id="box15-fac-radio" type="radio" name="module_1" value="Y" @if ($data->module_1 == "Y") checked @endif>
                    <label for="box15-fac-radio">เปิด</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box16-fac-radio" type="radio" name="module_1" value="N" @if ($data->module_1 == "N") checked @endif>
                    <label for="box16-fac-radio">ปิด</label>
                </div>
            </em>
            @if ($data->module_1 == "N")
                <strong class="color-red2-dark">บัตรผู้ป่วย + ประวัติรับบริการ</strong>
            @else
                <strong>บัตรผู้ป่วย + ประวัติรับบริการ</strong>
            @endif
        </div>
        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box25-fac-radio" type="radio" name="module_2" value="Y" @if ($data->module_2 == "Y") checked @endif>
                    <label for="box25-fac-radio">เปิด</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box26-fac-radio" type="radio" name="module_2" value="N" @if ($data->module_2 == "N") checked @endif>
                    <label for="box26-fac-radio">ปิด</label>
                </div>
            </em>
            @if ($data->module_2 == "N")
                <strong class="color-red2-dark">วันนัด + ข้อมูลวัคซีน</strong>
            @else
                <strong>วันนัด + ข้อมูลวัคซีน</strong>
            @endif
        </div>
        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box35-fac-radio" type="radio" name="module_3" value="Y" @if ($data->module_3 == "Y") checked @endif>
                    <label for="box35-fac-radio">เปิด</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box36-fac-radio" type="radio" name="module_3" value="N" @if ($data->module_3 == "N") checked @endif>
                    <label for="box36-fac-radio">ปิด</label>
                </div>
            </em>
            @if ($data->module_3 == "N")
                <strong class="color-red2-dark">ตรวจสุขภาพ + จองคิวรับบริการ</strong>
            @else
                <strong>ตรวจสุขภาพ + จองคิวรับบริการ</strong>
            @endif
        </div>
        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box45-fac-radio" type="radio" name="module_4" value="Y" @if ($data->module_4 == "Y") checked @endif>
                    <label for="box45-fac-radio">เปิด</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box46-fac-radio" type="radio" name="module_4" value="N" @if ($data->module_4 == "N") checked @endif>
                    <label for="box46-fac-radio">ปิด</label>
                </div>
            </em>
            @if ($data->module_4 == "N")
                <strong class="color-red2-dark">โทร 1669 + ตรวจสอบสิทธิ</strong>
            @else
                <strong>โทร 1669 + ตรวจสอบสิทธิ</strong>
            @endif
        </div>

        <div class="cal-schedule">
            <em>
                <div class="fac fac-radio fac-green"><span></span>
                    <input id="box95-fac-radio" type="radio" name="modulecustom" value="Y" @if ($data->modulecustom == "Y") checked @endif>
                    <label for="box95-fac-radio">มี</label>
                </div>
                <div class="fac fac-radio fac-red"><span></span>
                    <input id="box96-fac-radio" type="radio" name="modulecustom" value="N" @if ($data->modulecustom == "N") checked @endif>
                    <label for="box96-fac-radio">ไม่มี</label>
                </div>
            </em>
            @if ($data->modulecustom == "N")
                <strong class="color-red2-dark">พัฒนาโมดูลเพิ่มเติม</strong>
            @else
                <strong>พัฒนาโมดูลเพิ่มเติม</strong>
            @endif
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
            @if ($data->dm_status == "N")
                <strong class="color-red2-dark">ปุ่มเลือก Dark Mode โหมดกลางคืน</strong>
            @else
                <strong>ปุ่มเลือก Dark Mode โหมดกลางคืน</strong>
            @endif
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
