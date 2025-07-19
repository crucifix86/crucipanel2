<?php
/*
 *
 * @Personal cabinet mod
 * @author  alexdnepro
 * 2018-03
*/

class LogFormat
{
	var $gorn;
	var $nick_table;
	var $nick_id_field;
	var $klan_table;
	var $klan_id_field;
	var $klan_name_field;
	var $find_role_id;
	var $type;

	function __construct($find_role_id = 0, $type = 'chat')
	{
		$this->gorn = array ('','[радостно]','[разочарованно]','[грустно]','[счастливо]','[недовольно]','[нежно]','[влюбленно]','[одиноко]','[восхищенно]','[в гневе]');
		$this->nick_table = 'top';
		$this->nick_id_field = 'roleid';
		$this->nick_name_field = 'rolename';
		$this->klan_table = 'klan';
		$this->klan_id_field = 'id';
		$this->klan_name_field = 'name';
		$this->find_role_id = $find_role_id;
		$this->type = $type;
	}

	function GetTime($t){	
		if ($t == 0) return '';
		return strftime(' <font color="#c0c0c0">действует до <font color="#00ff00">%d.%m.%Y %T</font></font> ', $t);
	}

	function GetRoleName($roleid, $rolename){
		$name = '<font color="#ff0000">UNK</font>';
		if ($roleid == 1) {
			return '<b>Аукцион</b> ';
		}
		if ($roleid == -1) {
			return '<b>GM</b> ';
		}
		if ($rolename) $name = $rolename;
		$col = "roleidcol";
		if ($roleid == $this->find_role_id) $col = "selcol";
		if ($this->type == 'chat') $f = 'FindChatRole('.$roleid.')'; else
		if ($this->type == 'main') $f = 'FindLogRole('.$roleid.')';
		return '<span class="role_panel" onclick="RolePanel('.$roleid.',\''.htmlspecialchars($name).'\')"></span><b><span class="'.$col.'"><a href="#" onclick="'.$f.'">'.$roleid.'</a></span> <span class="pmcol">'.$name.'</span></b> ';
	}

	function GetFactionName($fid, $fname){
		$name = '<font color="#ff0000">UNK</font>';
		if ($fname) $name = $fname;	
		return '<a href="#" onclick="FindFaction('.$fid.')"><span class="selcol"><b>'.$fid.'</b></span></a> <font color="#ffffff">'.$name.'</font> ';	
	}

	function GornEmoticon($id)
	{
		$id = intval($id);
		if (isset($this->gorn[$id])) return $this->gorn[$id];
		return "[$id]";
	}
	
	function GetExpireTime($t)
	{
		if ($t == 0) return '';
		return sprintf(' <font color="#c0c0c0">%s <font color="#00ff00">%s</font></font> ', 'до ', date('Y-m-d H:i:s', $t));
	}

	function PrintItem($id, $name, $icon, $count, $expire = 0, $stackid = -1, $print_delim = false)
	{
		if ($id == 0) return '';
		if ($stackid < 0) $stack = ''; else $stack = ' <font color="#004000">'.$stackid.'</font>';
		if ($print_delim) $delim =';'; else $delim = '';
		return '<font color="#ffff00">'.$count.'</font> <img src="getitemicon.php?i='.urlencode(base64_encode($icon)).'" border="0"> <b>'.$name.'</b><font color="#888888"> ('.$id.')</font>'.$this->GetExpireTime($expire).$stack.$delim.' ';
	}

	function PrintItems($items, $role, $money)
	{
		if ($money > 0) $m = sprintf(' <font color="a0a0a0">(деньги: %d)</font>', $money); else $m = '';
		$res = sprintf('%s%s => ', $role, $m);
		foreach ($items as $i => $val)
		{
			$res .= $this->PrintItem($val['item_id'], $val['item_name'], $val['item_icon'], $val['item_count'], 0, $val['item_pos'], true);
		}
		$res .= '<br>';
		return $res;
	}

	function PrintMob($id, $count, $name, $visual_id = 0, $visual_name = '')
	{
		if ($visual_id == 0) $vis = ''; else
			$vis = ' <font color="#90e090">[внешность <font color="#c0c0c0">'.$visual_name.'</font><font color="#888888"> ('.$visual_id.') </font>]</font>';
		return '<font color="#ffff00">'.$count.'</font> <b>'.$name.'</b><font color="#888888"> ('.$id.')</font>'.$vis;
	}

	public function FormatMainLogLine($l)
	{
		$name1 = htmlspecialchars($l['role_name1']);
		$name2 = htmlspecialchars($l['role_name2']);
		$d = '<span class="data">'.$l['date'].'</span>';
		if ($l['role_id1'] != 0) $l['role_name1'] = $this->GetRoleName($l['role_id1'], $name1);
		if ($l['role_id2'] != 0) $l['role_name2'] = $this->GetRoleName($l['role_id2'], $name2);
		switch ($l['type']){
			case 1: // ShopBuy
				return sprintf('<div class="p act1">%s %s<font color=cyan>покупка из шопа: </font>%sСтоимость: <font color=#ffff00>%d</font> Остаток: <font color=#ffff00>%d</font></div>', $d, $l['role_name1'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['cash_need'], $l['cash_left']);
			break;
			case 2: // PlayersTrade
				return sprintf('<div class="p act2">%s %s <span class="act">торг с</span> %s <br>%s%s</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItems($l['items1'], $l['role_name1'], $l['money1']), $this->PrintItems($l['items2'], $l['role_name2'], $l['money2']));
			break;
			case 3: // SysSendMail
				return sprintf('<div class="p act3">%s %s => <font color="#efb608">отправка почты системой</font> %s %s (деньги: <font color="#ffff00">%d</font>)</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			case 4: // PlayerSendMail
				return sprintf('<div class="p act3">%s %s => <font color="#efb608">отправка почты</font> %s %s (деньги: <font color="#ffff00">%d</font>)</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			case 5: // PlayerDeleteMail
				return sprintf('<div class="p act5">%s <font color="#ef3908">удаление письма </font>%s => %s %s (деньги: <font color="#ffff00">%d</font>)</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			case 6: // GetMailAttach
				return sprintf('<div class="p act5">%s <font color="#ef3908">получение содержимого </font>%s => %s %s (деньги: <font color="#ffff00">%d</font>)</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			case 7: // DividentShopBuy
				return sprintf('<div class="p act1">%s %s<font color="#80e0e0">покупка из ярмарки: </font>%sСтоимость: <font color=#ffff00>%d</font> Остаток: <font color=#ffff00>%d</font></div>', $d, $l['role_name1'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['cash_need'], $l['cash_left']);
			break;
			case 8: // PlayerShopBuy
				return sprintf('<div class="p act2">%s %s <span class="act">покупка через комиссионый магазин у</span> %s %s за <font color="#ffff00">%d</font> и <font color="#ffff00">%d</font> чеков</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1'], $l['yp_cost']);
			break;
			case 9: // UserSold
				return sprintf('<div class="p wp">%s %s <font color="cyan">продал через кота</font> %s %s за <font color="#ffff00">%d</font></div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			case 10: // SellToNPC
				return sprintf('<div class="p wp">%s %s <font color="#80e0e0">продал НПСу</font> %s</div>', $d, $l['role_name1'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']));
			break;
			case 11: // DropItem
				return sprintf('<div class="p wp">%s %s <font color="#ef3908">выбросил (выбили)</font> %s</div>', $d, $l['role_name1'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']));
			break;
			case 12: // PickUpItem
				return sprintf('<div class="p wp">%s %s <font color="#efb608">поднял</font> %s <font color="#ef3908"><b>выбитых из</b></font> %s</div>', $d, $l['role_name1'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['role_name2']);
			break;
			case 13: // GMTriggerOn
				return sprintf('<div class="p wp">%s <font color="red">GM: </font>%s <font color="#ef5050"><b>активировал триггер</b></font> %d</div>', $d, $l['role_name1'], $l['item_id']);
			break;
			case 14: // GMTriggerOff
				return sprintf('<div class="p wp">%s <font color="red">GM: </font>%s <font color="#50ef50"><b>отключил триггер</b></font> %d</div>', $d, $l['role_name1'], $l['item_id']);
			break;
			case 15: // GMGenMob
				return sprintf('<div class="p wp">%s <font color="red">GM: </font>%s <font color="#ef4040"><b>сгенерировал моба</b></font> %s</div>', $d, $l['role_name1'], $this->PrintMob($l['item_id'], $l['item_count'], $l['item_name'], $l['money1'], $l['role_name2']));
			break;
			case 16: // DebugCommand
				return sprintf('<div class="p wp">%s %s <font color="#ff2020"><b>дебаг комманда</b></font> %d</div>', $d, $l['role_name1'], $l['item_id']);
			break;
			case 17: // GMEventOn
				return sprintf('<div class="p wp">%s <font color="red">GM: </font>%s <font color="#ef5050"><b>активировал событие</b></font> %d</div>', $d, $l['role_name1'], $l['item_id']);
			break;
			case 18: // GMEventOn
				return sprintf('<div class="p wp">%s <font color="red">GM: </font>%s <font color="#50ef50"><b>отключил событие</b></font> %d</div>', $d, $l['role_name1'], $l['item_id']);
			break;
			case 19: // FactionMassMail
				return sprintf('<div class="p act3">%s %s <font color="#efb608">массовая отправки почты клану</font> %s %s (деньги: <font color="#ffff00">%d</font>)</div>', $d, $l['role_name1'], $l['role_name2'], $this->PrintItem($l['item_id'], $l['item_name'], $l['item_icon'], $l['item_count'], $l['expire']), $l['money1']);
			break;
			default:
				return sprintf('<p>Неизвестный тип лога %s</p><br>', $l['type']);
			break;
		}
	}

	public function FormatChatLogLine($l)
	{
		$name1 = htmlspecialchars($l['name1']);
		$name2 = htmlspecialchars($l['name2']);
		$l['msg'] = htmlspecialchars($l['msg']);
		$d = '<span class="data">'.$l['date'].'</span> ';
		if ($l['type'] == 1 || $l['type'] == 2 || $l['type'] == 3) $l['name1'] = $this->GetRoleName($l['param1'], $name1);
		if ($l['type'] == 2 || $l['type'] == 4) $l['name2'] = $this->GetRoleName($l['param2'], $name2);
		if ($l['type'] == 3) $l['name2'] = $this->GetFactionName($l['param2'], $name2);		
		$l['msg'] = preg_replace('/[]&lt;(\d+)&gt;&lt;(\d+):(\d+)&gt;/u', '<span class="smile smile$2_$3"></span>', $l['msg']);		
		$l['msg'] = preg_replace('/[]&lt;(\d+)&gt;&lt;W&gt;&lt;(\d+):(\d+)&gt;/u', '<span class="smile smile$2_$3"></span>', $l['msg']);
		$l['msg'] = preg_replace('/[]&lt;1&gt;&lt;\^(.{6})(\[.+\])&gt;/u', ' <font color="$1">$2</font>', $l['msg']);
		$l['msg'] = preg_replace('/\\[\^([0-9abcdef]{6})(.*)\]/u', '[<font color="$1">$2</font>]', $l['msg']);
		$l['msg'] = preg_replace('/[]&lt;5&gt;&lt;(\[.+\])&gt;&lt;.+&gt;/u', ' <font color="#ffffff">$1</font>', $l['msg']);
		$em = '';
		switch ($l['type']){
			case 1:
				if ($l['param2'] <> 2){
					if ($l['param2'] == 12 || $l['param2'] == 15){
						// Горны
						if (preg_match('/(.{6})(\d{2})$/', $l['msg'], $m)) {
							$l['msg'] = sprintf('<font color="#%s">%s</font>', $m[1], substr($l['msg'], 0, strlen($l['msg'])-8));
							if ($m[2] > 0) $em = ' '.$this->GornEmoticon($m[2]);
						}
					}
					$s = '';
					if ($l['param2'] == 1) $s = 'worldcol'; else
        				if ($l['param2'] == 7) $s = 'torgcol'; else
        				if ($l['param2'] == 9) $s = 'gmcol';
					return sprintf('<p class="ch%d">%s<i class="channel%d"></i>%s%s <span class="%s">%s</span><br></p>'.chr(10), $l['param2'], $d, $l['param2'], $l['name1'], $em, $s, $l['msg']);
				} else {
					$s = 'groupcol';
					return sprintf('<p class="ch2">%s<i class="channel%d"></i>%s <span class="%s">%s</span><br></p>'.chr(10), $d, $l['param2'], $l['name1'], $s, $l['msg']);
				}
			break;

			case 2:
				$s = 'pmcol';
				return sprintf('<p class="ch4">%s<i class="channel4"></i>%s %s <span class="%s">%s</span><br></p>'.chr(10), $d, $l['name1'], $l['name2'], $s, $l['msg']);
			break;

			case 3:
				$s = 'guildcol';
				return sprintf('<p class="ch3">%s<i class="channel3"></i>%s %s <span class="%s">%s</span><br></p>'.chr(10), $d, $l['name2'], $l['name1'], $s, $l['msg']);
			break;

			case 4:
				$s = 'roomcol';
				return sprintf('<p class="ch5">%s<span class="roleidcol">Room %d</span> %s <span class="%s">%s</span><br></p>'.chr(10), $d, $l['param1'], $l['name2'], $s, $l['msg']);
			break;
		}
	}
}

?>