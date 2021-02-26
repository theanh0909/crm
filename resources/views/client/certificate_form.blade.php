<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('limitless/global_assets/css/icons/icomoon/styles.css')}}">
    <link rel="stylesheet" href="{{asset('limitless/global_assets/css/icons/fontawesome/styles.min.css')}}">
    <link href="{{asset('limitless/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('tags/amsify.suggestags.css')}}">

    <style>
        span.primary-color-2.ml-1 {
            color: red;
        }
        .amsify-suggestags-input{
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <br>
        <center>
            <h2 >ĐĂNG KÝ DỰ THI SÁT HẠCH VÀ CẤP CHỨNG CHỈ HÀNH NGHỀ XÂY DỰNG</h2>
        </center>
        <br><br>
        <form action="{{route('certificate-form-post', ['id' => $id])}}" method="post">
            @csrf
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            <div class="form-group row">
                <label class="col-form-label col-lg-2">1. Họ và tên:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input value="{{old('customer_name')}}" class="form-control" type="text" name="customer_name" placeholder="Nhập và chọn lĩnh vực...">
                    @if ($errors->has('customer_name'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('customer_name') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">2. Ngày sinh:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="date" value="{{old('customer_birthday')}}" name="customer_birthday" placeholder="Nhập ngày sinh">
                    @if ($errors->has('customer_birthday'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('customer_birthday') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">3. Địa chỉ thường trú:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="{{old('customer_address')}}" name="customer_address" placeholder="Ghi theo chứng minh thư">
                    @if ($errors->has('customer_address'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('customer_address') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">4. Quốc tịch:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" value="Việt Nam" type="text" name="nation" placeholder="Việt Nam">
                    @if ($errors->has('nation'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('nation') }}</span>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-form-label col-lg-2">4. Số diện thoại:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input value="{{old('customer_phone')}}" class="form-control" type="text" name="customer_phone" placeholder="Số điện thoại...">
                    @if ($errors->has('customer_phone'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('customer_phone') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">5. Địa chỉ Email:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input value="{{old('customer_email')}}" class="form-control" type="text" name="customer_email" placeholder="Địa chỉ email...">
                    @if ($errors->has('customer_email'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('customer_email') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">6. Số CMND / Hộ chiếu:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="{{old('id_card')}}" name="id_card" placeholder="Nhập số chứng minh thư hoặc hộ chiếu...">
                    @if ($errors->has('id_card'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('id_card') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">7. Ngày cấp CMND / Hộ chiếu:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="date" value="{{old('date_card')}}" name="date_card" placeholder="mm/dd/yyyy">
                    @if ($errors->has('date_card'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('date_card') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">8. Nơi cấp CMND / Hộ chiếu:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-10">
                    <input class="form-control" type="text" value="{{old('address_card')}}" name="address_card" placeholder="Nhập nơi cấp CMT/Hộ chiếu">
                    @if ($errors->has('address_card'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('address_card') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">9. Trình độ chuyên môn:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-10">
                    <input class="form-control" type="text" value="{{old('qualification')}}" name="qualification" placeholder="Ví dụ: Kỹ sư xây dựng, Kỹ sư Kinh tế xây dựng">
                    @if ($errors->has('qualification'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('qualification') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">10. Cơ sở đào tạo:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="{{old('school')}}" name="school" placeholder="Ví dụ: Đại học Xây dựng, Đại học GTVT...">
                    @if ($errors->has('school'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('school') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">11. Hệ đào tạo:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="{{old('edu_system')}}" name="edu_system" placeholder="Chính quy hay vừa làm vừa học">
                    @if ($errors->has('edu_system'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('edu_system') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">12. Lĩnh vực đăng ký sát hạch:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="{{old('type_exam')}}" name="type_exam" placeholder="Nhập tên lĩnh vực và chọn...">
                    @if ($errors->has('type_exam'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('type_exam') }}</span>
                    @endif
                </div>
                <label class="col-form-label col-lg-2">13. Hạng sát hạch:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-4">
                    <input class="form-control" type="text"  value="{{old('class')}}" name="class" placeholder="VD: II;III">
                    <span class="primary-color-2 ml-1">Lưu ý: mỗi hạng cách nhau bởi dấu ;</span><br>
                    @if ($errors->has('class'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('class') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">14. Số năm kinh nghiệm:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-10">
                    <input class="form-control" type="number"  value="{{old('exper_num')}}" name="exper_num" placeholder="Tính theo thời gian trên bằng ĐH, CĐ">
                    @if ($errors->has('exper_num'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('exper_num') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">15. Đơn vị công tác:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-10">
                    <input class="form-control" type="text" value="{{old('company')}}" name="company" placeholder="Tên cơ quan, nơi công tác">
                    @if ($errors->has('company'))
                        <span class="primary-color-2 ml-1">{{ $errors->first('company') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">16. Nơi thi:<span class="primary-color-2 ml-1">*</span></label>
                <div class="col-lg-10">
                    <select class="form-control" name="customer_cty" id="">
                        <option @if(old('customer_cty') == 'Hà Nội'){{'selected'}}@endif value="Hà Nội">
                            Hà Nội
                        </option>
                        <option @if(old('customer_cty') == 'Hồ Chí Minh'){{'selected'}}@endif value="Hồ Chí Minh">
                            Hồ Chí Minh
                        </option>
                        <option @if(old('customer_cty') == 'Nha Trang'){{'selected'}}@endif value="Nha Trang">
                            Nha Trang
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-lg-12">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Xác nhận</button>
            </div><!-- end col-md-12 -->
        </form>
    </div>
</body>
<script src="{{asset('limitless/global_assets/js/main/jquery.min.js')}}"></script>
<script src="{{asset('tags/jquery.amsify.suggestags.js')}}"></script>
<script>
    $('input[name="type_exam"]').amsifySuggestags({
            type : 'amsify',
            suggestions: ['Khảo sát xây dựng',
                            'Thiết kế quy hoạch xây dựng',
                            'Thiết kế xây dựng công trình',
                            'Quản lý dự án đầu tư xây dựng',
                            'Định giá xây dựng',
                            'Giám sát thi công xây dựng công trình',
                            'Giám sát lắp đặt thiết bị công trình']
        });
</script>
</html>
    


