
<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
$customer_cty = isset($_POST['txt_cty']) ? $_POST['txt_cty'] : "";
?>
<div >
    <?php
    $tinh = array("An Giang", "Bắc Cạn", "Bạc Liêu", "Bắc Ninh", "Bắc Giang",
        "Bến Tre", "Bình Dương", "Bình Phước", "Bình Định", "Bình Thuận", "Cà Mau",
        "Cao Bằng", "Cần Thơ", "Đắk Lắk", "Đắk Nông", "Đà Nẵng", "Điện Biên", "Đồng Nai",
        "Đồng Tháp", "Gia Lai", "Hà Giang", "Hải Dương", "Hải Phòng", "Hà Nam",
        "Hà Nội", "Hà Tĩnh", "Hậu Giang", "Hòa Bình", "Hồ Chí Minh", "Huế",
        "Hưng Yên", "Khánh Hòa", "Kiên Giang", "Kon Tum", "Lai Châu", "Lâm Đồng",
        "Lạng Sơn", "Lào Cai", "Long An", "Nam Định", "Nghệ An", "Ninh Bình",
        "Ninh Thuận", "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam", "Quảng Ngãi",
        "Quảng Trị", "Quảng Ninh", "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình",
        "Thái Nguyên", "Thanh Hóa", "Tiền Giang", "Trà Vinh", "Tuyên Quang",
        "Vĩnh Long", "Vũng Tàu", "Yên Bái", "Tỉnh Khác");
    ?>
    <table id='myTable1' style="margin-top: -50px">	
        <caption>BIỂU ĐỒ SỐ LƯỢNG KHÁCH HÀNG SỬ DỤNG PM TRONG CẢ NƯỚC</caption>
        <thead>
            <tr>
                <th></th>
                <?php
                foreach ($tinh as $key => $value) {
                    echo "<th>$value</th>";
                    echo"\n";
                }
                ?> 
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlP = "select product_type, name from product";
            $resultP = mysqli_query($sqlP, $con);
            $i = 0;
            while ($rowP = mysqli_fetch_array($resultP)) {
                $nameP = $rowP['name'];
                $product_typeP = $rowP['product_type'];
                $i++;
                ?>
                <tr>
                    <th><?= $nameP ?></th>
                    <?php
                    $con = open_db();
                    foreach ($tinh as $key => $value) {
                        echo "<td>";
                        $sql = "select count(*) as tmp from registered where product_type='$product_typeP' and customer_cty='$value' ";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        $total_record = $row['tmp'];
                        echo $total_record;
                        echo "</td>";
                        echo "\n";
                    }
                    mysqli_close();
                    ?>
                </tr>
                <?php
            }
//            } 
            ?>
        </tbody>
    </table>

</div>
<div id="footer">
    <?php
    $con = open_db();
    $sql = "select count(*) as tmp from registered";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $count = $row['tmp'];
    mysqli_close($con);

    echo " <p style='color:blue'>Tổng số máy đã đăng ký tính đến thời điểm: " . date("d/m/Y") . " là: <b>" . $count . "</b></p>";
    ?>
</div>
<div style="display:block; height:80px; background:#CCFFFF">
    <p style="font-family: arial; width:55%; padding:10px 0 0 5px; float:left; display:block; text-align:left; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: #000000;"> © <a href="http://www.giaxaydung.vn/diendan/f329/dia-chi-lien-he-giao-dich-cong-viec-voi-cong-ty-gia-xay-dung-20760.html#post296829">Cty Giá xây dựng</a> - GP của Cục Báo chí - Bộ TT&amp;TT số 323/GP-CBC ngày 11/07/2008. <br>
        Người chịu trách nhiệm chính: Ths. Nguyễn Thế Anh.<br>
        Ghi rõ nguồn khi phát hành thông tin, tài liệu từ giaxaydung.vn<br>

    </p>
    <p style="font-family: arial; padding:10px 10px 0 0; float:right; display:block; text-align:right; width:40%; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: #000000;"> <a href="http://giaxaydung.vn/diendan/duong_den_GXD.gif" target="_blank">Địa chỉ: Toà nhà số 2A/55 Nguyễn Ngọc Nại, Thanh Xuân, Hà Nội</a><br>
        Tel: 04.3 5682482, Fax: 04.3 5682483<br>
        Email: <a href="mailto:theanh@giaxaydung.com">theanh@giaxaydung.com</a>
</div>
