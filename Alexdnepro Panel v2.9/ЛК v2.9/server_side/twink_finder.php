<?php

function AddAccIP(&$ipdata, $ip, $isreg = false)
{
	if (!isset($ipdata[$ip]) || !is_array($ipdata[$ip])) $ipdata[$ip] = array('cnt' => 0, 'r' => $isreg);
	$ipdata[$ip]['cnt']++;
	$ipdata[$ip]['r'] = ($ipdata[$ip]['r'] || $isreg);
}

function GetAccIPData($acc)
{
	global $db;
	$ipdata = array();
	foreach ($acc as $i => $userid)
	{
		$ipdata[$userid] = array(
			'name' => 'Not found',
			'ips' => array()
		);
		$res = $db->query("SELECT `name`,`idnumber` FROM `users` WHERE `ID`=".$userid);
		if (!$res) return $ipdata;		
		if (!$res->num_rows) continue;
		$row = mysqli_fetch_assoc($res);
		$ipdata[$userid]['name'] = $row['name'];
		AddAccIP($ipdata[$userid]['ips'], $row['idnumber'], true);
		$res = $db->query("SELECT `ip` FROM `login_log` WHERE (`action`=1 OR `action`=3) AND `userid`=".$userid);
		if (!$res) return $ipdata;
		while ($row = mysqli_fetch_assoc($res))
		{
			AddAccIP($ipdata[$userid]['ips'], $row['ip']);
		}
	}
	return $ipdata;
}

function GetTwinkIPCount($ip, $userid)
{
	global $db;
	$res = $db->query("SELECT count(*) FROM `login_log` WHERE `ip`='$ip' AND (`action`=1 OR `action`=3) AND `userid`=".$userid);
	if (!$res) return 0;
	$row = mysqli_fetch_array($res);
	return $row[0];
}

function GetTwinkAccounts(&$acc, $userid, $level = 0, $max_acc_parse = 0)
{
	global $db;
	if (!$userid) return;
	if (!in_array($userid, $acc, false)) $acc[] = $userid;
	if ($max_acc_parse && count($acc) >= $max_acc_parse) return;
	$ips = array();
	$res = $db->query("SELECT `idnumber` FROM `users` WHERE `ID`=".$userid);
	if (!$res) return;
	$row = mysqli_fetch_assoc($res);
	if ($row['idnumber']) $ips[] = $row['idnumber'];
	$res = $db->query("SELECT DISTINCT `ip` FROM `login_log` WHERE (`action`=1 OR `action`=3) AND `userid`=".$userid);
	if (!$res) return;
	while ($row = mysqli_fetch_assoc($res))
	{		
		$ips[] = $row['ip'];
	}
	foreach ($ips as $i => $ip)
	{
		if ($max_acc_parse && count($acc) >= $max_acc_parse) return;
		$userids = implode(",",$acc);		
		$res = $db->query("SELECT `ID` FROM `users` WHERE `idnumber`='$ip' AND `ID` NOT IN (".$userids.')');
		if (!$res) return;
		while ($row = mysqli_fetch_assoc($res))
		{
			if (!in_array($row['ID'], $acc,false))
			{				
				$acc[] = $row['ID'];
				GetTwinkAccounts($acc, $row['ID'], $level, $max_acc_parse);
			}
		}
		$userids = implode(',',$acc);
		$res = $db->query("SELECT `userid` FROM `login_log` WHERE (`action`=1 OR `action`=3) AND `ip`='$ip' AND `userid` NOT IN (".$userids.")");
		if (!$res) return;
		while ($row = mysqli_fetch_assoc($res))
		{
			if ($level > 0)
			{
				if (GetTwinkIPCount($ip, $row['userid']) < $level) continue;
			}
			if (!in_array($row['userid'], $acc,false))
			{
				$acc[] = $row['userid'];
				if ($max_acc_parse && count($acc) >= $max_acc_parse) return;
				GetTwinkAccounts($acc, $row['userid'], $level, $max_acc_parse);
			}
		}
	}
}