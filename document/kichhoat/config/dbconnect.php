<?php
require_once("global.php");
$con = "";

//require_once ('active_software.php');
function get_infor_from_conf($path) {
    global $server, $userid, $pass;
    $fp = fopen($path, "r");
    $server = trim(fgets($fp));
    $userid = trim(fgets($fp));
    $pass = trim(fgets($fp));

    fclose($fp);
}

//Kết nối với database
function open_db() {
    global $server, $userid, $pass;
    $con = mysqli_connect('localhost', 'root', '','giaxaydung_key');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    //$select_db = mysqli_select_db("kichhoat", $con);
    $select_db = mysqli_select_db($con,'giaxaydung_key');
    if (!$select_db) {
        die("Cannot select the database");
        return "";
    }
    return $con;
}

//******************************Kiểm tra hạn sự tồn tại của Key**************************************
function check_license_exist($client_key, $product_type) {
    $count = 0;
    $con = open_db();
    $sql = "select count(*) as tmp from license where product_type = '$product_type' and license_serial = '$client_key'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $count = $row['tmp'];
        if ($count > 0) {
            $fb = true;
        } else {
            $fb = FALSE;
        }
    }
    mysqli_close($con);
    return $fb;
}
function get_total_record_create($product_type,$day) {
    $con = open_db();
    $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.product_type ='$product_type' and license.license_created_date = '$day'   ";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        return 0;
    }
    $row = mysqli_num_rows($result);
    mysqli_close($con);
    return $row;
}
function get_total_record_1($product_type,$key,$email) {
    $con = open_db();
        if($email == ''){
        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key'   ";
        }
        else
        {
        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key' and email_cus like '%$email%'";    
        }
    $result = mysqli_query($con, $sql);
    if (!$result) {
        return 0;
    }
    $row = mysqli_num_rows($result);
    mysqli_close($con);
    return $row;
}
//*********************** Kiểm tra số máy đăng ký của một key******************
function check_no_computers($client_key) {
    $con = open_db();
    $sql = "select * from license where license_serial = '$client_key'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row['license_is_registered'] <= $row['license_no_computers']) {
            $fb = $row['license_is_registered'];
        }
    }
    mysqli_close($con);
    return $fb;
}
//========================= Kiểm tra lại key đăng ký ============
function check_key_agian($client_key){
    $con = open_db();
    $sql ="SELECT * FROM registered where  license_original = '$client_key'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row['hardware_id'] == 'EDIT_ID_HARDWARE') {
            return 1;
        }
        else return 0;
    }
}

//=====================================
function get_expire($date) {
    $con = open_db();
    //$sql ="SELECT * FROM registered where  product_type = '$pro' and license_activation_date = '$date' ";
    $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
        license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.name ,product.icon,registered.id, registered.customer_address from  registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_expire_date='$date'
        ";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        return 0;
    }
    //$row = mysqli_fetch_array($result);
    mysqli_close($con);
    return $result;
}

//*********************** Kiểm tra số máy đăng ký của một key******************
function check_status_license($client_key) {
    $con = open_db();
    $sql = "select * from license where license_serial = '$client_key' ";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row['status'] == 1) {
            $fb = true;
        }
        else
            $fb = FALSE;
    }
    mysqli_close($con);
    return $fb;
}
function get_total_record_nv($product_type,$nv,$date) {
    $con = open_db();

    $sql = "SELECT * FROM user,license  WHERE user.id= '$nv'  and license.id_user=user.id and license.product_type ='$product_type' ";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        return 0;
    }
    $row = mysqli_num_rows($result);
    
    $sql1 = "SELECT * FROM user,license,registered  WHERE user.id='$nv' and registered.license_serial = license.license_serial and license.id_user=user.id and license.product_type ='$product_type' and license.product_type ='$product_type' and license.status = '1' and registered.license_activation_date like '%$date%' ";    
    $result1 = mysqli_query($con, $sql1);
    if (!$result1) {
        return 0;
    }
    $row1 = mysqli_num_rows($result1);
    
    $row2 = $row - $row1;
    mysqli_close($con);
    $arr = array($row,$row1,$row2);
    return $arr;
}


function get_total_record_nv_mod($product_type,$nv) {
    $con = open_db();

    $sql = "SELECT * FROM user,license  WHERE user.id= '$nv'  and license.id_user=user.id and license.product_type ='$product_type' ";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        return 0;
    }
    $row = mysqli_num_rows($result);
    
    $sql1 = "SELECT * FROM user,license,registered  WHERE (user.id='$nv' and registered.license_serial = license.license_serial and license.id_user=user.id and license.product_type ='$product_type' and license.status = '1') ";    

    $result1 = mysqli_query($sql1, $con);
    if (!$result1) {
        return 0;
    }
    $row1 = mysqli_num_rows($result1);
    
	$sql2 = "SELECT * FROM user,license,registered  WHERE (user.id='$nv' and registered.license_serial = license.license_serial and license.id_user=user.id and license.product_type ='$product_type' and license.status = '1') or(user.id='$nv' and license.id_user=user.id and license.product_type ='$product_type' and license.email_cus != '')  ";    

    $result2 = mysqli_query($sql1, $con);
    if (!$result2) {
        return 0;
    }
    $row2 = mysqli_num_rows($result1);
	
    $row3 = $row - $row1 - $row2;
    mysqli_close($con);
    $arr = array($row,$row1,$row2,$row3);
    return $arr;
}
//*********************** Kiểm tra số key đăng cho máy và Key đã đăng ký hay chưa ******************
function check_no_computers_resgistered($client_key, $hardware_id) {
    $fb = -1;
    $con = open_db();
    $sql = "select * from license where license_serial = '$client_key'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row['license_is_registered'] < $row['license_no_computers']) {
            $fb = $row['license_is_registered'];
        }
    }
//************** kiem tra neu hardware_id da dang ky license_key roi thi khong cho dang ky nua******************************
    $sql = "select count(*) as count from registered where license_serial = '$client_key' and hardware_id = '$hardware_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row['count'] > 0) {
            $fb = -1;
        }
    } else {
        $fb != -1;
    }
    mysqli_close($con);
    return $fb;
}

//*******************************KIểm tra hạn của key****************************************
function check_registered($client_key, $hardware_id) {
    $con = open_db();
    $sql = "select count(*) as count from registered where license_serial = '$client_key' and hardware_id = '$hardware_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row['count'] > 0) {
            $fb = -1;
        }
    } else {
        $fb != -1;
    }
    mysqli_close($con);
    return $fb;
}

//*******************************KIểm tra hạn của key****************************************
function check_info($md5, $hardware_id,$client_key) {
    $con = open_db();
	
    $sql = "select * from registered,license,product where registered.product_type = product.product_type and license.license_serial = '$md5' and registered.license_serial = '$md5' and registered.hardware_id = '$hardware_id'";
	mysqli_set_charset($con,'utf8');
    $result = mysqli_query($con, $sql);
	$data='';
	$text='';
   // if ($result) {
   //     $row = mysqli_fetch_array($result);
	if ($result) {
		while($row=mysqli_fetch_array($result))
			{
					$st1 = $client_key;
					$str1 = substr($st1, 0, 5);
					$str2 = substr($st1, 5, 5);
					$str3 = substr($st1, 10, 5);
					$str4 = substr($st1, 15, 5);
					$st = "$str1-" . "$str2-" . "$str3-" . "$str4";
					if ($row[status] == "1"  ){
						$text = 'Bản thương mại';
                    }else
                        $text = "Bản dùng thử";
					 //$date = date("m/d/y", $row[license_activation_date]);
					    $Date = date( 'd/m/Y', strtotime($row[license_activation_date]));
					    $Date_last = date( 'd/m/Y', strtotime($row[license_expire_date]));
					    $data = $row[customer_name] ."|".$row[customer_address]."|".$row[customer_email]."|".$st."|".$Date."|".$Date_last."|".$text."|".$row[customer_phone]."|".$row[version]."|".$row[key_version];
			}
    }
   //$data = "dfdgsgdg|hvghvhvgh|hhhhhhh|iii";
    mysqli_close($con);
    return $data;
}

//*******************************KIểm tra hạn của key****************************************
function check_info_KC($product_type) {
    $con = open_db();
	
    $sql = "select * from product where product_type = '$product_type'";
	mysqli_set_charset($con,'utf8');
    $result = mysqli_query($con, $sql);
	$data='';
	$text='';
   // if ($result) {
   //     $row = mysqli_fetch_array($result);
	if ($result) {
		while($row=mysqli_fetch_array($result))
			{
					$data = "Bạn đang dùng khóa cứng" ."|"."..............................."."|"."..............................."."|"."..............................."."|"."..............................."."|"."..............................."."|"."..............................."."|"."..............................."."|".$row[version]."|".$row[key_version];
			}
    }
   //$data = "dfdgsgdg|hvghvhvgh|hhhhhhh|iii";
    mysqli_close($con);
    return $data;
}
function Check_resetup($hardware_id, $product,$email) {
    $con = open_db();
//	return '#BEGIN_RES#NOT_ACCESS#hhhhhh#END_RES#';
	
    //$sql = "select * from registered where hardware_id = '$hardware_id' and product_type = '$product'";
	$sql = "select * from `registered`,`license` where registered.hardware_id = '$hardware_id' and license.hardware_id = registered.hardware_id and registered.customer_email='$email' and registered.product_type = '$product' and license.license_serial = registered.license_serial";
	mysqli_set_charset($con,'utf8');
    $result = mysqli_query($con, $sql);
	$date = date('Y-m-d');
    $text ='';
	if ($result) {
		while($row=mysqli_fetch_array($result))
			{			
				if ($row[status] == "1"  )
					{
						if($row['license_expire_date'] >= $date){
						$data= $row['license_original'];
						return "#BEGIN_RES#KEY_VALID#" . $data.  "#END_RES#";
						}
					}					
			}   
		mysqli_data_seek($result, 0);
		while($row1=mysqli_fetch_array($result))
			{	
			
				if ($row1[status] == "0" )
					 {
						if($row1['license_expire_date'] >= $date){
						$data= $row1['license_original'];
						return "#BEGIN_RES#KEY_VALID#" . $data.  "#END_RES#";
						}
					 }					
			}		
	return '#BEGIN_RES#NOT_ACCESS#END_RES#';		
   //$data = "dfdgsgdg|hvghvhvgh|hhhhhhh|iii";
    mysqli_close($con);
    
}else
return '#BEGIN_RES#NOT_ACCESS#END_RES#';
}

//*******************************KIểm tra key cài lại phần mềm****************************************
function Check_resetup_1($hardware_id, $product) {
    $con = open_db();
//return "#BEGIN_RES#KEY_VALID#" . "11111111".  "#END_RES#";
	
    //$sql = "select * from registered where hardware_id = '$hardware_id' and product_type = '$product'";
	$sql = "select * from `registered`,`license` where registered.hardware_id = '$hardware_id' and license.hardware_id = registered.hardware_id and registered.product_type = '$product' and license.license_serial = registered.license_serial";
	mysqli_set_charset($con,'utf8');
    $result = mysqli_query($con, $sql);
	//$result1=mysqli_query($con, $sql);
	$date = date('Y-m-d');
    $text ='';
	if ($result) {
		while($row=mysqli_fetch_array($result))
			{			
				if ($row[status] == "1"  )
					 {
						if($row['license_expire_date'] >= $date){
						$data= $row['license_original'];
						return "#BEGIN_RES#KEY_VALID#" . $data.  "#END_RES#";
						}
					 }					
			}   
			mysqli_data_seek($result, 0);
		while($row1=mysqli_fetch_array($result))
			{	
			
				if ($row1[status] == "0" )
					 {
						if($row1['license_expire_date'] >= $date){
						$data= $row1['license_original'];
						return "#BEGIN_RES#KEY_VALID#" . $data.  "#END_RES#";
						}
					 }					
			}		
	return '#BEGIN_RES#NOT_ACCESS#END_RES#';		
   //$data = "dfdgsgdg|hvghvhvgh|hhhhhhh|iii";
    mysqli_close($con);
    
}else
return '#BEGIN_RES#NOT_ACCESS#END_RES#';
}
//*******************************KIểm tra hạn của key****************************************
function check_registered_expire($client_key) {

				
    $fb = false;
    $con = open_db();
    $sql = "select * from registered where license_serial = '$client_key'";
    $result = mysqli_query($con, $sql);


    if ($result) {
        $row = mysqli_fetch_array($result);

        if (!$row) {

            $fb = true;
            mysqli_close($con);
            return $fb;
        }
        $t1 = date('Y-m-d H:i:s');
        $today = strtotime($t1);
        $expireday = strtotime($row['license_expire_date']);
        if ($expireday > $today) {
            $fb = true;
        }
    } else {
        $fb = true;
    }
    mysqli_close($con);
    return $fb;
}


//*******************************đổi key****************************************
function check_registered_expire_ed($client_key,$hardware_id) {

				
    $fb = false;
    $con = open_db();
    $sql = "select * from registered where license_serial = '$client_key' and hardware_id = '$hardware_id' ";
    $result = mysqli_query($con, $sql);


    if ($result) {
        $row = mysqli_fetch_array($result);

        if (!$row) {

            //$fb = true;
            mysqli_close($con);
            return $fb;
        }
        $t1 = date('Y-m-d H:i:s');
        $today = strtotime($t1);
        $expireday = strtotime($row['license_expire_date']);
        if ($expireday > $today) {
            $fb = true;
        }
    } else {
        $fb = false;
    }
    mysqli_close($con);
    return $fb;
}

function get_expireday($client_key) {
    $con = open_db();
    $sql = "select * from registered where license_serial = '$client_key' ";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $expireday = strtotime($row['license_expire_date']);
		$fb = date('d/m/Y',$expireday);
		//$fb = $row['license_expire_date'];
    }
    mysqli_close($con);
    return $fb;
}

// ******************************Cập nhật số máy đăng ký cho một key ******************************
function update_no_computers_registered($client_key, $no_computers_registered) {
    $con = open_db();
    $sql = "update license set license_is_registered = '$no_computers_registered' where license_serial = '$client_key'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $fp = true;
    }

    mysqli_close($con);
    return $fb;
}

//*********************************** Cập nhật thông tin khách hàng sử dụng phần m�?m*****************************
function update_last_runing_date($license_serial, $last_runing_date, $hardware_id) {
    $con = open_db();
    $sql = "update registered set last_runing_date = '$last_runing_date' where license_serial = '$license_serial' and hardware_id = '$hardware_id'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update key";
        return false;
    }
    mysqli_close($con);
    return true;
}


//-------------------------
function insert_n_product(
$product_type, $email, $tel, $name, $address,$key,$customer_cty,$hardware_id
) {
   
    if($email == ''){
        die();
    }
    
    $con = open_db();
    $sqlp = "select * from  n_registered where email = '".$email."' AND product_type = '".$product_type."'";
    $date = date("Y-m-d");
    $resultp = mysqli_query($sqlp, $con);  
    mysqli_close($con);
    
    if (mysqli_num_rows($resultp)==0 ) 
    {
        $con = open_db();
        $sql = "INSERT INTO n_registered (
        product_type,
        email,
        tel,
        name,
        address,
        date1,
		key1,
        customer_cty,
		hardware_id
        )
        VALUES (
        '$product_type',
        '$email',
        '$tel',
        '$name',
        '$address',
        '$date',
		'$key',
        '$customer_cty',
		'$hardware_id'

        );
        ";

        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo "Cannot insert data into database";
        }
        mysqli_close($con);
    }
//    else echo "Cannot insert data into database1111";
}

//-------------------------------------
////-------------------------
function del_n_product(
$product_type, $email
) {
    $con = open_db();
    $sqlp = "select * from  n_registered where email = '".$email."' AND product_type = '".$product_type."'";
    $resultp = mysqli_query($sqlp, $con);  
    mysqli_close($con);
    if (mysqli_num_rows($resultp)!=0 ) 
    {
        $con = open_db();
        $sql = "delete from n_registered where email = '".$email."' AND product_type = '".$product_type."'";
        

        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo "Cannot insert data into database";
        }
        mysqli_close($con);
    }
//    else echo "Cannot insert data into database1111";
}
//*********************************** Cập nhật thông tin máy đã đăng ký key****************************************
function update_license($license_serial, $new_hardware_id, $no_computers_registered) {
    $con = open_db();
    $sql = "update license set hardware_id = '$new_hardware_id',
    license_is_registered = '$no_computers_registered'
    where
    license_serial = '$license_serial'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update key";
        return false;
    }
    mysqli_close($con);
    return true;
}

///********************************** Tổng số Key đã sinh ra *****************************************************/
function get_last_id() {
    $con = open_db();
    $sql = "select max(id) as count from license";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_array($result);
    mysqli_close($con);
    return $row['count'];
}

/* * *********************************************Tổng số record trong một bảng************************ */

function get_total_record() {
    $con = open_db();
    $sql = "select count(*) as count from license";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_array($result);
    mysqli_close($con);
    return $row['count'];
}
function get_aaa($pro) {
    $con = open_db();
    $sql ="SELECT * FROM n_registered where  product_type = '$pro' ";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        return 0;
    }
    //$row = mysqli_fetch_array($result);
    mysqli_close($con);
    return $result;
}
function get_1($pro,$date,$st) {
    $con = open_db();
    //$sql ="SELECT * FROM registered where  product_type = '$pro' and license_activation_date = '$date' ";
		$sql = "select registered.license_original, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
					license.status, license.product_type,registered.license_activation_date from registered, license where license.status='$st' and registered.product_type='$pro' and  registered.license_serial=license.license_serial and registered.license_activation_date='$date'
		 ";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        return 0;
    }
    //$row = mysqli_fetch_array($result);
    mysqli_close($con);
    return $result;
}
//*************************************Cập nhật thông tin khách hàng đăng ký Key kích hoạt******************************
function add_client_info_to_db(
$license_serial, $license_original, $hardware_id, $customer_name, $customer_phone, $customer_email, $customer_address, $license_activation_date, $last_runing_date, $license_expire_date, $product_type, $customer_cty
) {
    $con = open_db();
    $sql = "INSERT INTO registered (id,
    license_serial,
    license_original,
    hardware_id,
    customer_name,
    customer_phone,
    customer_email,
    customer_address,
    license_activation_date,
    last_runing_date,
    license_expire_date,
    product_type,
    customer_cty
    )
    VALUES (NULL,
    '$license_serial',
    '$license_original',
    '$hardware_id',
    '$customer_name',
    '$customer_phone',
    '$customer_email',
    '$customer_address',
    '$license_activation_date',
    '$last_runing_date',
    '$license_expire_date',
    '$product_type',
    '$customer_cty'
    );
    ";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot insert data into database";
    }
    mysqli_close($con);
}
//******************************************Cập nhật thông tin khách hàng đăng ký**********************************************************
function update_registered_info_1($id, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date, $license_activation_date, $license_expire_date,$n) {
    $con = open_db();
    $sql = "update registered set customer_name = '$customer_name',
   customer_phone = '$customer_phone',
    hardware_id = '$hardware_id',
    customer_email = '$customer_email',
    customer_address = '$customer_address',
    last_runing_date = '$last_runing_date',
    license_activation_date = '$license_activation_date',
    license_expire_date = '$license_expire_date',
    n= '$n'
    where
    id = '$id'";

    $result = mysqli_query($con, $sql);
   
    if (!$result) {
        echo "Cannot update registered";
        return false;
    }
    mysqli_close($con);
    return true;
}
//******************************************Cập nhật thông tin khách hàng đăng ký**********************************************************
function update_registered_info($id, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date, $license_activation_date, $license_expire_date) {
    $con = open_db();
    $sql = "update registered set customer_name = '$customer_name',
    customer_phone = '$customer_phone',
    hardware_id = '$hardware_id',
    customer_email = '$customer_email',
    customer_address = '$customer_address',
    last_runing_date = '$last_runing_date',
    license_activation_date = '$license_activation_date',
    license_expire_date = '$license_expire_date'
    where
    id = '$id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update registered";
        return false;
    }
    mysqli_close($con);
    return true;
}

//******************************************Cập nhật thông tin khách hàng đăng ký**********************************************************
function update_registered($license_serial, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date, $cty) {
    $con = open_db();
    $sql = "update registered set customer_name = '$customer_name',
    customer_phone = '$customer_phone',
    customer_email = '$customer_email',
    customer_address = '$customer_address',
    last_runing_date = '$last_runing_date',
    customer_cty= '$cty'
    where
    license_serial = '$license_serial' AND hardware_id = '$hardware_id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update registered";
        return false;
    }
    mysqli_close($con);
    return true;
}

function update_registered_hw($client_key, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date, $cty) {
    $con = open_db();
    $sql = "update registered set customer_name = '$customer_name',
    customer_phone = '$customer_phone',
    customer_email = '$customer_email',
    customer_address = '$customer_address',
    last_runing_date = '$last_runing_date',
    customer_cty= '$cty',
	hardware_id = '$hardware_id'
    where
    license_original = '$client_key'  ";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update registered";
        return false;
    }
    mysqli_close($con);
    return true;
}

//********************************* Cập nhật thông tin khách hàng đăng ký lại ***************************************************
function update_registered1($license_serial, $hardware_id, $last_runing_date) {
    $con = open_db();
    $sql = "UPDATE registered SET last_runing_date = '$last_runing_date' WHERE license_serial = '$license_serial' AND hardware_id = '$hardware_id'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot update last_runing_date";
        return false;
    }
    mysqli_close($con);
    return true;
}

//************************************************Xóa thông tin khách hàng *******************************************************
function delete_client_info($id, $license_serial) {
    $con = open_db();
    $sql = "delete from registered where id = '$id'";
    $result = mysqli_query($con, $sql);
    mysqli_close($con);
    if ($result) {

        $no_computers_registered = check_no_computers($license_serial);
        $no_computers = $no_computers_registered > 0 ? ($no_computers_registered - 1) : 0;
        update_license($license_serial, "NA", $no_computers);
        $fb = true;
    }
    return $fb;
}

//Sử lý bảng email 
/* * ***************Hiển thị các email tự động trong bảng*********************************** */

function view_email_auto() {
    $con = open_db();
    $sql = "select * from email where status=0";
    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $string = $row['subjects'];
            $output = "25";
            $iChar = "30"; // Max number of character(s) for cutting
            if (strlen($string) > $iChar) {
                $output = mb_substr($string, 0, $output, "UTF-8");
                while (substr($output, -1) != " ") {
                    $output = substr($output, 0, strlen($output) - 1);
                }
                $string = $output . " ...";
            }
            echo "<a href='editemail.php?id=$row[id]'><button style='width:260px; height:28px'>" . $string . "</button></a>";
        }
    }
    mysqli_close();
    return TRUE;
}

/* * **********************Thêm email vào trong bảng email******************************* */
/* * ***************Hiển thị các email trong bảng*********************************** */

function view_email() {
    $con = open_db();
    $sql = "select * from email where status=1";
    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $string = $row['subjects'];
            $output = "25";
            $iChar = "30"; // Max number of character(s) for cutting
            if (strlen($string) > $iChar) {
                $output = mb_substr($string, 0, $output, "UTF-8");
                while (substr($output, -1) != " ") {
                    $output = substr($output, 0, strlen($output) - 1);
                }
                $string = $output . " ...";
            }
            echo "<a href='editemail.php?id=$row[id]'><button style='width:260px; height:28px'>" . $string . "</button></a>";
        }
    }
    mysqli_close();
    return TRUE;
}

/* * **********************Thêm email vào trong bảng email******************************* */

function add_email($email, $subjects, $content, $time, $status) {
    $con = open_db();
    $sql = "insert into email (id, email, subjects, content, time, status) values(NULL, '$email','$subjects','$content','$time','$status')";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Không thể thêm email này vào bảng";
        return FALSE;
    } else {
        echo "Email đã được thêm";
        return TRUE;
    }
    mysqli_close();
    return TRUE;
}

function update_email($id, $email, $subjects, $content, $time) {
    $con = open_db();
    $sql = "update email set email='$email',
                                 subjects='$subjects',
                                 content='$content',
                                 time='$time' where id='$id'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Không thể sửa email";
        return FALSE;
    } else {
        echo "Email đã được sửa";
        return TRUE;
    }
    mysqli_close();
    return TRUE;
}

/* * *************************Xóa email ở bảng ************************************* */

function delete_email($id) {
    $con = open_db();
    $sql = "delete from email where id='$id' ";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Bạn không thể xóa được email";
        return FALSE;
    } else {
        echo "Email đã được xóa";
    }
    mysqli_close();
    return TRUE;
}

/* Hàm phân trang ************************************************************* */

function phantrang($page, $total_page, $link, $show) {//$link='&page = %s'
    $nav_page = "";
//showpage
    if ($total_page == 0) {

    } else {
//$nav_page='<divclass = "navpage"><spanclass = "current">Page'.$page.'of'.$total_page.':</span>';
        $limit_nav = 4;
        $start = ($page - $limit_nav <= 0) ? 1 : $page - $limit_nav;
        $end = $page + $limit_nav > $total_page ? $total_page : $page + $limit_nav;
        if ($page + $limit_nav >= $total_page && $total_page > $limit_nav * 2) {
            $start = $total_page - $limit_nav * 2;
        }
//if($start!=1){//showfirstpage
        $nav_page.='<span class = "item"><a style = "text-decoration:none;
    " href = "' . sprintf($link, 0) . '">
                    <img style = "padding:2" src = "../template/img/nut dau.jpg"></img></a></span>';
//}
//if($start>2){//themnut...
//$nav_page.='<span class = "current">...</span>';
//}
        if ($page > 0) {//themnutprev
            $nav_page.='<span class = "item"><a style = "text-decoration:none;
    " href = "' . sprintf($link, $page - 1) . '">
                    <img style = "padding:2" src = "../template/img/back.jpg"></img></a></span>';
        }
        for ($i = $start; $i <= $end - 1; $i++) {
            if ($page == $i)
                $nav_page.='<span class = "current1">' . $i . '--</span>';
            else
                $nav_page.='<span class = "item1"><a style = "text-decoration:none;
    " href = "' . sprintf($link, $i) . '">' . $i . '--</a></span>';
        }
        if ($page < $total_page - 1) {//themnutnext
            $nav_page.='<span class = "item"><a style = "text-decoration:none;
    " href = "' . sprintf($link, $page + 1) . '">
                    <img style = "padding:2" src = "../template/img/next.jpg"></img></a></span>';
        }
        $nav_page.='<span class = "item"><a style = "text-decoration:none;
    " href = "' . sprintf($link, $total_page - 1) . '" >
                    <img style = "padding:2" height = "25" src = "../template/img/nut cuoi.jpg"></img></a></span>';
        $nav_page.='</div>';
        return $nav_page;
    }
}
/*
function phantrang1($tableName,$rowsPerPage){
    //tổng số mẩu tin
    $con = open_db();
    $sql = "SELECT * FROM ".$tableName;
    $result = mysqli_query($sql,$con);
    if($result){
    $totalRows = @mysqli_num_rows($result);
    
    //tổng số trang
    $totalPages = ceil($totalRows/$rowsPerPage);
    //$this->totalPages = ceil($this->totalRows/$rowsPerPage);
    
    //lấy số trang hiện tại
    if(isset($_GET['page'])){
			$page = $_GET['page'];
		}
		else{
			$page = 1;	
		}
     //tính vị trí mẩu tin đầu tiên trên mỗi trang
      //function perRow($page, $rowsPerPage){
					
    $perRow = $page*$rowsPerPage - $rowsPerPage;
    
    //phân trang
    $listPages = '';
		for($i=1; $i<=$totalPages; $i++){
			
			if($page == $i){
				
				$listPages .= '<span>'.$i.'</span> ';
			}
			else{
				$listPages .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
			}
		}
		return $listPages;
	//}          
    }
   
}*/
function phantrang_test($total_page,$page) {
    $list_page='';
if($total_page == 0){
     $list_page='';
}else{
    if($total_page <= 5 && $total_page>0) {
        for($i=1;$i<=$total_page;$i++){
        if($i == $page){
            $list_page.='<span>'.$i.' </span>'.' &nbsp ';
        }
        else
        $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.' </a>'.' &nbsp ';
    }
    }
    elseif( $total_page > 5 && $page > 3 && $page <= $total_page - 2){
        
        $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($page-3).'"> << </a>'.' &nbsp ';       
        for($i=$page - 2;$i<=$page +2;$i++){
            if($page == $i){
                 $list_page.='<span>'.$i.' </span>'.' &nbsp ';
            }
            else
            $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.' </a>'.' &nbsp ';
        }
        if($page < $total_page - 2){
         $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($page+3).'"> >> </a>'.' &nbsp ';
        }
    }
    else if($total_page > 5 && $page <= 3 && $page <= $total_page - 2){
     for($i=1;$i<=$page +2;$i++){
            if($page == $i){
                 $list_page.='<span>'.$i.' </span>'.' &nbsp ';
            }
            else
            $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.' </a>'.' &nbsp ';
        }
        if($page < $total_page - 2){
         $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($page+3).'"> >> </a>'.' &nbsp ';
        }
    }
    else{
     $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($page-3).'"> << </a>'.' &nbsp '; 
     for($i=$page -2;$i<=$total_page;$i++){
            if($page == $i){
                 $list_page.='<span>'.$i.' </span>'.' &nbsp ';
            }
            else
            $list_page.= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.' </a>'.' &nbsp ';
        }

    }
	}
    return $list_page;
    

}
function Log_info($id_action,$user_name){
        //$t=time();

        $date= date("Y-m-d H:i:s"); 

         $con = open_db();
       
         
        $sql = "INSERT INTO `log_info` (user,id_action,time) VALUES ('$user_name',$id_action,'$date')";
        $result = mysqli_query($con, $sql);
        return 0;
        
    }
//-----------------
function sendemail($email,$product,$key,$n){
    $con = open_db(); 
	    $t = date("Y-m-d");
        $sql = "SELECT * FROM `license` WHERE product_type = '".$product."' and status='".$key."' and type_expire_date=365 and license_no_computers = '1' and email_cus = '' and license.stt_email = 0 ORDER BY id DESC;";
        $result = mysqli_query($con, $sql);
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            if($row['license_key'] != ''){
                $arr[$i] = $row['license_key'];
				 $sql1 = "UPDATE `kichhoat`.`license` SET `stt_reg` = '1' ,`email_cus` = '$email',`Sell` = '$t' WHERE `id` = '$id'";
				   $id = $row['id'];
                //$sql = "UPDATE `kichhoat`.`license` SET `license_is_registered` = '1' WHERE `id` = '$id'";
                $result1 = mysqli_query($sql1, $con);
				
                $i++;         
            }
            if($i == $n){
                break;    
            }
        }
       echo  $sql = 'SELECT * FROM `email`,`product` WHERE product.product_type = "'.$product.'" and product.product_type = email.product';

        $result = mysqli_query($con, $sql);
        $count=  mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        if($count == 0){
            echo '<script type="text/javascript" charset="UTF-8">  
                               alert("Bạn cần thêm email mặc định cho phần mềm này");
                               </script>';
            die();
        }
        else{
            $id1=$row['email'];
            $sql = 'SELECT * FROM `email` WHERE id = '.$id1;
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $title = $row['subjects'];
            $content = $row['content'];
            $st='';
            //for($j=0;$j<$n;$j++){
             //   $st = $arr[$j].'<br>'.$st;
            //}
			if($n == 1){
                $st = $arr[0];
            }
            else{
                for($j=0;$j<$n;$j++){
                    if($j == 0){
                        $st = $arr[$j];
                    }
                    else $st = $st.'<br>'.$arr[$j];
                }
            }
            $st;
            $content1 = str_replace( 'PASTE_KEY', $st, $content );
            $arr = Array();
            $arr[0]= $email;
            send_email_3($arr,$title, $content1,1);
        }
}
