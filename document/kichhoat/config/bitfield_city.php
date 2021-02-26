<?php
class bitmask_city {

    public $permissions = array(
        "An Giang" => FALSE,
        "Bắc Cạn" => FALSE,
        "Bạc Liêu" => FALSE,
        "Bắc Ninh" => FALSE,
        "Bắc Giang" => FALSE,
        "Bến Tre" => FALSE,
        "Bình Dương" => FALSE,
        "Bình Phước" => FALSE,
        "Bình Định" => FALSE,
        "Bình Thuận" => FALSE,
        "Cà Mau" => FALSE,
        "Cao Bằng" => FALSE,
        "Cần Thơ" => FALSE,
        "Đăk Lăk" => FALSE,
        "Đắk Nông" => FALSE,
        "Đà Nẵng" => FALSE,
        "Điện Biên" => FALSE,
        "Đồng Nai" => FALSE,
        "Đồng Tháp" => FALSE,
        "Gia Lai" => FALSE,
        "Hà Giang" => FALSE,
        "Hải Dương" => FALSE,
        "Hải Phòng" => FALSE,
        "Hà Nam" => FALSE,
        "Hà Nội" => FALSE,
        "Hà Tĩnh" => FALSE,
        "Hậu Giang" => FALSE,
        "Hòa Bình" => FALSE,
        "Hồ Chí Minh" => FALSE,
        "Huế" => FALSE,
        "Hưng Yên" => FALSE,
        "Khánh Hòa" => FALSE,
        "Kiên Giang" => FALSE,
        "Kon Tum" => FALSE,
        "Lai Châu" => FALSE,
        "Lâm Đồng" => FALSE,
        "Lạng Sơn" => FALSE,
        "Lào Cai" => FALSE,
        "Long An" => FALSE,
        "Nam Định" => FALSE,
        "Nghệ An" => FALSE,
        "Ninh Bình" => FALSE,
        "Ninh Thuận" => FALSE,
        "Phú Thọ" => FALSE, 
        "Phú Yên" => FALSE,
        "Quảng Bình" => FALSE,
        "Quảng Nam" => FALSE,
        "Quảng Ngãi" => FALSE,
        "Quảng Trị" => FALSE,
        "Quảng Ninh" => FALSE,
        "Sóc Trăng" => FALSE,
        "Sơn La" => FALSE,
        "Tây Ninh" => FALSE,
        "Thái Bình" => FALSE,
        "Thái Nguyên" => FALSE,
        "Thanh Hóa" => FALSE,
        "Tiền Giang" => FALSE,
        "Trà Vinh" => FALSE,
        "Tuyên Quang" => FALSE,
        "Vĩnh Long" => FALSE,
        "Vũng Tàu" => FALSE,
        "Yên Bái" => FALSE,
        "Tỉnh Khác" => FALSE 
    );
        
    public function getPermissions($bitMask = 0) {
        $i = 0;
        foreach ($this->permissions as $key => $value) {
            $this->permissions[$key] = (($bitMask & pow(2, $i)) != 0) ? true : false;
            //uncomment the next line if you would like to see what is happening.
            //echo $key . " i= ".strval($i)." power=" . strval(pow(2,$i)). "bitwise & = " . strval($bitMask & pow(2,$i))."<br>";
            $i++;
        }
        return $this->permissions;
    }

    function toBitmask() {
        $bitmask = 0;
        $i = 0;
        foreach ($this->permissions as $key => $value) {

            if ($value) {
                $bitmask += pow(2, $i);
            }
            $i++;
        }
        return $bitmask;
    }

}

?>
