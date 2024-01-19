<?php
// $data = [
// 	"bio" => "Software Engineer",
// 	"dob" => "1987-10-31",
// 	"dp" => "ZERO_5g9d6S441Cx3e1Ibmt.jpg",
// 	"firstname" => "Ao™",
// 	"gender" => "M",
// 	"lastname" => "",
// 	"living" => "Abuja, Nigeria"
// ];

// $bind = ["oauthid" => "NGm8Jy8Eov9qA02n1Yx51d5FkDiMK020I4tX7h8Oc41SslUz2PrwjVpCZ0RT6uW436aB1L"];
// $column = ['oauthid'];
// // $column = 'oauthid';


// $setting = SETTING['NETWORK'];
// if(!empty($setting['DATABASE'])){
// 	$settingDB = $setting['DATABASE'];
// 	if(isset($settingDB['USER'])){$init['user'] = $settingDB['USER'];}
// 	if(isset($settingDB['PASSWORD'])){$init['password'] = $settingDB['PASSWORD'];}
// 	if(isset($settingDB['NAME'])){$init['name'] = $settingDB['NAME'];}
// 	if(!empty($init)){$connect = _connect($init);}
// }

// function _connect($auth, $database=''){
// 	if(empty($auth['name']) && !empty($database)){$auth['name'] = $database;}
// 	$pdo = new oPDO;
// 	$pdo->initialize($auth);
// 	$pdo->verify();
// 	$pdo->connect();
// 	return $pdo;
// }

// $mars = $connect->save('profileo', $bind, $column, $data);




// $call = new NetworkModel;
// $oreo = $call->setAppUserAuthorization($bind, 'oauthid', ['previous' => 'VENO'], 'x6O872D7ZtB1o6eq442W');


// $oreo = RandomX::tuid().RandomX::puid();
// oTraceX(['OREO' => $oreo, 'length' => strlen($oreo)]);

URLX::domain(ServerX::host());

// $mail = new EmailX;
// $mail->test();