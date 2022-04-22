@extends('layouts.theme')
@section('menu-active-emr','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="page-content header-clear-small">

    @if (Session::has('settingemr-updated'))
    <div class="ml-3 mr-3 alert alert-small rounded-s shadow-xl bg-green1-dark" role="alert">
        <span><i class="fa fa-check"></i></span>
        <strong>{{ Session('settingemr-updated') }}</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>

    @endif


<form method="POST" action="{{ route('emr.update', 1) }}">
    @csrf
    @method('PATCH')
<div class="card card-style shadow-xl rounded-m">
    <div class="cal-footer">
        <h4 class="cal-title text-center text-uppercase font-25 bg-blue2-dark color-white">EMR Setting</h4>
        <span class="cal-message mt-3 mb-3">
            <strong class="color-gray-dark">ตั้งค่าระบบ EMR และกำหนดค่ามาตรฐาน สูงสูด/ต่ำสุด</strong>
        </span>
        <div class="divider mb-0"></div>
        <div class="content mb-0">
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">จำกัด visit ทั่วไปย้อนหลังไม่เกิน...ปี</span>
                <input class="form-control" type="number" name="emr_visit_limit" value="{{ $settingemr->emr_visit_limit }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">ICD10 ตรวจสุขภาพ</span>
                <input class="form-control" type="text" name="emr_checkup_icd10" value="{{ $settingemr->emr_checkup_icd10 }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">BP systolic ความดัน</span>
                <input class="form-control" type="number" name="emr_bps" value="{{ $settingemr->emr_bps }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">BP diastolic ความดัน</span>
                <input class="form-control" type="number" name="emr_bpd" value="{{ $settingemr->emr_bpd }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Temp อุณหภูมิ</span>
                <input class="form-control" type="number" name="emr_temperature" value="{{ $settingemr->emr_temperature }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Pulse ชีพจร</span>
                <input class="form-control" type="number" name="emr_pulse" value="{{ $settingemr->emr_pulse }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Body Weight น้ำหนัก</span>
                <input class="form-control" type="number" name="emr_bw" value="{{ $settingemr->emr_bw }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">Height ส่วนสูง</span>
                <input class="form-control" type="number" name="emr_height" value="{{ $settingemr->emr_height }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">BMI ดัชนีมวลกาย (ต่ำผอม)</span>
                <input class="form-control" type="number" name="emr_bmi1" value="{{ $settingemr->emr_bmi1 }}">
            </div>
            <div class="input-style input-style-2 input-required">
                <span class="color-highlight input-style-1-active">BMI ดัชนีมวลกาย (สูงอ้วน)</span>
                <input class="form-control" type="number" name="emr_bmi2" value="{{ $settingemr->emr_bmi2 }}">
            </div>

        </div>

        <div class="cal-schedule">
            <strong>ตั้งค่า LAB specimen</strong>
            <div class="content mb-0">
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">Specimen เลือด</span>
                    <input class="form-control" type="text" name="lab_spec_blood" value="{{ $data->lab_spec_blood }}">
                </div>
                <div class="input-style input-style-2 input-required mt-4">
                    <span class="color-highlight input-style-1-active">Specimen ปัสสาวะ</span>
                    <input class="form-control" type="text" name="lab_spec_urine" value="{{ $data->lab_spec_urine }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-m btn-center-l text-uppercase font-900 bg-blue2-dark rounded-sm shadow-xl mt-4 mb-0">บันทึก</button>
        <div class="clear"><br></div>

    </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">คำแนะนำ</span></a>
        <p class="footer-text">
        <span class="font-12">
            <br>ดูคำแนะนำการตั้งค่าได้ที่นี่ครับ --><a target="_blank" href="https://drive.google.com/drive/folders/1QXJuYPB84ae705tz5QmkZ7hK0dJY2DbZ?usp=sharing">คลิกที่นี่</a>
            <br>
        </span>
        <span class="font-16">
            <br><br><b>หากมีปัญหา ข้อสงสัย ต้องการคำแนะนำ ปรึกษาผู้พัฒนาได้ครับ
                <br>Line ID = <a href="https://line.me/ti/p/Xu3TXschDY">0619921666</a>
        </span>
        </p>
    </div>

</div>

</form>



</div>
<!-- End of Page Content-->

@endsection


@section('footer_script')


@endsection
