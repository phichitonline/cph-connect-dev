@extends('layouts.theme')
@section('menu-active-main','')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="page-content header-clear-small">

@if (session('session-alert'))
    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">{{ session('session-alert') }}</span></a>
        <div class="clear"><br></div>
    </div>
@endif

<form method="POST" action="{{ route('ptregister.store') }}" autocomplete="off" class="form-horizontal">
    @csrf
    @method('post')

    <div class="page-content header-clear-small">

        <div class="card card-style shadow-xl rounded-m">
            <div class="cal-footer">
                <h4 class="cal-title text-center text-uppercase font-25 bg-red2-dark color-white">{{ $moduletitle }}</h4>

                <div class="content mb-0">
                    <h2 class="mb-4">ข้อมูลส่วนตัว</h2>

                    <div class="form-row">
                        <div class="form-group col-md-4 form-group input-style input-style-1 has-icon input-required">
                            {{-- <i class="input-icon fa fa-address-card"></i> --}}
                            <span class="color-highlight input-style-1-active">เลขที่บัตรประจำตัวประชาชน</span>
                            <br>
                            <a class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s text-left">
                                <i class="fa fa-address-card font-15 text-left"></i>
                                &nbsp; &nbsp;{{ old('cid', $cid) }}
                                <i class="fa fa-check font-15 text-success text-right float-right"></i>
                            </a>

                            {{-- <input type="text" class="form-control" value="{{ old('cid', $cid) }}"> --}}

                            <input type="hidden" name="cid" class="form-control" value="{{ old('cid', $cid) }}">
                            <input type="hidden" name="hn" class="form-control" value="{{ old('hn', $hn) }}">
                            <input type="hidden" name="hos_guid" class="form-control" value="{{ old('hos_guid', $hos_guid) }}">
                            <input type="hidden" name="serial_no" class="form-control" value="{{ old('serial_no', $serial_no) }}">
                            <input type="hidden" name="lineid" class="form-control" value="{{ old('lineid', $lineid) }}">
                            <input type="hidden" name="email" class="form-control" value="{{ old('email', $email) }}">
                            <small class="text-danger">{{ $errors->first('cid') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">คำนำหน้า</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="sexprename" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกคำนำหน้า</option>
                                @foreach ($pname as $data)
                                    <option value="{{ $data->sex.$data->name }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('sexprename') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-3">
                            <i class="input-icon fa fa-user"></i>
                            <span class="color-highlight input-style-1-active">ชื่อ</span>
                            <em>(required)</em>
                            <input type="text" name="fname" class="form-control mb-0" placeholder="ชื่อ (ภาษาไทย)" value="{{ old('fname')}}" required>
                            <small class="text-danger">{{ $errors->first('fname') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-3">
                            <i class="input-icon fa fa-user"></i>
                            <span class="color-highlight input-style-1-active">นามสกุล</span>
                            <em>(required)</em>
                            <input type="text" name="lname" class="form-control mb-0" placeholder="นามสกุล (ภาษาไทย)" value="{{ old('lname')}}" required>
                            <small class="text-danger">{{ $errors->first('lname') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-3">
                            <i class="input-icon fa fa-calendar"></i>
                            <span class="color-highlight input-style-1-active">วันเดือนปี พ.ศ.เกิด</span>
                            <em>(required)</em>
                            <input type="tel" name="birthday" class="form-control mb-0" value="{{ old('birthday', $birthday) }}" required>
                            <small class="text-danger">{{ $errors->first('birthday') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">สภาพสมรส</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="marrystatus" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกสภาพสมรส</option>
                                @foreach ($marrystatus as $data)
                                    <option value="{{ $data->code }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('marrystatus') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">กรุ๊ปเลือด</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="bloodgrp" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกกรุ๊ปเลือด</option>
                                @foreach ($blood_group as $data)
                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('bloodgrp') }}</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-3">
                            <!--<i class="input-icon fa fa-calendar"></i>-->
                            <span class="color-highlight input-style-1-active">ชื่อบิดา</span>
                            <em>(required)</em>
                            <input type="text" name="fathername" class="form-control mb-0" placeholder="ชื่อบิดา (ภาษาไทย)" value="{{ old('fathername') }}" required>
                            <small class="text-danger">{{ $errors->first('fathername') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-3">
                            <!--<i class="input-icon fa fa-calendar"></i>-->
                            <span class="color-highlight input-style-1-active">ชื่อมารดา</span>
                            <em>(required)</em>
                            <input type="text" name="mathername" class="form-control mb-0" placeholder="ชื่อมารดา (ภาษาไทย)" value="{{ old('mathername') }}" required>
                            <small class="text-danger">{{ $errors->first('mathername') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">อาชีพ</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="occupation" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกอาชีพ</option>
                                @foreach ($occupation as $data)
                                    <option value="{{ $data->occupation }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('occupation') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">เชื้อชาติ</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="nationality" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกเชื้อชาติ</option>
                                @foreach ($nationality as $data)
                                    <option value="{{ $data->nationality }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('nationality') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">สัญชาติ</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="citizenship" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกสัญชาติ</option>
                                @foreach ($emp_citizenship as $data)
                                    <option value="{{ $data->emp_citizenship_id }}">{{ $data->emp_citizenship_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('citizenship') }}</small>
                        </div>
                        <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                            <span class="color-highlight input-style-1-active">ศาสนา</span>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select name="religion" class="form-control mb-0">
                                <option value="" disabled selected>กรุณาเลือกศาสนา</option>
                                @foreach ($religion as $data)
                                    <option value="{{ $data->religion }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('religion') }}</small>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <div class="card card-style">
            <div class="content mb-0">
                <h2 class="mb-4">ข้อมูลการติดต่อ</h2>

                <div class="form-row">
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <i class="input-icon fa fa-map-marker"></i>
                        <span class="color-highlight input-style-1-active">ที่อยู่</span>
                        <em>(required)</em>
                        <input name="addrpart" type="text" class="form-control mb-0" placeholder="บ้านเลขที่" value="{{ old('addrpart')}}" required>
                        <small class="text-danger">{{ $errors->first('addrpart') }}</small>
                    </div>
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <span class="color-highlight input-style-1-active">หมู่ที่</span>
                        {{-- <em>(required)</em> --}}
                        <input name="moopart" type="number" class="form-control mb-0" placeholder="หมู่ที่" value="{{ old('moopart')}}">
                        <small class="text-danger">{{ $errors->first('moopart') }}</small>
                    </div>
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <span class="color-highlight input-style-1-active">ซอย/ถนน</span>
                        {{-- <em>(required)</em> --}}
                        <input name="road" type="text" class="form-control mb-0" placeholder="ซอย/ถนน" value="{{ old('road')}}">
                        <small class="text-danger">{{ $errors->first('road') }}</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <span class="color-highlight input-style-1-active">จังหวัด</span>
                        <em><i class="fa fa-angle-down"></i></em>
                        <select id="province" name="province" class="form-control mb-0">
                            <option value="">เลือกจังหวัด</option>
                            @foreach ($thaiaddress_provinces as $data)
                                <option value="{{ $data->PROVINCE_ID }}">{{ $data->PROVINCE_NAME }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('province') }}</small>
                    </div>
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <span class="color-highlight input-style-1-active">อำเภอ</span>
                        <em><i class="fa fa-angle-down"></i></em>
                        <select id="amphure" name="amphure" class="form-control mb-0">
                            <option value="">เลือกอำเภอ</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('amphure') }}</small>
                    </div>
                    <div class="form-group col-md-4 input-style input-style-1 has-icon input-required">
                        <span class="color-highlight input-style-1-active">ตำบล</span>
                        <em><i class="fa fa-angle-down"></i></em>
                        <select name="catpart" id="district" class="form-control mb-0">
                            <option value="">เลือกตำบล</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('catpart') }}</small>
                    </div>
                </div>

                <div class="form-row">
                <div class="form-group col-md-4 input-style input-style-1 has-icon input-required mb-4">
                    <i class="input-icon fa fa-phone"></i>
                    <span class="color-highlight input-style-1-active">เบอร์โทรศัพท์</span>
                    <em>(required)</em>
                    <input type="tel" name="hometel" class="form-control mb-0" placeholder="เบอร์โทรศัพท์" value="{{ old('hometel')}}" required>
                    <small class="text-danger">{{ $errors->first('hometel') }}</small>
                </div>
                </div>


                <button type="submit" class="btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-blue1-dark font-800 text-uppercase">ลงทะเบียน</button>
                <div class="clear"><br></div>
            </div>
        </div>


    </div>

</form>



</div>
<!-- End of Page Content-->

@endsection


@section('footer_script')

<script type="text/javascript" src="{{ URL::asset('scripts/province.js') }}"></script>

@endsection
