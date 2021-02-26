<div class="leftcolumn">
    <div>
        <p><a style="text-decoration: none; font-weight: 600" href="changepass.php?id=<?php echo $iduser ?>"><img src="../template/img/password.png" width="20" height="20"/>Đổi mật khẩu</a></p>
        <p><a style="text-decoration: none; font-weight: 600" href="../views/message.php?id=<?php echo $iduser ?>"><img src="../template/img/mail.png" width="20" height="20"/>Tin nhắn của bạn</a></p>
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
			$(".qlsp").click(function() {
                $("#qlsp").slideToggle();
            });
        });
    </script>
	<p id="sidebarl" class="qlsp"> 
        <img src="../template/img/key.png" width="20" height="20"/>Quản lý sản phẩm
    </p>
    <ul id="qlsp" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/Mod/genkeys.php" class="underline">Tạo key dùng thử</a></li>
        
    </ul>
    <p id="sidebarl" class="qlkh"> 
        <img src="../template/img/khachhang.png" width="20" height="20"/>Khách hàng GXD
    </p>
    <ul id="qlkh" class="sider">    
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
        <li><a href="<?php echo SITE_URL ?>/Mod/expire_date.php" class="underline">Khách hàng sắp hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_fdate.php" class="underline">Còn 3 ngày nữa là hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_week.php" class="underline">Còn 1 tuần nữa là hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/Mod/expire_last_date.php" class="underline" >Khách hàng đã hết hạn</a></li>
        <li><a href="<?php echo SITE_URL ?>/status_use/expire_tlast_date.php" class="underline" >Đã hết hạn 5 ngày</a></li>
    </ul>
	
	 <p id="sidebarl" class="khckh"> 
        <img src="../template/img/trangthai.png" width="20" height="20"/>khách hàng chưa kích hoạt
    </p>
    <ul id="khckh" class="sider">    
        <li><a href="<?php echo SITE_URL ?>/status_use/khachhangchuakh.php" class="underline">khách hàng chưa kích hoạt</a></li>
         
    </ul>
	
    <p id="sidebarl" class="email"> 
        <img src="../template/img/email.png" width="20" height="20"/>Hệ thống Key
    </p>
    <ul id="email" class="sider">    
        <li><a href="../Key.php" class="underline">Key kích hoạt</a></li>
    </ul>
</div>
