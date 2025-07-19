<?php
if (!defined('main_def')) die();
include('logformat.php');
if (isset($_GET['r'])) {
	echo GetErrorTxt($_GET['r']);
}

$auto = true; $chat_date1 = ''; $chat_date2 = ''; $chat_role_id = ''; $chat_faction_id = '';
$log_date1 = ''; $log_date2 = ''; $log_role_id = ''; $auto_chat = 'true'; $auto_log = 'true'; $chat_div = 'true'; $log_div = 'false';
$fullscreen = 'false';
if (isset($_GET['type'])) {
	$auto = false; $auto_chat = 'false'; $auto_log = 'false';
	if ($_GET['type'] == 'chat' )
	{
		$chat_date1 = (isset($_GET['date1']))?$_GET['date1']:'';
		$chat_date2 = (isset($_GET['date2']))?$_GET['date2']:'';
		$chat_role_id = (isset($_GET['role_id']))?intval($_GET['role_id']):'';
		$chat_faction_id = (isset($_GET['faction_id']))?intval($_GET['faction_id']):'';
	} else
	if ($_GET['type'] == 'log')
	{
		$log_date1 = (isset($_GET['date1']))?$_GET['date1']:'';
		$log_date2 = (isset($_GET['date2']))?$_GET['date2']:'';
		$log_role_id = (isset($_GET['role_id']))?intval($_GET['role_id']):'';
	}
}
if ($auto) {
	if (isset($_COOKIE['ChatAuto'])) $auto_chat = $_COOKIE['ChatAuto'];
	if (isset($_COOKIE['LogAuto'])) $auto_log = $_COOKIE['LogAuto'];
}
if (isset($_COOKIE['ChatDiv'])) $chat_div = $_COOKIE['ChatDiv'];
if (isset($_COOKIE['LogDiv'])) $log_div = $_COOKIE['LogDiv'];
if (isset($_COOKIE['FullScreen'])) $fullscreen = $_COOKIE['FullScreen'];

//$autotext = ($auto)?'true':'false';

function PrintFindPanel($auto = 'true', $div = 'true')
{
	global $chat_date1, $chat_date2, $chat_role_id, $chat_faction_id;
	if ($auto == 'true') $a = ' btn-success'; else $a = '';
	if ($div == 'true') $d = ' btn-success'; else $d = '';
	printf('<div class="row-fluid"><div class="box-content">
	<center>
	<div class="input-prepend">
		<span id="chat_loader" style="float: left; margin-top: 6px"></span>
		<span id="chat_auto_r" onclick="SetChatAuto()" class="btn'.$a.' add-on" title="Автообновление" data-rel="tooltip"><span class="icon icon-darkgray icon-arrowrefresh-w"></span></span>&nbsp;
		<span id="chat_div" onclick="SetChatDiv()" class="btn'.$d.' add-on" title="Разделить данные на два столбца" data-rel="tooltip"><span class="icon icon-darkgray icon-newwin"></span></span>&nbsp;
		<span id="chat_page_l" onclick="ListChatPage(-1,$(this))" class="btn add-on"><<</span><input id="chat_page" oninput="WaitChatRefresh(false)" style="width: 40px; text-align:center" type="number" min="1" value="1"><span id="chat_page_r" onclick="ListChatPage(1,$(this))" class="btn add-on">>></span>&nbsp;	
		<span class="add-on">Записей</span><select onchange="LoadChatData()" id="c_recordCount" style="width: 60px"><option>25</option><option>50</option><option selected>80</option><option>100</option><option>120</option><option>150</option><option>200</option><option>250</option><option>500</option><option>1000</option></select>&nbsp;
		<span id="chat_show_find_panel" onclick="$(this).toggleClass(\'btn-success\');$(\'#chat_find_panel\').toggle();setCookie(\'ShowFindPanel\', $(this).hasClass(\'btn-success\'), 1800)" class="add-on" title="Панель поиска" data-rel="tooltip"><span class="icon icon-darkgray icon-search"></span></span>&nbsp;
		<span id="chat_find_panel">
		<span class="add-on" onclick="ClearField($(this))" id="h_c_date1">Дата >=</span><input onchange="ResetChatPage();LoadChatData()" id="c_date1" class="input-xlarge datepicker" style="width: 70px" type="text" value="'.$chat_date1.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_date2">Дата <=</span><input onchange="ResetChatPage();LoadChatData()" id="c_date2" class="input-xlarge datepicker" style="width: 70px" type="text" value="'.$chat_date2.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_role_id">ID перса</span><input oninput="WaitChatRefresh()" id="c_role_id" style="width: 50px" type="number" value="'.$chat_role_id.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_role_name">Ник</span><input oninput="WaitChatRefresh()" id="c_role_name" type="text" style="width: 100px">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_faction_id">ID клана</span><input oninput="WaitChatRefresh()" id="c_faction_id" style="width: 50px" min="1" type="number" value="'.$chat_faction_id.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_faction_name">Название клана</span><input oninput="WaitChatRefresh()" id="c_faction_name" type="text" style="width: 100px">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_c_word">Текст</span><input oninput="WaitChatRefresh()" id="c_word" type="text" style="width: 120px">&nbsp;
		</span>
		<span id="chat_show_channels_panel" onclick="$(this).toggleClass(\'btn-success\');$(\'#chat_channels_panel\').toggle();setCookie(\'ShowChannelsPanel\', $(this).hasClass(\'btn-success\'), 1800)" class="add-on" title="Каналы чата" data-rel="tooltip"><span class="icon icon-darkgray icon-messages"></span></span>&nbsp;		
		<span id="chat_channels_panel">
			<input id="send_msg" type="text">&nbsp;<select id="c_channel" style="width: 80px"><option value=0>Осн 0</option><option value=1>Мир 1</option><option value=2>Груп 2</option><option value=3>Клан 3</option><option value=6>Инфо 6</option><option value=7>Торг 7</option><option selected value=9>Сист 9</option><option value=10>Инфо 10</option><option value=11>Канал 11</option><option value=12>Горн 12</option><option value=13>Атк 13</option></select>&nbsp;<button class="btn btn-inverse" id="send_msg_btn" onclick="SendMsg()">Отправить</button><hr style="margin:0; margin-top: 3px">
			<input onclick="dohide(this)" id="ch0" checked="" type="checkbox"><i class="channel0"></i>
			<input onclick="dohide(this)" id="ch1" checked="" type="checkbox"><i class="channel1"></i>
			<input onclick="dohide(this)" id="ch2" checked="" type="checkbox"><i class="channel2"></i>
			<input onclick="dohide(this)" id="ch3" checked="" type="checkbox"><i class="channel3"></i>
			<input onclick="dohide(this)" id="ch4" checked="" type="checkbox"><i class="channel4"></i>
			<input onclick="dohide(this)" id="ch5" checked="" type="checkbox"><span id="room_channel">Room</span>
			<input onclick="dohide(this)" id="ch7" checked="" type="checkbox"><i class="channel7"></i>
			<input onclick="dohide(this)" id="ch9" checked="" type="checkbox"><i class="channel9"></i>
			<input onclick="dohide(this)" id="ch12" checked="" type="checkbox"><i class="channel12"></i>
			<input onclick="dohide(this)" id="ch13" checked="" type="checkbox"><i class="channel13"></i>
			<input onclick="dohide(this)" id="ch14" checked="" type="checkbox"><i class="channel14"></i>
		</span>
		<span id="chat_loader1" style="float: right; margin-top: 6px"></span>
	</div>
	</center>
</div></div>');
}

function PrintLogFindPanel($auto = 'true', $div = 'false')
{
	global $log_date1, $log_date2, $log_role_id;
	if ($auto == 'true') $a = ' btn-success'; else $a = '';
	if ($div == 'true') $d = ' btn-success'; else $d = '';
	printf('<div class="row-fluid"><div class="box-content">
	<center>
	<div class="input-prepend">
		<span id="log_loader" style="float: left; margin-top: 6px"></span>
		<span id="log_auto_r" onclick="SetLogAuto()" class="btn'.$a.' add-on" title="Автообновление" data-rel="tooltip"><span class="icon icon-darkgray icon-arrowrefresh-w"></span></span>&nbsp;
		<span id="log_div" onclick="SetLogDiv()" class="btn'.$d.' add-on" title="Разделить данные на два столбца" data-rel="tooltip"><span class="icon icon-darkgray icon-newwin"></span></span>&nbsp;
		<span id="log_page_l" onclick="ListLogPage(-1,$(this))" class="btn add-on"><<</span><input id="log_page" oninput="WaitLogRefresh(false)" style="width: 40px; text-align:center" type="number" min="1" value="1"><span id="log_page_r" onclick="ListLogPage(1,$(this))" class="btn add-on">>></span>&nbsp;	
		<span class="add-on">Записей</span><select onchange="LoadLogData()" id="l_recordCount" style="width: 60px"><option  selected>15</option><option>20</option><option>25</option><option>30</option><option>50</option><option>80</option><option>150</option><option>200</option><option>250</option><option>500</option><option>1000</option></select>&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_date1">Дата >=</span><input onchange="ResetLogPage();LoadLogData()" id="l_date1" class="input-xlarge datepicker" style="width: 70px" type="text" value="'.$log_date1.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_date2">Дата <=</span><input onchange="ResetLogPage();LoadLogData()" id="l_date2" class="input-xlarge datepicker" style="width: 70px" type="text" value="'.$log_date2.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_role_id">ID перса</span><input oninput="WaitLogRefresh()" id="l_role_id" style="width: 50px" type="number" value="'.$log_role_id.'">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_role_name">Ник</span><input oninput="WaitLogRefresh()" id="l_role_name" type="text" style="width: 100px">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_item_id">ID предмета</span><input oninput="WaitLogRefresh()" id="l_item_id" style="width: 80px" min="1" type="number">&nbsp;
		<span class="add-on" onclick="ClearField($(this))" id="h_l_money">Деньги >=</span><input oninput="WaitLogRefresh()" id="l_money" style="width: 80px" min="1" type="number">&nbsp;
		<span id="log_loader1" style="float: right; margin-top: 6px"></span>
	</div>
	</center>
</div></div>');
}
?>
<style type="text/css">
@import url("css/logviewer.css");
@import url("css/smiles.css");
</style>
	<ul class="nav nav-tabs" id="myTab" style="margin-bottom:0">
	<?php
		if (isset($_GET['type']) && $_GET['type'] == 'log') 
		echo '				
		<li><a href="#log_tab">Логи</a></li>
		<li><a href="#chat_tab">Чат</a></li>
		'; else 
		echo '<li><a href="#chat_tab">Чат</a></li><li><a href="#log_tab">Логи</a></li>'; ?>
	</ul><span id="full_screen" onclick="SetFullScreen()" class="btn panel-btn" title="На полный экран" data-rel="tooltip"><span class="icon icon-darkgray icon-extlink"></span></span><div class="clearfix"></div>
	<div id="myTabContent" class="tab-content">		
	<div class="tab-pane" id="chat_tab">
<?php 
	PrintFindPanel($auto_chat, $chat_div);?>	
	<div id="chat_content" class="chat_content">
	</div>
	</div>

	<div class="tab-pane" id="log_tab">
		<?php PrintLogFindPanel($auto_log, $log_div); ?>
		<div id="log_content" class="chat_content"></div>
	</div>


<script type="text/javascript">
var FullScreen = <?php echo $fullscreen; ?>;
var ChatPage = 1;
var CharPages = 0;
var ChatCount = 0;
var ChatAuto = <?php echo $auto_chat; ?>;
var ChatAutoID;
var ChatDiv = <?php echo $chat_div; ?>;
var LogPage = 1;
var LogPages = 0;
var LogCount = 0;
var LogAuto = <?php echo $auto_log; ?>;
var LogAutoID;
var LogDiv = <?php echo $log_div; ?>;
var AJAX_IMG = '<img src="img/ajax-loaders/ajax-loader-1.gif" border="0" align="absmiddle"/>';

function SendMsg()
{
	var MSG = $('#send_msg').val();
	if (MSG == '') 
	{
		alert('Введите сообщение!');
		return;
	}
	var CHANNEL = $('#c_channel').val();
	$('#send_msg_btn').html(AJAX_IMG + " Отправляем " + AJAX_IMG);
	$('#send_msg_btn').prop( "disabled", true );
	$.ajax({
		url: "pages/log_processing.php",
		type: "POST",
		dataType: 'json',		
		data: {
			msg: MSG,
			channel: CHANNEL
		},
		success: function(data){
			$('#send_msg_btn').html("Отправить");
			$('#send_msg_btn').prop( "disabled", false );
			$('#send_msg').val('');
			LoadChatData();
		},
		error: function() {			
			alert('Произошла ошибка! Попробуйте позже');
		}
	});
}

function setCookie(cname,cvalue,exdays) 
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) 
{
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function dohide(t)
{
	n = t.id.substr(2);
	setCookie("ShowChannel"+n, t.checked, 1800);
	LoadChatData();
}

function SetFullScreen(change = true)
{
	if (change) FullScreen = !FullScreen;
	$('#full_screen').toggleClass("btn-success");
	$('#main_content_div').toggleClass("full-screen");
	setCookie("FullScreen",FullScreen,1800);
}

function ResetChatPage()
{
	if (ChatPage != 1)
	{
		ChatPage = 1;
		$('#chat_page').val(ChatPage);
	}
}

function ResetLogPage()
{
	if (LogPage != 1)
	{
		LogPage = 1;
		$('#log_page').val(LogPage);
	}
}

function WaitChatRefresh(ResetPage = true)
{
	if (ResetPage) ResetChatPage();
	clearTimeout(ChatAutoID);
	ChatAutoID = setTimeout(LoadChatData, 500);
}

function WaitLogRefresh(ResetPage = true)
{
	if (ResetPage) ResetLogPage();
	clearTimeout(LogAutoID);
	LogAutoID = setTimeout(LoadLogData, 500);
}

function SetChatAuto()
{
	ChatAuto = !ChatAuto;
	$('#chat_auto_r').toggleClass("btn-success");
	clearTimeout(ChatAutoID);
	setCookie("ChatAuto",ChatAuto,1800);
	if (ChatAuto) ChatAutoID = setTimeout(LoadChatData, 5000);
}

function SetLogAuto()
{
	LogAuto = !LogAuto;
	$('#log_auto_r').toggleClass("btn-success");
	clearTimeout(LogAutoID);
	setCookie("LogAuto",LogAuto,1800);
	if (LogAuto) LogAutoID = setTimeout(LoadLogData, 5000);
}

function SetChatDiv()
{
	ChatDiv = !ChatDiv;
	$('#chat_div').toggleClass("btn-success");
	setCookie("ChatDiv",ChatDiv,1800);
	LoadChatData();
}

function SetLogDiv()
{
	LogDiv = !LogDiv;
	$('#log_div').toggleClass("btn-success");	
	setCookie("LogDiv",LogDiv,1800);
	LoadLogData();
}

function CheckChatPages()
{
	if (ChatPage == 1) $('#chat_page_l').addClass("disabled"); else $('#chat_page_l').removeClass("disabled");
	if (ChatPage >= ChatPages) $('#chat_page_r').addClass("disabled"); else $('#chat_page_r').removeClass("disabled");
}

function CheckLogPages()
{
	if (LogPage == 1) $('#log_page_l').addClass("disabled"); else $('#log_page_l').removeClass("disabled");
	if (LogPage >= LogPages) $('#log_page_r').addClass("disabled"); else $('#log_page_r').removeClass("disabled");
}

function ListChatPage(n,t)
{
	if (t.hasClass( "disabled" )) return;
	ChatPage = parseInt(ChatPage) + parseInt(n);
	$('#chat_page').val(ChatPage);
	if (ChatPage > 1 && ChatAuto) SetChatAuto();
	LoadChatData();
}

function ListLogPage(n,t)
{
	if (t.hasClass( "disabled" )) return;
	LogPage = parseInt(LogPage) + parseInt(n);
	$('#log_page').val(LogPage);
	if (LogPage > 1 && LogAuto) SetLogAuto();
	LoadLogData();
}

function CheckVal(id)
{
	if ($('#'+id).val() != '') $('#h_'+id).addClass("btn-success"); else
	$('#h_'+id).removeClass("btn-success");
}

function ClearField(t)
{
	if (!t.hasClass( "btn-success" )) return;
	id = t.attr("id").substring(2, t.attr("id").length);
	$("#"+id).val("");
	if (t.attr("id").substring(2, 3) == "c") {
		ResetChatPage();
		LoadChatData();
	} else 
	{
		ResetLogPage();
		LoadLogData();
	}
}

function UncheckChannel(n)
{
	cc = document.getElementById("ch"+n);
	if (cc != null) 
	{			
		cc.checked = false;
	}
}

function LoadChatData()
{
	clearTimeout(ChatAutoID);
	ChatPage = $('#chat_page').val();
	$('#chat_loader').html(AJAX_IMG);
	$('#chat_loader1').html(AJAX_IMG);
	var date1 = ''; var date2 = '';
	if ($('#c_date1').val() != '') date1 = $('#c_date1').val()+' 00:00:00';
	if ($('#c_date2').val() != '') date2 = $('#c_date2').val()+' 23:59:59';
	CheckVal('c_date1'); CheckVal('c_date2'); CheckVal('c_role_id');
	CheckVal('c_role_name'); CheckVal('c_faction_id'); CheckVal('c_faction_name');
	CheckVal('c_word');
	var hide_chats = [];
	for (a=0; a<15; a++)
	{	
		cc = document.getElementById("ch"+a);
		if (cc != null) 
		{			
			if (!cc.checked) hide_chats.push(a);
		}		
	}	
	$.ajax({
		url: "pages/log_processing.php",
		type: "POST",
		dataType: 'json',		
		data: {
			log: "chat",
			hide_chats: hide_chats,
			date1: date1,
			date2: date2,
			role_id: $('#c_role_id').val(),
			role_name: $('#c_role_name').val(),
			faction_id: $('#c_faction_id').val(),
			faction_name: $('#c_faction_name').val(),			
			word: $('#c_word').val(),
			page: $('#chat_page').val(),
			record_count: $('#c_recordCount').val(),
			div: ChatDiv			
		},
		success: function(data){
			ChatCount = data.count;
			ChatPages = data.pages;
			s = "из "+data.pages+" (Всего записей: " + data.count+")";
			$('#chat_page').attr("data-original-title",s);
			$('#chat_page').attr("title",s);
			$('#chat_page').tooltip({"placement":"top",delay: { show: 400, hide: 200 }});
			$('#chat_loader').html(""); $('#chat_loader1').html("");
			$('#chat_content').html(data.data);
			CheckChatPages();
			if (ChatAuto) ChatAutoID = setTimeout(LoadChatData, 5000);
		},
		error: function() {
			$('#chat_loader').html(""); $('#chat_loader1').html("");
			$('#chat_content').html('<p>Произошла ошибка! Попробуйте позже</p>');
			if (ChatAuto) ChatAutoID = setTimeout(LoadChatData, 5000);
		}
	});
}

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

function FindChatRole(roleid)
{
	url = 'index.php?op=logs&type=chat&date1='+$('#c_date1').val()+'&date2='+$('#c_date2').val()+'&role_id='+roleid;
	openInNewTab(url);
	return false;
}

function FindFaction(fid)
{
	url = 'index.php?op=logs&type=chat&date1='+$('#c_date1').val()+'&date2='+$('#c_date2').val()+'&faction_id='+fid;
	openInNewTab(url);
	return false;
}

function FindLogRole(roleid)
{
	url = 'index.php?op=logs&type=log&date1='+$('#l_date1').val()+'&date2='+$('#l_date2').val()+'&role_id='+roleid;
	openInNewTab(url);
	return false;
}

function LoadLogData()
{
	clearTimeout(LogAutoID);
	LogPage = $('#log_page').val();
	$('#log_loader').html(AJAX_IMG);
	$('#log_loader1').html(AJAX_IMG);
	var date1 = ''; var date2 = '';
	if ($('#l_date1').val() != '') date1 = $('#l_date1').val()+' 00:00:00';
	if ($('#l_date2').val() != '') date2 = $('#l_date2').val()+' 23:59:59';
	CheckVal('l_date1'); CheckVal('l_date2'); CheckVal('l_role_id');
	CheckVal('l_role_name'); CheckVal('l_item_id');
	$.ajax({
		url: "pages/log_processing.php",
		type: "POST",
		dataType: 'json',		
		data: {
			log: "main",
			date1: date1,
			date2: date2,
			role_id: $('#l_role_id').val(),
			role_name: $('#l_role_name').val(),
			item_id: $('#l_item_id').val(),
			money: $('#l_money').val(),
			page: $('#log_page').val(),
			record_count: $('#l_recordCount').val(),
			div: LogDiv
		},
		success: function(data){
			LogCount = data.count;
			LogPages = data.pages;
			s = "из "+data.pages+" (Всего записей: " + data.count+")";
			$('#log_page').attr("data-original-title",s);
			$('#log_page').attr("title",s);
			$('#log_page').tooltip({"placement":"top",delay: { show: 400, hide: 200 }});
			$('#log_loader').html(""); $('#log_loader1').html("");
			$('#log_content').html(data.data);
			CheckLogPages();
			if (LogAuto) LogAutoID = setTimeout(LoadLogData, 5000);
		},
		error: function() {
			$('#log_loader').html(""); $('#log_loader1').html("");
			$('#log_content').html('<p>Произошла ошибка! Попробуйте позже</p>');
			if (LogAuto) LogAutoID = setTimeout(LoadLogData, 5000);
		}
	});
}

function RolePanel(roleid, rolename)
{
	$('#process_ban_btn').html("Выдать бан");
	$('#process_ban_btn').prop( "disabled", false );
	$('html').css('overflow', 'hidden');
	$('body').css('overflow', 'hidden');
	$('.modal-body').css('max-height', document.body.clientHeight - 200);
	$('#ban_roleid').val(roleid);
	$('#ban_rolename').val(rolename);
	$('#pop_role_id').html(roleid);
	$('#pop_role_name').html(rolename);
	p = $('.popup__overlay');
	p.css('display', 'none').fadeIn();
	p.click(function(event) {
	e = event || window.event;
	if (e.target == this) {
	    $(p).css('display', 'none');
	    $('html').css('overflow', 'auto');
	    $('body').css('overflow', 'auto');
	}
	});
	$('.close').click(function() {
	    $('html').css('overflow', 'auto');
	    $('body').css('overflow', 'auto');
	    p.css('display', 'none');
	});
}

function ProcessBan()
{
	$('#process_ban_btn').html(AJAX_IMG + " Отправка запроса " + AJAX_IMG);
	$('#process_ban_btn').prop( "disabled", true );
	var E = document.getElementById("ban_form");
	var formData = new FormData(E);	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", E.action);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {				
			if(xhr.status == 200) {
				var txt = "error"; var txt1 = xhr.responseText;
				if (txt1 == "ok") {
					txt = "success";
					txt1 = "Бан успешно выдан";
				}
				noty({"text":txt1,"layout":"top","type":txt});				
			}
			$("#ban_close").click();
			LoadChatData();
		}
	};
	xhr.send(formData);
	return false;
}

<?php
for ($i=0;$i<15;$i++){
	if (isset($_COOKIE['ShowChannel'.$i]))
	{
		if ($_COOKIE['ShowChannel'.$i] == 'false') echo "UncheckChannel($i);\n";
	}
}
if (isset($_COOKIE['ShowFindPanel']) && $_COOKIE['ShowFindPanel'] == 'true') echo "$('#chat_show_find_panel').toggleClass('btn-success'); $('#chat_find_panel').show();\n";
if (isset($_COOKIE['ShowChannelsPanel']) && $_COOKIE['ShowChannelsPanel'] == 'true') echo "$('#chat_show_channels_panel').toggleClass('btn-success'); $('#chat_channels_panel').show();\n";
?>
if (FullScreen) SetFullScreen(false);
$('.datepicker').datepicker({"dateFormat": "yy-mm-dd"});
LoadChatData();
LoadLogData();
</script>
<div class="popup__overlay">
    <div class="popup">
        <div class="modal-header">
		<button type="button" class="close" id="ban_close" data-dismiss="modal">×</button>
		<h3 id="modalHeader">Бан игрока <font color="#ff0000"><span id="pop_role_id"></span></font> <font color="#0000ff"><span id="pop_role_name"></span></font></h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" name="ban_form" id="ban_form" method="post" action="pages/log_processing.php?ban">
			<input type="hidden" name="roleid" id="ban_roleid">
			<input type="hidden" name="rolename" id="ban_rolename">
			<fieldset>
				<label class="control-label" for="type">Тип бана</label>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span><select name="type" type="text"><option value="chat">Бан чата</option><option value="role">Бан персонажа</option></select>
				</div><div class="clearfix"></div>

				<label class="control-label" for="time">Время бана</label>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-time"></i></span><select name="time" type="text"><option value=900>15 минут</option><option value=1800>30 минут</option><option value=3600>1 час</option><option value=10800>3 часа</option><option value=43200>12 часов</option><option value=86400>1 день</option><option value=172800>2 дня</option><option value=259200>3 дня</option><option value=345600>4 дня</option><option value=432000>5 дней</option><option value=604800>1 неделя</option><option value=907200>1,5 недели</option><option value=1209600>2 недели</option><option value=2592000>1 месяц</option><option value=99999999>Перманент</option><option value=1>Разбан (1 сек)</option></select>
					</div><div class="clearfix"></div>					
					<label class="control-label" for="reason">Причина</label>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span><input name="reason" type="text" maxlength="20">
					</div><div class="clearfix"></div>
					<label class="control-label" for="broadcast">Оповещение в мир</label>
					<input name="broadcast" type="checkbox">
					<div class="clearfix"></div>
					<div class="form-actions">
						<button class="btn btn-primary" id="process_ban_btn" onclick="return ProcessBan()"></button>
					</div>					
				</fieldset>
			</form>
	</div>	
    </div>
</div>