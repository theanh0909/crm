<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/limitless/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <title>In phiếu thu</title>
</head>
<body>
    <div class="container print">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-left h3">
                    CÔNG TY CỔ PHẦN GIÁ XÂY DỰNG</br>
                </h3>
                124 Nguyễn Ngọc Nại, Thanh Xuân, Hà Nội
            </div>
            <div class="col-md-6">
                <h3 class="text-right h3">
                    CÔNG NGHỆ - ĐÀO TẠO - PHẦN MỀM - TƯ VẤN
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
               <h1 class="text-center h1">
                    PHIẾU THU
                </h1>
                <p class="text-center">
                    Ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}
                </p>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
               <p>
                    Người nộp tiền: <b>{{$registered->customer_name}}</b>
               </p>
               
               <p>
                    SĐT: <b>{{($registered->customer_phone != '' ? $registered->customer_phone : '..')}}</b>
               </p>
               <p>
                    Email: <b>{{($registered->customer_email != '' ? $registered->customer_email : '..')}}</b>
               </p>
               <p>
                    Người lập phiếu: <b>{{auth()->user()->fullname}}</b>
               </p>
               <p>
                    Sản phẩm: <b>{{($registered->product) ? $registered->product->name : ''}}</b>
               </p>

               <table>
                    <tr align="center">
                        <th>
                            Stt
                        </th>
                        <th>
                            Sản phẩm
                        </th>
                        <th>
                            Số lượng
                        </th>
                        <th class="text-center">
                            Đơn giá
                        </th>
                        <th>Chuyển khoản</th>
                        <th>Thành tiền</th>
                    </tr>
                    <tr>
                        <td align="center">
                           1
                        </td>
                        <td>
                            {{($registered->product) ? $registered->product->name : ''}} ({{$registered->product->description}})
                        </td>
                        
                        <td align="center">
                            {{$registered->qty}}
                        </td>
                        
                        <td class="text-right">
                            {{number_format($registered->price, 0, '.', '.')}} VND
                        </td>
                        <td></td>
                        <td class="text-right">
                            {{number_format($registered->price * $registered->qty)}} VNĐ
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">
                            Chiết khấu
                        </td>
                        <td class="text-right">
                            @if(!empty($registered->transaction))
                                @php $discount = $registered->transaction->discount; @endphp
                            @else
                                @php $discount = 0; @endphp
                            @endif
                            {{$discount}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">
                            Tổng cộng
                        </td>
                        <td class="text-right">
                            {{number_format($registered->price * $registered->qty - $discount)}} VNĐ
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">
                            Đã thanh toán
                        </td>
                        <td class="text-right">
                            
                        </td>
                    </tr>
               </table>
               <br>
               <p>
                    <i>Bằng chữ: <b id="money-text"></b></i>
               </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <p class="text-center">
                    <b>
                        <!-- Giám đốc -->
                        Lớp dự toán GXD
                    </b>
                </p>
            </div>
            <div class="col-md-3">
                <p class="text-center">
                    <b>
                        <!-- Kế toán -->
                        Lớp Thanh quyết toán GXD
                    </b>
                </p>
            </div>
            <div class="col-md-3">
                <p class="text-center">
                    <b>
                        Lớp Hiệu quả dự án GXD
                    </b>
                </p>
            </div>
            <div class="col-md-3">
                <p class="text-center">
                    <b>
                        Lớp Quản lý chất lượng GXD
                    </b>
                </p>
            </div>
        </div>
    </div>
</body>
<style>
    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .text-right{
        text-align: right;
    }
    .h1{
        font-weight: bold;
        color: red;
        font-size: 50px;
    }
    .h3{
        font-weight: bold;
    }
    .print{
        margin-top: 30px !important;
        border: 7px double #000;
        padding: 30px;
        min-height: 750px;
    }
    table{
        width: 100%;
    }
    table tr td, table tr th{
        border: 1px solid #ccc;
        padding: 10px;
    }
</style>
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var tien = "{{($registered->product->price * $registered->qty) - $registered->discount}}";
        var money = tien.replace(/[^a-z0-9A-Z ]/g, ""); // loại bỏ ký tự đặc biệt
        var DOCSO=function(){var t=["không","một","hai","ba","bốn","năm","sáu","bảy","tám","chín"],r=function(r,n){var o="",a=Math.floor(r/10),e=r%10;return a>1?(o=" "+t[a]+" mươi",1==e&&(o+=" mốt")):1==a?(o=" mười",1==e&&(o+=" một")):n&&e>0&&(o=" lẻ"),5==e&&a>=1?o+=" lăm":4==e&&a>=1?o+=" tư":(e>1||1==e&&0==a)&&(o+=" "+t[e]),o},n=function(n,o){var a="",e=Math.floor(n/100),n=n%100;return o||e>0?(a=" "+t[e]+" trăm",a+=r(n,!0)):a=r(n,!1),a},o=function(t,r){var o="",a=Math.floor(t/1e6),t=t%1e6;a>0&&(o=n(a,r)+" triệu",r=!0);var e=Math.floor(t/1e3),t=t%1e3;return e>0&&(o+=n(e,r)+" ngàn",r=!0),t>0&&(o+=n(t,r)),o};return{doc:function(r){if(0==r)return t[0];var n="",a="";do ty=r%1e9,r=Math.floor(r/1e9),n=r>0?o(ty,!0)+a+n:o(ty,!1)+a+n,a=" tỷ";while(r>0);return n.trim()}}}();
        document.getElementById("money-text").innerHTML = DOCSO.doc(money) + ' đồng';
    });
</script>
</html>