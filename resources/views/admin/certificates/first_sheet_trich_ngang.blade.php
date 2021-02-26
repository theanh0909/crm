<table>
    <thead>
        <tr>
            <th>Mã sát hạch</th>
            <th>Số chứng chỉ</th>
            <th>Họ và tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ thường chú</th>
            <th>CMND</th>
            <th>SĐT</th>
            <th>Email</th>
            <th>Trình độ chuyên môn</th>
            <th>Lĩnh vực sát hạch</th>
            <th>Hạng sát hạch</th>
            <th>Mã tỉnh</th>
            <th>Số năm kinh nghiệm</th>
            <th>Đơn vị công tác</th>
            <th>
                Ngày cấp CMT/ Hộ chiếu
            </th>
            <th>
                Nơi cấp CMT/ Hộ chiếu
            </th>
            <th>Quốc Tịch</th>
            <th>Hệ đào tạo</th>
            <th>Cơ sở đào tạo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificates as $key => $item)
            <tr>
                <td></td>
                <td></td>
                <td>
                    {{$item->customer_name}}
                </td>
                <td>
                    {{date('d/m/Y', strtotime($item->customer_birthday))}}
                </td>
                <td>
                    {{$item->customer_address}}
                </td>
                <td>
                    {{$item->id_card}}
                </td>
                <td>
                    {{$item->customer_phone}}
                </td>
                <td>
                    {{$item->customer_email}}
                </td>
                <td>
                    {{$item->qualification}}
                </td>
                <td>
                    @foreach(explode(';', $item->type_exam) as $key => $typeExam)
                        {{$key + 1}}. {{$typeExam}};<br>
                    @endforeach
                </td>
                <td>
                    {{$item->class}}
                </td>
                <td>
                    @if(strpos($item->product_type, 'hnt') >= 0)
                        {{'HNT'}}
                    @elseif(strpos($item->product_type, 'hnt') >= 0)
                        {{'KTE'}}
                    @endif
                </td>
                <td>
                    {{$item->exper_num}}
                </td>
                <td>{{$item->company}}</td>
                <td>
                    {{date('d/m/Y', strtotime($item->date_card))}}
                </td>
                <td>
                    {{$item->address_card}}
                </td>
                <td>
                    {{$item->nation}}
                </td>
                <td>
                    {{$item->edu_system}}
                </td>
                <td>
                    {{$item->school}}
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>