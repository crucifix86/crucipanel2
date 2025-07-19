<?php
// Ключ активации ЛК (от разработчика)
$act_key = 'slonkey';
// IP адрес сервиса GameDB
$gamedb_ip = '127.0.0.1';
$gamedb_port = 29400;
// IP адрес сервиса GDeliveryD
$delivery_ip = '127.0.0.1';
$delivery_port = 29100;
// Данные базы данных MySql
$mysql_host = '127.0.0.1';
$mysql_user = 'root';
$mysql_pass = 'Pass';
$mysql_dbname = 'pw';
// Версия elements.data сервера
$ElementsVer = 156;

$db = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_dbname);
if ($db->connect_errno) {
    die('ErrorBase');
}

function KlanPic($num, $servid){
	$filename='klan/'.$_FILES['upload']['name'];
	move_uploaded_file ($_FILES['upload']['tmp_name'], $filename);
	require_once("klan/seticon.php");
	$r = seticon($filename,$num,$servid);
	return $r;
}

function GetClassConfig($class_id){
	$r = new LvlUpClassConfig;
	switch ($class_id){
		case 0:	// Воин
			$r->vit_hp = 15; $r->eng_mp = 9;
			$r->lvlup_hp = 30; $r->lvlup_mp = 18;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 1:	// Маг
			$r->vit_hp = 10; $r->eng_mp = 14;
			$r->lvlup_hp = 20; $r->lvlup_mp = 28;
			$r->lvlup_dmg = 0.2; $r->lvlup_magic = 1;
			break;
		case 2:	// Шаман
			$r->vit_hp = 10; $r->eng_mp = 14;
			$r->lvlup_hp = 20; $r->lvlup_mp = 28;
			$r->lvlup_dmg = 0.2; $r->lvlup_magic = 1;
			break;
		case 3:	// Друид
			$r->vit_hp = 12; $r->eng_mp = 12;
			$r->lvlup_hp = 24; $r->lvlup_mp = 24;
			$r->lvlup_dmg = 0.6; $r->lvlup_magic = 0.6;
			break;
		case 4:	// Оборотень
			$r->vit_hp = 17; $r->eng_mp = 7;
			$r->lvlup_hp = 34; $r->lvlup_mp = 14;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 5:	// Убийца
			$r->vit_hp = 13; $r->eng_mp = 10;
			$r->lvlup_hp = 26; $r->lvlup_mp = 22;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 6:	// Лучник
			$r->vit_hp = 13; $r->eng_mp = 11;
			$r->lvlup_hp = 26; $r->lvlup_mp = 22;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 7:	// Жрец
			$r->vit_hp = 10; $r->eng_mp = 14;
			$r->lvlup_hp = 20; $r->lvlup_mp = 28;
			$r->lvlup_dmg = 0.2; $r->lvlup_magic = 1;
			break;
		case 8:	// Страж
			$r->vit_hp = 15; $r->eng_mp = 9;
			$r->lvlup_hp = 30; $r->lvlup_mp = 18;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 9:	// Мистик
			$r->vit_hp = 10; $r->eng_mp = 14;
			$r->lvlup_hp = 20; $r->lvlup_mp = 28;
			$r->lvlup_dmg = 0.2; $r->lvlup_magic = 1;
			break;
		case 10: // Призрак
			$r->vit_hp = 13; $r->eng_mp = 11;
			$r->lvlup_hp = 26; $r->lvlup_mp = 22;
			$r->lvlup_dmg = 1; $r->lvlup_magic = 0;
			break;
		case 11: // Жнец
			$r->vit_hp = 10; $r->eng_mp = 14;
			$r->lvlup_hp = 20; $r->lvlup_mp = 28;
			$r->lvlup_dmg = 0.2; $r->lvlup_magic = 1;
			break;
	}
	return $r;
}

?>