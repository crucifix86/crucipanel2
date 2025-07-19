<?php
	require_once 'lkab/config.php';
	require_once 'lkab/packetstream.php';
	$ProtocolVer = $ElementsVer;
	set_time_limit(500);
	$db->query("SET NAMES utf8");
	$fname = 'guilds.txt';
	$fil=fopen($fname,'r');
	if (!$fil) die('File open error '.$fname);
	$buf = fgets($fil);
	$db->query("TRUNCATE TABLE `klan`");
	$fp = fsockopen($gamedb_ip, 29400);
	$r = new GRoleBase();
	while (!feof($fil)){
		$buf = fgets($fil);
		$a = explode(",", $buf);
		if (count($a)>1){
			$f = new GFactionDetail($a[0],$fp);
			if ($f->master != 0) {
				$r->GetRoleBase($f->master, $fp);
				$name = $db->real_escape_string($r->base->name);
			} else $name = '';
			$num = $f->members->count;
			$sql="INSERT INTO `klan` (`id` ,`name` ,`desc` ,`level` ,`masterid` ,`mastername` ,`members`) VALUES ('$a[0]', '".$db->real_escape_string($f->name)."', '".$db->real_escape_string($f->announce)."', '$f->level', '$f->master', '$name','$num');";
			if (!$db->query($sql)) echo $db->error;
		}
	}
	fclose($fil);
	$f = new DBBattleLoad();
	$data = $f->BattleLoad($fp);
	foreach ($f->terr as $i => $val){
		if ($val->owner!=0){
			switch ($val->level){
				case 1:$sql="update `klan` set terr3=terr3+1 where `id`=".$val->owner;break;
				case 2:$sql="update `klan` set terr2=terr2+1 where `id`=".$val->owner;break;
				case 3:$sql="update `klan` set terr1=terr1+1 where `id`=".$val->owner;break;
			}
			if (!$db->query($sql)) echo $db->error;
		}
	}
