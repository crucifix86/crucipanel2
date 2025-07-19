<?php
include('../config.php');
if (!isset($_SESSION['id']) || $_SESSION['id'] < 16) die();
if (isset($_GET['op'])) {
	$op = $_GET['op'];
	if ($op == 'proctypeform') {
		echo '<div id="proctypeform">
	<table border=0 cellpadding=0 cellspacing=0>
	<tr style="vertical-align:top">
		<td style="width: 240px">
			<input id="proctype_1" onclick="getproctype()" type="checkbox"> Защита от смерти<br>
			<input id="proctype_2" onclick="getproctype()" type="checkbox"> Нельзя выбросить<br>
			<input id="proctype_3" onclick="getproctype()" type="checkbox"> Нельзя продать НПС<br>
			<input id="proctype_4" onclick="getproctype()" type="checkbox"> Не падает при смерти<br>
			<input id="proctype_5" onclick="getproctype()" type="checkbox"> Нельзя обменять<br>
			<input id="proctype_6" onclick="getproctype()" type="checkbox"> Нельзя улучшать<br>
			<input id="proctype_7" onclick="getproctype()" type="checkbox"> Сплетатель душ<br>
			<input id="proctype_8" onclick="getproctype()" type="checkbox"> Нельзя поместить на общий склад<br>
			<input id="proctype_9" onclick="getproctype()" type="checkbox"> Исчезает при смене локации<br>			
		</td>
		<td>
			<input id="proctype_10" onclick="getproctype()" type="checkbox"> Использовать автоматически<br>
			<input id="proctype_11" onclick="getproctype()" type="checkbox"> Теряется в случае смерти<br>
			<input id="proctype_12" onclick="getproctype()" type="checkbox"> Теряется при выходе<br>
			<input id="proctype_13" onclick="getproctype()" type="checkbox"> Нельзя отремонтировать<br>
			<input id="proctype_14" onclick="getproctype()" type="checkbox"> ПК игрок убит - повреждается<br>
			<input id="proctype_15" onclick="getproctype()" type="checkbox"> Нельзя поместить на общий склад<br>
			<input id="proctype_16" onclick="getproctype()" type="checkbox"> Текст "Предмет привязан"<br>
			<input id="proctype_17" onclick="getproctype()" type="checkbox"> Можно продать в поисках сокровищ (WebTrade)<br>
			<input id="proctype_18" onclick="getproctype()" type="checkbox"> Товары со спец покупок (Mall)<br>
		</td>
	</tr>
	</table>
    </div>';
		die();
	} else
	if ($op == 'maskform') {
		echo '<div id="maskform">
	<table border=0 cellpadding=0 cellspacing=0>
	<tr style="vertical-align:top">
		<td style="width: 185px">
			<input id="mask_1" onclick="getmask()" type="checkbox"> Оружие<br>
			<input id="mask_2" onclick="getmask()" type="checkbox"> Шлем<br>
			<input id="mask_3" onclick="getmask()" type="checkbox"> Ожерелье<br>
			<input id="mask_4" onclick="getmask()" type="checkbox"> Плащ<br>
			<input id="mask_5" onclick="getmask()" type="checkbox"> Броня<br>
			<input id="mask_6" onclick="getmask()" type="checkbox"> Пояс<br>
			<input id="mask_7" onclick="getmask()" type="checkbox"> Бриджи<br>
			<input id="mask_8" onclick="getmask()" type="checkbox"> Сапоги<br>
			<input id="mask_9" onclick="getmask()" type="checkbox"> Наручи<br>
			<input id="mask_10" onclick="getmask()" type="checkbox"> Кольцо - Левое<br>
			<input id="mask_11" onclick="getmask()" type="checkbox"> Кольцо - Правое<br>
			<input id="mask_12" onclick="getmask()" type="checkbox"> Стрелы<br>
			<input id="mask_13" onclick="getmask()" type="checkbox"> Полет<br>
			<input id="mask_14" onclick="getmask()" type="checkbox"> Стиль - Верх<br>
			<input id="mask_15" onclick="getmask()" type="checkbox"> Стиль - штаны<br>
			<input id="mask_16" onclick="getmask()" type="checkbox"> Камень | Стиль - сапоги
		</td>
		<td>
			<input id="mask_17" onclick="getmask()" type="checkbox"> Стиль - Наручи<br>
			<input id="mask_18" onclick="getmask()" type="checkbox"> Знак атаки<br>
			<input id="mask_19" onclick="getmask()" type="checkbox"> Трактат<br>
			<input id="mask_20" onclick="getmask()" type="checkbox"> Смайлы<br>
			<input id="mask_21" onclick="getmask()" type="checkbox"> Хирка HP<br>
			<input id="mask_22" onclick="getmask()" type="checkbox"> Хирка MP<br>
			<input id="mask_23" onclick="getmask()" type="checkbox"> Цитатник<br>
			<input id="mask_24" onclick="getmask()" type="checkbox"> Джин<br>
			<input id="mask_25" onclick="getmask()" type="checkbox"> Торговая лавка<br>
			<input id="mask_26" onclick="getmask()" type="checkbox"> Стиль - Головной убор<br>
			<input id="mask_27" onclick="getmask()" type="checkbox"> Грамота альянса<br>
			<input id="mask_28" onclick="getmask()" type="checkbox"> Печать воителя - верх<br>
			<input id="mask_29" onclick="getmask()" type="checkbox"> Печать воителя - низ<br>
			<input id="mask_30" onclick="getmask()" type="checkbox"> Стиль оружие<br>
			<input id="mask_31" onclick="getmask()" type="checkbox"> Надет/Снят<br>
			<input id="mask_32" onclick="getmask()" type="checkbox"> Неизв.
		</td>
	</tr>
	</table>
    </div>';
		die();
	} else
	if ($op != 'history' && $op != 'loginlog') die();
	$postdata = array(
		'op' => $op,	
		'id' => $_SESSION['id'],
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	$postdata = array_merge($_GET, $postdata);
	CurlPage($postdata, 10, 0, true);
} else
if (isset($_GET['subact'])){
	$subact = $_GET['subact'];
	if ($subact == 'show_skills'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 82,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP()
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				if (count($a['skills']) > 0){
					echo '
<script language="javascript">
function confskill(num, i){
	if (window.confirm(\'Вы уверены, что хотите купить данный скилл?\')) {
		ModalLoad();
		document.location.href = "index.php?op=act&n=83&num="+num+"&i="+i+"&rand="+Math.random();
		return true;
	} else return false;
}
</script>';					
					echo '<div align="center"><span class="label label-success">Список скиллов, доступных для персонажа '.htmlspecialchars($a['rolename']).'</span>
					<table class="table table-bordered table-striped bootstrap-datatable datatable">
					<thead>
						<tr>
							<td style="width:500px">Название</td>
							<td>Действие</td>
						</tr>
					</thead>
					<tbody>';					
					foreach ($a['skills'] as $i => $val) {	
						$icon = '';
						if ($val['icon'] != '') $icon = $icon = sprintf('<img src="getitemicon.php?i=%s&skill" border="0" class="imcnt"> ', urlencode(base64_encode($val['icon'])));
						
						ParseCost($val['cost'], $gold, $silver);
						$showgold = ($gold==0)?' hide':''; $showsilver = ($silver==0)?' hide':'';
						$cost = sprintf('<span class="gold%s">%d</span> <span class="silver%s">%d</span>', $showgold, $gold, $showsilver, $silver);
						printf('
						<tr>
						<td><div class="sname">%s (<b>%d ур.</b>)</div></td>
						<td><a class="btn btn-mini btn-inverse" onclick="confskill(%d, %d)" href="#">Купить %s</a></td>
					</tr>',
						$icon.$val['name'], $val['max_lvl'],
						$a['rolenum'],
						$val['id'],
						$cost);						
					}					
					echo '</tbody></table></div>';
				} else printf('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Ошибка!</strong> %s</div>', 'На данного персонажа нет скиллов, доступных для покупки');
			}
		}
	} else

	if ($lvlup_enable && $subact == 'buylvl'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 84,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP()
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);			
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				$level = $a['level'];
				if ($level >= $lvlup_maxlvl) {
					echo GetErrorTxt(10);
					die();
				}
				$name = $a['name'];
				ParseCost($lvlup_100_cost, $lvlup_100_cost_g, $lvlup_100_cost_s);
				ParseCost($lvlup_110_cost, $lvlup_110_cost_g, $lvlup_110_cost_s);
				ParseCost($lvlup_120_cost, $lvlup_120_cost_g, $lvlup_120_cost_s);
				ParseCost($lvlup_130_cost, $lvlup_130_cost_g, $lvlup_130_cost_s);
				ParseCost($lvlup_140_cost, $lvlup_140_cost_g, $lvlup_140_cost_s);
				ParseCost($lvlup_150_cost, $lvlup_150_cost_g, $lvlup_150_cost_s);
				ParseCost($lvlup_150_plus, $lvlup_150_plus_g, $lvlup_150_plus_s);
					echo '
<script language="javascript">
var BaseLvl = '.$level.';
var CurLvl = '.$lvlup_maxlvl.';
var MinLvl = '.($level+1).';
var MaxLvl = '.$lvlup_maxlvl.';
var lvlup_100_cost_g = '.$lvlup_100_cost_g.';
var lvlup_110_cost_g = '.$lvlup_110_cost_g.';
var lvlup_120_cost_g = '.$lvlup_120_cost_g.';
var lvlup_130_cost_g = '.$lvlup_130_cost_g.';
var lvlup_140_cost_g = '.$lvlup_140_cost_g.';
var lvlup_150_cost_g = '.$lvlup_150_cost_g.';
var lvlup_150_plus_g = '.$lvlup_150_plus_g.';
var lvlup_100_cost_s = '.$lvlup_100_cost_s.';
var lvlup_110_cost_s = '.$lvlup_110_cost_s.';
var lvlup_120_cost_s = '.$lvlup_120_cost_s.';
var lvlup_130_cost_s = '.$lvlup_130_cost_s.';
var lvlup_140_cost_s = '.$lvlup_140_cost_s.';
var lvlup_150_cost_s = '.$lvlup_150_cost_s.';
var lvlup_150_plus_s = '.$lvlup_150_plus_s.';
var cost_g = 0;
var cost_s = 0;
function conf1(){
	if (window.confirm(\'Вы уверены, что хотите купить уровень на данного персонажа?\')) {
		ModalLoad();
		document.location.href = "index.php?op=act&n=9&num="+'.$_GET['num'].'+"&newlevel="+CurLvl+"&rand="+Math.random();
		return true;
	} else return false;
}

function CalcSubLvlCost(range1, range2, cost_g_, cost_s_){
	if (CurLvl > range1 && BaseLvl < range2) {
		if (CurLvl <= range2) SubLvl = CurLvl; else SubLvl = range2;
		if (BaseLvl >= range1) diffr = SubLvl - BaseLvl; else diffr = SubLvl - range1;
		cost_g += diffr * cost_g_;
		cost_s += diffr * cost_s_;
	}
}

function ChangeLvl(){
	var I = document.getElementById("new_lvl");
	var G = document.getElementById("e_gold");
	var S = document.getElementById("e_silver");	
	cost_g = 0;
	cost_s = 0;
	CurLvl = I.value*1;
	if (CurLvl > MaxLvl) CurLvl = MaxLvl;
	if (CurLvl < MinLvl) CurLvl = MinLvl;
	if (I.value != CurLvl) I.value = CurLvl;
	if (CurLvl > 150) {
		if (BaseLvl >= 150) diffr = CurLvl - BaseLvl; else diffr = CurLvl - 150;
		cost_g += diffr * lvlup_150_plus_g;
		cost_s += diffr * lvlup_150_plus_s;
	}
	CalcSubLvlCost(140, 150, lvlup_150_cost_g, lvlup_150_cost_s);
	CalcSubLvlCost(130, 140, lvlup_140_cost_g, lvlup_140_cost_s);
	CalcSubLvlCost(120, 130, lvlup_130_cost_g, lvlup_130_cost_s);
	CalcSubLvlCost(110, 120, lvlup_120_cost_g, lvlup_120_cost_s);
	CalcSubLvlCost(100, 110, lvlup_110_cost_g, lvlup_110_cost_s);
	CalcSubLvlCost(1, 100, lvlup_100_cost_g, lvlup_100_cost_s);
	G.innerHTML = cost_g;
	S.innerHTML = cost_s;
	if (cost_g < 1) G.setAttribute("class", "gold hide"); else G.setAttribute("class", "gold");
	if (cost_s < 1) S.setAttribute("class", "silver hide"); else S.setAttribute("class", "silver");
}
function BtnActL(pl){
	var I = document.getElementById("new_lvl");
	CurLvl = I.value*1;
	if (pl) {
		CurLvl+=10;
		if (CurLvl > MaxLvl) CurLvl = MaxLvl;
	} else {
		CurLvl-=10;
		if (CurLvl < MinLvl) CurLvl = MinLvl;
	}
	I.value = CurLvl;
	ChangeLvl();
}
</script>';					
					echo '<div align="center"><span class="label label-success">Для персонажа '.htmlspecialchars($name).'</span><br>';
					$cost = '<span id="e_gold" class="gold">0</span> <span id="e_silver" class="silver">0</span>';
					printf('<a class="btn btn-mini btn-primary" href="#" style="width:10px; height:15px;" onclick="BtnActL(false)"><font size="+1">-</font></a> <input type="number" onchange="ChangeLvl()" onkeyup="setTimeout(ChangeLvl, 1000)" id="new_lvl" value="%d" min="%d" max="%d" maxlength="4" style="width:50px"> <a class="btn btn-mini btn-primary" href="#" style="width:10px; height:15px;" onclick="BtnActL(true)"><font size="+1">+</font></a> <a class="btn btn-inverse w200" onclick="conf1()" href="#">Купить за %s</a>', $lvlup_maxlvl, $level+1, $lvlup_maxlvl, $cost);								
					echo '</div><br>
					<span class="label label-important">Обратите внимание!</span>
		<ul align="left" type="disc">
			<li>После покупки уровня, все статы станут нераспределенными</li>
		</ul>
<script type="text/javascript">
ChangeLvl();
</script>';
			}
		}
	} else
	if ($subact == 'show_buffs'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 63,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP()
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				if (count($a['buffs']) > 0){
					echo '
<script language="javascript">
function conf1(num, i, cnt_n){
	if (window.confirm(\'Вы уверены, что хотите купить данный баф?\')) {
		ModalLoad();
		document.location.href = "index.php?op=act&n=64&num="+num+"&i="+i+"&cnt="+window["cur_count"+cnt_n]+"&rand="+Math.random();
		return true;
	} else return false;
}
function GetTime(t,h){
	pinkdays = Math.floor(t/86400);
	pinkhours = Math.floor((t-pinkdays*86400)/3600);
	pinkmin = Math.floor((t-pinkdays*86400-pinkhours*3600)/60);
	pinksec = Math.round(t-pinkdays*86400-pinkhours*3600-pinkmin*60,0);
	if (pinkhours<10) pinkhours="0"+pinkhours;
	if (pinkmin<10) pinkmin="0"+pinkmin;
	if (pinksec<10) pinksec="0"+pinksec;
	timeused = "";
	if (pinkdays>0) {
		if (h) timeused=\'<font color="#00aa00"><b>\'+pinkdays+\'</b></font> дн \'; else
		timeused=pinkdays+" дн ";
	}
	if ((pinkhours!="00")||(pinkmin!="00")||(pinksec!="00")) timeused += pinkhours+":"+pinkmin+":"+pinksec;
	if (timeused=="") timeused = 0;
	return \'<font color="#ffff00">\' + timeused + \'</font>\';
}
function BtnAct(n,p){
	cur_count = "cur_count"+n;
	e_gold = "e_gold"+n; e_silver = "e_silver"+n;
	e_count = "e_count"+n; expire = "expire"+n; cost = "cost"+n;
	if (p) {
		if (window[cur_count] > 99) return;
		window[cur_count]++;
	} else {
		if (window[cur_count] < 2) return;
		window[cur_count]--;
	}
	document.getElementById(e_count).innerHTML = GetTime(window[cur_count]*window[expire],true);
	document.getElementById(e_gold).innerHTML = window[cur_count]*window[cost][0];
	document.getElementById(e_silver).innerHTML = window[cur_count]*window[cost][1];
}
</script>';					
					echo '<div align="center"><span class="label label-success">Список бафов, доступных для персонажа '.htmlspecialchars($a['rolename']).'</span>
					<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<td>Название</td>
							<td>Описание</td>
							<td>Действие</td>
						</tr>
					</thead>
					<tbody>';					
					foreach ($a['buffs'] as $i => $val) {	
						$icon = '';
						if ($val['icon'] != '') $icon = sprintf('<img src="data:image/png;base64,%s" border="0" class="imcnt"> ', $val['icon']);
						$cost_txt = 'var cost'.$i.' = ';
						ParseCost($val['cost'], $gold, $silver);
						$cost_txt .= sprintf("[%d, %d]", $gold, $silver);
						$showgold = ($gold==0)?' hide':''; $showsilver = ($silver==0)?' hide':'';
						$cost = sprintf('<span id="e_gold%d" class="gold%s">%d</span> <span id="e_silver%d" class="silver%s">%d</span>', $i, $showgold, $gold, $i, $showsilver, $silver);
						printf('
						<tr>
						<td>%s</td>
						<td>%s</td>
						<td><a class="btn btn-mini btn-primary" href="#" onclick="BtnAct(%d,false)" style="width:10px; height:15px;"><font size="+1">-</font></a> <a class="btn btn-mini btn-inverse w200" onclick="conf1(%d, %d, %d)" href="#">Купить за %s<br>на <span id="e_count%d">%s</span></a> <a class="btn btn-mini btn-primary" href="#" style="width:10px; height:15px;" onclick="BtnAct(%d,true)"><font size="+1">+</font></a></td>
					</tr>',
						$icon.$val['name'],
						$val['description'],
						$i, $a['rolenum'],
						$val['id'], $i, 
						$cost, $i, '<font color="#ffff00">'.GetTime($val['expire']).'</font>', $i);
						echo "<script>\r\n";
						printf("var cur_count%d = 1;\r\n", $i);
						echo $cost_txt."\r\n";
						printf("var expire%d = %d;\r\n", $i, $val['expire']);
						echo '</script>';
					}					
					echo '</tbody></table></div>
					<span class="label label-important">Обратите внимание!</span>
		<ul align="left" type="disc">
			<li>ЛК бафы не снимаются друлей или другими дебафами и не исчезают после смерти</li>
			<li>Время действия и сила ЛК бафа может быть перебито аналогичным игровым бафом</li>
			<li>Время бафа считается только когда персонаж находится в игре</li>
		</ul>';
				}
			}
		}
	} else
	if ($add_distance_enable && $subact == 'add_distance'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 23,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP(),				
				'add_distance_classes' => serialize($add_distance_classes),
				'add_distance_max' => $add_distance_max,
				'add_distance_cost' => $add_distance_cost
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				if ($a['item_count'] > 0){
					echo '<script language="javascript">
					function conf1(){
						if (window.confirm(\'Вы уверены, что хотите увеличить дальность в данном оружии?\')) {
							ModalLoad();
							return true;
						} else return false;
					}
					</script>';					
					echo '<div align="center"><span class="label label-success">Вещи в инвентаре персонажа '.htmlspecialchars($a['rolename']).', на которых можно увеличить дальность</span>
					<table class="auth shop_items" cellspacing="0" cellpadding="0" border="0" style="width:100%">
						<tbody>
							<tr>
								<td class="auth">
									<table class="table table-bordered table-shop">
										<thead><tr>
											<td>Название вещи</td>
											<td>Позиция в инвентаре</td>
											<td>Действие</td>
										</tr></thead>
										<tbody>';					
					foreach ($a['items'] as $i => $val) {						
						printf('
						<tr>
						<td>%s</td>
						<td>%s</td>
						<td>
						<a class="btn btn-mini btn-inverse w200" onclick="return conf1()" href="index.php?op=act&n=24&num=%s&i=%s&rand='.time().'">Увеличить дальность до <b>'.$add_distance_max.'<b><br>'.ShowCost($add_distance_cost).'</a></td>
					</tr>',
					'<div align="left"><img title="'.htmlspecialchars($val['name']).'" data-content="'.str_replace('"',"'",$val['desc']).'" data-rel="popover" src="getitemicon.php?i='.urlencode(base64_encode($val['icon'])).'"> <span class="item_name">'.$val['name'].'</span></div>',
					$val['pos']+1,
					$a['rolenum'],
					$val['index'],
					$a['rolenum'],
					$val['index']);
					}					
					echo '</tbody></table></td></tr></tbody></table></div>';
				}
			}
		}
	} else
	if ($add_slot_enable && $subact == 'add_slot'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 21,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP(),
				'weapon_max_slot' => $weapon_max_slot,
				'armor_max_slot' => $armor_max_slot,
				'weapon_slot1_cost' => $weapon_slot1_cost,
				'weapon_slot2_cost' => $weapon_slot2_cost,
				'weapon_slot3_cost' => $weapon_slot3_cost,
				'weapon_slot4_cost' => $weapon_slot4_cost,	
				'armor_slot1_cost' => $armor_slot1_cost,
				'armor_slot2_cost' => $armor_slot2_cost,
				'armor_slot3_cost' => $armor_slot3_cost,
				'armor_slot4_cost' => $armor_slot4_cost
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				if ($a['item_count'] > 0){
					echo '<script language="javascript">
					function conf1(){
						if (window.confirm(\'Вы уверены, что хотите добавить ячейку в данной вещи?\')) {
							ModalLoad();
							return true;
						} else return false;
					}
					</script>';					
					echo '<br><div align="center"><span class="label label-success">Вещи в инвентаре персонажа '.htmlspecialchars($a['rolename']).', на которых можно добавить ячейку</span>
					<table class="auth shop_items" cellspacing="0" cellpadding="0" border="0" style="width:100%">
						<tbody>
							<tr>
								<td class="auth">
									<table class="table table-bordered table-shop">
										<thead><tr>
											<td>Название вещи</td>
											<td>Позиция в инвентаре</td>
											<td>Действие</td>
										</tr></thead>
										<tbody>';					
					foreach ($a['items'] as $i => $val) {						
						printf('
						<tr>
						<td>%s</td>
						<td>%s</td>
						<td>
						<a class="btn btn-mini btn-inverse w200" onclick="return conf1()" href="index.php?op=act&n=22&num=%s&i=%s&rand='.time().'">Добавить ячейку '.ShowCost($val['cost']).'</a></td>
					</tr>',
					'<div align="left"><img title="'.htmlspecialchars($val['name']).'" data-content="'.str_replace('"',"'",$val['desc']).'" data-rel="popover" src="getitemicon.php?i='.urlencode(base64_encode($val['icon'])).'"> <span class="item_name">'.$val['name'].'</span></div>',
					$val['pos']+1,
					$a['rolenum'],
					$val['index'],
					$a['rolenum'],
					$val['index']);
					}					
					echo '</tbody></table></td></tr></tbody></table></div>';
				}
			}
		}
	} else
	if ($unbind_enable && $subact == 'prctp'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 3,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP(),
				'proctype_list' => implode(',', $proctype_list)
			);
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);	
			if (!is_array($a) && !CheckNum($result)) echo GetErrorTxt($result); else		
			if ($a['errorcode'] == 0) {
				if ($a['item_count'] > 0){
					echo '<script language="javascript">
					function conf1(){
						if (window.confirm(\'Вы уверены, что хотите отвязать данную вещь?\')) {
							ModalLoad();
							return true;
						} else return false;
					}
					</script>';					
					echo '<br><div align="center"><span class="label label-success">Вещи в инвентаре персонажа '.htmlspecialchars($a['rolename']).', которые можно отвязать</span>
					<table class="auth shop_items" cellspacing="0" cellpadding="0" border="0" style="width:100%">
						<tbody>
							<tr>
								<td class="auth">
									<table class="table table-bordered table-shop">
										<thead><tr>
											<td>Название вещи</td>
											<td>Позиция в инвентаре</td>
											<td>Действие</td>
										</tr></thead>
										<tbody>';					
					foreach ($a['items'] as $i => $val) {
						$cost = getcost($val['id'],$val['list']); 
						printf('
						<tr>
						<td>%s</td>
						<td>%s</td>
						<td>
						<a class="btn btn-mini btn-inverse w200" onclick="return conf1()" href="index.php?op=act&n=4&num=%s&i=%s&id='.$val['id'].'&l='.$val['list'].'&rand='.time().'">Отвязать вещь '.ShowCost($cost).'</a></td>
					</tr>',
					'<div align="left"><img title="'.htmlspecialchars($val['name']).'" data-content="'.str_replace('"',"'",$val['desc']).'" data-rel="popover" src="getitemicon.php?i='.urlencode(base64_encode($val['icon'])).'"> <span class="item_name">'.$val['name'].'</span></div>',
					$val['pos']+1,
					$a['rolenum'],
					$val['index'],
					$a['rolenum'],
					$val['index']);
					}					
					echo '</tbody></table></td></tr></tbody></table></div>';
				}
			}
		}
	} else
	if ($chname_enable && $subact == 'chnam'){
		if ( !isset($_GET['num']) || CheckNum($_GET['num']) ) GetErrorTxt(10); else {
			$poststr = array(
				'op'	=> 'act',
				'id'	=> $_SESSION['id'],
				'n'	=> 13,
				'num'	=> $_GET['num'],
				'ip'	=> GetIP(),
				'name_maxlength' => $name_maxlength
			);			
			$result = CurlPage($poststr, 5);
			$a = UnpackAnswer($result);			
			if ($a['errorcode'] == 0) {
				if ($a['item_count'] > 0){
					echo '<script language="javascript">
					function conf3(s){
						F = document.getElementById("chfrm"+s);
						I = F.newname;
						if (I.value.length > '.$name_maxlength.') {
							alert("Длина нового ника создателя должна быть не больше '.$name_maxlength.' символов");
							return false;
						} else
						if (window.confirm("Обратите внимание! \rЗа нецензурные слова, оскорбления и прочие нарушения,\rпредусмотренные правилами, бан аккаунта будет выдаваться без предупреждений!\r\rВы уверены, что хотите изменить создателя данной вещи?")){
							ModalLoad();
							document.body.appendChild(F);
							F.submit();
						}
						return false;			
					}
					</script>';
					echo '<br><div align="center"><span class="label label-success">Вещи в инвентаре персонажа '.htmlspecialchars($a['rolename']).', на которых можно поменять создателя</span>
					<table class="auth shop_items" cellspacing="0" cellpadding="0" border="0" style="width:100%">
						<tbody>
							<tr>
								<td class="auth">
									<table class="table table-bordered table-shop">
										<thead><tr>
											<td>Название вещи</td>
											<td>Позиция в инвентаре</td>
											<td>Действия</td>
										</tr></thead>
										<tbody>';					
					foreach ($a['items'] as $i => $val) {
						printf('
						<tr>
						<td>%s</td>
						<td>%s</td>
						<td>
						<form name="chfrm%s" id="chfrm%s" method="post" action="index.php?op=act&n=14&num=%s&i=%s&rand='.time().'">
						Новое имя создателя:<br>
						<input name="newname" maxlength="'.$name_maxlength.'" style="width:100px"><br>
						<a class="btn btn-mini btn-inverse w200" onclick="conf3(%s)" href="#">Сменить создателя '.ShowCost($chnamecost).'</a></form></td>
					</tr>','<div align="left"><img title="'.htmlspecialchars($val['name']).'" data-content="'.str_replace('"',"'",$val['desc']).'" data-rel="popover" src="getitemicon.php?i='.urlencode(base64_encode($val['icon'])).'"> <span class="item_name">'.$val['name'].'</span></div>',$val['pos']+1,$val['index'],$val['index'],$a['rolenum'],$val['index'],$val['index']);
					}					
					echo '</tbody></table></td></tr></tbody></table></div>';
				}
			}
		}
	}
	
}
?>