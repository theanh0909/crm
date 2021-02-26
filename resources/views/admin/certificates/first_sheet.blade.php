<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Năm sinh (dd/MM/YYYY)</th>
            <th>Số CMND/hộ chiếu/thẻ</th>
            <th>Ngày cấp</th>
            <th>Nơi cấp</th>
            <th>Quốc tịch</th>
            <th>Địa chỉ thường chú</th>
            <th>Cơ sở đào tạo</th>
            <th>Hệ đào tạo</th>
            <th>Trình độ chuyên môn</th>
            <th>Lĩnh vực theo Nghị định 100/2018/NĐ-CP</th>
            <th>Lĩnh vực cấp</th>
            <th>
                Hạng
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificates as $key => $item)
            @php
                $type_exam = explode(';', $item->type_exam);
                $class = explode(';', $item->class);
                $decree = explode(';', $item->decree);
            @endphp
            @foreach($type_exam as $keyType => $typeExamItem)
                @if($keyType == 0)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            {{$item->customer_name}}
                        </td>
                        <td>
                            {{date('d/m/Y', strtotime($item->customer_birthday))}}
                        </td>
                        <td>
                            {{$item->id_card}}
                        </td>
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
                            {{$item->customer_address}}
                        </td>
                        <td>
                            {{$item->school}}
                        </td>
                        <td>
                            {{$item->edu_system}}
                        </td>
                        <td>
                            {{$item->qualification}}
                        </td>
                        <td>
                            {{(!empty($decree[$keyType]) ? $decree[$keyType] : '')}}
                        </td>
                        <td>
                            {{$typeExamItem}}
                        </td>
                        <td>
                            {{ (!empty($class[$keyType]) ? $class[$keyType] : '') }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="11"></td>
                        <td>
                            {{(!empty($decree[$keyType]) ? $decree[$keyType] : '')}}
                        </td>
                        <td>
                            {{$typeExamItem}}
                        </td>
                        <td>
                            {{ (!empty($class[$keyType]) ? $class[$keyType] : '') }}
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>