<?php
include('../config.php');
if (!in_array($_SESSION['id'], $ext_users)) die();
if (isset($_GET['id'])||isset($_GET['login'])) {	
	if (isset($_GET['id'])) {
		$postdata = array(
			'op' => 'userinfo',
			'servid' => $servid,
			'id' => intval($_GET['id'])
		);
		$donsumm = GetUserDonateSumm('', $_GET['id']);	
	} else {
		if (preg_match($login_filter, $_GET['login']) || strlen($_GET['login']) < $login_min_len || strlen($_GET['login']) > $login_max_len) {
			echo GetErrorTxt(10);
			die();
		}
		$postdata = array(
			'op' => 'userinfo',
			'servid' => $servid,
			'login' => $_GET['login']
		);
		$donsumm = GetUserDonateSumm($_GET['login'], '');	
	}
	printf('Пожертвовано: <b><font color="#ffff00">%s руб.</font></b><br>', $donsumm);
} else 
 {
	$postdata = array(
		'op' => 'lklogs'
	);
	$postdata = array_merge($_GET, $postdata);
}
CurlPage($postdata, 10, 0, true);
?>