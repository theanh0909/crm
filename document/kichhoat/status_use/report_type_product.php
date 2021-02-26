<?php ob_start(); ?>
<?php
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
?>
<div id="rightcolumn">

		<?php
		echo" <h2 align='center' class='gxdh2'>THỐNG KÊ KÍCH HOẠT PHẦN MỀM THEO PHÂN LOẠI</h1> ";
		?>		
		<?php
		$sql1 = "select count(*) as tmp from registered, license where registered.product_type='DutoanGXD' and registered.license_serial=license.license_serial";
		$result1 = mysqli_query($sql1, $con);
		$row1 = mysqli_fetch_array($result1);
		$total_record1 = $row1['tmp'];
		?>		
		<?php
		$sql2 = "select count(*) as tmp from registered, license where registered.product_type='DuthauGXD' and registered.license_serial=license.license_serial";
		$result2 = mysqli_query($sql2, $con);
		$row2 = mysqli_fetch_array($result2);
		$total_record2 = $row2['tmp'];
		?>		
		<?php
		$sql3 = "select count(*) as tmp from registered, license where registered.product_type='QuyettoanGXD' and registered.license_serial=license.license_serial";
		$result3 = mysqli_query($sql3, $con);
		$row3 = mysqli_fetch_array($result3);
		$total_record3 = $row3['tmp'];
		?>		
		<?php
		$sql4 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and registered.product_type='qlclGXD'";
		$result4 = mysqli_query($sql4, $con);
		$row4 = mysqli_fetch_array($result4);
		$total_record4 = $row4['tmp'];
		?>		
		<?php
		$sql5 = "select count(*) as tmp from registered, license where registered.product_type='gcm' and registered.license_serial=license.license_serial";
		$result5 = mysqli_query($sql5, $con);
		$row5 = mysqli_fetch_array($result5);
		$total_record5 = $row5['tmp'];
		?>		
		<?php
		$sql6 = "select count(*) as tmp from registered, license where registered.product_type='DutoanVKT' and registered.license_serial=license.license_serial";
		$result6 = mysqli_query($sql6, $con);
		$row6 = mysqli_fetch_array($result6);
		$total_record6 = $row6['tmp'];
		?>		
		<?php		
		mysqli_close($con);
		echo
		"<table width='500' border='1' cellspacing='1' cellpadding='1' align='center'>
		  <tr>
			<td align='center'>STT</td>
			<td align='center'>Tên phần mềm</td>
			<td align='center'>Số lượng</td>
		  </tr>
		  <tr>
			<td align='center'>1</td>
			<td>Dự toán GXD</td>
			<td align='right'>" . $total_record1 . "</td>
		  </tr>
		  <tr>
			<td align='center'>2</td>
			<td>Dự thầu GXD</td>
			<td align='right'>" . $total_record2 . "</td>
		  </tr>
		  <tr>
			<td align='center'>3</td>
			<td>Quyết toán GXD</td>
			<td align='right'>" . $total_record3 . "</td>
		  </tr>
		  <tr>
			<td align='center'>4</td>
			<td>QLCL GXD</td>
			<td align='right'>" . $total_record4 . "</td>
		  </tr>
		  <tr>
			<td align='center'>5</td>
			<td>Giá ca máy GXD</td>
			<td align='right'>" . $total_record5 . "</td>
		  </tr>
		  <tr>
			<td align='center'>6</td>
			<td>Dự toán VKT</td>
			<td align='right'>" . $total_record6 . "</td>
		  </tr>
		</table>"
		?>		

</div>
<?php
require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>
