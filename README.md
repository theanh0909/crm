# Tạo lại repo key để bắt đầu phát triển tiếp 20/08/2020

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


## Project GXD

## Router

Register License
```
link: http://domain.com/api/v1/clientregister
method: POST/GET
params: 
    - client_key:                   string|required
    - client_hardware_id:           string|required
    - customer_name:                string|required
    - customer_phone:               string|required
    - customer_email:               string|required
    - customer_address:             string|required
    - product (is product_type):    string|required
    - province:                     string
```

Captcha
```
link: http://domain.com/captcha.php
method: GET
```

API Lấy key
```
link: http://domain.com/api/v1/get-key
method: POST/GET
header: 
    - secret:                      string|required
    - domain:                      string|required
params: 
    - quantity:                     integer|required
    - product:                      string|required
    - key_type:                     string|required (0: key dung thu, 1: key thuong mai)
    - expire_date:                  integer|required (Số ngày hoạt động)
```

```$xslt
mã lỗi API: 
    - 10  => 'Thành công',
    - 11  => 'Mã API KEY không đúng',
    - 12  => 'Số lượng Key không đủ',
    - 13  => 'Lỗi không xác định',
    - 14  => 'Không tìm thấy sản phẩm',
```

```$xslt
Response: 
    - error: 
    {
        "success":  bool,
        "code":     string,
        "message":  string
    }
    
    - success: 
    {
        "success":  bool,
        "code":     string,
        "data":     array
    }
```

## Author

Thanks for watching!

Bảng License:
- Key tạo ra nằm trong bảng License chờ.
- Key kích hoạt cột hardware_id sẽ có mã máy của khách hàng, cột email sẽ có địa chỉ email của khách
- Key kích hoạt sẽ được đẩy cả sang bảng Registed, trong khi key chưa kích hoạt thì không

Bảng Transactions: lưu lại những giao dịch khi bán key
    + Cột status: 0 = tạo đơn, 1 = duyệt đơn
    + Cột user_approve_id lưu ID người duyệt đơn
    + Khóa mềm: 0; Khóa cứng: 1; Khóa học: 2; Chứng chỉ: 3

Khi duyệt đơn
    + Nằm trong RequestController@approve
    + Nếu là khóa mềm => update trạng thái
    + Nếu là khóa cứng, khóa học, chứng chỉ => sẽ thêm 1 dòng vào bảng Registered
    + Dữ liệu sẽ được Insert vào bảng registed

Khi tạo đơn hàng
    + Đơn hàng sẽ nhảy vào bản Transactions

Lệnh update tỉnh trong bảng registed
    +UPDATE registered SET customer_cty = 'Hà Nội' WHERE customer_cty = 'Thành phố Hà Nội'

Thiết kế thêm csdl
    + Thêm bảng sales: lưu thông tin khách hàng mua sản phẩm
    + Thêm bảng sale_details: lưu thông tin chi tiết đơn hàng

Sử dụng lệnh php artisian tinker để getColumnListing


Tạo đơn: {{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}
{{date('d/m/Y', strtotime($item->created_at))}}

Import dữ liệu học viên thi chứng chỉ:
- Lần 1: Upload danh sách học viên đăng ký dự thi
- Lần 2: Vẫn danh sách đó nhưng thêm thông tin ngày thi, nếu ai không có ngày thi thì Chưa thi, số lần thi lại (tính tiền thi lại)
Up lại lần 2 này thì sẽ Check SĐT, email, CMND (bởi vì khóa cứng, khóa mềm, khóa học không có CMND, nhưng có thể lần khác lại là số hộ chiếu, or bằng lái)

- Lần 3: Có thể up thêm thông tin Số chứng chỉ

Insert hoặc Update dựa vào ngày Import, lấy ngày thi là ngày Import chuẩn, cứ thuộc kỳ thi nào thì lấy ngày đó.

Lần sau lại up tiếp: Cấp lại chứng chỉ hoặc là thi lại sau 5 năm (thi bằng lái xe): kì thi mới hoặc thi 1 chứng chỉ khác.
Khi thi chứng chỉ khác hoặc thi lại của chu kì sau -> khác nhau ở chỗ Ngày thi, up lên thì chưa có ngày thi (xung đột với trước)
Cá nhân: Nguyễn Văn A thi chứng chỉ năm 2019 - đến năm 2024 sẽ thi lại chứng chỉ mới, khi đó thông tin đã có trên hệ thống.


Mã sát hạch lần đầu thi: chưa có mã sát hạch thì đánh STT: 1, 2, 3... Từ lần thi thứ 2 (thi lấy thêm chứng chỉ hoặc thi chu kỳ sau 5 năm)



===========================Cấu trúc file excel import chứng chỉ

- Phải để ở sheet đầu tiên
- Cột lĩnh vực sát hạch: mỗi linh vực kết thúc bằng dấu ; (trừ lĩnh vực cuối cùng)
- Cột hạng chứng chỉ: mỗi hạng kết thúc bằng dấu ; (trừ hạng cuối cùng)
- File excel chỉ có 1 sheet

DG01-Định giá xây dựng
GS01-Giám sát DDCN và Hạ tầng kỹ thuật
GS02-Giám sát lắp đặt thiết bị công trình
GS06-Giám sát công trình NN&PTNT
GS10-Giám sát Công trình Giao thông
KS01-Khảo sát địa chất công trình
TK02-Thiết kế Cấp thoát nước
TK04-Thiết kế Cơ - Điện công trình
TK09-Thiết kế kết cấu công trình DD&CN
TK11-Thiết kế Quy hoạch xây dựng
PLGS-Pháp luật Giám sát
KS02-Khảo sát địa hình
TK13-Thiết kế công trình NN&PTNT
TK14-Thiết kế Hạ tầng kỹ thuật
QLDA-Quản lý dự án
TK17-Thiết kế Công trình Giao thông

Ghi chú:
 - Không nhập thừa 2 dấu cách, không tiện tay nhập thêm dấu cách ở cuối
 - Hạng sát hạch phân cách nhau bởi dấu chấm phẩy ;
 - Lĩnh vực sát hạch phân cách nhau bởi dấu chấm phẩy ;, không cần Alt + Enter bẻ dòng, ở cuối không có dấu chấm phẩy.
 - Lĩnh vực sát hạch và Hạng sát hạch tương ứng nhau, sắp xếp theo thứ tự và ngăn cách bởi dấu chấm phẩy.

Xuất thông tin ra để up lên trang tạo tài khoản.
Up trở lại để cập nhật vào cột Mã sát hạch

Khi tạo số chứng chỉ rồi, thì update để -> Lan xuất để đăng tải trên trang Web.

Sửa mã sản phẩm chứng chỉ cho các bảng: product; transaction; registered; n_registered; license ; email; sale_details (tên cột lại là product)
Lệnh:
UPDATE `transactions` SET product_type='hnt3' WHERE product_type = 'hntcc3linhvuc'


fa thumbs-up
fa tasks

Doc làm việc với Import Export Excel: https://docs.laravel-excel.com/3.1/architecture

Ngày 21/11/2020 ngồi học tạo SSH key để truy cập Server bảo mật. Git push và pull thử nghiệm.

Bộ icon

https://lab.artlung.com/font-awesome-sample

Nhóm 1: Khách hàng mục tiêu (những người mong muốn mua hàng, những người có nhu cầu mà chúng ta nhắm tới)
                </p>
                <p>
                Nhóm 2: Khách hàng tiềm năng (đã cho chúng ta một mẩu thông tin nào đó, có thể là email, có thể là điện thoại)
                </p>
                <p>
                Nhóm 3: Mua hàng (ít nhất 1 lần mua hàng), khách hàng này sự trung thành chưa cao, sẵn sàng từ bỏ để mua hàng từ nơi khác
                </p>
                <p>
                Nhóm 4: Khách hàng (ít nhất mua hàng 2 lần trở lên)
                </p>
                <p>
                Nhóm 5: Thành viên (đã mua đi mua lại nhiều lần, được hưởng ưu đãi, có thẻ thành viên, ưu đãi, VIP, được đón tiếp nồng hậu hơn) hãy tập trung chăm sóc nhóm này, tập trung thật nhiều vào xây dựng nhóm thành viên này.
                </p>
                <p>
                Nhóm 6: Những người ủng hộ (những người mua hàng vô cùng nhiều, mỗi khi có ai đó hỏi về món hàng liên quan thì bạn sẽ là người đầu tiên xuất hiện trong tâm trí của họ), nhóm này luôn muốn bạn phát triển kinh doanh, họ sẵn sàng giới thiệu bạn với bạn bè, họ hàng, khách hàng của họ
                </p>
                <p>
                Nhóm 7: Khách hàng cuồng nhiệt (Raving fan): (bạn có thể như 1 ca sỹ, cầu thủ ủng hộ - sẵn sàng bán hàng cho bạn vì bất kì điều kiện nào, chỉ bởi vì thích), nếu xây dựng nhóm này tốt, kinh doanh sẽ ở tầm cao mới.
                </p>

Route: Question
- Làm thế nào để Internet kết nối được với khái niệm tiện lợi của chúng ta?
- Làm thế nào để chúng ta gắn nó với mẫu số chung là dòng tiền trên mỗi lần khách hàng ghé qua?
- Làm thế nào chúng ta dùng trang web để nâng cao những gì chúng ta đã làm tốt hơn các công ty khác trên thế giới và theo cách khiến chúng chúng ta đam mê?
- GXD là 1 công ty đi lên từ bò, đến đi bộ, rồi mới chạy.