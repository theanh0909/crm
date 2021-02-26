@php $rand = rand(); @endphp
<tr id="item{{$rand}}">
<td class="count">{{$count}}</td>
    <td style="width: 170px">
        <select name="product[]" class="form-control">
            <option value="{{$product->product_type}}">
                {{$product->name}}
            </option>
        </select>
    </td>
    <td style="width: 170px">
        <select name="product_type[]" class='form-control'>
            @if($type == 0)
                <option value='0'>Khóa mềm</option>
            @elseif($type == 1)
                <option value='1'>Khóa cứng</option>
            @elseif($type == 2)
                <option value='2'>Học viên</option>
            @elseif($type == 3)
                <option value='3'>Chứng chỉ</option>
            @endif
        </select>
    </td>
    <td style="width: 100px">
        <input onchange="sl({{$rand}})" name="amount[]" class='form-control' type='number' value='1'/>
    </td>
    <td>
        @if($type == 0)
            <label for="">Số ngày</label>
            <select name="expiry[]" class="form-control">
                @foreach($typeExpireDate as $key => $dateItem)
                    <option @if($key == 365){{'selected'}}@endif value="{{$key}}">{{$dateItem}}</option>
                @endforeach
            </select>
            <label for="">Loại key</label>
            <select name="type_key[]" class="form-control">
                <option value="1" selected>Key thương mại</option>
                <option value="0">Key thử nghiệm</option>
            </select>
        @elseif($type == 2)
            <label>Phương thức học</label>
            <select name="option_learn[]" class="form-control">
                <option selected value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
            <label>Tặng Key</label>
            <select name="donation_key[]" class="form-control">
                <option selected value="NULL">Không tặng</option>
                @foreach($productDonate as $key => $productDonateItem)
                    <option value="{{$key}}">{{$productDonateItem}}</option>
                @endforeach
            </select>
        @endif
    </td>
    <td style="width: 170px;">
        <input style="text-align: right" onchange="gia({{$rand}})" name="price[]" class='form-control' type='number' value='{{$product->price}}'/>
    </td>
    <td style="display: none">
        <input onchange="giamGia({{$rand}})" name="discount[]" type="number" class="form-control">
    </td>
    <td class="count{{$count}}" id="total{{$rand}}" style="text-align: right">
        {{number_format($product->price)}}
    </td>
    <td>
        <button price="{{$product->price}}" id="remove-row{{$rand}}" class="btn btn-danger remove-row" type='button'>
            <i class="flaticon2-rubbish-bin-delete-button"></i>
        </button>
    </td>
</tr>
<script>
    price = "{{$product->price}}";
    priceRequest = "{{$total}}";
    total = addCommas(parseInt(price) + parseInt(priceRequest));
    document.getElementById("total").innerHTML = total;
    $("#total-insert").val(total);
</script>