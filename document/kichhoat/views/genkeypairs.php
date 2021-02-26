<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generate key pair using for encryting license code</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style></head>
<body>
<?php
$config = array("config" => 'C:\\xampp\\apache\\bin\\openssl.cnf');
$dn = array(
			"countryName" => 'VN', 
			"stateOrProvinceName" => 'HaNoi', 
			"localityName" => 'HaDong', 
			"organizationName" =>'HUST', 
			"organizationalUnitName" => 'DCE', 
			"commonName" => 'HiepHV', 
			"emailAddress" => 'hiephv@gmail.com');
$privpassphrase = "Bachkhoa12";
$daysexpire = 365;

$privkey = openssl_pkey_new($config);
$csr = openssl_csr_new($dn, $privkey, $config);
$sscert = openssl_csr_sign($csr, null, $privkey, $daysexpire, $config);

//get public key from keypair
openssl_x509_export($sscert, $publickey);
//get private key from keypair
openssl_pkey_export($privkey, $privatekey, $privpassphrase, $config);
openssl_csr_export($csr, $csrstr);

//store keys into files
$fp = fopen(".\\PKI\\public\\hiephv.crt", "w");
if(!$fp)
{
	echo "<br>Cannot open file to write";
	return;
}
fwrite($fp, $publickey);
fclose($fp);

$fp = fopen(".\\PKI\\private\\hiephv.key", "w");
if(!$fp)
{
	echo "<br>Cannot open file private key to write";
	return;
}
fwrite($fp, $privatekey);
fclose($fp);
?>
</body>
</html>
