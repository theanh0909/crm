<div id="footer">
    <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type = "text/javascript" ></script>
    <script type="text/javascript">
        $(function() {
            $("#checkall").click(function() {
                var checkedStatus = this.checked;
                $("#listcheck tbody tr").find(":checkbox").each(function() {
                    $(this).prop("checked", checkedStatus);
                });
            });
        });
    </script>
    <?php
    require_once("../config/dbconnect.php");
    get_infor_from_conf("../config/DB.conf");
    $con = open_db();
    $sql = "select count(*) as tmp from registered";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $count = $row['tmp'];
    mysqli_close($con);
    echo " <p style='color:blue'>Tổng số máy đã đăng ký tính đến thời điểm: " . date("d/m/Y") . " là: <b>" . $count . "</b></p>";
    ?>
</div>
<!--<div style="display:block; height:80px; background:#CCFFFF">
    <p style="font-family: arial; width:55%; padding:10px 0 0 5px; float:left; display:block; text-align:left; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: #000000;"> © <a href="http://www.giaxaydung.vn/diendan/f329/dia-chi-lien-he-giao-dich-cong-viec-voi-cong-ty-gia-xay-dung-20760.html#post296829">Cty Giá xây dựng</a> - GP của Cục Báo chí - Bộ TT&amp;TT số 323/GP-CBC ngày 11/07/2008. <br>
        Người chịu trách nhiệm chính: Ths. Nguyễn Thế Anh.<br>
        Ghi rõ nguồn khi phát hành thông tin, tài liệu từ giaxaydung.vn<br>

    </p>
    <p style="font-family: arial; padding:10px 10px 0 0; float:right; display:block; text-align:right; width:40%; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: #000000;"> <a href="http://giaxaydung.vn/diendan/duong_den_GXD.gif" target="_blank">Địa chỉ: Toà nhà số 2A/55 Nguyễn Ngọc Nại, Thanh Xuân, Hà Nội</a><br>
        Tel: 04.3 5682482, Fax: 04.3 5682483<br>
        Email: <a href="mailto:theanh@giaxaydung.com">theanh@giaxaydung.com</a>
</div>-->
</div>
</body>
</html>