@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Customer', 'item2' => 'Thêm đơn hàng'])
<div class="container">
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Thêm đơn hàng</h3>
        </div>
        @include('admin.layouts.partitals.notify')
        <!--begin::Form-->
        <form action="{{route('admin.product-add')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label class="col-form-label">Họ tên <i class="fa fa-asterisk color-red font-size-2"></i></label>
                        {{Form::text('customer_name', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Số điện thoại (nhập đúng số) <i class="fa fa-asterisk color-red font-size-2"></i></label>
                        {{Form::text('customer_phone', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Email (nhập đúng email)<i class="fa fa-asterisk color-red font-size-2"></i></label>
                        {{Form::text('customer_email', '', ['class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label class="col-form-label">Địa chỉ</label>
                        {{Form::text('customer_address', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Tỉnh thành (chọn hoặc gõ từ khóa)</label>
                        <select class="js-example-basic-single form-control" name="customer_cty">
                            @foreach($provinces as $provinceItem)
                                @if ($provinceItem->provinceid == '01TTT' || $provinceItem->provinceid == '79TTT' || $provinceItem->provinceid == '56TTT')
                                    <option value="{{$provinceItem->name}}">{{$provinceItem->name}}</option>
                                @endif
                            @endforeach
                            @foreach($provinces as $provinceItem)
                                @if ($provinceItem->provinceid != '01TTT' && $provinceItem->provinceid != '79TTT' && $provinceItem->provinceid != '56TTT')
                                    <option value="{{$provinceItem->name}}">{{$provinceItem->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <!-- {{Form::text('customer_cty', 'Hà Nội', ['class' => 'form-control', 'placeholder' => 'Hà Nội', 'required' => 'required'])}} -->
                    </div>
                    <div class="col-lg-4">
                        <label class="col-form-label">Ghi chú</label>
                        {{Form::text('note', '', ['class' => 'form-control', 'rows' => 3])}}
                        @if($errors->has('note'))
                            <span class="text-danger">{{$errors->first('note')}}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="col-form-label">Chọn sản phẩm <i class="fa fa-asterisk color-red font-size-2"></i></label>
                        <select id="product" onchange="pickProduct()" class="form-control js-example-basic-single" name="state">
                            <option value="-1">Chọn sản phẩm</option>
                            @foreach($products as $productItem)
                                <option value="{{$productItem->id}}">{{$productItem->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="test1 form-group row">
                            <table class="table">
                                <thead style="background: #eee">
                                    <tr align="center">
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>
                                            Loại sản phẩm
                                        </th>
                                        <th>Số lượng</th>
                                        <th>Khác</th>
                                        <th>Đơn giá</th>
                                        <!-- <th>Giảm giá</th> -->
                                        <th>Thành tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody class="product-lisst">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="text-align: right">
                                            Tổng tiền: 
                                        </td>
                                        <td style="text-align: right">
                                            <span id="total">0</span>
                                            <input type="hidden" name="total" id="total-insert">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: right">
                                            Đã nộp
                                        </td>
                                        <td style="text-align: right">
                                            <input style="width: 50%; float:right" type="number" name="prepaid" class="form-control">
                                        </td>
                                        <td></td>
                                    </tr>
                                  </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <div class="col-lg-12" style="text-align: center;">
                        <button style="width: 100%" type="submit" class="btn btn-primary mr-2">Tạo yêu cầu đơn hàng</button>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
@endsection

@section('script')
    <style>
        .content table tr td *{
            font-size: 13.5px;
        }
        i.fa.fa-asterisk.color-red.font-size-2{
            font-size: 8px;
            color: red;
        }
    </style>
    <script>
        //Set Default Price
        var firstProduct = $('select[name=product_type]').find('option:selected');
        //$('input[name=price]').val(firstProduct.attr('price'));

        //
        $('select[name=product_type]').change(function() {
            var element = $(this).find('option:selected');
            $('input[name=price]').val(element.attr('price'));
        });

        function getMoney() {
            var price       = $('input[name=price]').val();
            var total       = $('input[name=qty]').val();
            var discount    = $('input[name=discount]').val();

            var money = (price * total) - (total - 1) * 800000  - discount;
            if (total == 0) {
                $('input[name=money]').val(0);
            } else {
                $('input[name=money]').val(money);
            }
            
        }

        getMoney();

        $('input[name=price], input[name=qty], input[name=discount]').change(function () {
            getMoney();
        });

        $('#donate_key').change(function () {
            $('.donate_product').toggle();
        });
        count = 1;
        function pickProduct()
        {
            dem = $('.product-lisst tr').length + 1;
            productId = $('#product').val();
            total = $('#total').html();
            
            $.get('admin/get-product/' + productId + '/' + dem + '/' + total, function(data){
                $('.product-lisst').append(data);
            })

            return dem;
        }
        $('.test1').on("click",".remove-row", function(e) {
            e.preventDefault();
            total = $('#total').html();
            totalFormat = total.replaceAll(',', '');
            $(this).parent().parent().remove();
            $('#total').html(addCommas(parseInt(totalFormat) - parseInt($(this).attr('price'))));
            $('input[name=prepaid]').val(parseInt(totalFormat) - parseInt($(this).attr('price')));
            $("#total-insert").val(addCommas(parseInt(totalFormat) - parseInt($(this).attr('price'))));
            check = $('.product-lisst tr').length;
            
            for (i = 0; i <= check; i++) {
                $('.test1 .product-lisst tr .count:eq(' + i + ')').html(parseInt(i+1));
            }
        })
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        function sl(rand)
        {
            totalNow = convert($('#total' + rand).html()); // lấy số tiền đang xuất hiện
            total = tong(rand);
            $('#total' + rand).html(total);
            $('#remove-row' + rand).attr('price', convert(total));

            if (totalNow < convert(total)) { // nếu số tiền đang xuất hiện mà nhỏ hơn số tiền thay đổi thì cộng vào
                result = parseInt(convert(total)) - parseInt(convert(totalNow)) + parseInt(convert($('#total').html()));
            } else if (totalNow >  convert(total)) { // nếu số tiền đang xuất hiện mà nhỏ hơn số tiền thay đổi thì trừ đi
                result = parseInt(convert($('#total').html())) - (parseInt(convert(totalNow)) - parseInt(convert(total)));
            }
            $('#total').html(addCommas(result));
            $('input[name=prepaid]').val(result);
            $("#total-insert").val(addCommas(result));

        }
        function convert(string)
        {
            return string.replaceAll(',', '');
        }
        function gia(rand)
        {
            totalNow = convert($('#total' + rand).html()); // lấy số tiền đang xuất hiện
            total = tong(rand);
            $('#total' + rand).html(total);
            $('#remove-row' + rand).attr('price', total.replaceAll(',', ''));

            if (totalNow < convert(total)) { // nếu số tiền đang xuất hiện mà nhỏ hơn số tiền thay đổi thì cộng vào
                result = parseInt(convert(total)) - parseInt(convert(totalNow)) + parseInt(convert($('#total').html()));
            } else if (totalNow >  convert(total)) { // nếu số tiền đang xuất hiện mà nhỏ hơn số tiền thay đổi thì trừ đi
                result = parseInt(convert($('#total').html())) - (parseInt(convert(totalNow)) - parseInt(convert(total)));
            }
            $('#total').html(addCommas(result));
            $('input[name=prepaid]').val(result);
            $("#total-insert").val(addCommas(result));
        }
        function giamGia(rand)
        {
            total = tong(rand);
            $('#total' + rand).html(total);
            
        }
        function tong(rand)
        {
            price = $('#item' + rand + ' input[name="price[]"]').val();
            amount = $('#item' + rand + ' input[name="amount[]"]').val();
            discount = $('#item' + rand + ' input[name="discount[]"]').val();
            total = amount * price - discount;

            return addCommas(total);
        }
        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endsection