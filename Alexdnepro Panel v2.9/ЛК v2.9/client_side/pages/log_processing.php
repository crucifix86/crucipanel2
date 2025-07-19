<?php
include('../config.php');
if (!isset($_SESSION['id']) || !in_array($_SESSION['id'], $log_read_ids)) die('');
include('logformat.php');
$err = '<div class="alert alert-error">%s</div>';
if (isset($_GET['ban']))
{
	extract($_POST);
	$broadcast = (isset($broadcast));
	$postdata = array(
		'op' => 'log_ban',
		'roleid' => $roleid,
		'rolename' => $rolename,
		'time' => $time,
		'type' => $type,
		'reason' => $reason,
		'broadcast' => $broadcast,
		'id' => $_SESSION['id'],
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	$result = CurlPage($postdata, 15);
	die($result);
} else
if (isset($_POST['msg']) && isset($_POST['channel']))
{
	extract($_POST);
	$postdata = array(
		'op' => 'log_send_msg',
		'msg' => $msg,
		'channel' => intval($channel),
		'id' => $_SESSION['id'],
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	$result = CurlPage($postdata, 15);
	$answ = array('status' => 'error');	
	$a = @UnpackAnswer($result);
	if (is_array($a))
	{
		if ($a['errorcode'] == 0) $answ['status'] = 'success';
	}
	echo json_encode( $answ );
	die();
} else
if (isset($_POST['log']) && ($_POST['log'] == 'chat' || $_POST['log'] == 'main'))
{
	extract($_POST);
	$start = ($page-1)*$record_count; $limit = $record_count;
	$postdata = array(
		'date1' => $date1,
		'date2' => $date2,
		'role_id' => $role_id,
		'role_name' => $role_name,		
		'start' => $start,
		'limit' => $limit,
		'id' => $_SESSION['id'],
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	if ($_POST['log'] == 'chat') {
		$hide_chats = (isset($hide_chats))?($hide_chats):array();
		$postdata['op'] = 'logchat';
		$postdata['hide_chats'] = implode(',', $hide_chats);
		$postdata['faction_id'] = $faction_id;
		$postdata['faction_name'] = $faction_name;
		$postdata['word'] = $word;
	} else
	if ($_POST['log'] == 'main') {
		$postdata['op'] = 'logmain';
		$postdata['item_id'] = $item_id;
		$postdata['money'] = $money;
	}
	$result = CurlPage($postdata, 15);
	$answ = array('count'=>0, 'status' => 'error', 'pages' => 0);	
	$a = @UnpackAnswer($result);	
	if (!is_array($a))
	{
		$answ['data'] = sprintf($err, $a);
	} else
	if ($a['errorcode'] != 0) 
	{
		$answ['data'] = sprintf($err,$a['errtxt']);
	} else
	{
		$answ['count'] = $a['count'];
		$answ['status'] = 'success';
		$answ['data'] = '';
		$answ['pages'] = ceil($a['count'] / $limit);
		$l = new LogFormat($role_id, $_POST['log']);
		if ($div == 'true') $answ['data'] = '<div class="left-side">';
		if ($limit > $a['count']) $limit = $a['count'];
		$cnt_div = ceil($limit / 2); $cnt = 0;
		foreach ($a['logs'] as $i => $val) 
		{
			if ($_POST['log'] == 'chat') $answ['data'] .= $l->FormatChatLogLine($val); else
			if ($_POST['log'] == 'main') $answ['data'] .= $l->FormatMainLogLine($val);
			if ($div == 'true')
			{
				$cnt++;
				if ($cnt == $cnt_div) $answ['data'] .= '</div><div class="right-side">';
			}
		}
		if (!$answ['count']) $answ['data'] .= 'По данному запросу записей нет';
		if ($div == 'true') $answ['data'] .= '</div><div class="clearfix"></div>';		
	}
	echo json_encode( $answ );
	die();
}
?>