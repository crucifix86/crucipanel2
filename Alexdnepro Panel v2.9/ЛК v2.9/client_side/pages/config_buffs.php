<?php
if (!defined('main_def')) die();
?>
<style>
.userinfo_table {
  background-color: inherit;
}
.userinfo_table p {
  padding: 0px;
  line-height: 16px;
  margin: 0px;
}
</style>
<table class="table table-bordered table-striped" id="buffs_table">
	<thead>
		<tr>
			<th style="width:50px">ID</th>
			<th style="width:80px">ID бафа</th>
			<th style="width:150px">Название</th>
			<th style="width:50px">Мощность</th>
			<th style="width:150px">Ограничение по классу</th>
			<th style="width:80px">Время действия</th>
			<th style="width:100px">Стоимость</th>
			<th style="width:50px">Активен</th>
			<th style="width:80px">Купили раз</th>
			<th>Описание</th>
		</tr>
	</thead>
	<tfoot id="buff_foot">
		<tr>
			<th><input name="search_id" value="ID..." class="search_init" /></th>
			<th><input name="search_filterid" value="ID бафа..." class="search_init" /></th>
			<th><input name="search_name"  value="Название..." class="search_init" /></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th><input name="search_desc" value="Описание..." class="search_init" /></th>
		</tr>
	</tfoot>
</table>
<center><a href="#" onclick="add_buff()" class="btn btn-inverse">Добавить новый баф</a><br></center>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well"><h2>Управление бафами персонажа</h2></div>
		<div class="box-content">
			<input id="buff_pers_id" class="config_itemid" onKeyUp="clearTimeout(timeout_id); timeout_id = setTimeout(GetRoleBuffInfo, 1000);"> RoleId 
			<input id="buff_auto_id" class="config_itemid"> ID (из списка бафов 1-я колонка)<br>
			<div id="role_buff_info" class="well span3 shop-block pers-block" align="center" style="display: none; margin:0"></div><div class="clear"></div>
			<input class="btn btn-inverse" type="button" onclick="AdminBuff()" id="btn_buff" value="Бафнуть"> <input class="btn btn-danger w150" type="button" id="btn_buff" value="Удалить все бафы" onclick="DeleteRoleBuffs()">
		</div>
	</div>
</div>
<script type="text/javascript">
var timeout_id = 0;

function AdminBuff(){
	if (!$('#buff_pers_id').val() || !$('#buff_auto_id').val()) {
		alert('Укажите данные');
		return;
	}
	if (!window.confirm('Вы действительно хотите бафнуть персонажа?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=65&num=0&roleid="+$('#buff_pers_id').val()+"&record_id="+$('#buff_auto_id').val());
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "ok") {
					txt = "success";
					txt1 = "Действие было успешно завершено";
				}
				noty({"text":txt1,"layout":"top","type":txt});
				GetRoleBuffInfo();
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}

function DeleteRoleBuffs(){
	if (!$('#buff_pers_id').val()) {
		alert('Укажите данные');
		return;
	}
	if (!window.confirm('Вы действительно хотите удалить все бафы с персонажа?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=66&num=0&roleid="+$('#buff_pers_id').val());
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "ok") {
					txt = "success";
					txt1 = "Действие было успешно завершено";
				}
				noty({"text":txt1,"layout":"top","type":txt});
				GetRoleBuffInfo();
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}

function GetRoleBuffInfo(){
	sOut = '<div class="userinfo"><center><img src="img/ajax-loaders/ajax-loader-1.gif" border=0> Получение данных с сервера <img src="img/ajax-loaders/ajax-loader-1.gif" border=0></center></div>';
	$('#acc_info').html('');
	$('#acc_info').css('display' , 'none');
	roleid = $('#buff_pers_id').val();
	if (roleid == '') return;
	$('#role_buff_info').html(sOut);
	$('#role_buff_info').css({'display' : 'inherit', 'margin-top' : '3px'});
	$.ajax({
	     url: 'pages/server_processing.php?roleid='+roleid+'&r='+Math.random(),             // указываем URL и
	     dataType : "text",                     // тип загружаемых данных
	     complete: function (data, textStatus) { // вешаем свой обработчик на complete
		if (textStatus!='success') {
			$('role_buff_info').html(textStatus);
			return;
		}
	        $('#role_buff_info').html(data.responseText);
	     }
	});
}
var oTable = $('#buffs_table').dataTable( {
	"sDom": '<"row-fluid"<"span10 pagination1"p><"span2"l>><"label"i>tr',
	"iDisplayLength": 25,
	"aLengthMenu": [[15, 25, 50, 75, 100, 200, 500], [15, 25, 50, 75, 100, 200, 500]],	
	"sPaginationType": "bootstrap1",
	"bJQueryUI": true,
	"oLanguage": {
		"sSearch": "Поиск:",
		"sLengthMenu": "_MENU_ записей",
		"sZeroRecords": "Не найдено",
		"sInfo": "Показаны записи _START_-_END_ из _TOTAL_",
		"sInfoEmpty": "Нет данных",
		"oPaginate": {
			"sFirst": "В начало",
			"sLast": "В конец",
			"sNext": "&rarr;",
			"sPrevious": "&larr;"
		},
		"sProcessing": "<center><img src=\"img/ajax-loaders/ajax-loader-1.gif\" border=0> Получение данных с сервера <img src=\"img/ajax-loaders/ajax-loader-1.gif\" border=0></center>",
		"sInfoFiltered": "(обработано _MAX_ записей)"
	},
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "pages/server_processing.php?shop_buffs",		
	"aaSorting": [[ 0, "desc" ]],
	"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre )  {
		$('[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});
		return "Показаны записи " + iStart + "-" + iEnd + " из " + iTotal;
	}
} );

function add_buff(){
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=60&num=0");
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "16") {
					txt = "success";
					txt1 = "Запись успешно добавлена";
				}
				noty({"text":txt1,"layout":"top","type":txt});
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}

var CurUserInfoID = 1;

function fnFormatDetails ( nTr )
{
	var aData = oTable.fnGetData( nTr );
	var sOut = '<div id="info_'+CurUserInfoID+'"><center><img src="img/ajax-loaders/ajax-loader-1.gif" border=0> Получение данных с сервера <img src="img/ajax-loaders/ajax-loader-1.gif" border=0></center></div>';
	CurId = '#info_'+CurUserInfoID;
	CurUserInfoID++;
	$.ajax({
	     url: 'pages/server_processing.php?edit_shop_buffs='+aData[10]+'&r='+Math.random(),             // указываем URL и
	     dataType : "text",                     // тип загружаемых данных
	     complete: function (data, textStatus) { // вешаем свой обработчик на complete
		if (textStatus!='success') {
			$(CurId).html(textStatus);
			return;
		}
	        $(CurId).html(data.responseText);
	     }
	});
	return sOut;
}

$('#buffs_table tbody td i').live( 'click', function () {
	var nTr = this.parentNode.parentNode;
	if ( this.className.match('icon-cancel') )
	{
		/* This row is already open - close it */
		this.className = "icon icon-color icon-edit";
		oTable.fnClose( nTr );
	}
	else
	if ( this.className.match('icon-edit') )
	{
		/* Open this row */
		this.className = "icon icon-color icon-cancel";
		oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details' );
	} else
	if ( this.className.match('icon-close') )
	{
		/* Enable buff */
		DoEnableDisable(nTr, 1);
	} else
	if ( this.className.match('icon-check') )
	{
		/* Disable Buff */
		DoEnableDisable(nTr, 0);
	} 
} );

var asInitVals = new Array();
	$("#buff_foot input").keyup( function () {
		oTable.fnFilter( this.value, $("#buff_foot input").index(this) );
	} );	
	$("#buff_foot input").each( function (i) {
		asInitVals[i] = this.value;
	} );
	
	$("#buff_foot input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "search_focus";
			this.value = "";
		}
	} );
	
	$("#buff_foot input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("#buff_foot input").index(this)];
		}
	} );
function DoEnableDisable(n,v){
	var aData = oTable.fnGetData( n );
	if (v) {
		s='разрешить';
		v = 1;
	} else {
		s='запретить';
		v = 0;
	}
	if (!window.confirm('Вы действительно хотите '+s+' покупку этого бафа?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=67&num=0&record_id="+aData[10]+"&v="+v);
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "ok") {
					txt = "success";
					txt1 = "Действие успешно выполнено";
				}
				noty({"text":txt1,"layout":"top","type":txt});
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}
function CheckDelete(n){
	if (!window.confirm('Вы действительно хотите удалить этот баф из базы данных?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=62&num=0&record_id="+n);
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "16") {
					txt = "success";
					txt1 = "Запись успешно удалена";
				}
				noty({"text":txt1,"layout":"top","type":txt});
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}
</script>		
<span class="label label-important">Обратите внимание!</span>
<ul align="left" type="disc">
	<li>ЛК бафы не снимаются друлей или другими дебафами и не исчезают после смерти</li>
	<li>Время действия и сила ЛК бафа может быть перебито аналогичным игровым бафом</li>
	<li>Размер изображения иконки для бафа должен быть <b>16х16 пискелей</b></li>
	<li>Размер файла иконки должен быть <b>не более 200 KБайт</b></li>
	<li>Добавляйте новые фильтры только если точно понимаете, что делаете. При неправильных значениях и их использовании может падать локация при входе персонажем с таким бафом!</b></li>
</ul>