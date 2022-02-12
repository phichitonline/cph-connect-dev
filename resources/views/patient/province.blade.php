@extends('layouts.theme')
@section('menu-active-main','')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h3>การทำ Multiple Dropdown ด้วย Ajax เลือก 3 ขั้น</h3>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="province">จังหวัด</label>
                        <select name="province_id" id="province" class="form-control">
                            <option value="">เลือกจังหวัด</option>
                            @foreach ($thaiaddress_provinces as $data)
                                <option value="{{ $data->PROVINCE_ID }}">{{ $data->PROVINCE_NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="amphure">อำเภอ</label>
                        <select name="amphure_id" id="amphure" class="form-control">
                            <option value="">เลือกอำเภอ</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="district">ตำบล</label>
                        <select name="district_id" id="district" class="form-control">
                            <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <script src="assets/jquery.min.js"></script> --}}
{{-- <script src="assets/province.js"></script> --}}


@endsection

@section('footer_script')

<script type="text/javascript" src="{{ URL::asset('scripts/province.js') }}"></script>

@endsection
