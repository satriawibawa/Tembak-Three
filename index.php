<?php
/**
 * Name:    Dor Three beta
 * Author:  Satria Wibawa
 * FB: https://www.facebook.com/HTTP200K
 * Github: https://github.com/satriawibawa
 * Created: 31/08/2018
 *
 */
function mintaOTP($nomor, $wait){
    $ch = curl_init();
    $imei = "867706023561122";

    $payload = [
           	"msisdn" => "".$nomor."",
  			"imei" => $imei
        ];

        $data1 = json_encode($payload, true);
        curl_setopt($ch, CURLOPT_URL,"https://bimaplus.tri.co.id/api/v1/login/otp-request");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
			'Cache-Control: no-store, must-revalidate, no-cache',
			'Pragma: no-cache',
			'Accept: application/json',
			'Accept-Encoding: identity',
			'User-Agent: Dalvik/2.1.0 (Linux; U; Android 5.1.1; A37f Build/LMY47V)',
			'Host: bimaplus.tri.co.id',
			'Connection: Keep-Alive'
        ));
        curl_setopt ($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        sleep($wait);
        flush();
        return $server_output;
};
function RequestLogin($nomor, $otp, $wait){

    $ch = curl_init();
    $imei = "867706023561122";

    $payload = [
            "msisdn" => "".$nomor."",
			"otp" => "".$otp."",
		  	"imei" => $imei,
		  	"deviceModel" => "A37f",
		  	"deviceOs" => "5.1.1",
		  	"deviceManufactur" => "OPPO"
        ];

        $data1 = json_encode($payload, true);
        curl_setopt($ch, CURLOPT_URL,"https://bimaplus.tri.co.id/api/v1/login/login-with-otp");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
			'Cache-Control: no-store, must-revalidate, no-cache',
			'Pragma: no-cache',
			'Accept: application/json',
			'Accept-Encoding: identity',
			'User-Agent: Dalvik/2.1.0 (Linux; U; Android 5.1.1; A37f Build/LMY47V)',
			'Host: bimaplus.tri.co.id',
			'Connection: Keep-Alive',
        ));
        curl_setopt ($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        sleep($wait);
        flush();
        return $server_output;
    };
function BeliLangsung($no, $wait, $id){
    $ch = curl_init();
    $waktu = date('Ymdims');

    $payload = [
    	  "callPlan" => "SP KEWL",
		  "imei" => "864217034503297",
		  "language" => "0",
		  "msisdn" => "".$no."",
		  "paymentMethod" => "00",
		  "menuCategoryName" => "rfu",
		  "menuSubCategoryName" => "rfu",
		  "productId" => "".$id."",
		  "secretKey" => "".$_SESSION['secretKey']."",
		  "servicePlan" => "-",
		  "subscriberType" => "Prepaid",
		  "vendorId" => "11"
        ];

        $data1 = json_encode($payload, true);
        curl_setopt($ch, CURLOPT_URL,"https://bimaplus.tri.co.id/api/v1/recommended/redeem");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Cache-Control: no-store, must-revalidate, no-cache',
			'Pragma: no-cache',
			'Accept: application/json',
			'Accept-Encoding: identity',
			'User-Agent: Dalvik/2.1.0 (Linux; U; Android 5.1.1; A37f Build/LMY47V)',
			'Host: bimaplus.tri.co.id',
			'Connection: Keep-Alive',
        ));
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        sleep($wait);
        flush();
        return $server_output;
    }
    function service($str) {
    switch ((int) $str) {
        case 1: return 'RFU2753DVIU';
        break;
        
        case 2: return '32GB30Min30D';
        break;
                       
        default;
    }
    }
    $respon = '';
    if (isset($_POST["OTP"])) {
        $nomor = $_POST['nomor'];
        $jeda = "1";
        $execute = mintaOTP($nomor, $jeda);
        $data = json_decode((string) $execute);
        $respon = $data->status;
    }else if (isset($_POST["login"])) {
    	$nomor = $_POST['nomor'];
        $otp = $_POST['_otp'];
        $jeda = "1";
        $execute = RequestLogin($nomor, $otp, $jeda);
        $data = json_decode((string) $execute);
        if ($data->status == '1'){
       		$respon = 'Login Sukses';
        } 
    }else if (isset($_POST["beli"])) {
        $nomor = $_POST['nomor'];
        $jeda = "1";
        $id = service($_POST['anuID']);
		$var = $_POST['anuID'];
        $execute = BeliLangsung($nomor, $jeda, $id);
        $respon = $execute;
    }
}
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Three</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style type="text/css">
    #wrapshopcart{width:350px;margin:auto;padding:20px;
     padding-bottom: 1px;margin-bottom: 20px;background:#fff;box-shadow:0 0 5px #c1c1c1;border-radius:5px;}
    #response{
        text-align: center;
    }
    #EE{
        width: 50%;
    }
    textarea { resize:none; }
    #count{
        text-align: right;
    }
</style>
</head>
<body>
<br>
<div id="wrapshopcart">
    <h3>Tembak Three</h3>
    <hr/>
    <div class="form-group">
        <?php

        (isset($_POST["anuID"])) ? $anuID = $_POST["anuID"] : $anuID=1;

        ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
                <div class="Login" style="display: block;">
                <label>Nomor Three: </label>
                <input class="form-control" type="text" name="nomor" value="<?php echo isset($_POST['nomor']) ? $_POST['nomor'] : ''; ?>" placeholder="Contoh: 628xxxx" required><br>
                <label>OTP Three: </label>
                <div class="input-group mb-3">
                <input class="form-control" type="text" name="_otp" value="<?php echo isset($_POST['_otp']) ? $_POST['_otp'] : ''; ?>" placeholder="Contoh: ABC123"><br><div class="input-group-append">
                <button type="submit" class="btn btn-info" name="OTP">Minta OTP</button></div></div>
                <div class="form-group">
                </div>
                <button type="submit" class="btn btn-success" name="login">Login</button><br><br>
                <div class="form-group">
                    <label>Pilih paket default</label><br>
                    <select class="form-control" id="anuID" name="anuID">
                        <option <?php if ($anuID == 1 ) echo 'selected' ; ?> value="1">Paket 2.75GB, 3hr, Rp10rb</option>
                        <option <?php if ($anuID == 2 ) echo 'selected' ; ?> value="2">Paket 32GB, 30hr, Rp60rb</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="beli">Beli Paket</button>
                </div>
            </form>
             <textarea class="form-control input-sm" type="textarea" placeholder="message" maxlength="150" rows="2" style="text-align: center;" readonly><?php echo $respon; ?></textarea>
<center>
    <p> &copy; 2018 By Satria Wibawa</p>
<center>
    </div>
</body>
</html>
