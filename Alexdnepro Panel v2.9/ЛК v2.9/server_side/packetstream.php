<?php
/*
Unit PacketStream version 2.12
by alexdnepro
*/
$packet_stream_ver = '2.12.';
if (!isset($gamedb_port)) $gamedb_port = 29400;
if (!isset($delivery_port)) $delivery_port = 29100;
if (!isset($gamedb_ip) && isset($sockip)) $gamedb_ip = $sockip; 
if (!isset($delivery_ip) && isset($sockip)) $delivery_ip = $sockip; 
define('gamedb_port', $gamedb_port);
define('delivery_port', $delivery_port);
define('gamedb_ip', $gamedb_ip);
define('delivery_ip', $delivery_ip);
$ProtocolVer = 7;	// Версия elements.data

/*

$p_k = base64_decode('LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUFwVXJaNy82dUttMzdGYndSQWxUdQpxZTl3dk10MGJ0UTVKVGxya2d0a25ZTHNOcnQ0SkFXY0VjeS9TRk8xc2d2Sk9rUHNncGxPZHpJQnRYNnNsWithCllraEFkdHdQblFaeVRhUERhUWdxQ0tSUXZwNFhqYWZFRmllSTZqMjBLMmNFSGdEK1R2YUtzQXFoT28vd3FLYkwKcVYwcWQ3Rk9LY2xUZWdwczdvUTN2ODNvSy9ldkJ4UFhHSUpGMGtYNm9hYUNLSGwxc2x6YVpUaFJDV2premUzOApoeVhXOFFSMlBhUkhrUWEySzFsM3dUSkxqTmlWV1FFQkhhRFZSaGpHRnpLUWdvNDZPL01OSjdWNms4N3FtQ1FnCklnQ0xOOUhWUktWQXBEY2g3c0RXOGZNNkc1QmxFZjlYYzNEakJYanFCVVdweXZXczNMM3ordFVKZEFDK0tnUk4Kc1FJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0tCg==');

function AssignData($data){
	global $p_k;
	$result = '';
	$Split = str_split($data, 344);
	foreach($Split as $Part){
		@openssl_public_decrypt(base64_decode($Part), $PartialData, $p_k);
		$result .= $PartialData;
	}
	return $result;
}

function PrepareData($data){
	global $p_k;
	$Split = str_split($data, 117);
	$PartialData = '';
	$EncodedData = '';
	foreach ($Split as $Part){
		openssl_public_encrypt($Part, $PartialData, $p_k);
		$EncodedData .= base64_encode($PartialData);
	}
	return $EncodedData;
}

*/


function AssignData($data)
{
    return $data;
}

function PrepareData($data)
{
    return $data;
}


function encode($String, $cookie_pasw, $encoder_Salt)
{  
    $StrLen = strlen($String);
    $Gamma = '';
    while (strlen($Gamma)<$StrLen)
    {
        $Seq = pack("H*",sha1($Gamma.$cookie_pasw.$encoder_Salt)); 
        $Gamma.=substr($cookie_pasw,0,8);
    }
    
    return $String^$Gamma;
}

function mycrypt($s){
	$s1 = '';	
	for ($i=0; $i < strlen($s); $i++){
		$s2 = bin2hex(chr(ord($s[$i])-150+($i+1)*12));
		$s1 .= $s2;
	}
	return $s1;
}

function decrypt($s){
	$s1 = pack('H*', $s);
	for ($i=0; $i < strlen($s1); $i++){		
		$s1[$i] = chr(ord($s1[$i])+150-($i+1)*12);
	}
	return $s1;
}

function CurlPage($server_side_script_path, $postdata, $timeout, $into_var=1, &$error_buf){
	$ch = curl_init();
	if (!$ch) {		
		die('Curl init error');
	}
	curl_setopt($ch, CURLOPT_URL, $server_side_script_path);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, $into_var);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_POST, 1);	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	$result = curl_exec($ch);
	if ($result === false) $error_buf .= curl_error($ch)."\n<br>";
	curl_close($ch);	
	return $result;
}

function CheckNum($val){
	if (preg_match("/[^0-9]/", $val)) return true;
	return false;
}

/*

function _77147747($i){$a=Array('WWtkc2FscFhOWHBhVmpseVdsaHJkVnBIUmpCWlVUMDk=','V1ZkNGJHVkhVblZhV0VKNVluazFkVnBZVVQwPQ==','WTIxV2VscFlTakphVXpWb1lrZFdORnBITld4alNFcDJURzAxYkdSQlBUMD0=','U1Vkc2VrbEhOWFprUTBJelkyMXNNRmxYU25OYVVUMDk=','VEdjOVBRPT0=','VlRCT1UxTldRbFZZTUZwS1ZFVldUMUZWTVVZPQ==','V2tkc2VXSnRSblJhVVQwOQ==','VWtkc2VWcFhUakJpTTBvMVNVRTlQUT09','U1Vkc2VrbEhOWFprUTBJelkyMXNNRmxYU25OYVVUMDk=','WTJjOVBRPT0=','WmtFOVBRPT0=','Vld0V1RsUXhVa1pZTUVaRlVrWkpQUT09','VFZSTlBRPT0=','WmtFOVBRPT0=','VFZSTlBRPT0=','','','V1RKNGNGcFhOVEE9','V1RKNGNGcFhOVEE9','','U2xoT09FcFhVamhLV0U0NFNsaE9PRXBZVGpoS1dFNDRTbGhPT0VwWVRUMD0=','Vld0V1RsUXhVa1pZTUVaRlVrWkpQUT09','VTBaU1ZWVkdPVWxVTVU1Vg==','VlRCV1UxWnJWbE5ZTURWQ1ZGVlZQUT09','WVRKV05RPT0=','V2tkR01GbFJQVDA9','WVVoU01HTkViM1pNZHowOQ==','VERKNGNGa3lWblZqTWxabVdUTkJkV05IYUhjPQ==','','','','V1RKNGNGcFhOVEE9','V1RKNGNGcFhOVEE9','','','','V1RKb2JGa3ljejA9','V20xR2NHSkJQVDA9','V2xob2QyRllTbXhhUVQwOQ==','','WmtFOVBRPT0=','Vld0V1RsUXhVa1pZTUVaRlVrWkpQUT09','WkhjOVBRPT0=','V2xob2QyRllTbXhhUVQwOQ==','VFZSQmQwMVJQVDA9','V1ZkelBRPT0=','V2tkR01GbFJQVDA9','V2tkR01GbFJQVDA9','');return base64_decode($a[$i]);}
function lll_($vvv_0){$vvv_1=Array(_77147747(0),_77147747(1),_77147747(2),_77147747(3),_77147747(4),_77147747(5),_77147747(6),_77147747(7),_77147747(8),_77147747(9),_77147747(10),_77147747(11),_77147747(12),_77147747(13),_77147747(14),_77147747(15),_77147747(16),_77147747(17),_77147747(18),_77147747(19),_77147747(20),_77147747(21),_77147747(22),_77147747(23),_77147747(24),_77147747(25),_77147747(26),_77147747(27),_77147747(28),_77147747(29),_77147747(30),_77147747(31),_77147747(32),_77147747(33),_77147747(34),_77147747(35),_77147747(36),_77147747(37),_77147747(38),_77147747(39),_77147747(40),_77147747(41),_77147747(42),_77147747(43),_77147747(44),_77147747(45),_77147747(46),_77147747(47),_77147747(48));return base64_decode($vvv_1[$vvv_0]);}
function lll__($vvv_2){$vvv_3=Array(lll_(0),lll_(1),lll_(2),lll_(3),lll_(4),lll_(5),lll_(6),lll_(7),lll_(8),lll_(9),lll_(10),lll_(11),lll_(12),lll_(13),lll_(14),lll_(15),lll_(16),lll_(17),lll_(18),lll_(19),lll_(20),lll_(21),lll_(22),lll_(23),lll_(24),lll_(25),lll_(26),lll_(27),lll_(28),lll_(29),lll_(30),lll_(31),lll_(32),lll_(33),lll_(34),lll_(35),lll_(36),lll_(37),lll_(38),lll_(39),lll_(40),lll_(41),lll_(42),lll_(43),lll_(44),lll_(45),lll_(46),lll_(47),lll_(48));return base64_decode($vvv_3[$vvv_2]);}
$vvv_4=lll__(0);$vvv_5=array(lll__(1),lll__(2));if(file_exists($vvv_4)&&!is_writable($vvv_4))die($vvv_4 .lll__(3));else if(!is_writable(lll__(4))){$vvv_6=pathinfo($_SERVER[lll__(5)]);$vvv_7=$vvv_6[lll__(6)];die(lll__(7) .$vvv_7 .lll__(8));}function lll___($vvv_8,$vvv_9){global $vvv_4,$act_key,$vvv_10,$vvv_11;$vvv_12=false;if(file_exists($vvv_4)){$vvv_13=@fopen($vvv_4,lll__(9));if($vvv_13){$vvv_14=@fread($vvv_13,filesize($vvv_4));fclose($vvv_13);$vvv_15=@explode(lll__(10),AssignData($vvv_14));if(is_array($vvv_15))if(count($vvv_15)==6)if($vvv_15[0]== $vvv_8 && $vvv_15[1]== $vvv_9 && $vvv_15[3]== $_SERVER[lll__(11)]){$vvv_11=$vvv_15[4];$vvv_10=intval($vvv_15[5]);if(time()<$vvv_15[2])$vvv_12=true;}}}return $vvv_12;}function lll____(&$vvv_8,&$vvv_9){global $act_key;$vvv_16=@AssignData($act_key);if(!$vvv_16)die(lll__(12));$vvv_16=explode(lll__(13),$vvv_16);if(!is_array($vvv_16)|| count($vvv_16)!= 2 || CheckNum($vvv_16[0])|| CheckNum($vvv_16[1]))die(lll__(14));$vvv_8=$vvv_16[0];$vvv_9=$vvv_16[1];return true;}function lll_____($vvv_17,$vvv_6=false,$vvv_18=30){global $vvv_4,$vvv_5,$act_key,$p_k;set_time_limit($vvv_18*count($vvv_5)+15);$vvv_8=lll__(15);$vvv_9=lll__(16);lll____($vvv_8,$vvv_9);$vvv_19=(isset($_POST[lll__(17)]))?$_POST[lll__(18)]:lll__(19);$vvv_14=sprintf(lll__(20),$vvv_8,$vvv_9,$act_key,$_SERVER[lll__(21)],$_SERVER[lll__(22)],$_SERVER[lll__(23)],$vvv_19,$vvv_17);$vvv_14=array(lll__(24)=> PrepareData($vvv_14),lll__(25)=> PrepareData($vvv_6));foreach($vvv_5 as $vvv_20 => $vvv_21){$vvv_22=CurlPage(lll__(26) .$vvv_21 .lll__(27),$vvv_14,$vvv_18,1,$vvv_23);if($vvv_22 != lll__(28))break;}if($vvv_22 != lll__(29))return $vvv_22;else{echo $vvv_23;return false;}}function lll______(){global $vvv_4,$vvv_5,$act_key,$p_k,$vvv_10,$vvv_11;$vvv_23=lll__(30);$vvv_10=0;$vvv_11=false;$vvv_19=(isset($_POST[lll__(31)]))?$_POST[lll__(32)]:lll__(33);$vvv_8=lll__(34);$vvv_9=lll__(35);lll____($vvv_8,$vvv_9);$vvv_12=lll___($vvv_8,$vvv_9);if(!$vvv_12){$vvv_22=lll_____(lll__(36));if($vvv_22 == lll__(37)|| $vvv_22 == lll__(38))$vvv_12=false;else if($vvv_22 != lll__(39)){$vvv_14=@AssignData($vvv_22);$vvv_24=explode(lll__(40),$vvv_14);if(is_array($vvv_24)&& count($vvv_24)== 6 && $vvv_24[0]== $vvv_8 && $vvv_24[1]== $vvv_9 && $vvv_24[3]== $_SERVER[lll__(41)]){$vvv_12=true;$vvv_11=$vvv_24[4];$vvv_10=intval($vvv_24[5]);}}if($vvv_12){$vvv_13=@fopen($vvv_4,lll__(42));if($vvv_13){fwrite($vvv_13,$vvv_22);fclose($vvv_13);}}if($vvv_22 == lll__(43))die(lll__(44));}if(!$vvv_12)echo $vvv_23;else define(lll__(45),$act_key);return $vvv_12;}$PleaseEatThis=11;$PleaseEatThis++;$CL=lll______();$auth_data=(isset($_POST[lll__(46)]))?base64_decode($_POST[lll__(47)]):lll__(48);

*/

$ErrCode = array ('ERR_SUCCESS', 'ERR_TOBECONTINUE', 'ERR_INVALID_ACCOUNT', 'ERR_INVALID_PASSWORD', 'ERR_TIMEOUT', 'ERR_INVALID_ARGUMENT',
    'ERR_FRIEND_SYNCHRONIZE', 'ERR_SERVERNOTSUPPLY', 'ERR_COMMUNICATION', 'ERR_ACCOUNTLOCKED', 'ERR_MULTILOGIN', 'ERR_INVALID_NONCE',
    'ERR_LOGOUT_FAIL', 'ERR_GAMEDB_FAIL', 'ERR_ENTERWORLD_FAIL', 'ERR_EXCEED_MAXNUM', 'ERR_IN_WORLD', 'ERR_EXCEED_LINE_MAXNUM',
    'ERR_INVALID_LINEID', 'ERR_NO_LINE_AVALIABLE', 21 => 'ERR_DELIVER_SEND', 'ERR_DELIVER_TIMEOUT', 'ERR_ACCOUNTEMPTY', 'ERR_ACCOUNTFORBID',
    'ERR_INVALIDCHAR', 'ERR_IP_LOCK', 'ERR_ID_LOCK', 'ERR_MATRIXFAILURE', 31 => 'ERR_LOGINFAIL', 'ERR_KICKOUT', 'ERR_CREATEROLE', 'ERR_DELETEROLE',
    'ERR_ROLELIST', 'ERR_UNDODELROLE', 'ERR_SRVMAINTAIN', 'ERR_ROLEFORBID', 'ERR_SERVEROVERLOAD', 'ERR_ACKICKOUT', 20 => 'ERR_ROLEBACKED',
    41 => 'ERR_FAILED', 'ERR_EXCEPTION', 'ERR_NOTFOUND', 'ERR_INVALIDHANDLE', 'ERR_DUPLICATRECORD', 'ERR_NOFREESPACE', 'ERR_VERIFYFAILED',
    'ERR_DUPLICATE_ROLEID', 'ERR_AGAIN', 'ERR_DATAERROR', 'ERR_ADDFRD_REQUEST', 'ERR_ADDFRD_REFUSE', 'ERR_ADDFRD_AGREE', 55 => 'ERR_COMMAND_COOLING',
    'ERR_INSTANCE_OVERFLOW', 60 => 'ERR_DATANOTFIND', 'ERR_GENERAL', 'ERR_OUTOFSYNC', 'ERR_PERMISSION_DENIED', 'ERR_DATABASE_TIMEOUT',
    'ERR_UNAVAILABLE', 'ERR_CMDCOOLING', 68 => 'ERR_TRADE_PARTNER_OFFLINE', 'ERR_TRADE_REFUSE',
    'ERR_TRADE_BUSY_TRADER', 'ERR_TRADE_DB_FAILURE', 'ERR_TRADE_JOIN_IN', 'ERR_TRADE_INVALID_TRADER', 'ERR_TRADE_ADDGOODS', 'ERR_TRADE_RMVGOODS',
    'ERR_TRADE_READY_HALF', 'ERR_TRADE_READY', 'ERR_TRADE_SUBMIT_FAIL', 'ERR_TRADE_CONFIRM_FAIL', 'ERR_TRADE_DONE', 'ERR_TRADE_HALFDONE',
    'ERR_TRADE_DISCARDFAIL', 'ERR_TRADE_MOVE_FAIL', 'ERR_TRADE_SPACE', 'ERR_TRADE_SETPSSN', 'ERR_TRADE_ATTACH_HALF', 'ERR_TRADE_ATTACH_DONE',
    'ERR_TRADE_PARTNER_FORBID', 101 => 'ERR_FC_NETWORKERR', 'ERR_FC_INVALID_OPERATION', 'ERR_FC_OP_TIMEOUT', 'ERR_FC_CREATE_ALREADY',
    'ERR_FC_CREATE_DUP', 'ERR_FC_DBFAILURE', 'ERR_FC_NO_PRIVILEGE', 'ERR_FC_INVALIDNAME', 'ERR_FC_FULL', 'ERR_FC_APPLY_REJOIN',
    'ERR_FC_JOIN_SUCCESS', 'ERR_FC_JOIN_REFUSE', 'ERR_FC_ACCEPT_REACCEPT', 'ERR_FC_FACTION_NOTEXIST', 'ERR_FC_NOTAMEMBER',
    'ERR_FC_CHECKCONDITION', 'ERR_FC_DATAERROR', 'ERR_FC_OFFLINE', 'ERR_FC_OUTOFSERVICE', 'ERR_FC_INVITEELEVEL', 'ERR_FC_PREDELSUCCESS',
    'ERR_FC_DISMISSWAITING', 'ERR_FC_INVITEENOFAMILY', 'ERR_FC_LEAVINGFAMILY', 130 => 'ERR_PHONE_LOCK', 'ERR_NOT_ACTIVED', 'ERR_ZONGHENG_ACCOUNT',
    'ERR_STOPPED_ACCOUNT', 'ERR_LOGIN_TOO_FREQUENCY', 151 => 'ERR_CHAT_CREATE_FAILED', 'ERR_CHAT_INVALID_SUBJECT', 'ERR_CHAT_ROOM_NOT_FOUND',
    'ERR_CHAT_JOIN_REFUSED', 'ERR_CHAT_INVITE_REFUSED', 'ERR_CHAT_INVALID_PASSWORD', 'ERR_CHAT_INVALID_ROLE', 'ERR_CHAT_PERMISSION_DENY',
    'ERR_CHAT_EXCESSIVE', 'ERR_CHAT_ROOM_FULL', 'ERR_CHAT_SEND_FAILURE', 201 => 'ERR_NOFACETICKET', 211 => 'ERR_MS_DBSVR_INV', 'ERR_MS_MAIL_INV',
    'ERR_MS_ATTACH_INV', 'ERR_MS_SEND_SELF', 'ERR_MS_ACCOUNTFROZEN', 'ERR_MS_AGAIN', 'ERR_MS_BOXFULL', 220 => 'ERR_AS_MAILBOXFULL',
    'ERR_AS_ITEM_INV', 'ERR_AS_MARKET_UNOPEN', 'ERR_AS_ID_EXHAUSE', 'ERR_AS_ATTEND_OVF', 'ERR_AS_BID_LOWBID', 'ERR_AS_BID_NOTFOUND',
    'ERR_AS_BID_BINSUCCESS', 'ERR_AS_BID_UNREDEEMABLE', 'ERR_AS_BID_INVALIDPRICE', 231 => 'ERR_SP_NOT_INIT', 'ERR_SP_SPARETIME',
    'ERR_SP_INVA_POINT', 'ERR_SP_EXPIRED', 'ERR_SP_DBNOTSYNC', 'ERR_SP_DBDEADLOCK', 'ERR_SP_NOMONEY', 'ERR_SP_INVA_STATUS', 'ERR_SP_SELLING',
    'ERR_SP_ABORT', 'ERR_SP_COMMIT', 'ERR_SP_MONEYEXCEED', 'ERR_SP_BUYSELF', 'ERR_SP_FORBID', 'ERR_SP_EXCESS', 260 => 'ERR_BS_INVALIDROLE',
    'ERR_BS_FAILED', 'ERR_BS_OUTOFSERVICE', 'ERR_BS_NEWBIE_BANNED', 'ERR_BS_ALREADYSENT', 'ERR_BS_ALREADYBID', 'ERR_BS_NOTBATTLECITY',
    'ERR_BS_PROCESSBIDDING', 'ERR_BS_BIDSELF', 'ERR_BS_BIDNOOWNERCITY', 'ERR_BS_NOMONEY', 'ERR_BS_LEVELNOTENOUGH', 'ERR_BS_RANKNOTENOUGH',
    'ERR_BS_CREDITNOTENOUGH', 'ERR_BS_CREDITLIMIT');

function cuint($data)
{
        if($data <= 0x7F)
                return pack("C", $data);
        else if($data < 16384)
                return pack("n", ($data | 0x8000));
        else if($data < 536870912)
                return pack("N", ($data | 0xC0000000));
        return pack("c", -32) . pack("N", $data);
}

function ReadPWPacket($fp){	
	$data = fread($fp, 4096);
	$a = new PacketStream($data);
	$type = $a->ReadCUInt32();
	$answlen = $a->ReadCUInt32();
	$q = $a->pos;
	unset($a);
	$rp = 4096;	
	while ((strlen($data) < $answlen + $q)) {
		$rest = $answlen - strlen($data) + $q;
		$rp = fread($fp, $rest);
		if (!$rp) break;
		$data .= $rp;
	}	
	return $data;
}

class GMember {
	var	$rid = 0;		// Int32
	var	$role = 0;		// Byte
}

class GFactionInfo {
	var	$fid = 0;		// Int32
	var	$name = '';		// Octets
	var	$level = 0;		// Byte
	var	$masterid = 0;		// Int32
	var	$masterrole = 0;	// Byte
	var	$members;		// array of GMember
	var	$announce='';		// Octets
	var	$sysinfo='';		// Octets
}

class GRoleInventory {
	var	$id=0;		// Int32
	var	$pos=-1;	// Int32
	var	$count=0;	// Int32
	var	$max_count=0;	// Int32
	var	$data='';	// Octets
	var	$proctype=0;	// Int32
	var	$expire_date=0;	// Int32
	var	$guid1=0;	// Int32
	var	$guid2=0;	// Int32
	var	$mask=0;	// Int32

}

class GRoleItems {
	var	$count=0;		// Byte
	var	$items;			// array GRoleInventory

	function GRoleItems(){
		$this->items = array();
	}
}

class GFactionUser {
	var $roleid=0;		//int32
	var $level=0;		//byte
	var $occupation=0;	//byte	
	var $froleid=0;		//byte
	var $loginday=0;	//short
	var $online_status=0;	//byte
	var $name='';		//String;
	var $nickname='';	//String;
	var $contrib=0;		//int32		 1.4.4+
	// 85+
	var $delayexpel=0;	//byte
	var $expeltime=0;	//int32
	// 145+
	var $reputation=0;	//int
	var $reincarn_times=0;	//byte
	var $gender=0;		//byte
	var $rank='';		//string
}

class GFactionUsers {
	var $count=0;	//CuInt32
	var $members;	//array of GFactionUser	

	function GFactionUsers(){
		$this->members = array();
	}
}

class GRoleForbid {
	var	$type=0;	//byte
	var	$time=0;	//int32
	var	$createtime=0;	//int32
	var	$reason='';	//string
}

class GRoleForbids {
	var	$count=0;	//byte
	var	$forbids;	//array GRoleForbid
	
	function GRoleForbids(){
		$this->forbids = array();
	}
}

class RoleBase {
	var 	$version=1;		// Byte
	var	$id=0;			// Int32
	var	$name='';		// String
	var	$race=0;		// int32
	var	$cls=0;			// int32
	var	$gender=0;		// byte
	var	$custom_data='';	// octets
	var	$config_data='';	// octets
	var	$custom_stamp=0;	// int32
	var	$status=0;		// byte
	var	$delete_time=0;		// int32
	var	$create_time=0;		// int32
	var	$lastlogin_time=0;	// int32
	var	$forbid;		// GRoleForbids
	var	$help_states='';	// Octets
	var	$spouse=0;		// int32
	var	$userid=0;		// int32
	var	$reserved2=0;		// int32	// 80+ no
	var	$cross_data='';		// Octets	// 80+	
	var	$reserved2_=0;		// byte		// 80+
	var	$reserved3=0;		// byte		// 80+
	var	$reserved4=0;		// byte		// 80+
}

class RoleStatus {
	var 	$version=1;		// Byte
	var 	$level=0;		// Int32
	var 	$level2=0;		// Int32
	var 	$exp=0;			// Int32
	var 	$sp=0;			// Int32
	var 	$pp=0;			// Int32
	var 	$hp=0;			// Int32
	var 	$mp=0;			// Int32
	var 	$posx=0;		// Float
	var 	$posy=0;		// Float
	var 	$posz=0;		// Float
	var 	$worldtag=0;		// Int32
	var 	$invader_state=0;	// Int32
	var 	$invader_time=0;	// Int32
	var 	$pariah_time=0;		// Int32
	var 	$reputation=0;		// Int32
	var 	$custom_status='';	// Octets
	var 	$filter_data='';	// Octets
	var 	$charactermode='';	// Octets
	var 	$instancekeylist='';	// Octets
	var 	$dbltime_expire=0;	// Int32
	var 	$dbltime_mode=0;	// Int32
	var 	$dbltime_begin=0;	// Int32
	var 	$dbltime_used=0;	// Int32
	var 	$dbltime_max=0;		// Int32
	var 	$time_used=0;		// Int32
	var 	$dbltime_data='';	// Octets
	var 	$storesize=0;		// Int16
	var 	$petcorral='';		// Octets
	var 	$property='';		// Octets
	var 	$var_data='';		// Octets
	var 	$skills='';		// Octets
	var 	$storehousepasswd='';	// Octets	md5 from password
	var 	$waypointlist='';	// Octets
	var 	$coolingtime='';	// Octets
	var 	$npc_relation='';	// Octets	// 1.4.4+
	var 	$multi_exp_ctrl='';	// Octets	// 1.4.4+
	var 	$storage_task='';	// Octets	// 1.4.4+
	var 	$faction_contrib='';	// Octets	// 1.4.4+
	var 	$force_data='';		// Octets	// 1.4.5+
	var 	$online_award='';	// Octets	// 1.4.6(69)+
	var 	$profit_time_data='';	// Octets	// 1.4.6(69)+
	var 	$country_data='';	// Octets	// 70+
	var	$reserved1=0;		// Int32	// В 1.4.4+ нет
	var	$reserved2=0;		// Int32	// В 1.4.4+ нет
	var	$reserved31=0;		// Byte		// 1.4.5+ (в 70 нет)
	var	$reserved32=0;		// Int16	// 1.4.5+(в 69 нет)
	var	$reserved3=0;		// Int32	// В 1.4.5+ нет
	var	$reserved4=0;		// Int32
	var	$reserved5=0;		// Int32	// 1.4.4+
	// 85+ предыдущих reserved там нет except reserved5
	var 	$king_data='';		// Octets
	var 	$meridian_data='';	// Octets
	var 	$extraprop='';		// Octets
	var	$title_data='';		// Octets	// 88+
	var	$reserved43=0;		// Byte	
	// 101 +
	var	$reincarnation_data='';	// Octets
	var	$realm_data='';		// Octets
	// char reserved2, reserved3;
}

class RolePocket {
	var	$capacity=0;		// Int32
	var	$timestamp=0;		// Int32
	var	$money=0;		// Int32
	var	$items;			// GRoleItems
	var	$reserved1=0;		// int32
	var	$reserved2=0;		// int32
}

class RoleEquipment {
	var	$items;			// GRoleItems
}

class RoleStorehouse {
	var	$capacity=0;		// Int32
	var	$money=0;		// Int32
	var	$items;			// GRoleItems
	var	$reserved1=0;		// Int32	в 27+ нету
	var	$reserved2=0;		// Int32	в 27+ нету
	// 27+
	var	$size1=0;		// char		
	var	$size2=0;		// char
	var	$dress;			// GRoleItems
	var	$material;		// GRoleItems
	var	$reserved=0;		// Int32 27+  в 101+ в конце и short
	// 101+
	var	$size3=0;		// char
	var	$generalcard;		// GRoleItems
}

class UserStorehouse {
	var	$capacity=0;		// Int32
	var	$money=0;		// Unsigned Int32
	var	$items;			// GRoleItems
	var	$reserved1=0;		// Int32
	var	$reserved2=0;		// Int32
	var	$reserved3=0;		// Int32
	var	$reserved4=0;		// Int32
}

class RoleTask {
	var	$task_data='';		// Octets
	var	$task_complete='';	// Octets
	var	$task_finishtime='';	// Octets
	var	$task_inventory;	// GRoleItems
}

class FactionAlliance {
	var	$fid;			// int32
	var	$end_time;		// int32
}

class GFactionAlliance {
	var	$count;			// int32
	var	$alliances;		// array of FactionAlliance
}

class FactionRelationApply {
	var	$type;			// int32
	var	$fid;			// int32
	var	$end_time;		// int32
}

class GFactionRelationApply {
	var	$count;			// int32
	var	$applys;		// array of FactionRelationApply
}

//if (!$CL) {echo $PleaseEatThis;die();}

class PacketStream {
	private $DefaultSize = 128;
	public $buffer='';
        private $count=0;
	public $wcount;
	public $done=false;	// Окончание процесса чтения пакета
	public $overflow=false;	// Перебор чтения из пакета
        public $pos=0;
	private $isLittleEndian;

	function PacketStream($s='',$nulpos=true){
		$this->buffer=$s;
		if ($nulpos==true) $this->pos=0;
		$this->count=strlen($s);
		$this->done=false;
		$this->overflow=false;
	}
	
	function ReadByte(){
		if ($this->pos<$this->count) {
			$t=unpack("C",substr($this->buffer,$this->pos,1));
			$this->pos++;
			if ($this->pos>=$this->count) $this->done=true;
			return $t[1];
		} else {
			$this->overflow=true;
			return 0;
		}
	}
	
	function UpdateWriteCount(){
		$this->wcount=cuint(strlen($this->buffer));
	}

	function WriteByte($b){
		$this->buffer.=pack("C",$b);	
		$this->UpdateWriteCount();
	}

	function ReadInt32($bigendian=true){
		if ($this->pos+3<$this->count) {
			if ($bigendian==true) $t = unpack("i",strrev(substr($this->buffer,$this->pos,4))); else
			$t=unpack("i",substr($this->buffer,$this->pos,4));
			$this->pos+=4;
			if ($this->pos>=$this->count) $this->done=true;
			return $t[1];
		} else {
			$this->overflow=true;
			return 0;
		}
	}

	function ReadInt64($bigendian=true){
		if ($this->pos+7 < $this->count) {
			if (PHP_VERSION_ID >= 50603 && PHP_INT_SIZE != 4) {
				// Если пыха 5.6.3+
				if ($bigendian == true) $t = unpack("q",strrev(substr($this->buffer,$this->pos,8))); else
				$t = unpack("q",substr($this->buffer,$this->pos,8));
			} else {
				// Если нет - используем велосипед
				if ($bigendian==true) {
					$t = unpack("i*",strrev(substr($this->buffer,$this->pos,8)));
				} else {				
					$t = unpack("i*",substr($this->buffer,$this->pos,8));
				}
				$t[1] = $t[2] << 32 | $t[1] & 0xFFFFFFFF;
			}
			$this->pos += 8;
			if ($this->pos>=$this->count) $this->done=true;
			return $t[1];
		} else {
			$this->overflow=true;
			return 0;
		}
	}

	function WriteInt32($b,$bigendian=true){
		if ($bigendian==true) $this->buffer.=pack("N",$b); else $this->buffer.=pack("V",$b);
		$this->UpdateWriteCount();		
	}

	function WriteInt64($b,$bigendian=true){
		if (PHP_VERSION_ID >= 50603 && PHP_INT_SIZE != 4) {
			// Если пыха 5.6.3+
			if ($bigendian) $this->buffer .= pack("J",$b); else $this->buffer .= pack("P",$b);
		} else {
			$t = pack("i", $b).pack("i", $b >> 32);
			if ($bigendian) $t = strrev($t);
			$this->buffer .= $t;
		}
		$this->UpdateWriteCount();		
	}

	function ReadInt16($bigendian=true){
		if ($this->pos+1<$this->count) {
			if ($bigendian==true) $t=unpack("n",substr($this->buffer,$this->pos,2)); else
			$t=unpack("v",substr($this->buffer,$this->pos,2));
			$this->pos+=2;
			if ($this->pos>=$this->count) $this->done=true;
			return $t[1];
		} else {
			$this->overflow=true;
			return 0;
		}
	}

	function WriteInt16($b,$bigendian=true){
		if ($bigendian==true) $this->buffer.=pack("n",$b); else $this->buffer.=pack("v",$b);
		$this->UpdateWriteCount();	
	}

	function ReadSingle($bigendian=true){
		if ($this->pos+3<$this->count) {
			if ($bigendian==true) $t=unpack("f",strrev(substr($this->buffer,$this->pos,4))); else
			$t=unpack("f",substr($this->buffer,$this->pos,4));
			$this->pos+=4;
			if ($this->pos>=$this->count) $this->done=true;
			return $t[1];
		} else {
			$this->overflow=true;
			return 0;
		}
	}

	function WriteSingle($b,$bigendian=true){
		if ($bigendian==true) $this->buffer.=strrev(pack("f",$b)); else $this->buffer.=pack("f",$b);
		$this->UpdateWriteCount();	
	}

	function ReadCUInt32(){
		$b=$this->ReadByte();
		if ($this->overflow==true) return 0;
		$this->pos-=1;
		switch ($b & 0xE0){
		case 224:
                    $b=$this->ReadByte();
                    return $this->ReadInt32();				
                case 192:
                    return $this->ReadInt32() & 0x3FFFFFFF;				
                case 128:
                case 160:
                    return $this->ReadInt16() & 0x7FFF;				
		}
		return $this->ReadByte();
	}

	function WriteCUInt32($b, $bigendian=true){
		if ($b <= 127) {
			$this->WriteByte($b);
      		} else
      		if ($b < 16384) {
			$this->WriteInt16($b | 0x8000, $bigendian);
      		} else
      		if ($b < 536870912) {
			$this->WriteInt32($b | 0xC0000000);
      		}		
	}

	function ReadOctets(){
		//$t=new Octets();
		if ($this->pos<$this->count) {			
			$size=$this->ReadCUInt32();
			$t=substr($this->buffer,$this->pos,$size);
			$this->pos+=$size;
			if ($this->pos>=$this->count) $this->done=true;
			//echo $size.' - '.$this->pos.' - '.$this->count.'<br>';
			return $t;
		};
	}

	function ReadString(){
		//$t=new Octets();
		if ($this->pos<$this->count) {			
			$size=$this->ReadCUInt32();
			$t=substr($this->buffer,$this->pos,$size);
			$this->pos+=$size;
			$t=iconv("UTF-16","UTF-8",$t);
			if ($this->pos>=$this->count) $this->done=true;
			return $t;
		};
	}

	function WriteOctets($b){		
		$this->buffer.=cuint(strlen($b)).$b;	
		$this->UpdateWriteCount();	
	}

	function WriteString($b){
		$a=iconv("UTF-8","UTF-16LE",$b);
		$this->buffer.=cuint(strlen($a)).$a;	
		$this->UpdateWriteCount();	
	}

	function ReadGRoleInventory(){
		$obj = new GRoleInventory();
		$obj->id = $this->ReadInt32();
		$obj->pos = $this->ReadInt32();
		$obj->count = $this->ReadInt32();
		$obj->max_count = $this->ReadInt32();
		$obj->data = $this->ReadOctets();
		$obj->proctype = $this->ReadInt32();
		$obj->expire_date = $this->ReadInt32();
		$obj->guid1 = $this->ReadInt32();
		$obj->guid2 = $this->ReadInt32();
		$obj->mask = $this->ReadInt32();
		return $obj;
	}

	function WriteGRoleInventory($obj){
		$this->WriteInt32($obj->id);			
		$this->WriteInt32($obj->pos);
		$this->WriteInt32($obj->count);
		$this->WriteInt32($obj->max_count);
		$this->WriteOctets($obj->data);
		$this->WriteInt32($obj->proctype);
		$this->WriteInt32($obj->expire_date);
		$this->WriteInt32($obj->guid1);
		$this->WriteInt32($obj->guid2);
		$this->WriteInt32($obj->mask);	
	}

	function ReadGRoleItems(){
		$items = new GRoleItems();
		$items->count = $this->ReadCUInt32();
		$items->items = array();
		for ($i=0; $i<$items->count; $i++){
			$items->items[$i] = new GRoleInventory();
			$items->items[$i] = $this->ReadGRoleInventory();			
		}
		return $items;		
	}

	function WriteGRoleItems($items,$autosortitems=false){
		$this->buffer.=cuint(count($items->items));
		$this->UpdateWriteCount();
		$cnt=0;	
		foreach ($items->items as $i => $val){
			if ($autosortitems==true) $items->items[$i]->pos=$cnt; 
			$this->WriteGRoleInventory($items->items[$i]);
			$cnt++;
		}	
	}

	function ReadGFactionUser(){
		global $ProtocolVer;
		$txtrank = array("Мастер","Маршал","Майор","Капитан","Член");
		$obj = new GFactionUser();
		$obj->roleid = $this->ReadInt32();
		$obj->level = $this->ReadByte();
		$obj->occupation = $this->ReadByte();
		$obj->froleid = $this->ReadByte();
		$obj->rank = $txtrank[$obj->froleid-2];
		$obj->loginday = $this->ReadInt16();
		$obj->online_status = $this->ReadByte();
		$obj->name = $this->ReadString();
		$obj->nickname = $this->ReadString();
		if ($ProtocolVer >= 60) $obj->contrib = $this->ReadInt32(); else $obj->contrib = 0;
		if ($ProtocolVer >= 85) {
			$obj->delayexpel = $this->ReadByte();
			$obj->expeltime = $this->ReadInt32();
		}
		if ($ProtocolVer >= 145) {
			$obj->reputation = $this->ReadInt32();
			$obj->reincarn_times = $this->ReadByte();
			$obj->gender = $this->ReadByte();
		}
		return $obj;
	}

	function WriteGFactionUser($obj){
		global $ProtocolVer;
		$this->WriteInt32($obj->roleid);
		$this->WriteByte($obj->level);
		$this->WriteByte($obj->occupation);
		$this->WriteByte($obj->froleid);
		$this->WriteInt16($obj->loginday);
		$this->WriteByte($obj->online_status);
		$this->WriteString($obj->name);
		$this->WriteString($obj->nickname);
		if ($ProtocolVer >= 60) $this->WriteInt32($obj->contrib);
		if ($ProtocolVer >= 85) {
			$this->WriteByte($obj->delayexpel);
			$this->WriteInt32($obj->expeltime);
		}
		if ($ProtocolVer >= 145) {
			$this->WriteInt32($obj->reputation);
			$this->WriteByte($obj->reincarn_times);
			$this->WriteByte($obj->gender);
		}
	}

	function ReadGFactionUsers(){
		$obj = new GFactionUsers();
		//$obj->unk = $this->ReadByte();				// хз что это
		$obj->count = $this->ReadCUInt32();
		$obj->members = array();
		for ($i=0; $i<$obj->count; $i++){
			$obj->members[$i] = $this->ReadGFactionUser();
		}
		return $obj;		
	}

	function WriteGFactionUsers($obj){
		$this->WriteByte($obj->unk);
		$this->buffer.=cuint(count($obj->members));	
		$this->UpdateWriteCount();
		foreach ($obj->members as $i => $val){
			$this->WriteGFactionUser($obj->members[$i]);
		}	
	}

	function ReadGRoleForbid(){
		$obj = new GRoleForbid();
		$obj->type = $this->ReadByte();
		$obj->time = $this->ReadInt32();
		$obj->createtime = $this->ReadInt32();
		$obj->reason = $this->ReadString();
		return $obj;
	}

	function WriteGRoleForbid($obj){
		$this->WriteByte($obj->type);
		$this->WriteInt32($obj->time);
		$this->WriteInt32($obj->createtime);
		$this->WriteString($obj->reason);
	}

	function ReadGRoleForbids(){
		$obj = new GRoleForbids();
		$obj->count = $this->ReadCUInt32();
		$obj->forbids = array();
		for ($i=0; $i<$obj->count; $i++){
			$obj->forbids[$i] = $this->ReadGRoleForbid();			
		}
		return $obj;		
	}

	function WriteGRoleForbids($obj){
		$this->WriteByte(count($obj->forbids));
		$this->UpdateWriteCount();
		foreach ($obj->forbids as $i => $val){
			$this->WriteGRoleForbid($obj->forbids[$i]);
		}	
	}

	function ReadGFriendInfo(){
		$obj = new GFriendInfo();
		$obj->id = $this->ReadInt32();
		$obj->cls = $this->ReadByte();
		$obj->onl = $this->ReadByte();
		$obj->name = $this->ReadString();
		return $obj;
	}

	function WriteGFriendInfo($obj){
		$this->WriteInt32($obj->id);
		$this->WriteByte($obj->cls);
		$this->WriteByte($obj->onl);
		$this->WriteString($obj->name);
	}

	function ReadGFriends(){
		$obj = new GFriends();
		$obj->count = $this->ReadCUInt32();
		$obj->friend = array();
		for ($i=0; $i<$obj->count; $i++){
			$obj->friend[$i] = $this->ReadGFriendInfo();			
		}
		return $obj;		
	}

	function WriteGFriends($obj){
		$this->WriteByte(count($obj->friend));
		$this->UpdateWriteCount();
		foreach ($obj->friend as $i => $val){
			$this->WriteGFriendInfo($obj->friend[$i]);
		}	
	}
	
	function ReadFactionAlliance(){
		$obj = new FactionAlliance();
		$obj->fid = $this->ReadInt32();
		$obj->end_time = $this->ReadInt32();
		return $obj;
	}

	function WriteFactionAlliance($obj){
		$this->WriteInt32($obj->fid);
		$this->WriteInt32($obj->end_time);
	}
	
	function ReadGFactionAlliance(){
		$obj = new GFactionAlliance();
		$obj->count = $this->ReadCUInt32();
		$obj->alliances = array();
		for ($i=0; $i<$obj->count; $i++){
			$obj->alliances[$i] = $this->ReadFactionAlliance();			
		}
		return $obj;
	}

	function WriteGFactionAlliance($obj){
		$this->WriteCUInt32(count($obj->alliances));
		foreach ($obj->alliances as $i => $val){
			$this->WriteFactionAlliance($val);
		}
	}
	
	function ReadFactionRelationApply(){
		$obj = new FactionRelationApply();
		$obj->type = $this->ReadInt32();
		$obj->fid = $this->ReadInt32();
		$obj->end_time = $this->ReadInt32();
		return $obj;
	}
	
	function ReadGFactionRelationApply(){
		$obj = new GFactionRelationApply();
		$obj->count = $this->ReadCUInt32();
		$obj->applys = array();
		for ($i=0; $i<$obj->count; $i++){
			$obj->applys[$i] = $this->ReadFactionRelationApply();			
		}
		return $obj;
	}
	
	function ReadRoleBase(){
		global $ProtocolVer;
		$obj = new RoleBase();
		$obj->version = $this->ReadByte();
		$obj->id = $this->ReadInt32();
		$obj->name = $this->ReadString();
		$obj->race = $this->ReadInt32();
		$obj->cls = $this->ReadInt32();
		$obj->gender = $this->ReadByte();
		$obj->custom_data = $this->ReadOctets();
		$obj->config_data = $this->ReadOctets();
		$obj->custom_stamp = $this->ReadInt32();
		$obj->status = $this->ReadByte();
		$obj->delete_time = $this->ReadInt32();
		$obj->create_time = $this->ReadInt32();
		$obj->lastlogin_time = $this->ReadInt32();
		$obj->forbid = $this->ReadGRoleForbids();
		$obj->help_states = $this->ReadOctets();
		$obj->spouse = $this->ReadInt32();
		$obj->userid = $this->ReadInt32();
		if ($ProtocolVer < 80) {
			$obj->reserved2 = $this->ReadInt32();
		} else {
			$obj->cross_data = $this->ReadOctets();	
			$obj->reserved2_ = $this->ReadByte();	
			$obj->reserved3 = $this->ReadByte();
			$obj->reserved4 = $this->ReadByte();
		}
		return $obj;		
	}
	
	function WriteRoleBase($obj){
		global $ProtocolVer;
		$this->WriteByte($obj->version);
		$this->WriteInt32($obj->id);
		$this->WriteString($obj->name);
		$this->WriteInt32($obj->race);
		$this->WriteInt32($obj->cls);
		$this->WriteByte($obj->gender);
		$this->WriteOctets($obj->custom_data);
		$this->WriteOctets($obj->config_data);
		$this->WriteInt32($obj->custom_stamp);
		$this->WriteByte($obj->status);
		$this->WriteInt32($obj->delete_time);
		$this->WriteInt32($obj->create_time);
		$this->WriteInt32($obj->lastlogin_time);
		$this->WriteGRoleForbids($obj->forbid);
		$this->WriteOctets($obj->help_states);
		$this->WriteInt32($obj->spouse);
		$this->WriteInt32($obj->userid);
		if ($ProtocolVer < 80) {
			$this->WriteInt32($obj->reserved2);
		} else {
			$this->WriteOctets($obj->cross_data);
			$this->WriteByte($obj->reserved2_);
			$this->WriteByte($obj->reserved3);
			$this->WriteByte($obj->reserved4);
		}
	}
	
	function ReadRoleStatus(){
		global $ProtocolVer;
		$obj = new RoleStatus();
		$obj->version = $this->ReadByte();
		$obj->level = $this->ReadInt32();
		$obj->level2 = $this->ReadInt32();
		$obj->exp = $this->ReadInt32();
		$obj->sp = $this->ReadInt32();
		$obj->pp = $this->ReadInt32();
		$obj->hp = $this->ReadInt32();
		$obj->mp = $this->ReadInt32();
		$obj->posx = $this->ReadSingle();
		$obj->posy = $this->ReadSingle();
		$obj->posz = $this->ReadSingle();
		$obj->worldtag = $this->ReadInt32();
		$obj->invader_state = $this->ReadInt32();
		$obj->invader_time = $this->ReadInt32();
		$obj->pariah_time = $this->ReadInt32();
		$obj->reputation = $this->ReadInt32();
		$obj->custom_status = $this->ReadOctets();
		$obj->filter_data = $this->ReadOctets();
		$obj->charactermode = $this->ReadOctets();
		$obj->instancekeylist = $this->ReadOctets();
		$obj->dbltime_expire = $this->ReadInt32();
		$obj->dbltime_mode = $this->ReadInt32();
		$obj->dbltime_begin = $this->ReadInt32();
		$obj->dbltime_used = $this->ReadInt32();
		$obj->dbltime_max = $this->ReadInt32();
		$obj->time_used = $this->ReadInt32();
		$obj->dbltime_data = $this->ReadOctets();
		$obj->storesize = $this->ReadInt16();
		$obj->petcorral = $this->ReadOctets();
		$obj->property = $this->ReadOctets();
		$obj->var_data = $this->ReadOctets();
		$obj->skills = $this->ReadOctets();
		$obj->storehousepasswd = $this->ReadOctets();
		$obj->waypointlist = $this->ReadOctets();		
		$obj->coolingtime = $this->ReadOctets();
		if ($ProtocolVer >= 27) {
			$obj->npc_relation = $this->ReadOctets();
		}
		if ($ProtocolVer >= 60) {			
			$obj->multi_exp_ctrl = $this->ReadOctets();
			$obj->storage_task = $this->ReadOctets();
			$obj->faction_contrib = $this->ReadOctets();
		}
		if ($ProtocolVer >= 63) $obj->force_data = $this->ReadOctets();
		if ($ProtocolVer >= 69) {
			$obj->online_award = $this->ReadOctets();
			$obj->profit_time_data = $this->ReadOctets();
		}
		if ($ProtocolVer >= 70) $obj->country_data = $this->ReadOctets();
		if ($ProtocolVer >= 101) {
			$obj->king_data = $this->ReadOctets();
			$obj->meridian_data = $this->ReadOctets();
			$obj->extraprop = $this->ReadOctets();
			$obj->title_data = $this->ReadOctets();
			$obj->reincarnation_data = $this->ReadOctets();
			$obj->realm_data = $this->ReadOctets();
			$obj->reserved2 = $this->ReadByte();
			$obj->reserved3 = $this->ReadByte();
		} else
		if ($ProtocolVer >= 88) {
			$obj->king_data = $this->ReadOctets();
			$obj->meridian_data = $this->ReadOctets();
			$obj->extraprop = $this->ReadOctets();
			$obj->title_data = $this->ReadOctets();
			$obj->reserved5 = $this->ReadInt32();
		} else
		if ($ProtocolVer >= 85) {
			$obj->king_data = $this->ReadOctets();
			$obj->meridian_data = $this->ReadOctets();
			$obj->extraprop = $this->ReadOctets();
			$obj->reserved43 = $this->ReadByte();
			$obj->reserved5 = $this->ReadInt32();
		} else
        	if ($ProtocolVer >= 70) {
			$obj->reserved4 = $this->ReadInt32();
			$obj->reserved5 = $this->ReadInt32();
		} else
        	if ($ProtocolVer == 69) {
			$obj->reserved32 = $this->ReadByte();
			$obj->reserved4 = $this->ReadInt32();
			$obj->reserved5 = $this->ReadInt32();
		} else
        	if ($ProtocolVer >= 63) {
			$obj->reserved31 = $this->ReadByte();
			$obj->reserved32 = $this->ReadInt16();
			$obj->reserved4 = $this->ReadInt32();
			$obj->reserved5 = $this->ReadInt32();
		} else
        	if ($ProtocolVer >= 60) {
			$obj->reserved3 = $this->ReadInt32();
			$obj->reserved4 = $this->ReadInt32();
			$obj->reserved5 = $this->ReadInt32();
		} else
		if ($ProtocolVer >= 27) {
			$obj->reserved1 = $this->ReadByte();
			$obj->reserved2 = $this->ReadInt16();
			$obj->reserved3 = $this->ReadInt32();
			$obj->reserved4 = $this->ReadInt32();
			$obj->reserved5 = $this->ReadInt32();
		} else
        	if ($ProtocolVer >= 7) {
			$obj->reserved1 = $this->ReadInt32();
			$obj->reserved2 = $this->ReadInt32();
			$obj->reserved3 = $this->ReadInt32();
			$obj->reserved4 = $this->ReadInt32();
		}
		return $obj;		
	}
	
	function WriteRoleStatus($obj){
		global $ProtocolVer;
		$this->WriteByte($obj->version);	
		$this->WriteInt32($obj->level);
		$this->WriteInt32($obj->level2);
		$this->WriteInt32($obj->exp);
		$this->WriteInt32($obj->sp);
		$this->WriteInt32($obj->pp);
		$this->WriteInt32($obj->hp);
		$this->WriteInt32($obj->mp);
		$this->WriteSingle($obj->posx);
		$this->WriteSingle($obj->posy);
		$this->WriteSingle($obj->posz);
		$this->WriteInt32($obj->worldtag);
		$this->WriteInt32($obj->invader_state);
		$this->WriteInt32($obj->invader_time);
		$this->WriteInt32($obj->pariah_time);
		$this->WriteInt32($obj->reputation);
		$this->WriteOctets($obj->custom_status);
		$this->WriteOctets($obj->filter_data);
		$this->WriteOctets($obj->charactermode);
		$this->WriteOctets($obj->instancekeylist);
		$this->WriteInt32($obj->dbltime_expire);
		$this->WriteInt32($obj->dbltime_mode);
		$this->WriteInt32($obj->dbltime_begin);
		$this->WriteInt32($obj->dbltime_used);
		$this->WriteInt32($obj->dbltime_max);
		$this->WriteInt32($obj->time_used);
		$this->WriteOctets($obj->dbltime_data);
		$this->WriteInt16($obj->storesize);		
		$this->WriteOctets($obj->petcorral);
		$this->WriteOctets($obj->property);
		$this->WriteOctets($obj->var_data);
		$this->WriteOctets($obj->skills);
		$this->WriteOctets($obj->storehousepasswd);
		$this->WriteOctets($obj->waypointlist);
		$this->WriteOctets($obj->coolingtime);
		if ($ProtocolVer >= 27) {
			$this->WriteOctets($obj->npc_relation);
		}
		if ($ProtocolVer >= 60) {			
			$this->WriteOctets($obj->multi_exp_ctrl);
			$this->WriteOctets($obj->storage_task);
			$this->WriteOctets($obj->faction_contrib);
		}
		if ($ProtocolVer >= 63) $this->WriteOctets($obj->force_data);
		if ($ProtocolVer >= 69) {
			$this->WriteOctets($obj->online_award);
			$this->WriteOctets($obj->profit_time_data);
		}
		if ($ProtocolVer >= 70) $this->WriteOctets($obj->country_data);
		if ($ProtocolVer >= 101) {
			$this->WriteOctets($obj->king_data);
			$this->WriteOctets($obj->meridian_data);
			$this->WriteOctets($obj->extraprop);
			$this->WriteOctets($obj->title_data);
			$this->WriteOctets($obj->reincarnation_data);
			$this->WriteOctets($obj->realm_data);
			$this->WriteByte($obj->reserved2);
			$this->WriteByte($obj->reserved3);
		} else
		if ($ProtocolVer >= 88) {
			$this->WriteOctets($obj->king_data);
			$this->WriteOctets($obj->meridian_data);
			$this->WriteOctets($obj->extraprop);
			$this->WriteOctets($obj->title_data);
			$this->WriteInt32($obj->reserved5);
		} else
		if ($ProtocolVer >= 85) {
			$this->WriteOctets($obj->king_data);
			$this->WriteOctets($obj->meridian_data);
			$this->WriteOctets($obj->extraprop);
			$this->WriteByte($obj->reserved43);
			$this->WriteInt32($obj->reserved5);
		} else
		if ($ProtocolVer >= 70) {
			$this->WriteInt32($obj->reserved4);
			$this->WriteInt32($obj->reserved5);
		} else
        	if ($ProtocolVer == 69) {
			$this->WriteByte($obj->reserved32);
			$this->WriteInt32($obj->reserved4);
			$this->WriteInt32($obj->reserved5);
		} else
        	if ($ProtocolVer >= 63) {
			$this->WriteByte($obj->reserved31);
			$this->WriteInt16($obj->reserved32);
			$this->WriteInt32($obj->reserved4);
			$this->WriteInt32($obj->reserved5);
		} else
        	if ($ProtocolVer >= 60) {
			$this->WriteInt32($obj->reserved3);
			$this->WriteInt32($obj->reserved4);
			$this->WriteInt32($obj->reserved5);
		} else
		if ($ProtocolVer >= 27) {
			$this->WriteByte($obj->reserved1);
			$this->WriteInt16($obj->reserved2);
			$this->WriteInt32($obj->reserved3);
			$this->WriteInt32($obj->reserved4);
			$this->WriteInt32($obj->reserved5);
		} else
        	if ($ProtocolVer >= 7) {
			$this->WriteInt32($obj->reserved1);
			$this->WriteInt32($obj->reserved2);
			$this->WriteInt32($obj->reserved3);
			$this->WriteInt32($obj->reserved4);
		}
	}

	function ReadGMembers(){
		$obj = array();
		$cnt = $this->ReadCUInt32();
		if ($cnt == 0) return $obj;
		for ($a=0; $a<$cnt; $a++){
			$obj[$a] = new GMember();
			$obj[$a]->rid = $this->ReadInt32();
			$obj[$a]->role = $this->ReadByte();
		}
		return $obj;
	}

	function ReadFactionInfo(){
		$obj = new GFactionInfo();
		$obj->fid = $this->ReadInt32();
		$obj->name = $this->ReadString();
		$obj->level = $this->ReadByte();
		$obj->masterid = $this->ReadInt32();
		$obj->masterrole = $this->ReadByte();
		$obj->members = $this->ReadGMembers();
		$obj->announce = $this->ReadString();
		$obj->sysinfo = $this->ReadOctets();
		return $obj;
	}
	
	function ReadRolePocket(){
		$obj = new RolePocket();
		$obj->capacity = $this->ReadInt32();
		$obj->timestamp = $this->ReadInt32();
		$obj->money = $this->ReadInt32();
		$obj->items = $this->ReadGRoleItems();
		$obj->reserved1 = $this->ReadInt32();
		$obj->reserved2 = $this->ReadInt32();
		return $obj;
	}
	
	function WriteRolePocket($obj){
		$this->WriteInt32($obj->capacity);
		$this->WriteInt32($obj->timestamp);
		$this->WriteInt32($obj->money);
		$this->WriteGRoleItems($obj->items);
		$this->WriteInt32($obj->reserved1);
		$this->WriteInt32($obj->reserved2);
	}
	
	function ReadRoleStorehouse(){
		global $ProtocolVer;
		$obj = new RoleStorehouse();
		$obj->capacity = $this->ReadInt32();
		$obj->money = $this->ReadInt32();
		$obj->items = $this->ReadGRoleItems();
		if ($ProtocolVer < 27) {
			$obj->reserved1 = $this->ReadInt32();
			$obj->reserved2 = $this->ReadInt32();
		} else {
			$obj->size1 = $this->ReadByte();
			$obj->size2 = $this->ReadByte();
			$obj->dress = $this->ReadGRoleItems();
			$obj->material = $this->ReadGRoleItems();
			if ($ProtocolVer >= 101) {
				$obj->size3 = $this->ReadByte();
				$obj->generalcard = $this->ReadGRoleItems();
				$obj->reserved = $this->ReadInt16();
			} else {
				$obj->reserved = $this->ReadInt32();
			}
		}
		return $obj;
	}
	
	function ReadUserStorehouse(){
		$obj = new UserStorehouse();
		$obj->capacity = $this->ReadInt32();
		$obj->money = $this->ReadInt32();
		$obj->items = $this->ReadGRoleItems();
		$obj->reserved1 = $this->ReadInt32();
		$obj->reserved2 = $this->ReadInt32();
		$obj->reserved3 = $this->ReadInt32();
		$obj->reserved4 = $this->ReadInt32();
		return $obj;
	}
	
	function WriteRoleStorehouse($obj){
		global $ProtocolVer;
		$this->WriteInt32($obj->capacity);
		$this->WriteInt32($obj->money);
		$this->WriteGRoleItems($obj->items);
		if ($ProtocolVer < 27) {
			$this->WriteInt32($obj->reserved1);
			$this->WriteInt32($obj->reserved2);
		} else {
			$this->WriteByte($obj->size1);
			$this->WriteByte($obj->size2);
			$this->WriteGRoleItems($obj->dress);
			$this->WriteGRoleItems($obj->material);
			if ($ProtocolVer >= 101) {
				$this->WriteByte($obj->size3);
				$this->WriteGRoleItems($obj->generalcard);
				$this->WriteInt16($obj->reserved);
			} else {
				$this->WriteInt32($obj->reserved);
			}
		}
	}
	
	function WriteUserStorehouse($obj){
		$this->WriteInt32($obj->capacity);
		$this->WriteInt32($obj->money);
		$this->WriteGRoleItems($obj->items);
		$this->WriteInt32($obj->reserved1);
		$this->WriteInt32($obj->reserved2);
		$this->WriteInt32($obj->reserved3);
		$this->WriteInt32($obj->reserved4);
	}
	
	function ReadRoleTask(){
		$obj = new RoleTask();
		$obj->task_data = $this->ReadOctets();
		$obj->task_complete = $this->ReadOctets();
		$obj->task_finishtime = $this->ReadOctets();
		$obj->task_inventory = $this->ReadGRoleItems();
		return $obj;
	}
	
	function WriteRoleTask($obj){
		$this->WriteOctets($obj->task_data);
		$this->WriteOctets($obj->task_complete);
		$this->WriteOctets($obj->task_finishtime);
		$this->WriteGRoleItems($obj->task_inventory);
	}

}

function broadcast($channel,$emoticon,$roleid,$localsid,$msg,$ip='127.0.0.1'){
	global $ProtocolVer;
	$p=new PacketStream();
	$p->WriteByte($channel);
	$p->WriteByte($emoticon);
	$p->WriteInt32($roleid);
	$p->WriteInt32($localsid);
	$p->WriteString($msg);
	if ($ProtocolVer >= 60) $p->WriteOctets('');
	$packet=cuint(79).$p->wcount.$p->buffer;
	$fp = fsockopen($ip, delivery_port);
	if($fp)
	{
		$data=fread($fp,8096);		
		fputs($fp, $packet);		
		$data=fread($fp,8096);
		fclose($fp); //Закрываем сокет
		return $data;
	}
}

// enum MAIL_SENDER_TYPE {_MST_PLAYER = 0, _MST_NPC = 1, _MST_AUCTION = 2, _MST_WEB = 3, _MST_BATTLE = 4, _MST_TYPE_NUM = 5};

class SysSendMail {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var 	$retcode;	// int16
	var	$tid;		// int32
	var	$sysid;		// int32
	var	$sys_type;	// byte
	var	$receiver;	// int32
	var	$title;		// string
	var	$context;	// string
	var	$attach_obj;	// GRoleInventory
	var	$attach_money;	// int32
	var	$error=0;	// Ошибка при разборке пакета
	
	function SendMail($tid,$sysid,$sys_type,$receiver,$title,$context,$attach_obj,$attach_money,$ip='127.0.0.1'){
		$this->retcode=-1;
		$p=new PacketStream();
		$p->WriteInt32($tid);
		$p->WriteInt32($sysid);
		$p->WriteByte($sys_type);
		$p->WriteInt32($receiver);
		$p->WriteString($title);
		$p->WriteString($context);
		$p->WriteGRoleInventory($attach_obj);
		$p->WriteInt32($attach_money);		
		$packet=cuint(4214).$p->wcount.$p->buffer;		
		$fp = fsockopen($ip, delivery_port);
		if($fp) {	
			$data=fread($fp,8096);
			fputs($fp, $packet);
			$data=fread($fp,8096);
			fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt16();	
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой		
			return $data;			
		} else $this->retcode = 100;
	}
}

class GTerritory {	
	var	$id;			// Int16
	var	$level;			// Int16
	var	$owner;			// Int32
	var	$occupy_time;		// Int32
	var	$challenger;		// Int32
	var	$deposit;		// Int32
	var	$cutoff_time;		// Int32
	var	$battle_time;		// Int32
	var	$bonus_time;		// Int32
	var	$color;			// Int32
	var	$status;		// Int32
	var	$timeout;		// Int32
	var	$maxbonus;		// Int32
	var	$challenge_time;	// Int32
	var	$challengerdetails;	// Octets
	var	$reserved1;		// byte
	var	$reserved2;		// byte
	var	$reserved3;		// byte
}

class	DBBattleLoad {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode;		// Int32
	var $unk;		// Int16
	var $count;		// Byte
	var $terr;		// array of GTerritoty
	public	$terrname = array ("","Замерзшие земли","Ледяной путь","Ущелье лавин","Лесной хребет","Древний путь","Роковой город","Город истоков","Великая стена",
"Равнина побед","Город мечей","Сломанные горы","Крепость-Компас","Светлые горы","Деревня огня","Перечный луг","Равнина ветров","Поселок ветров","Изумрудный лес",
"Земли драконов","Город оборотней","Шелковые горы","Портовый город","Город Драконов","Пахучий склон","Плато заката","Река Ришоу","Длинный откос","Безопасный путь",
"Небесное озеро","Небесные скалы","Долина орхидей","Персиковый док","Высохшее море","Горы лебедя","Город Перьев","Тренога Юй-вана","Бездушная топь","Туманная чаща","Поле костей",
"Южные горы","Белые горы","Черные горы","Горы мечтателей","Порт мечты");
	var	$error=0;	// Ошибка при разборке пакета

	//enum BATTLE_SETREASON {_BATTLE_INITIALIZE, _BATTLE_SETTIME};
	
	function BattleSet($reason,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);	
		$p->WriteInt16($reason);
		$p->WriteByte($this->count);
		foreach ($this->terr as $i => $val){
			$p->WriteInt16($val->id);
			$p->WriteInt16($val->level);			
			$p->WriteInt32($val->owner);
			$p->WriteInt32($val->occupy_time);
			$p->WriteInt32($val->challenger);
			$p->WriteInt32($val->deposit);
			$p->WriteInt32($val->cutoff_time);
			$p->WriteInt32($val->battle_time);
			$p->WriteInt32($val->bonus_time);
			$p->WriteInt32($val->color);
			$p->WriteInt32($val->status);
			$p->WriteInt32($val->timeout);
			$p->WriteInt32($val->maxbonus);
			$p->WriteInt32($val->challenge_time);
			$p->WriteOctets($val->challengerdetails);			
			$p->WriteByte($val->reserved1);
			$p->WriteByte($val->reserved2);
			$p->WriteByte($val->reserved3);
		}
		$packet=cuint(864).$p->wcount.$p->buffer;		
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt32();
			$this->unk = $a->ReadInt16();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
	
	function BattleLoad($fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32(0);
		$packet=cuint(863).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt32();
			$this->unk = $a->ReadInt16();
			$this->count = $a->ReadCUInt32();
			$this->terr = array();
			for ($i=0; $i<$this->count; $i++){
				$this->terr[$i] = new GTerritory();
				$this->terr[$i]->id = $a->ReadInt16();
				$this->terr[$i]->level = $a->ReadInt16();		
				$this->terr[$i]->owner = $a->ReadInt32();
				$this->terr[$i]->occupy_time = $a->ReadInt32();
				$this->terr[$i]->challenger = $a->ReadInt32();
				$this->terr[$i]->deposit = $a->ReadInt32();
				$this->terr[$i]->cutoff_time = $a->ReadInt32();
				$this->terr[$i]->battle_time = $a->ReadInt32();
				$this->terr[$i]->bonus_time = $a->ReadInt32();
				$this->terr[$i]->color = $a->ReadInt32();
				$this->terr[$i]->status= $a->ReadInt32();
				$this->terr[$i]->timeout = $a->ReadInt32();
				$this->terr[$i]->maxbonus = $a->ReadInt32();
				$this->terr[$i]->challenge_time = $a->ReadInt32();
				$this->terr[$i]->challengerdetails = $a->ReadOctets();
				$this->terr[$i]->reserved1 = $a->ReadByte();
				$this->terr[$i]->reserved2 = $a->ReadByte();
				$this->terr[$i]->reserved3 = $a->ReadByte();
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GMForbidUser {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode;		// Int32
	var $localsid;		// Int32
	var $operation;		// Byte
	var $time;		// Int32
	var $createtime;	// Int32
	var $reason;		// String
	var $error=0;		// Ошибка при разборке пакета

	function ForbidUser($operation,$gmuserid,$source,$userid,$time,$reason,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteByte($operation);
		$p->WriteInt32($gmuserid);
		$p->WriteInt32($source);
		$p->WriteInt32($userid);
		$p->WriteInt32($time);
		$p->WriteString($reason);
		$packet=cuint(8004).$p->wcount.$p->buffer;
		if($fp) {
			fputs($fp, $packet);
			$data = fread($fp,8096);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->operation = $a->ReadByte();				
			$this->time = $a->ReadInt32();
			$this->createtime = $a->ReadInt32();
			$this->reason = $a->ReadString();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class	PlayerIDByName {
	private $type;		// cuInt32
	private $answlen;	// cuInt32	
	var $localsid;		// Int32
	var $rolename;		// String
	var $reason;		// Byte
	var $retcode;		// Int32
	var $roleid;		// Int32	
	var $error=0;		// Ошибка при разборке пакета
	function GetRoleId($rolename,$fp,$reason=0){
		global $ProtocolVer;
		$this->rolename=$rolename;
		$this->reason = $reason;
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteString($rolename);
		if ($ProtocolVer >= 27)	$p->WriteByte($reason);
		//$p->WriteByte(0);
		$packet=cuint(3033).$p->wcount.$p->buffer;
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();			
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->roleid = $a->ReadInt32();			
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;
			if ($a->overflow==true) $this->error = 2;
			return $data;
		}
	}
}

class GFactionDetail {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode;		// Int32
	var $localsid;		// Int32
	var $fid=0;		// Int32
	var $name='';		// String
	var $level=0;		// Byte
	var $master=0;		// Int32
	var $announce='';	// Octets
	var $sysinfo='';	// Octets
	var $members;		// GFactionUsers
	// 1.4.4+
	var $last_op_time=0;	// Int32
	var $alliance;		// GNET::GFactionDetail::GFactionAllianceVector
	var $hostile;		// GNET::GFactionDetail::GFactionHostileVector
	var $apply;		// GNET::GFactionDetail::GFactionRelationApplyVector
	// 145+
	var $unifid;		// int64
	
	var $error=0;		// Ошибка при разборке пакета

	function GFactionDetail($id,$fp){
		global $ProtocolVer;
		if ($id==0) return;
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$packet=cuint(4608).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			if ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
				$data.=fread($fp,8096);				
				$a->PacketStream($data,false);
			}
			$this->retcode = $a->ReadInt32();
			$this->localsid = $a->ReadInt32();
			$this->fid = $a->ReadInt32();
			$this->name = $a->ReadString();
			$this->level = $a->ReadByte();
			$this->master = $a->ReadInt32();
			$this->announce = $a->ReadString();
			$this->sysinfo = $a->ReadString();
			$this->members = $a->ReadGFactionUsers();
			if ($ProtocolVer >= 60) {
				$this->last_op_time = $a->ReadInt32();
				$this->alliance = $a->ReadGFactionAlliance();
				$this->hostile = $a->ReadGFactionAlliance();
				$this->apply = $a->ReadGFactionRelationApply();
			}
			if ($ProtocolVer >= 145) {
				$this->unifid = $a->ReadInt64();
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GMKickOutRole {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode;		// Int32
	var $gmroleid;		// Int32
	var $localsid;		// Int32
	var $kickroleid;	// Int32
	var $error=0;		// Ошибка при разборке пакета

	function KickOutRole($gmroleid,$localsid,$kickroleid,$forbid_time,$reason,$fp){
		$p=new PacketStream();
		$p->WriteInt32($gmroleid);
		$p->WriteInt32($localsid);
		$p->WriteInt32($kickroleid);
		$p->WriteInt32($forbid_time);
		$p->WriteString($reason);
		$packet=cuint(360).$p->wcount.$p->buffer;
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt32();
			$this->gmroleid = $a->ReadInt32();	
			$this->localsid = $a->ReadInt32();	
			$this->kickroleid = $a->ReadInt32();	
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class	GMPlayerInfo {
	var	$userid;	// Int32
	var	$roleid;	// Int32
	var	$linkid;	// Int32
	var	$localsid;	// UInt32
	var	$gsid;		// Int32
	var	$status;	// Byte
	var	$name;		// String
}

class	GMListOnlineUser {
	private $type;		// cuInt32
	private $answlen;	// cuInt32	
	var $retcode;		// Int32
	var $gmroleid;		// Int32
	var $localsid;		// UInt32
	var $handler;		// Int32
	var $count;		// CUInt
	var $userlist;		// array of GMPlayerInfo	
	var $error=0;		// Ошибка при разборке пакета
	
	function GetList($gmroleid=0, $localsid=0, $handler=0, $cond='',$ip='10.0.2.15'){
		$p=new PacketStream();
		$p->WriteInt32($gmroleid);
		$p->WriteInt32($localsid);
		$p->WriteInt32($handler);
		$p->WriteOctets($cond);
		$packet=cuint(352).$p->wcount.$p->buffer;
		$fp = @fsockopen($ip, delivery_port);
		if($fp) {
			$data=fread($fp,8096);
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();			
			$this->retcode = $a->ReadInt32();
			$this->gmroleid = $a->ReadInt32();
			$this->localsid = $a->ReadInt32();
			$this->handler = $a->ReadInt32();					
			$this->count = $a->ReadCUInt32();
			$this->userlist = array();
			if ($this->count > 0){
				for ($b=0; $b<$this->count; $b++){
					$this->userlist[$b] = new GMPlayerInfo();
					$this->userlist[$b]->userid = $a->ReadInt32();
					$this->userlist[$b]->roleid = $a->ReadInt32();
					$this->userlist[$b]->linkid = $a->ReadInt32();
					$this->userlist[$b]->localsid = $a->ReadInt32();
					$this->userlist[$b]->gsid = $a->ReadInt32();
					$this->userlist[$b]->status = $a->ReadByte();
					$this->userlist[$b]->name = $a->ReadString();
				}
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;
			if ($a->overflow==true) $this->error = 2;			
			return $data;
		}		
	}	
}

function GetFullRoleListOnline($ip='10.0.2.15'){	
	$LastUserID = 0;
	$res = array();
	$f = new GMListOnlineUser();
	while (true) {
		$f->GetList(0, 0, $LastUserID, '',$ip);
		if ($f->count > 0) {
			foreach ($f->userlist as $i => $val){
				array_push($res, $val);
				$LastUserID = $val->userid+1;
			}
			if ($LastUserID<0) return $res;
		} else return $res;
	}
}

class ShopLog {
	var	$roleid;	// Int32
	var	$order_id;	// Int32
	var	$item_id;	// Int32
	var	$expire;	// Int32
	var	$item_count;	// Int32
	var	$order_count;	// Int32
	var	$cash_need;	// Int32
	var	$time;		// Int32
	var	$guid1;		// Int32
	var	$guid2;		// Int32
}

class ShopLogs {
	var	$count;		// CuInt32
	var	$logs;		// array of ShopLog
	
	function ReadLogs($a){
		$this->count = $a->ReadCUInt32();
		$this->logs = array();
		for ($i=0; $i<$this->count; $i++){
			$this->logs[$i] = new ShopLog();
			$this->logs[$i]->roleid = $a->ReadInt32();	
			$this->logs[$i]->order_id = $a->ReadInt32();
			$this->logs[$i]->item_id = $a->ReadInt32();
			$this->logs[$i]->expire = $a->ReadInt32();
			$this->logs[$i]->item_count = $a->ReadInt32();
			$this->logs[$i]->order_count = $a->ReadInt32();
			$this->logs[$i]->cash_need = $a->ReadInt32();
			$this->logs[$i]->time = $a->ReadInt32();
			$this->logs[$i]->guid1 = $a->ReadInt32();
			$this->logs[$i]->guid2 = $a->ReadInt32();		
		}
	}

	function WriteLogs($a){
		$a->WriteCUint32(count($this->logs));
		foreach ($this->logs as $i => $val){
			$a->WriteInt32($val->roleid);	
			$a->WriteInt32($val->order_id);
			$a->WriteInt32($val->item_id);
			$a->WriteInt32($val->expire);
			$a->WriteInt32($val->item_count);
			$a->WriteInt32($val->order_count);
			$a->WriteInt32($val->cash_need);
			$a->WriteInt32($val->time);
			$a->WriteInt32($val->guid1);
			$a->WriteInt32($val->guid2);		
		}
	}
}

class GRoleDetail {
	var	$version=0;		// Byte
	var	$id=0;			// Unsigned Int32
	var	$userid=0;		// Unsigned Int32	// 1.4.4+
	var	$status;		// RoleStatus
	var	$name;			// String
	var	$race=0;		// Int32
	var	$cls=0;			// Int32
	var	$spouse=0;		// Unsigned Int32
	var	$gender=0;		// Byte
	var	$create_time=0;		// Int32;
	var	$lastlogin_time=0;	// Int32;		// 1.4.4+
	var	$cash_add=0;		// Int32;		// 1.4.4+
	var	$cash_total=0;		// Int32;
	var	$cash_used=0;		// Int32;
	var	$cash_serial=0;		// Int32;
	var	$factionid=0;		// Unsigned Int32;
	var	$factionrole=0;		// Int32
	var	$custom_data='';	// Octets
	var	$custom_stamp=0;	// Int32
	var	$inventory;		// RolePocket
	var	$equipment;		// RoleInventoryVector
	var	$storehouse;		// RoleStorehouse
	var	$task;			// RoleTask
	var	$addiction='';		// Octets
	var	$logs;			// ShopLogs
	// 27+
	var	$bonus_add=0;		// int
	var	$bonus_reward=0;	// int
	var	$bonus_used=0;		// int
	var	$referrer=0;		// int
	var	$userstorehouse;	// RoleStorehouse
	var	$taskcounter='';	// Octets
	// 60+
	var	$factionalliance;	// GNET::GFactionDetail::GFactionAllianceVector
	var	$factionhostile;	// GNET::GFactionDetail::GFactionHostileVector
	// 1.4.6(69)+
	var	$mall_consumption=0;	// int
	// 1/.4.7(85)+
	var	$src_zoneid=0;		// int
	// 145+
	var	$unifid=0;		// int64
	// 156+
	var	$vip_level=0;		// int
	var	$score_add=0;		// int
	var	$score_cost=0;		// int
	var	$score_consume=0;	// int
	var	$day_clear_stamp=0;	// int
	var	$week_clear_stamp=0;	// int
	var	$month_clear_stamp=0;	// int
	var	$year_clear_stamp=0;	// int
	var	$purchase_limit_data='';// Octets
	var	$home_level=0;		// int
}

class GRole {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	private $unk;			// Int32
	var	$retcode=-1;		// Int32
	var	$data_mask=0;		// Int32
	var	$gameserver_id=0;	// Byte
	var	$value;			// GRoleDetail

	function GetRole($id,$mask,$fp){
		global $ProtocolVer;
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);
		$p->WriteInt32($mask);				
		$packet=cuint(3005).$p->wcount.$p->buffer;		
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			$a = new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->unk = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->data_mask = $a->ReadInt32();
			$this->gameserver_id = $a->ReadByte();			
			$this->value = new GRoleDetail();
			$this->value->version = $a->ReadByte();
			$this->value->id = $a->ReadInt32();
			if ($ProtocolVer >= 27) $this->value->userid = $a->ReadInt32(); else $this->value->userid = floor($id/16)*16;
			$this->value->status = $a->ReadRoleStatus();
			$this->value->name = $a->ReadString();
			$this->value->race = $a->ReadInt32();
			$this->value->cls = $a->ReadInt32();
			$this->value->spouse = $a->ReadInt32();
			$this->value->gender = $a->ReadByte();
			$this->value->create_time = $a->ReadInt32();
			if ($ProtocolVer >= 27) {
				$this->value->lastlogin_time = $a->ReadInt32();
				$this->value->cash_add = $a->ReadInt32();
			}
			$this->value->cash_total = $a->ReadInt32();
			$this->value->cash_used = $a->ReadInt32();
			$this->value->cash_serial = $a->ReadInt32();
			$this->value->factionid = $a->ReadInt32();
			$this->value->factionrole = $a->ReadInt32();
			$this->value->custom_data = $a->ReadOctets();
			$this->value->custom_stamp = $a->ReadInt32();
			$this->value->inventory = $a->ReadRolePocket();
			$this->value->equipment = $a->ReadGRoleItems();
			$this->value->storehouse = $a->ReadRoleStorehouse();
			$this->value->task = $a->ReadRoleTask();
			$this->value->addiction = $a->ReadOctets();
			$this->value->logs = new ShopLogs();
			$this->value->logs->ReadLogs($a);
			if ($ProtocolVer >= 27) {
				$this->value->bonus_add = $a->ReadInt32();
				$this->value->bonus_reward = $a->ReadInt32();
				$this->value->bonus_used = $a->ReadInt32();
				$this->value->referrer = $a->ReadInt32();
				$this->value->userstorehouse = $a->ReadUserStorehouse();
				$this->value->taskcounter = $a->ReadOctets();
			}
			if ($ProtocolVer >= 60) {
				$this->value->factionalliance = $a->ReadGFactionAlliance();
				$this->value->factionhostile = $a->ReadGFactionAlliance();
			}
			if ($ProtocolVer >= 69) $this->value->mall_consumption = $a->ReadInt32();
			if ($ProtocolVer >= 85) $this->value->src_zoneid = $a->ReadInt32();
			if ($ProtocolVer >= 145) $this->value->unifid = $a->ReadInt64();
			if ($ProtocolVer >= 156) {
				$this->value->vip_level = $a->ReadInt32();
				$this->value->score_add = $a->ReadInt32();
				$this->value->score_cost = $a->ReadInt32();
				$this->value->score_consume = $a->ReadInt32();
				$this->value->day_clear_stamp = $a->ReadInt32();
				$this->value->week_clear_stamp = $a->ReadInt32();
				$this->value->month_clear_stamp = $a->ReadInt32();
				$this->value->year_clear_stamp = $a->ReadInt32();
				$this->value->purchase_limit_data = $a->ReadOctets();
				$this->value->home_level = $a->ReadInt32();
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длина пакета меньше ожидаемой
			return $data;			
		}
	}

	function PutRole($id,$mask,$fp){
		global $ProtocolVer;
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteInt32($mask);
		$p->WriteByte(0);
		// GRoleDetail
		$this->value->inventory->timestamp++;
		$p->WriteByte($this->value->version);
		$p->WriteInt32($this->value->id);
		if ($ProtocolVer >= 27) $p->WriteInt32($this->value->userid);
		$p->WriteRoleStatus($this->value->status);
		$p->WriteString($this->value->name);
		$p->WriteInt32($this->value->race);
		$p->WriteInt32($this->value->cls);
		$p->WriteInt32($this->value->spouse);
		$p->WriteByte($this->value->gender);
		$p->WriteInt32($this->value->create_time);
		if ($ProtocolVer >= 27) {
			$p->WriteInt32($this->value->lastlogin_time);
			$p->WriteInt32($this->value->cash_add);
		}
		$p->WriteInt32($this->value->cash_total);
		$p->WriteInt32($this->value->cash_used);
		$p->WriteInt32($this->value->cash_serial);
		$p->WriteInt32($this->value->factionid);
		$p->WriteInt32($this->value->factionrole);
		$p->WriteOctets($this->value->custom_data);
		$p->WriteInt32($this->value->custom_stamp);
		$p->WriteRolePocket($this->value->inventory);
		$p->WriteGRoleItems($this->value->equipment);
		$p->WriteRoleStorehouse($this->value->storehouse);
		$p->WriteRoleTask($this->value->task);
		$p->WriteOctets($this->value->addiction);
		$this->value->logs->WriteLogs($p);
		if ($ProtocolVer >= 27) {
			$p->WriteInt32($this->value->bonus_add);
			$p->WriteInt32($this->value->bonus_reward);
			$p->WriteInt32($this->value->bonus_used);
			$p->WriteInt32($this->value->referrer);
			$p->WriteUserStorehouse($this->value->userstorehouse);
			$p->WriteOctets($this->value->taskcounter);
		}
		if ($ProtocolVer >= 60) {
			$p->WriteGFactionAlliance($this->value->factionalliance);
			$p->WriteGFactionAlliance($this->value->factionhostile);
		}
		if ($ProtocolVer >= 69) $p->WriteInt32($this->value->mall_consumption);
		if ($ProtocolVer >= 85) $p->WriteInt32($this->value->src_zoneid);
		if ($ProtocolVer >= 145) $p->WriteInt64($this->value->unifid);
		if ($ProtocolVer >= 156) {
			$p->WriteInt32($this->value->vip_level);
			$p->WriteInt32($this->value->score_add);
			$p->WriteInt32($this->value->score_cost);
			$p->WriteInt32($this->value->score_consume);
			$p->WriteInt32($this->value->day_clear_stamp);
			$p->WriteInt32($this->value->week_clear_stamp);
			$p->WriteInt32($this->value->month_clear_stamp);
			$p->WriteInt32($this->value->year_clear_stamp);
			$p->WriteOctets($this->value->purchase_limit_data);
			$p->WriteInt32($this->value->home_level);
		}
		$packet=cuint(3024).$p->wcount.$p->buffer;		
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			$a = new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();			
			$this->unk = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->data_mask = $a->ReadInt32();
			$this->gameserver_id = $a->ReadByte();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длина пакета меньше ожидаемой
			return $data;			
		}
	}
}

class GRoleBase {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;		// Int32
	var	$retcode=-1;		// Int32
	var 	$base=1;		// RoleBase
	var	$error=0;		// Ошибка при разборке пакета

	function PutRoleBase($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteRoleBase($this->base);		
		$packet=cuint(3012).$p->wcount.$p->buffer;		
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой			
			return $data;
		}
	}
	
	function GetRoleBase($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3013).$p->wcount.$p->buffer;		
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//if ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,16384);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->base = $a->ReadRoleBase();			
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;			
		}
	}
}

class ExtendProp {
	var	$vitality;		// Int	выносливость
	var	$energy;		// Int  интеллект
	var	$strength;		// Int  сила
	var	$agility;		// Int  ловкость
	var	$max_hp;		// Int
	var	$max_mp;		// Int
	var	$hp_gen;		// Int
	var	$mp_gen;		// Int
	var	$walk_speed;		// Float
	var	$run_speed;		// Float
	var	$swim_speed;		// Float
	var	$flight_speed;		// Float
	var	$attack;		// Int
	var	$damage_low;		// Int
	var	$damage_high;		// Int
	var	$attack_speed;		// Int
	var	$attack_range;		// Float
	var	$addon_damage_low;	// array 1-5 of Int
	var	$addon_damage_high;	// array 1-5 of Int
	var	$damage_magic_low;	// Int
	var	$damage_magic_high;	// Int
	var	$resistance;		// array 1-5 of Int
	var	$defense;		// Int
	var	$armor;			// Int
	var	$max_ap;		// Int

	function ReadProperty($data){
		$p = new PacketStream($data);
		$this->vitality = $p->ReadInt32(false);
		$this->energy = $p->ReadInt32(false);
		$this->strength = $p->ReadInt32(false);
		$this->agility = $p->ReadInt32(false);
		$this->max_hp = $p->ReadInt32(false);
		$this->max_mp = $p->ReadInt32(false);
		$this->hp_gen = $p->ReadInt32(false);
		$this->mp_gen = $p->ReadInt32(false);
		$this->walk_speed = $p->ReadSingle(false);
		$this->run_speed = $p->ReadSingle(false);
		$this->swim_speed = $p->ReadSingle(false);
		$this->flight_speed = $p->ReadSingle(false);
		$this->attack = $p->ReadInt32(false);
		$this->damage_low = $p->ReadInt32(false);
		$this->damage_high = $p->ReadInt32(false);
		$this->attack_speed = $p->ReadInt32(false);
		$this->attack_range = $p->ReadSingle(false);
		$this->addon_damage_low = array($p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false));
		$this->addon_damage_high = array($p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false));
		$this->damage_magic_low = $p->ReadInt32(false);
		$this->damage_magic_high = $p->ReadInt32(false);
		$this->resistance = array($p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false),$p->ReadInt32(false));
		$this->defense = $p->ReadInt32(false);
		$this->armor = $p->ReadInt32(false);
		$this->max_ap = $p->ReadInt32(false);
		$error = 0;
		if ($p->done!=true) $error = 1;		// Пакет разобран не до конца
		if ($p->overflow==true) $error = 2;	// Длинна пакета меньше ожидаемой
		return $error;	
	}

	function WriteProperty(){
		$p = new PacketStream();
		$p->WriteInt32($this->vitality,false);
		$p->WriteInt32($this->energy,false);
		$p->WriteInt32($this->strength,false);
		$p->WriteInt32($this->agility,false);
		$p->WriteInt32($this->max_hp,false);
		$p->WriteInt32($this->max_mp,false);
		$p->WriteInt32($this->hp_gen,false);
		$p->WriteInt32($this->mp_gen,false);
		$p->WriteSingle($this->walk_speed,false);
		$p->WriteSingle($this->run_speed,false);
		$p->WriteSingle($this->swim_speed,false);
		$p->WriteSingle($this->flight_speed,false);
		$p->WriteInt32($this->attack,false);
		$p->WriteInt32($this->damage_low,false);
		$p->WriteInt32($this->damage_high,false);
		$p->WriteInt32($this->attack_speed,false);
		$p->WriteSingle($this->attack_range,false);
		foreach ($this->addon_damage_low as $i => $val){
			$p->WriteInt32($val,false);
		}
		foreach ($this->addon_damage_high as $i => $val){
			$p->WriteInt32($val,false);
		}
		$p->WriteInt32($this->damage_magic_low,false);
		$p->WriteInt32($this->damage_magic_high,false);
		foreach ($this->resistance as $i => $val){
			$p->WriteInt32($val,false);
		}
		$p->WriteInt32($this->defense,false);
		$p->WriteInt32($this->armor,false);
		$p->WriteInt32($this->max_ap,false);
		return $p->buffer;
	}
}

class GRoleStatus {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;		// Int32
	var	$retcode=-1;		// Int32
	var 	$status=1;		// GRoleStatus
	var	$error=0;		// Ошибка при разборке пакета

	function PutRoleStatus($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteRoleStatus($this->status);
		$packet=cuint(3014).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}

	function GetRoleStatus($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3015).$p->wcount.$p->buffer;		
		//$fp = fsockopen($ip, 29400);
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->status = $a->ReadRoleStatus();			
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;			
		}
	}
}

class GRoleData {
	var	$type;			// CUInt
	var	$localsid;
	var	$retcode;
	var	$base;			// RoleBase
	var	$status;		// RoleStatus
	var	$pocket;		// RolePocket
	var	$equipment;		// RoleEquipment
	var	$storehouse;		// RoleStorehouse
	var	$task;			// RoleTask
	var	$error=0;
	
	function PutRoleData($id,$fp){
		global $ProtocolVer;
		if ($ProtocolVer < 27) {
			// Base
			$t = new GRoleBase();
			$t->base = $this->base;
			$t->PutRoleBase($id,$fp);			
			$this->retcode = $t->retcode;			
			// Status
			$t = new GRoleStatus();
			$t->status = $this->status;
			$t->PutRoleStatus($id,$fp);			
			$this->retcode += $t->retcode;			
			// Pocket
			$t = new GRolePocket();
			$t->pocket = $this->pocket;
			$t->PutRolePocket($id,$fp);			
			$this->retcode += $t->retcode;			
			// Equipment
			$t = new GRoleEquipment();
			$t->items = $this->equipment;
			$t->PutRoleEquipment($id,$fp);			
			$this->retcode += $t->retcode;			
			// Storehouse
			$t = new GRoleStorehouse();
			$t->storehouse = $this->storehouse;
			$t->PutRoleStorehouse($id,$fp);			
			$this->retcode += $t->retcode;			
			// Task
			$t = new GRoleTask();
			$t->task = $this->task;
			$data = $t->PutRoleTask($id,$fp);			
			$this->retcode += $t->retcode;			
			return true;
		}
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);
		$p->WriteByte(1);//Overwrite
		$p->WriteRoleBase($this->base);
		$p->WriteRoleStatus($this->status);
		$p->WriteRolePocket($this->pocket);
		$p->WriteGRoleItems($this->equipment->items);
		$p->WriteRoleStorehouse($this->storehouse);
		$p->WriteRoleTask($this->task);
		$packet = cuint(8002).$p->wcount.$p->buffer;
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);			
			//$data=fread($fp,8196);			
			$a = new PacketStream($data);			
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();			
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
	
	
	function GetRoleData($id,$fp){
		global $ProtocolVer;
		if ($ProtocolVer < 27) {
			// Base
			$t = new GRoleBase();
			$t->GetRoleBase($id,$fp);
			$this->localsid = $t->localsid;
			$this->base = $t->base;
			$this->retcode = $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			// Status
			$t = new GRoleStatus();
			$t->GetRoleStatus($id,$fp);
			$this->status = $t->status;
			$this->retcode += $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			// Pocket
			$t = new GRolePocket();
			$t->GetRolePocket($id,$fp);
			$this->pocket = $t->pocket;
			$this->retcode += $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			// Equipment
			$t = new GRoleEquipment();
			$t->GetRoleEquipment($id,$fp);
			$this->equipment = $t->items;
			$this->retcode += $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			// Storehouse
			$t = new GRoleStorehouse();
			$t->GetRoleStorehouse($id,$fp);
			$this->storehouse = $t->storehouse;
			$this->retcode += $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			// Task
			$t = new GRoleTask();
			$data = $t->GetRoleTask($id,$fp);
			$this->task = $t->task;
			$this->retcode += $t->retcode;
			$this->error = $t->error;
			if ($t->error) return false;
			return $data;
		}
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(8003).$p->wcount.$p->buffer;
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			$a = new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//$d = unpack('H*',$data);
			//echo $d[1]."<br>\n\n";
			//echo 'Anwslen: '.$this->answlen.', readed: '.strlen($data);die();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->base = $a->ReadRoleBase();
			$this->status = $a->ReadRoleStatus();
			$this->pocket = $a->ReadRolePocket();
			$this->equipment = new GRoleEquipment();
			$this->equipment->items = $a->ReadGRoleItems();
			$this->storehouse = $a->ReadRoleStorehouse();
			$this->task = $a->ReadRoleTask();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GRoleEquipment {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;		// Int32
	var	$retcode=-1;		// Int32
	var	$items;			// GRoleItems
	var $error=0;		// Ошибка при разборке пакета

	function PutRoleEquipment($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteGRoleItems($this->items);
		$packet=cuint(3016).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8196);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
				$data.=fread($fp,8196);				
				$a->PacketStream($data,false);
			}			
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой			
			return $data;
		}
	}

	function GetRoleEquipment($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3017).$p->wcount.$p->buffer;		
		//$fp = fsockopen($ip, 29400);
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();			
			$this->items = $a->ReadGRoleItems();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GRolePocket {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;		// Int32
	var	$retcode=-1;		// Int32
	var	$pocket;		// GRolePocket
	var	$error=0;		// Ошибка при разборке пакета

	function PutRolePocket($id,$fp,$autosortitems=false){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteRolePocket($this->pocket);		
		$packet=cuint(3050).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8196);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
				$data.=fread($fp,8196);				
				$a->PacketStream($data,false);
			}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}

	function GetRolePocket($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3051).$p->wcount.$p->buffer;		
		//$fp = fsockopen($ip, 29400);
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->pocket = $a->ReadRolePocket();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GRoleStorehouse {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;		// Int32
	var	$retcode=-1;		// Int32
	var	$storehouse;		// RoleStorehouse
	var	$error=0;		// Ошибка при разборке пакета

	function PutRoleStorehouse($id,$fp,$autosortitems=false){
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteRoleStorehouse($this->storehouse);		
		$packet=cuint(3026).$p->wcount.$p->buffer;
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8196);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
				$data.=fread($fp,8196);				
				$a->PacketStream($data,false);
			}			
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой			
			return $data;
		}
	}

	function GetRoleStorehouse($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3027).$p->wcount.$p->buffer;		
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);			
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->storehouse = $a->ReadRoleStorehouse();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			//print_r($a);
			return $data;			
		}
	}
}

class GRoleTask {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var	$localsid;			// Int32
	var	$retcode=-1;		// Int32
	var	$task;			// RoleTast
	var	$error=0;		// Ошибка при разборке пакета

	function PutRoleTask($id,$fp,$autosortitems=false){
		$p=new PacketStream();
		$p->WriteInt32(2147483677);
		$p->WriteInt32($id);
		$p->WriteRoleTask($this->task);
		$packet=cuint(3018).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой			
			return $data;
		}
	}

	function GetRoleTask($id,$fp){
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($id);				
		$packet=cuint(3019).$p->wcount.$p->buffer;		
		//$fp = fsockopen($ip, 29400);
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			//while ((strlen($a->buffer)-$a->pos)<$this->answlen) { 
			//	$data.=fread($fp,8196);				
			//	$a->PacketStream($data,false);
			//}
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->task = $a->ReadRoleTask();
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
}

class GPair {
	var	$key=0;			// int32
	var	$value=0;		// int32
}

class StockLog{
	var	$tid=0;			// Int32
	var	$time=0;		// Int32
	var	$result=0;		// Int16
	var	$volume=0;		// Int16
	var	$cost=0;		// Int32
 
}

class StockLogs{
	var	$count=0;		// Byte
	var	$stocklog;		// Array StockLog

	function StockLogs(){
		$this->stocklog=array();
	}
}

class GUser {
	private $type;			// cuInt32
	private $answlen;		// cuInt32
	var 	$retcode;		// Int32
	var 	$localsid;		// Int32
	var	$logicuid=0;		// Int32
	var 	$rolelist=0;		// Int32
	var	$cash=0;		// Int32
	var	$money=0;		// Int32
	var	$cash_add=0;		// Int32
	var	$cash_buy=0;		// Int32
	var	$cash_sell=0;		// Int32
	var	$cash_used=0;		// Int32
	var	$add_serial=0;		// Int32
	var	$use_serial=0;		// Int32
	var	$exg_log;		// StockLogS
	var	$addiction='';		// Octets
	var	$cash_password='';	// Octets
	// 7
	var	$reserved1;		// Int16
	var	$reserved2;		// Int32
	var	$reserved3;		// Int32
	var	$reserved4;		// Int32
	// end 7
	var	$autolock;		// std::vector<GNET::GPair, std::allocator<GNET::GPair> >
	var	$status=0;		// Byte
	var	$forbid;		// GNET::GetRoleForbid::GRoleForbidVector
	var	$reference='';		// Octets
	var	$consume_reward='';	// Octets
	var	$taskcounter='';	// Octets
	// 60+
	var	$cash_sysauction='';	// Octets
	var	$login_record='';	// Octets
	var	$reverded31=0;		// Byte		// only in 60
	var	$mall_consumption='';	// Octets
	var	$reserved32=0;		// Int16
	var	$error=0;		// Ошибка при разборке пакета

	function PutUser($id,$fp){
		global $ProtocolVer;
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteInt32($id);
		$p->WriteInt32($this->userid);	
		$p->WriteInt32($this->rolelist);
		$p->WriteInt32($this->cash);
		$p->WriteInt32($this->money);
		$p->WriteInt32($this->cash_add);
		$p->WriteInt32($this->cash_buy);
		$p->WriteInt32($this->cash_sell);
		$p->WriteInt32($this->cash_used);
		$p->WriteInt32($this->add_serial);
		$p->WriteInt32($this->use_serial);
		$p->WriteByte($this->exg_log->count);
		if ($this->exg_log->count>0)
		foreach ($this->exg_log->stocklog as $i => $val){
			$p->WriteInt32($val->tid);
			$p->WriteInt32($val->time);
			$p->WriteInt16($val->result);
			$p->WriteInt16($val->volume);
			$p->WriteInt32($val->cost);
		}
		$p->WriteOctets($this->addiction);
		$p->WriteOctets($this->cash_password);
		if ($ProtocolVer <= 12 ) {
			$p->WriteInt16($this->reserved1);
			$p->WriteInt32($this->reserved2);
			$p->WriteInt32($this->reserved3);
			$p->WriteInt32($this->reserved4);
		} else {
			$p->WriteCUInt32(count($this->autolock));
			if (count($this->autolock)>0)
			foreach ($this->autolock as $i => $val){
				$p->WriteInt32($val->key);
				$p->WriteInt32($val->value);
			}
			$p->WriteByte($this->status);
			$p->WriteGRoleForbids($this->forbid);
			$p->WriteOctets($this->reference);
			$p->WriteOctets($this->consume_reward);
			$p->WriteOctets($this->taskcounter);
			if ($ProtocolVer >= 60 ) {
				$p->WriteOctets($this->cash_sysauction);
				$p->WriteOctets($this->login_record);
			}
			if ($ProtocolVer <= 27) {
				$p->WriteByte($this->reserved2);
				$p->WriteInt32($this->reserved3);
			} else 
			if ($ProtocolVer <= 63) {
				$p->WriteByte($this->reserved31);
				$p->WriteInt16($this->reserved32);
			} else 
			if ($ProtocolVer <= 70) {
				$p->WriteOctets($this->mall_consumption);
				$p->WriteInt16($this->reserved32);
			}
		}
		$packet=cuint(3001).$p->wcount.$p->buffer;		
		if($fp) {
			fputs($fp, $packet);
			$data=fread($fp,8096);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt32();
			return $data;
		}
	}
	
	function GetUser($id,$fp,$ip='127.0.0.1'){
		global $ProtocolVer;
		$p=new PacketStream();
		$aid=floor($id/16)*16;
		$p->WriteInt32(2147483648);
		$p->WriteInt32($aid);
		$ips=explode('.',$ip);
		$pp = new PacketStream();
		$pp->WriteByte($ips[0]); $pp->WriteByte($ips[1]); $pp->WriteByte($ips[2]); $pp->WriteByte($ips[3]);
		$ips=unpack('I',$pp->buffer);
		$p->WriteInt32(time()); $p->WriteInt32($ips[1]);
		$packet=cuint(3002).$p->wcount.$p->buffer;		
		//$fp = fsockopen($ip, 29400);
		if($fp) {	
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);		
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->localsid = $a->ReadInt32();
			$this->retcode = $a->ReadInt32();
			$this->logicuid = $a->ReadInt32();
			$this->rolelist = $a->ReadInt32();
			$this->cash = $a->ReadInt32();
			$this->money = $a->ReadInt32();
			$this->cash_add = $a->ReadInt32();
			$this->cash_buy = $a->ReadInt32();
			$this->cash_sell = $a->ReadInt32();
			$this->cash_used = $a->ReadInt32();
			$this->add_serial = $a->ReadInt32();
			$this->use_serial = $a->ReadInt32();
			$this->exg_log = new StockLogs();
			$this->exg_log->count = $a->ReadCUInt32();
			for ($i=0; $i<$this->exg_log->count; $i++){
				$this->exg_log->stocklog[$i] = new StockLog();
				$this->exg_log->stocklog[$i]->tid = $a->ReadInt32();
				$this->exg_log->stocklog[$i]->time = $a->ReadInt32();
				$this->exg_log->stocklog[$i]->result = $a->ReadInt16();
				$this->exg_log->stocklog[$i]->volume = $a->ReadInt16();
				$this->exg_log->stocklog[$i]->cost = $a->ReadInt32();
			}
			$this->addiction = $a->ReadOctets();
			$this->cash_password = $a->ReadOctets();
			if ($ProtocolVer <= 12 ) {
				$this->reserved1 = $a->ReadInt16();
				$this->reserved2 = $a->ReadInt32();
				$this->reserved3 = $a->ReadInt32();
				$this->reserved4 = $a->ReadInt32();
			} else {
				$this->autolock = array();
				$cnt = $a->ReadCUInt32();
				for ($i=0; $i<$cnt; $i++){
					$this->autolock[$i] = new GPair();
					$this->autolock[$i]->key = $a->ReadInt32();
					$this->autolock[$i]->value = $a->ReadInt32();
				}				
				$this->status = $a->ReadByte();
				$this->forbid = $a->ReadGRoleForbids();
				$this->reference = $a->ReadOctets();
				$this->consume_reward = $a->ReadOctets();
				$this->taskcounter = $a->ReadOctets();
				if ($ProtocolVer >= 60 ) {
					$this->cash_sysauction = $a->ReadOctets();
					$this->login_record = $a->ReadOctets();
				}
				if ($ProtocolVer <= 27) {
					$this->reserved2 = $a->ReadByte();
					$this->reserved3 = $a->ReadInt32();
				} else 
				if ($ProtocolVer <= 63) {
					$this->reserved31 = $a->ReadByte();
					$this->reserved32 = $a->ReadInt16();
				} else 
				{
					$this->mall_consumption = $a->ReadOctets();
					$this->reserved32 = $a->ReadInt16();
				}
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			//print_r($a);echo "<br>";
			return $data;			
		}
	}
}

class	GUserRole {
	var $id;
	var $name;
}

class	GUserRoles {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode;		// Int32
	var $unk;		// Int32
	var $count;		// Byte
	var $roles;		// array of GUserRole
	var $error=0;		// Ошибка при разборке пакета

	function GetUserRoles($id=32,$fp){
		global $ProtocolVer;
		$aid=floor($id/16)*16;
		$p=new PacketStream();
		$p->WriteInt32(2147483648);
		$p->WriteInt32($aid);
		if ($ProtocolVer < 27) $pid = 3032; else $pid = 3401;
		$packet=cuint($pid).$p->wcount.$p->buffer;
		//$fp = fsockopen($ip, 29400);
		if($fp) {
			fputs($fp, $packet);
			$data = ReadPWPacket($fp);
			//fclose($fp);
			$a=new PacketStream($data);
			$this->type = $a->ReadCUInt32();
			$this->answlen = $a->ReadCUInt32();
			$this->retcode = $a->ReadInt32();
			$this->unk = $a->ReadInt32();
			$this->count = $a->ReadByte();
			$this->roles = array();
			for ($i=0; $i<$this->count; $i++){
				$this->roles[$i] = new GUserRole();
				$this->roles[$i]->id = $a->ReadInt32();
				//if ($ProtocolVer < 127)
				$this->roles[$i]->name = $a->ReadString();// else $this->roles[$i]->name = '';
			}
			$this->error = 0;
			if ($a->done!=true) $this->error = 1;		// Пакет разобран не до конца
			if ($a->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
			return $data;
		}
	}
	
	function GetUserName($id=32, $fp){
		$n='';
		$f=new GUserRoles();
		$f->GetUserRoles($id,$fp);
		for ($i=0; $i<$f->count; $i++){
			if ($f->roles[$i]->id==$id) $n=$f->roles[$i]->name;
		}
		return $n;
	}
}

function Int2Octets($i) {
	if ($i==0) return '';
	$p = new PacketStream();
	$p->WriteInt32($i);
	return $p->buffer;
}

function Octets2Int($o) {
	if ($o == '') return 0;
	$p = new PacketStream($o);
	//$p->ReadByte();
	return $p->ReadInt32();
}

function Octets2String($o) {
	if ($o == '') return $o;
	$p = new PacketStream($o);
	return $p->ReadString();
}

class RawKeyValue {
	var	$key='';	// Octets
	var	$value='';	// Octets
}

class DBRawRead {
	private $type;		// cuInt32
	private $answlen;	// cuInt32
	var $retcode=0;		// Int32
	var $localsid=0;	// Int32
	var $handle='';		// Octets
	var $values;		// array of RawKeyValue
	var $error=0;		// Ошибка при разборке пакета
	
	function Read($table, $key, $fp, $handle=''){
		if (!$fp) die('Socket connect error');
		$p=new PacketStream();
		$p->WriteInt32(2147483649);
		$p->WriteOctets($table);
		$p->WriteOctets($handle);
		$p->WriteOctets($key);
		$packet = cuint(3055).$p->wcount.$p->buffer;
		fputs($fp, $packet);
		$data = ReadPWPacket($fp);
		$p = new PacketStream($data);
		$this->type = $p->ReadCUInt32();
		$this->answlen = $p->ReadCUInt32();
		//while ((strlen($p->buffer)-$p->pos)<$this->answlen) { 
		//	$data.=fread($fp,8196);				
		//	$p->PacketStream($data, false);
		//}
		$this->localsid = $p->ReadInt32();
		$this->retcode = $p->ReadInt32();
		$this->handle = $p->ReadOctets();
		$cnt = $p->ReadCUInt32();
		$this->values = array();
		if ($cnt > 0) {
			for($a=0; $a<$cnt; $a++){
				$this->values[$a] = new RawKeyValue();
				$this->values[$a]->key = $p->ReadOctets();
				$this->values[$a]->value = $p->ReadOctets();
			}
		}
		$this->error = 0;
		if ($p->done!=true) $this->error = 1;		// Пакет разобран не до конца
		if ($p->overflow==true) $this->error = 2;	// Длинна пакета меньше ожидаемой
		return $data;
	}

	function Walk($table, $fp){
		if (!$fp) die('Socket connect error');
		$res = array();
		$this->Read($table, '', $fp);
		if ($this->retcode!=0 || $this->error!=0) return $res;
		$res = array_merge($res, $this->values);
		//print_r($this->values);
		while ($this->handle != '') {
			$this->Read($table, '', $fp, $this->handle);
			if ($this->retcode!=0 || $this->error!=0) return $res;
			$res = array_merge($res, $this->values);
			//print_r($this->values);
		}
		return $res;
	}

}

// ItemOctets

define("b_func1",  0x1 << 17);
define("b_func2",  0x1 << 16);
define("b_func3",  0x1 << 15);
define("b_func4",  0x1 << 14);
define("b_func5",  0x1 << 13);

class flysword_essence {
	var	$cur_time;		// int32
	var	$max_time;		// uint32
	var	$require_level;		// int16
	var	$element_level; 	// int16
	var	$require_class;		// int32
	var	$time_per_element;	// uint32
	var	$speed_increase1;	// float
	var	$speed_increase2;	// float
	var	$flag;			// byte
	var	$creator;		// String
	var	$unk;			// int16
	var	$retcode;		// Ошибки

	function ReadFlyswordEssence($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->cur_time		= $p->ReadInt32(false);
		$this->max_time		= $p->ReadInt32(false);
		$this->require_level	= $p->ReadInt16(false);
		$this->element_level	= $p->ReadInt16(false);
		$this->require_class	= $p->ReadInt32(false);
		$this->time_per_element	= $p->ReadInt32(false);
		$this->speed_increase1	= $p->ReadSingle(false);
		$this->speed_increase2	= $p->ReadSingle(false);
		$this->flag		= $p->ReadByte();
		$this->creator		= $p->ReadString();
		$this->creator		= iconv("UTF-16","UTF-8",$this->creator);
		$this->unk		= $p->ReadInt16(false);
		if ($p->done==false) {
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
		return true;
	}
	
	function WriteFlyswordEssence(){
		$p = new PacketStream();
		$p->WriteInt32($this->cur_time,false);
		$p->WriteInt32($this->max_time,false);
		$p->WriteInt16($this->require_level,false);
		$p->WriteInt16($this->element_level,false);
		$p->WriteInt32($this->require_class,false);
		$p->WriteInt32($this->time_per_element,false);
		$p->WriteSingle($this->speed_increase1,false);
		$p->WriteSingle($this->speed_increase2,false);
		$p->WriteByte($this->flag);
		$a = iconv("UTF-8","UTF-16",$this->creator);
		$p->WriteString($a);
		$p->WriteInt16($this->unk,false);
		return $p->buffer;
	}
}

class elf_skill {
	var	$id;			// int16
	var	$lvl;			// int16
}

class elf_essence {
	var	$exp;			// uint32
	var	$level;			// int16
	var	$total_attribute;	// int16
	var	$strength;		// int16
	var	$agility;		// int16
	var	$vitality;		// int16
	var	$energy;		// int16
	var	$total_genius;		// int16
	var	$genius;		// array[0..4] of int16
	var	$refine_level;		// int16
	var	$stamina;		// int32
	var	$status_value;		// int32
	var	$equip;			// array of int32
	var	$skills;		// array of elf_skill
	var	$retcode;		// внутр. ошибки

	function WriteElfEssence(){
		$p = new PacketStream();
		$p->WriteInt32($this->exp,false);
		$p->WriteInt16($this->level,false);
		$p->WriteInt16($this->total_attribute,false);
		$p->WriteInt16($this->strength,false);
		$p->WriteInt16($this->agility,false);
		$p->WriteInt16($this->vitality,false);
		$p->WriteInt16($this->energy,false);
		$p->WriteInt16($this->total_genius,false);
		for ($a=0; $a<5; $a++){
			$p->WriteInt16($this->genius[$a],false);
		}
		$p->WriteInt16($this->refine_level,false);
		$p->WriteInt32($this->stamina,false);
		$p->WriteInt32($this->status_value,false);
		$p->WriteInt32(count($this->equip),false);
		if (count($this->equip)>0) {
			foreach ($this->equip as $i => $val) {
				$p->WriteInt32($val,false);
			}
		}
		$p->WriteInt32(count($this->skills),false);
		if (count($this->skills)>0) {
			foreach ($this->skills as $i => $val) {
				$p->WriteInt16($val->id,false);
				$p->WriteInt16($val->lvl,false);
			}
		}
		return $p->buffer;
	}

	function ReadElfEssence($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->exp		= $p->ReadInt32(false);
		$this->level		= $p->ReadInt16(false);
		$this->total_attribute	= $p->ReadInt16(false);
		$this->strength		= $p->ReadInt16(false);
		$this->agility		= $p->ReadInt16(false);
		$this->vitality		= $p->ReadInt16(false);
		$this->energy		= $p->ReadInt16(false);
		$this->total_genius	= $p->ReadInt16(false);
		$this->genius = array();
		for ($a=0; $a<5; $a++){
			$this->genius[$a] = $p->ReadInt16(false);
		}
		$this->refine_level	= $p->ReadInt16(false);
		$this->stamina		= $p->ReadInt32(false);
		$this->status_value	= $p->ReadInt32(false);
		$equip_count		= $p->ReadInt32(false);
		$this->equip = array ();
		if ($equip_count>10) {
			$this->retcode=11;	// Слишком много эквипа
			return false;
		}
		if ($equip_count>0) {
			for ($a=0; $a<$equip_count; $a++) {
				$this->equip[$a] = $p->ReadInt32(false);
			}
		}
		$skill_count = $p->ReadInt32(false);
		$this->skills = array();
		if ($skill_count>10) {
			$this->retcode=10;	// Слишком много скилов
			return false;
		}
		if ($skill_count>0) {
			for ($a=0; $a<$skill_count; $a++) {
				$this->skills[$a] = new elf_skill();
				$this->skills[$a]->id = $p->ReadInt16(false);
				$this->skills[$a]->lvl = $p->ReadInt16(false);
			}
		}
		if ($p->done==false) {
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
		return true;
	}
}

class pet_data_skills {
	var $skill;		//int
	var $level;		//int
	
	function ReadPetDataSkills($p){
		$this->skill	= $p->ReadInt32(false);
		$this->level	= $p->ReadInt32(false);
	}
	
	function WritePetDataSkills($p){
		$p->WriteInt32($this->skill,false);
		$p->WriteInt32($this->level,false);
	}
}

class pet_data {
	var $size;		//cuint

	var $honor_point;	//int
	var $hunger_gauge;	//int
	var $feed_period;	//int
	var $pet_tid;		//int
	var $pet_vis_tid;	//int
	var $pet_egg_tid;	//int
	var $pet_class;		//int
	var $hp_factor;		//float
	var $level;		//short
	var $color;		//unsigned short
	var $exp;		//int
	var $skill_point;	//int	
	var $is_bind;		//byte		
	var $unused;		//byte	
	var $name_len;		//unsigned short
	var $name;		//char[16]
	var $skills;		//array[0..15] of pet_data_skills
	
	function ReadPetData($p){
		$this->size		= $p->ReadCUInt32();
		$this->honor_point	= $p->ReadInt32(false);
		$this->hunger_gauge	= $p->ReadInt32(false);
		$this->feed_period	= $p->ReadInt32(false);
		$this->pet_tid		= $p->ReadInt32(false);
		$this->pet_vis_tid	= $p->ReadInt32(false);
		$this->pet_egg_tid	= $p->ReadInt32(false);
		$this->pet_class	= $p->ReadInt32(false);
		$this->hp_factor	= $p->ReadSingle(false);
		$this->level		= $p->ReadInt16(false);		
		$this->color		= $p->ReadInt16(false);
		$this->exp		= $p->ReadInt32(false);
		$this->skill_point	= $p->ReadInt32(false);		
		$this->is_bind		= $p->ReadByte();
		$this->unused		= $p->ReadByte();
		$this->name_len		= $p->ReadInt16(false);
		$this->name='';
		for ($a=0; $a<16; $a++) $this->name.= chr($p->ReadByte());
		$this->name = substr($this->name, 0, $this->name_len);
		$this->name=iconv("UTF-16","UTF-8",$this->name);
		$this->skills = array();
		for ($a=0; $a<16; $a++) {
			$this->skills[$a] = new pet_data_skills();
			$this->skills[$a]->ReadPetDataSkills($p);
		}		
	}
	
	function WritePetData($p){
		$p1 = new PacketStream();
		$p1->WriteInt32($this->honor_point,false);
		$p1->WriteInt32($this->hunger_gauge,false);
		$p1->WriteInt32($this->feed_period,false);
		$p1->WriteInt32($this->pet_tid,false);
		$p1->WriteInt32($this->pet_vis_tid,false);
		$p1->WriteInt32($this->pet_egg_tid,false);
		$p1->WriteInt32($this->pet_class,false);
		$p1->WriteSingle($this->hp_factor,false);
		$p1->WriteInt16($this->level,false);
		$p1->WriteInt16($this->color,false);
		$p1->WriteInt32($this->exp,false);
		$p1->WriteInt32($this->skill_point,false);		
		$p1->WriteByte($this->is_bind);
		$p1->WriteByte($this->unused);
		$a=RTRIM($this->name,chr(0).chr(0));
		$a=iconv("UTF-8","UTF-16LE",$a);		
		if (strlen($a)>16) $a=substr($a,0,16);
		$p1->WriteInt16(strlen($a),false);
		if (strlen($a)<16) {
			for ($q=strlen($a); $q<16; $q++){
				$a.=chr(0);
			}			
		}		
		for ($i=0; $i<16; $i++) $p1->WriteByte(ord($a[$i]));
		for ($a=0; $a<16; $a++) {
			$this->skills[$a]->WritePetDataSkills($p1);
		}
		$p->buffer.=$p1->wcount.$p1->buffer;
	}
}

class pet {
	var $index;			// int32
	var $data;			// pet_data
	
	function ReadPet($p){
		$this->index	= $p->ReadInt32();
		$this->data	= new pet_data();
		$this->data->ReadPetData($p);
	}
	
	function WritePet($p){
		$p->WriteInt32($this->index);
		$this->data->WritePetData($p);
	}
}

class petcorral {
	var $capacity;			// int32
	var $count;			// byte
	var $list;			// array of pet
	
	function ReadPetCorral($data) {
		$p = new PacketStream($data);
		$this->capacity	= $p->ReadInt32();
		$this->count	= $p->ReadByte();
		$this->list	= array();
		for ($a=0; $a<$this->count; $a++){
			$this->list[$a] = new pet();
			$this->list[$a]->ReadPet($p);
		}
		$res=0;
		if ($p->done!=true) 	$res = 1;
		if ($p->overflow==true) $res = 2;
		return $res;
	}
	
	function WritePetCorral(){
		$p = new PacketStream();
		$p->WriteInt32($this->capacity);
		$p->WriteByte(count($this->list));
		foreach ($this->list as $i => $val){
			$this->list[$i]->WritePet($p);
		}
		return $p->buffer;
	}
}

class player_var_data {
	var $version;			// int32
	var $pk_count;			// int32
	var $pvp_cooldown;		// int32
	var $pvp_flag;			// bool
	var $dead_flag;			// char
	var $is_drop;			// bool
	var $resurrect_state;		// bool
	var $resurrect_exp_reduce;	// float
	var $instance_hash_key1;	// int32	
	var $instance_hash_key2;	// int32	
	var $trashbox_size;		// int32
	var $last_instance_timestamp;	// int32
	var $last_instance_tag;		// int32
	var $last_instance_pos_x;	// float
	var $last_instance_pos_y;	// float
	var $last_instance_pos_z;	// float
	var $dir; 			// int32
	var $resurrect_hp_factor;	// float
	var $resurrect_mp_factor;	// float

	function ReadVarData($data){
		$p = new PacketStream($data);
		$this->version = $p->ReadInt32(false);
		$this->pk_count = $p->ReadInt32(false);
		$this->pvp_cooldown = $p->ReadInt32(false);
		$this->pvp_flag = $p->ReadByte();
		$this->dead_flag = $p->ReadByte();
		$this->is_drop = $p->ReadByte();
		$this->resurrect_state = $p->ReadByte();
		$this->resurrect_exp_reduce = $p->ReadSingle(false);
		$this->instance_hash_key1 = $p->ReadInt32(false);
		$this->instance_hash_key2 = $p->ReadInt32(false);
		$this->trashbox_size = $p->ReadInt32(false);
		$this->last_instance_timestamp = $p->ReadInt32(false);
		$this->last_instance_tag = $p->ReadInt32(false);
		$this->last_instance_pos_x = $p->ReadSingle(false);
		$this->last_instance_pos_y = $p->ReadSingle(false);
		$this->last_instance_pos_z = $p->ReadSingle(false);
		$this->dir = $p->ReadInt32(false);
		$this->resurrect_hp_factor = $p->ReadSingle(false);
		$this->resurrect_mp_factor = $p->ReadSingle(false);
	}

	function WriteVarData(){
		$p = new PacketStream();
		$p->WriteInt32($this->version,false);
		$p->WriteInt32($this->pk_count,false);
		$p->WriteInt32($this->pvp_cooldown,false);
		$p->WriteByte($this->pvp_flag);
		$p->WriteByte($this->dead_flag);
		$p->WriteByte($this->is_drop);
		$p->WriteByte($this->resurrect_state);
		$p->WriteSingle($this->resurrect_exp_reduce,false);
		$p->WriteInt32($this->instance_hash_key1,false);
		$p->WriteInt32($this->instance_hash_key2,false);
		$p->WriteInt32($this->trashbox_size,false);
		$p->WriteInt32($this->last_instance_timestamp,false);
		$p->WriteInt32($this->last_instance_tag,false);
		$p->WriteSingle($this->last_instance_pos_x,false);
		$p->WriteSingle($this->last_instance_pos_y,false);
		$p->WriteSingle($this->last_instance_pos_z,false);
		$p->WriteInt32($this->dir,false);
		$p->WriteSingle($this->resurrect_hp_factor,false);
		$p->WriteSingle($this->resurrect_mp_factor,false);
		return $p->buffer;
	}
}

class Filter {
	var	$id;		// int32
	var	$param1;	// byte
	var	$param2;	// byte
	var	$param3;	// byte
	var	$param4;	// byte
	var	$showid;	// int32
	var	$param5;	// byte
	var	$param6;	// byte
	var	$time;		// int32
	var	$lvl;		// int32
}

class FilterData {
	var	$count=0;	// int32
	var	$filters;	// array of Filter;

	function ReadFilters($data){
		$this->filters = array();
		$p = new PacketStream($data);
		$this->count = $p->ReadInt32(false);
		for ($i=0; $i<$this->count; $i++){
			$this->filters[$i] = new Filter();
			$this->filters[$i]->id = $p->ReadInt32(false);
			$this->filters[$i]->param1 = $p->ReadByte();
			$this->filters[$i]->param2 = $p->ReadByte();
			$this->filters[$i]->param3 = $p->ReadByte();
			$this->filters[$i]->param4 = $p->ReadByte();
			$this->filters[$i]->showid = $p->ReadInt32(false);
			$this->filters[$i]->param5 = $p->ReadByte();
			$this->filters[$i]->param6 = $p->ReadByte();
			$this->filters[$i]->time = $p->ReadInt32(false);
			if ($this->filters[$i]->id==215) 
				$this->filters[$i]->lvl = $p->ReadInt16(false); else
			$this->filters[$i]->lvl = $p->ReadInt32(false);
		}
		$res = 0;
		if (!$p->done) $res = 1;
		if ($p->overflow) $res = 2;
		return $res;
	}

	function WriteFilters(){
		$p = new PacketStream();
		$this->count = count($this->filters);
		$p->WriteInt32($this->count,false);
		foreach ($this->filters as $i => $val){
			$p->WriteInt32($val->id,false);
			$p->WriteByte($val->param1);
			$p->WriteByte($val->param2);
			$p->WriteByte($val->param3);
			$p->WriteByte($val->param4);
			$p->WriteInt32($val->showid,false);
			$p->WriteByte($val->param5);
			$p->WriteByte($val->param6);
			$p->WriteInt32($val->time,false);
			if ($val->id==215)
				$p->WriteInt16($val->lvl,false); else
			$p->WriteInt32($val->lvl,false);
		}
		return $p->buffer;
	}

	function AddFilter($id,$time,$lvl){		
		$f=false;
		foreach ($this->filters as $i => $val){		// Проверка айди на наличие в списке текущих фильтров
			if ($val->id==$id) {
				$c=$i;
				$f=true;
			}
		}
		if ($f==false){
			$this->count++;
			$c = $this->count;
			$this->filters[$c] = new Filter();
			$this->filters[$c]->id		=	$id;
			$this->filters[$c]->param1	=	4;
			$this->filters[$c]->param2	=	0;
			$this->filters[$c]->param3	=	34;
			$this->filters[$c]->param4	=	0;
			$this->filters[$c]->showid	=	$id;
			$this->filters[$c]->param5	=	0;
			$this->filters[$c]->param6	=	0;
			$this->filters[$c]->time	=	$time;
			$this->filters[$c]->lvl		=	$lvl;
		} else {
			$this->filters[$c]->time	+=	$time;
		}
	}
}

class TaskData {
	var	$tasks;
	var	$count;		// Byte
	var	$count1;	// Byte
	var	$unk1;		// Int16
	var	$count2;	// Int32
	var	$data1;		// array[0..6] of array Int32
	var	$data2;		// array of Int16

	function ReadTasks($data){
		$this->data1 = array();
		$this->data2 = array();
		$this->tasks = array();
		$this->count = 0;
		if ($data == '') return true;
		$p = new PacketStream($data);
		$this->count = $p->ReadByte();
		$this->count1 = $p->ReadByte();
		$this->unk1 = $p->ReadInt16(false);
		$this->count2 = $p->ReadInt32(false);
		for ($i=0; $i<$this->count; $i++){
			$this->tasks[$i] = $p->ReadInt16(false);
			$this->data1[$i] = array();
			for ($i1=0; $i1<7; $i1++){
				$this->data1[$i][$i1] = $p->ReadInt32();
			}			
			$this->data2[$i] = $p->ReadInt16();
		}
		if ($p->done && !$p->overflow) return true; else return false;
	}

	function WriteTasks(){
		$p = new PacketStream();
		$this->count = count($this->tasks);
		$p->WriteByte($this->count);
		$p->WriteByte($this->count1);
		$p->WriteInt16($this->unk1,false);
		$p->WriteInt32($this->count2,false);
		for ($i=0; $i<$this->count; $i++){
			$p->WriteInt16($this->tasks[$i],false);
			for ($i1=0; $i1<7; $i1++){
				$p->WriteInt32($this->data1[$i][$i1]);
			}
			$p->WriteInt16($this->data2[$i]);
		}
		return $p->buffer;
	}
}

class TaskComplete {
	var	$tasks;		// array of int16
	var	$count;		// int32

	function ReadTasks($data){
		$this->tasks = array();
		$this->count = 0;
		if ($data == '') return true;
		$p = new PacketStream($data);
		$this->count = $p->ReadInt32(false);
		if ($this->count > 0) {
			for ($i=0; $i<$this->count; $i++){
				$this->tasks[$i] = $p->ReadInt16(false);
			}
		}
		if ($p->done && !$p->overflow) return true; else return false;
	}

	function WriteTasks(){
		$p = new PacketStream();
		$this->count = count($this->tasks);
		$p->WriteInt32($this->count,false);
		foreach ($this->tasks as $i => $val){
			$p->WriteInt16($val,false);
		}
		return $p->buffer;
	}
}

class SkillInfo {
	var	$id;		// ID скила
	var	$kraft=0;	// Прокачка крафта
	var	$lvl=1;		// Уровень скила
}

class Skills {
	var	$skills;	// array of SkillInfo
	var	$count;		// количество скилов

	function ReadSkills($data){
		$this->skills = array();
		$p = new PacketStream($data);
		$this->count = $p->ReadInt32(false);
		for ($i=0; $i<$this->count; $i++){
			$this->skills[$i] = new SkillInfo();
			$this->skills[$i]->id = $p->ReadInt32(false);
			$this->skills[$i]->kraft = $p->ReadInt32(false);
			$this->skills[$i]->lvl = $p->ReadInt32(false);
		}
		if ($p->done && !$p->overflow) return true; else return false;
	}

	function WriteSkills(){
		$p = new PacketStream();
		$this->count = count($this->skills);
		$p->WriteInt32($this->count,false);
		foreach ($this->skills as $i => $val){
			$p->WriteInt32($val->id,false);
			$p->WriteInt32($val->kraft,false);
			$p->WriteInt32($val->lvl,false);
		}
		return $p->buffer;
	}
}

class SlotInfo {
	var	$SlotCount=0;		// Int16 Кол-во ячеек
	var	$SlotFlag=0;		// Int16 Флаги ячеек
	var 	$SlotStone;		// Array of Int32 // ID камня в ячйке

	function SlotInfo(){
		$this->SlotStone = array();
	}

	function ReadSlotInfo($p){		
		$this->SlotCount = $p->ReadInt16(false);
		$this->SlotFlag = $p->ReadInt16(false);
		for ($i=0; $i<$this->SlotCount; $i++){
			$this->SlotStone[$i]=$p->ReadInt32(false);
		}
	}

	function WriteSlotInfo($p){
		$p->WriteInt16(count($this->SlotStone),false);
		$p->WriteInt16(count($this->SlotFlag),false);
		foreach ($this->SlotStone as $i => $val){
			$p->WriteInt32($val,false);
		}
	}
}

class Bonuses {
	var	$id=0;			// Int32 айди бонуса
	var	$type=0;		// Int32
	var	$stat=0;		// Int32 стат или функция
	var	$dopstat=0;		// Int32 дополнительный стат	
	var	$dopstat1=0;		// Int32 дополнительный стат	
}

class BonusInfo {
	var	$count=0;		// Int32 количество бонусов
	var	$bonus;			// Array of Bonuses

	function BonusInfo(){
		$this->bonus = array();
	}

	function ReadBonusInfo($p){
		$this->count = $p->ReadInt32(false);
		for ($i=0; $i<$this->count; $i++){
			$this->bonus[$i] = new Bonuses();
			$this->bonus[$i]->id = $p->ReadInt32(false);
			$this->bonus[$i]->type = 0;
			//echo '<br>';
			//printf("BonusId: %d, BonusCount: %d<br><br>", $this->bonus[$i]->id, $this->count);
			if ($this->bonus[$i]->id & b_func1) {
				$this->bonus[$i]->type ^= b_func1;
				$this->bonus[$i]->id ^= b_func1;
			}
			if ($this->bonus[$i]->id & b_func2) {
				$this->bonus[$i]->type ^= b_func2;
				$this->bonus[$i]->id ^= b_func2;
			}
			if ($this->bonus[$i]->id & b_func3) {
				$this->bonus[$i]->type ^= b_func3;
				$this->bonus[$i]->id ^= b_func3;
			}
			if ($this->bonus[$i]->id & b_func4) {
				//echo ($this->bonus[$i]->type ^ b_func4).' - 2<br><br>';
				$this->bonus[$i]->type ^= b_func4;
				$this->bonus[$i]->id ^= b_func4;
			}
			if ($this->bonus[$i]->id & b_func5) {
				//echo b_func5.' - 3<br><br>';
				$this->bonus[$i]->type ^= b_func5;
				$this->bonus[$i]->id ^= b_func5;
			}
			if ($this->bonus[$i]->id != 410 && $this->bonus[$i]->id != 336 && $this->bonus[$i]->id != 472) $this->bonus[$i]->stat = $p->ReadInt32(false);
			if ($this->bonus[$i]->type & b_func4) $this->bonus[$i]->dopstat = $p->ReadInt32(false);
			if ($this->bonus[$i]->type & b_func4 && $this->bonus[$i]->type & b_func5) $this->bonus[$i]->dopstat1 = $p->ReadInt32(false);
		}
	}

	function WriteBonusInfo($p){		
		$p->WriteInt32(count($this->bonus),false);
		foreach ($this->bonus as $i => $val){
			$p->WriteInt32($val->id+$val->type,false);
			if ($val->id != 410 && $val->id != 336 && $val->id != 472) $p->WriteInt32($val->stat, false);
			if ($val->type & b_func4) $p->WriteInt32($val->dopstat,false);
			if ($val->type & b_func4 && $val->type & b_func5) $p->WriteInt32($val->dopstat1,false);
		}
	}
}

class WeaponOctets{										// Оружие
	var	$retcode=0;		// Код ошибки
	var	$LvlReq=0;		// Int16 требуемый уровень
	var	$ClassReq=0;		// Int16 требуемый класс
	var	$StrReq=0;		// Int16 требуется силы
	var	$ConReq=0;		// Int16 требуется телосложения
	var	$DexReq=0;		// Int16 требуется ловкости
	var	$IntReq=0;		// Int16 требуется интеллекта
	var	$CurDurab=0;		// Int32 текущая прочность
	var	$MaxDurab=0;		// Int32 максимальная прочность
	var	$ItemClass=0;		// Int16 класс вещи
	var	$ItemFlag=0;		// Byte флаг вещи
	var	$Creator='';		// String создатель вещи
	var	$NeedAmmo=0;		// Int32 потребность в боеприпасах
	var	$WeaponClass=0;		// Int32 Класс оружия
	var	$Rang=0;		// Int32 Ранг
	var	$AmmoType=0;		// Int32 Тип боеприпасов
	var	$MinPhysAtk=0;		// Int32 Мин физ атака
	var	$MaxPhysAtk=0;		// Int32 Макс физ атака
	var	$MinMagAtk=0;		// Int32 Мин маг атака
	var	$MaxMagAtk=0;		// Int32 Макс маг атака
	var	$AtkSpeed=0;		// Int32 Скорость атаки
	var	$Distance=0;		// Single Дальность
	var	$FragDistance=0;	// Single Дистанция хрупкости
	var	$SlotInfo;		// SlotInfo Информация о ячейках
	var	$BonusInfo;		// BonusInfo
	var	$EnableDopInt;		// есть или нет добавочный int в конце
	var	$dopint;		// int32

	function ReadOctets($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->LvlReq = $p->ReadInt16(false);
		$this->ClassReq = $p->ReadInt16(false);
		$this->StrReq = $p->ReadInt16(false);
		$this->ConReq = $p->ReadInt16(false);
		$this->DexReq = $p->ReadInt16(false);
		$this->IntReq = $p->ReadInt16(false);
		$this->CurDurab = $p->ReadInt32(false);
		$this->MaxDurab = $p->ReadInt32(false);
		$this->ItemClass = $p->ReadInt16(false);
		if ($this->ItemClass!=44) {
			$this->retcode=1;	// Класс вещи не соответствует оружию
			return false;
		}
		$this->ItemFlag = $p->ReadByte();
		$this->Creator = $p->ReadString();
		$this->NeedAmmo = $p->ReadInt32(false);
		$this->WeaponClass = $p->ReadInt32(false);
		$this->Rang = $p->ReadInt32(false);
		$this->AmmoType = $p->ReadInt32(false);
		$this->MinPhysAtk = $p->ReadInt32(false);
		$this->MaxPhysAtk = $p->ReadInt32(false);
		$this->MinMagAtk = $p->ReadInt32(false);
		$this->MaxMagAtk = $p->ReadInt32(false);
		$this->AtkSpeed = $p->ReadInt32(false);
		$this->Distance = $p->ReadSingle(false);
		$this->FragDistance = $p->ReadSingle(false);
		$this->SlotInfo = new SlotInfo();
		$this->SlotInfo->ReadSlotInfo($p);
		$this->BonusInfo = new BonusInfo();
		$this->BonusInfo->ReadBonusInfo($p);
		$this->EnableDopInt = false;
		if ($p->done==false) {
			$this->dopint = $p->ReadInt32(false);		// костыль
			$this->EnableDopInt = true;
		}
		if ($p->done==false) {
			//printf('Pos: %d, length: %d<br><br>', $p->pos, strlen($p->buffer));
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
		return true;
	}

	function WriteOctets(){
		$p = new PacketStream();
		$p->WriteInt16($this->LvlReq,false);
		$p->WriteInt16($this->ClassReq,false);
		$p->WriteInt16($this->StrReq,false);
		$p->WriteInt16($this->ConReq,false);
		$p->WriteInt16($this->DexReq,false);
		$p->WriteInt16($this->IntReq,false);
		$p->WriteInt32($this->CurDurab,false);
		$p->WriteInt32($this->MaxDurab,false);
		$p->WriteInt16($this->ItemClass,false);
		$p->WriteByte($this->ItemFlag);
		$p->WriteString($this->Creator);
		$p->WriteInt32($this->NeedAmmo,false);
		$p->WriteInt32($this->WeaponClass,false);
		$p->WriteInt32($this->Rang,false);
		$p->WriteInt32($this->AmmoType,false);
		$p->WriteInt32($this->MinPhysAtk,false);
		$p->WriteInt32($this->MaxPhysAtk,false);
		$p->WriteInt32($this->MinMagAtk,false);
		$p->WriteInt32($this->MaxMagAtk,false);
		$p->WriteInt32($this->AtkSpeed,false);
		$p->WriteSingle($this->Distance,false);
		$p->WriteSingle($this->FragDistance,false);
		$this->SlotInfo->WriteSlotInfo($p);
		$this->BonusInfo->WriteBonusInfo($p);
		if ($this->EnableDopInt) $p->WriteInt32($this->dopint);
		return $p->buffer;
	}
}

class ArmorOctets{										// Броня и бижутерия
	var	$retcode=0;		// Код ошибки
	var	$LvlReq=0;		// Int16 требуемый уровень
	var	$ClassReq=0;		// Int16 требуемый класс
	var	$StrReq=0;		// Int16 требуется силы
	var	$ConReq=0;		// Int16 требуется телосложения
	var	$DexReq=0;		// Int16 требуется ловкости
	var	$IntReq=0;		// Int16 требуется интеллекта
	var	$CurDurab=0;		// Int32 текущая прочность
	var	$MaxDurab=0;		// Int32 максимальная прочность
	var	$ItemClass=0;		// Int16 класс вещи
	var	$ItemFlag=0;		// Byte флаг вещи
	var	$Creator='';		// String создатель вещи
	var	$PhysDef=0;		// Int32 Защита в броне, физ атака в бижутерии
	var	$Dodge=0;		// Int32 Уклон в броне, маг атака в бижутерии
	var	$Mana=0;		// Int32 Мана
	var	$HP=0;			// Int32 Здоровье
	var	$MetalDef=0;		// Int32 Защита от металла
	var	$WoodDef=0;		// Int32 Защита от дерева
	var	$WaterDef=0;		// Int32 Защита от воды
	var	$FireDef=0;		// Int32 Защита от огня
	var	$EarthDef=0;		// Int32 Защита от земли
	var	$SlotInfo;		// SlotInfo Информация о ячейках
	var	$BonusInfo;		// BonusInfo

	function ReadOctets($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->LvlReq = $p->ReadInt16(false);
		$this->ClassReq = $p->ReadInt16(false);
		$this->StrReq = $p->ReadInt16(false);
		$this->ConReq = $p->ReadInt16(false);
		$this->DexReq = $p->ReadInt16(false);
		$this->IntReq = $p->ReadInt16(false);
		$this->CurDurab = $p->ReadInt32(false);
		$this->MaxDurab = $p->ReadInt32(false);
		$this->ItemClass = $p->ReadInt16(false);
		if ($this->ItemClass!=36) {
			$this->retcode=1;	// Класс вещи не соответствует броне
			return false;
		}
		$this->ItemFlag = $p->ReadByte();
		$this->Creator = $p->ReadString();
		$this->PhysDef = $p->ReadInt32(false);
		$this->Dodge = $p->ReadInt32(false);
		$this->Mana = $p->ReadInt32(false);
		$this->HP = $p->ReadInt32(false);
		$this->MetalDef = $p->ReadInt32(false);
		$this->WoodDef = $p->ReadInt32(false);
		$this->WaterDef = $p->ReadInt32(false);
		$this->FireDef = $p->ReadInt32(false);
		$this->EarthDef = $p->ReadInt32(false);		
		$this->SlotInfo = new SlotInfo();
		$this->SlotInfo->ReadSlotInfo($p);
		$this->BonusInfo = new BonusInfo();
		$this->BonusInfo->ReadBonusInfo($p);
		if ($p->done==false) {
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
		return true;
	}

	function WriteOctets(){
		$p = new PacketStream();
		$p->WriteInt16($this->LvlReq,false);
		$p->WriteInt16($this->ClassReq,false);
		$p->WriteInt16($this->StrReq,false);
		$p->WriteInt16($this->ConReq,false);
		$p->WriteInt16($this->DexReq,false);
		$p->WriteInt16($this->IntReq,false);
		$p->WriteInt32($this->CurDurab,false);
		$p->WriteInt32($this->MaxDurab,false);
		$p->WriteInt16($this->ItemClass,false);
		$p->WriteByte($this->ItemFlag);
		$p->WriteString($this->Creator);
		$p->WriteInt32($this->PhysDef,false);
		$p->WriteInt32($this->Dodge,false);
		$p->WriteInt32($this->Mana,false);
		$p->WriteInt32($this->HP,false);
		$p->WriteInt32($this->MetalDef,false);
		$p->WriteInt32($this->WoodDef,false);
		$p->WriteInt32($this->WaterDef,false);
		$p->WriteInt32($this->FireDef,false);
		$p->WriteInt32($this->EarthDef,false);
		$this->SlotInfo->WriteSlotInfo($p);
		$this->BonusInfo->WriteBonusInfo($p);
		return $p->buffer;
	}
}

function auth_data(){
	/*
	global $act_key, $ElementsVer, $ErrCode, $auth_data;
	$ip = (isset($_POST['ip']))?$_POST['ip']:'';
	$d = @AssignData($_POST['data']);	
	$d = @unserialize($d);	
	if (!is_array($d)) die('Not array');
	if ($d['ip'] != $ip) die('Auth denied.'.$d['ip'].' - '.$ip);
	echo $act_key.'<br>'.$ElementsVer;
	*/
	echo ("Not array");
	return;
}

class FashionOctets {
	var	$require_level=0;	// int32
	var	$color=0;		// int16
	var	$gender=0;		// int16
	var	$name_type=0;		// byte
	var	$name='';		// string
	var	$color_mask;		// word
	var	$retcode;		// Result reading

	function ReadOctets($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->require_level = $p->ReadInt32(false);
		$this->color = $p->ReadInt16(false);
		$this->gender = $p->ReadInt16(false);
		$this->name_type = $p->ReadByte();
		$this->name = $p->ReadString();
		$this->color_mask = $p->ReadInt16(false);
		if ($p->done==false) {
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
	}
}

class LvlUpClassConfig {
	var	$vit_hp;
	var	$eng_mp;
	var	$lvlup_hp;
	var	$lvlup_mp;
	var	$lvlup_dmg;
	var	$lvlup_magic;
}

function CalcLevelProrepty($cls, $level, &$pr){
	$l = GetClassConfig($cls);
	$pr->max_hp = ($level - 1) * $l->lvlup_hp + $pr->vitality * $l->vit_hp;
	$pr->max_mp = ($level-1) * $l->lvlup_mp + $pr->energy * $l->eng_mp;
	$pr->damage_low = 1 + floor(($level-1) * $l->lvlup_dmg);
	$pr->damage_high = $pr->damage_low;
	$pr->damage_magic_low = 1 + floor(($level-1) * $l->lvlup_magic);
	$pr->damage_magic_high = $pr->damage_magic_low;
}

function ProcessStat(&$stat, $min, &$rest){
	if ($rest <= 0) return;
	if ($stat > $min) {
		if ($stat >= ($rest + $min)){
			$stat -= $rest;
			$rest = 0;
		} else {
			$a = $stat; $stat = $min;
			$rest = $rest - $a + $min;
		}
	}
}

function RecalculateLevelStats($cls, $oldlevel, $newlevel, &$pp, &$pr){
	if ($oldlevel == $newlevel) return false;
	if ($oldlevel < $newlevel) {
	  // Добавляем статы
	  $pp += ($newlevel - $oldlevel) * 5;
	} else {	
	  // Режем статы
	  $rest = ($oldlevel - $newlevel) * 5;
	  ProcessStat($pp, 0, $rest);
	  ProcessStat($pr->vitality, 5, $rest);
	  ProcessStat($pr->energy, 5, $rest);
	  ProcessStat($pr->strength, 5, $rest);
	  ProcessStat($pr->agility, 5, $rest);
	  if ($rest != 0) return false;
	}
	CalcLevelProrepty($cls, $newlevel, $pr);
	return true;
}

class RealmDataOctets {
	var	$level=0;	// int32
	var	$exp=0;		// int32
	var	$reserved1=0;	// int32
	var	$reserved2=0;	// int32
	var	$retcode;		// Result reading

	function ReadOctets($data){
		$this->retcode=0;
		$p = new PacketStream($data);
		$this->level = $p->ReadInt32();
		$this->exp = $p->ReadInt32();
		$this->reserved1 = $p->ReadInt32();
		$this->reserved2 = $p->ReadInt32();
		if ($p->done==false) {
			$this->retcode=2;	// Пакет не разобран до конца
			return false;
		}
		if ($p->overflow==true) {
			$this->retcode=3;	// Длинна пакета меньше ожидаемой
			return false;
		}
	}

	function WriteOctets(){
		$p = new PacketStream();
		$p->WriteInt32($this->level);
		$p->WriteInt32($this->exp);
		$p->WriteInt32($this->reserved1);
		$p->WriteInt32($this->reserved2);
		return $p->buffer;
	}
}

?>