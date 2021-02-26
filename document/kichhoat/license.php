<?php
require_once("config/dbconnect.php");
get_infor_from_conf("config/DB.conf");
require_once("config/global.php");
$con = open_db();

if (!function_exists('getallheaders'))
{
  function getallheaders()
  {
    $headers = array ();
    foreach ($_SERVER as $name => $value)
    {
      if (substr($name, 0, 5) == 'HTTP_')
      {
        $headers[substr($name, 5)] = $value;
      }
    }
    return $headers;
  }
}
$headers = getallheaders();

if ( !array_key_exists( 'X-GXD-KEY', $headers)) {
  $data = [
    'data' => [
      'license' => ''
    ],
    'meta' => [
      'code' => 404
    ]

  ];
} else {

  if ( $headers['X-GXD-KEY'] == 'abc' ) {
    $email = $_POST['email'];
    $softwareName = $_POST['software_name'];

    // Insert license key here
    $sql = 'SELECT * FROM `license` WHERE `license_is_registered` = "0" AND `status` = "0" AND `type_expire_date` = 7 AND `is_used` = 0 AND `product_type` = "' . $softwareName . '" ORDER BY `license` . `id` DESC';
    $result = mysqli_query($con, $sql);
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
        $license_key = $row['license_key'];
     }
    }

	$sql1 = 'UPDATE license SET `is_used`= 1 where `license_key` = "' . $license_key . '"';
                $result1 = mysqli_query($sql1, $con);

    $data = [
      'data' => [
        'license' => $license_key,
        'email' => $email,
        // 'product' => $product
      ],
      'meta' => [
        'code' => 201
      ]
    ];
  }
}

header('Content-Type: application/json');
echo json_encode($data);

