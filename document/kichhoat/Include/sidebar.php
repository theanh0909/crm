<div class="leftcolumn">
    <div>
        <p><a style="text-decoration: none; font-weight: 600" href="../views/changepass.php?id=<?php echo $iduser ?>"><img src="../template/img/password.png" width="20" height="20"/>Đổi mật khẩu</a></p>
        <p><a style="text-decoration: none; font-weight: 600" href="../views/message.php?id=<?php echo $iduser ?>"><img src="../template/img/mail.png" width="20" height="20"/>Tin nhắn của bạn</a></p>
        <?php if ($type == 1) { ?>
            <p><a style="text-decoration: none; font-weight: 600"><img src="../template/img/folder.png" width="20" height="20"/>Cài đặt hệ thống</a></p>
            <div style="margin-left: 15px; margin-top: -5px;">
                <a style="text-decoration: none;" href="../manager/control.php">+ Cài đặt hệ thống</a><br/>
				<a style="text-decoration: none;" href="../views/email.php">+ Cấu hình email</a><br/>
                <a style="text-decoration: none;" href="../manager/report_ct.php">+ Tạo thông báo mới</a></br>
				<a style="text-decoration: none;" href="../manager/changpass2.php">+ Đổi password (key)</a></br>
				<a style="text-decoration: none;" href="<?php echo SITE_URL ?>/views/clean.php" class = "underline">+ Dọn database</a>
            </div>
        <?php } ?>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $(".qlk").click(function() {
                $("#qlk").slideToggle();
            });
            $(".qlkh").click(function() {
                $("#qlkh").slideToggle();
            });
            $(".qlkhdt").click(function() {
                $("#qlkhdt").slideToggle();
            });
			$(".khckh").click(function() {
                $("#khckh").slideToggle();
            });
            $(".tkbh").click(function() {
                $("#tkbh").slideToggle();
            });
            $(".ttsd").click(function() {
                $("#ttsd").slideToggle();
            });
            $(".email").click(function() {
                $("#email").slideToggle();
            });
            $(".qltv").click(function() {
                $("#qltv").slideToggle();
            });
        });
    </script>
    <?php if ($permarr["key"]) { ?>
        <p id="sidebarl" class="qlk"> 
            <img src = "../template/img/key.png" width = "20" height = "20"/>Quản lý sản phẩm
        </p>            
        <ul id="qlk" class="sider">
            <?php if ($permarr["viewproduct"]) {
                ?> <li ><a href="<?php echo SITE_URL ?>/views/product.php" class = "underline">Danh sách sản phẩm</a></li><?php } ?>
			<li ><a href="<?php echo SITE_URL ?>/views/send_key.php" class = "underline">Gửi key</a></li>
            <?php if ($permarr["addproduct"]) {
                ?> <li ><a href="<?php echo SITE_URL ?>/views/addproduct.php" class = "underline">Thêm sản phẩm mới</a></li><?php } ?>
                <?php if ($permarr["addkey"]) {
                    ?> <li ><a href="<?php echo SITE_URL ?>/views/genkeys.php" class = "underline">Tạo key kích hoạt</a></li><?php } ?>
					<?php if ($permarr["addkey"]) {
                    ?> <li ><a href="<?php echo SITE_URL ?>/views/key_no_reg.php" class = "underline">Key chờ kích hoạt</a></li><?php } ?>
					<li><a href="<?php echo SITE_URL ?>/views/upload.php" class = "underline" >Import Key</a></li>
					<li><a href="<?php echo SITE_URL ?>/views/manage_key.php" class = "underline" >Key xuất ra trong ngày</a></li>
				<?php if ($permarr["viewkey"]) {
                    ?><li><a href="<?php echo SITE_URL ?>/views/report_key.php" class = "underline" > Chỉnh sửa và xóa Key</a></li><?php } ?>			
		<li><a href="<?php echo SITE_URL ?>/status_use/khoacung.php" class = "underline" > Thêm khách hàng sử dụng khóa cứng</a></li>					
        </ul>
        <?php
    }
    ?>
    <p id="sidebarl" class="qlkh"> 
        <img src="../template/img/khachhang.png" width="20" height="20"/>Khách hàng GXD
    </p>
    <ul id="qlkh" class="sider">    
		<li><a href="<?php echo SITE_URL ?>/views/khoacung.php" class="underline">Khách hàng sử dụng khóa cứng</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/no_paid.php" class="underline">Chưa thanh toán</a></li>
		<li><a href="<?php echo SITE_URL ?>/thuongmai/report_date.php" class="underline">Đăng ký trong ngày</a></li>
        <li><a href="<?php echo SITE_URL ?>/thuongmai/report_last_date.php" class="underline">Đăng ký 1 ngày trước</a></li>
        <li><a href="<?php echo SITE_URL ?>/thuongmai/report_2last_date.php" class="underline">Đăng ký 2 ngày trước</a></li>
        <li><a href="<?php echo SITE_URL ?>/thuongmai/report_week.php" class="underline">Đăng ký trong tuần</a></li>
        <li><a href="<?php echo SITE_URL ?>/thuongmai/report_month.php" class="underline">Đăng ký trong tháng</a></li>
    </ul>
    <p id="sidebarl" class="qlkhdt"> 
        <img src="../template/img/khachhang.png" width="20" height="20"/>Khách hàng dùng thử
    </p>
    <ul id="qlkhdt" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/status_use/report_date.php" class="underline">Đăng ký trong ngày</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/report_last_date.php" class="underline">Đăng ký 1 ngày trước</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/report_2last_date.php" class="underline">Đăng ký 2 ngày trước</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/report_week.php" class="underline">Đăng ký trong tuần</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/report_month.php" class="underline">Đăng ký trong tháng</a></li>
    </ul>
    <p id="sidebarl" class="tkbh"> 
        <img src="../template/img/thongke.png" width="20" height="20"/>Thống kê bán hàng
    </p>
    <ul id="tkbh" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/views/detail_dtoan.php?id=<?php echo $iduser ?>" class="underline">Thống kê tình trạng bán hàng</a></li>
		<li><a href="<?php echo SITE_URL ?>/views/province_customer.php" class="underline">Thống kê khách hàng theo tỉnh</a></li> 
        <li><a href="<?php echo SITE_URL ?>/views/status_dtoan.php?id=<?php echo $iduser ?>" class="underline">Doanh thu bán hàng trong tháng</a></li>
        <li><a href="<?php echo SITE_URL ?>/views/status_banhang.php?id=<?php echo $iduser ?>" class="underline">Thống kê bán hàng</a></li>
    </ul>
    <p id="sidebarl" class="ttsd"> 
        <img src="../template/img/trangthai.png" width="20" height="20"/>Trạng thái sử dụng
    </p>
    <ul id="ttsd" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/status_use/last_runing_date.php" class="underline">Sử dụng phần mềm trong ngày</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/chart_cty.php" class="underline">Sử dụng phần mềm theo tỉnh thành</a></li>
		<li><a href="<?php echo SITE_URL ?>/status_use/report_type_product.php" class="underline">Sử dụng theo loại sản phẩm</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_date.php" class="underline">Còn 2 ngày nữa là hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_fdate.php" class="underline">Còn 3 ngày nữa là hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_week.php" class="underline">Còn 1 tuần nữa là hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_last_date.php" class="underline" >Đã hết hạn 1 ngày</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_tlast_date.php" class="underline" >Đã hết hạn 5 ngày</a></li>
    </ul>
	
	 <p id="sidebarl" class="khckh"> 
        <img src="../template/img/trangthai.png" width="20" height="20"/>Chưa kích hoạt
    </p>
    <ul id="khckh" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh.php" class="underline">Chưa kích hoạt trong ngày</a></li>
		<li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh_1.php" class="underline">Chưa kích hoạt 1 ngày trước</a></li>
		<li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh_2.php" class="underline">Chưa kích hoạt 2 ngày trước</a></li>
		<li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh_3.php" class="underline">Chưa kích hoạt 3 ngày trước</a></li>
		<li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh_4.php" class="underline">Chưa kích hoạt 4 ngày trước</a></li>
         
    </ul>
	
    <p id="sidebarl" class="email"> 
        <img src="../template/img/email.png" width="20" height="20"/>Email
    </p>
    <ul id="email" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/sendmail/form.php" class="underline">Soạn email</a></li>
    </ul>
    <?php if ($type == 1) { ?>
        <p id="sidebarl" class="qltv"> 
            <img src="../template/img/manager.png" width="20" height="20"/>Quản lý thành viên
        </p>
        <ul id="qltv" class="sider">    
            <li><a href="<?php echo SITE_URL ?>/views/m_dutoan.php" class="underline">Danh sách các đại lý</a></li>
			<li><a href="<?php echo SITE_URL ?>/views/quanlynhanvien.php" class="underline">Quản lý thành viên</a></li>
            <li><a href="<?php echo SITE_URL ?>/views/createaccount.php" class="underline" >Thêm mới đại lý</a></li>
            <li><a href="<?php echo SITE_URL ?>/views/status_banhang.php" class="underline" >Tình trạng bán hàng</a> </li>
            <li><a href="<?php echo SITE_URL ?>/views/user.php" class="underline">Danh sách thành viên</a></li>
            <li><a href="<?php echo SITE_URL ?>/views/viewgroup.php" class="underline" >Phân quyền nhóm thành viên</a></li>
            <li><a href="<?php echo SITE_URL ?>/views/addgroup.php" class="underline">Tạo nhóm thành viên</a></li>
			<li><a href="<?php echo SITE_URL ?>/views/viewgroupcus.php" class="underline">Tạo nhóm khách hàng</a></li>
        </ul>

    <?php } ?>
</div>
