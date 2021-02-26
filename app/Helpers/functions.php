<?php

// Check Empty and value different numeric
function is_blank($value) {
    return empty($value) && !is_numeric($value);
}


// Convert UTF8 string to Latin string
function utf8ToLatin($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);

    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function strToHex($string) {
    $hex = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}


function active_nav($routeName = []) {
    $curent = \Illuminate\Support\Facades\Route::currentRouteName();
    $i = 0;
    foreach ($routeName as $route) {
        if($curent == $route)
            $i++;
    }

    return ($i > 0) ? "active" : "";
}

function open_nav($routeName = []) {
    $curent = \Illuminate\Support\Facades\Route::currentRouteName();
    $i = 0;
    foreach ($routeName as $route) {
        if($curent == $route)
            $i++;
    }

    return ($i > 0) ? "nav-item-open" : "";
}

function can($permission, $or = false) {
    $user = auth()->user();
    if($user->name == 'root')
        return true;

    $arrPermission = [];
    if(!is_array($permission))
        $arrPermission[] = $permission;
    else
        $arrPermission[] = $permission;

    $err        = 0;
    $success    = 0;
    foreach ($arrPermission as $pm) {
        if($user->can($pm))
            $success += 1;
        else
            $err += 1;
    }

    if($or) {
        if($success > 0)
            return true;
    }

    if($err == 0)
        return true;

    return false;
}



function getlabelTypeProduct($key)
{
     $typeLabel = [
        \App\Models\Product::TYPE_SOFWTWARE => 'Khóa mềm',
        \App\Models\Product::TYPE_HARDWARE  => 'Khóa cứng',
        \App\Models\Product::TYPE_COURSE    => 'Khóa học',
        \App\Models\Product::TYPE_CERTIFICATE    => 'Chứng chỉ',
    ];

     return $typeLabel[$key];
}
