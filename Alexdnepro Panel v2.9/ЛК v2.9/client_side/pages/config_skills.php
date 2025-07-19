<?php
if (!defined('main_def')) die();
?>
<table class="table table-bordered table-striped" id="skills_table">
	<thead>
		<tr>
			<th style="width:50px">ID</th>
			<th style="width:50px">Skill ID</th>
			<th style="width:290px">Название</th>
			<th style="width:60px">Тип</th>
			<th style="width:100px">Базовый класс</th>
			<th style="width:40px">Макс. уровень</th>
			<th>Классы, которые могут покупать</th>
			<th style="width:60px">Стоимость</th>
			<th style="width:50px">Активен</th>
			<th style="width:60px">Купили раз</th>
		</tr>
	</thead>
	<tfoot id="skill_foot">
		<tr>
			<th><input name="search_s_id" value="ID..." class="search_init" /></th>
			<th><input name="search_skillid" value="Скилл..." class="search_init" /></th>
			<th><input name="search_skill_name"  value="Название..." class="search_init" /></th>
			<th><input name="search_skill_type"  value="Тип..." class="search_init" /></th>
			<th><input name="search_skill_cls"  value="ID класса..." class="search_init" /></th>
			<th><input name="search_skill_lvl"  value="Уровень..." class="search_init" /></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>
<center><a href="#" onclick="add_skill()" class="btn btn-inverse">Добавить новый скилл</a><br></center>
<script type="text/javascript">

var SkillType = ['Обычный', '<font color="#ffffff">79</font>', '<font color="#d618e7">Ад(100)</font>', '<font color="#f7dfa5">Рай(100)</font>', '<font color="#d618e7">Ад</font>', '<font color="#f7dfa5">Рай</font>', '<font color="#ffff00">Морай</font>', '<font color="#d618e7">Ад(1.5.1)</font>', '<font color="#f7dfa5">Рай(1.5.1)</font>', '<font color="#ffff00">1.5.1</font>'];
var BaseCls = ['Воин','Маг','Шаман','Друид','Обор','Убийца','Лучник','Жрец','Страж','Мистик','Ремесло'];

var skillTable = $('#skills_table').dataTable( {
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
	"sAjaxSource": "pages/server_processing.php?shop_skills",		
	"aaSorting": [[ 0, "desc" ]],
	"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		nRow.cells[3].innerHTML = aData[3]+' <span class="label label-inverse">'+SkillType[aData[3]]+'</span>';
		if (aData[4]!=10)
		nRow.cells[4].innerHTML = '<i class="imcnt class_icon class_'+aData[4]+'"></i> <b>'+BaseCls[aData[4]]+'</b> <i class="imcnt class_icon fclass_'+aData[4]+'"></i>'; else
		nRow.cells[4].innerHTML = '<b>'+BaseCls[aData[4]]+'</b>';
	},
	"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre )  {
		$('[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});
		return "Показаны записи " + iStart + "-" + iEnd + " из " + iTotal;
	}
} );

function add_skill(){
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=78&num=0");
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
			skillTable._fnAjaxUpdate();
		}
	};
	X.send();
}

var CurUserInfoID = 1;

function skillFormatDetails ( nTr )
{
	var aData = skillTable.fnGetData( nTr );
	var sOut = '<div id="info_'+CurUserInfoID+'"><center><img src="img/ajax-loaders/ajax-loader-1.gif" border=0> Получение данных с сервера <img src="img/ajax-loaders/ajax-loader-1.gif" border=0></center></div>';
	CurId = '#info_'+CurUserInfoID;
	CurUserInfoID++;
	$.ajax({
	     url: 'pages/server_processing.php?edit_shop_skills='+aData[10]+'&r='+Math.random(),             // указываем URL и
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

$('#skills_table tbody td i').live( 'click', function () {
	var nTr = this.parentNode.parentNode;
	if ( this.className.match('icon-cancel') )
	{
		/* This row is already open - close it */
		this.className = "icon icon-color icon-edit";
		skillTable.fnClose( nTr );
	}
	else
	if ( this.className.match('icon-edit') )
	{
		/* Open this row */
		this.className = "icon icon-color icon-cancel";
		skillTable.fnOpen( nTr, skillFormatDetails(nTr), 'details' );
	} else
	if ( this.className.match('icon-close') )
	{
		/* Enable skill */
		SkillEnableDisable(nTr, 1);
	} else
	if ( this.className.match('icon-check') )
	{
		/* Disable skill */
		SkillEnableDisable(nTr, 0);
	} 
} );

var skillInitVals = new Array();
	$("#skill_foot input").keyup( function () {
		skillTable.fnFilter( this.value, $("#skill_foot input").index(this) );
	} );	
	$("#skill_foot input").each( function (i) {
		skillInitVals[i] = this.value;
	} );
	
	$("#skill_foot input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "search_focus";
			this.value = "";
		}
	} );
	
	$("#skill_foot input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = skillInitVals[$("#skill_foot input").index(this)];
		}
	} );
function SkillEnableDisable(n,v){
	var aData = skillTable.fnGetData( n );
	if (v) {
		s='разрешить';
		v = 1;
	} else {
		s='запретить';
		v = 0;
	}
	if (!window.confirm('Вы действительно хотите '+s+' покупку этого скилла?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=81&num=0&record_id="+aData[10]+"&v="+v);
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
			skillTable._fnAjaxUpdate();
		}
	};
	X.send();
}
function CheckSkillDelete(n){
	if (!window.confirm('Вы действительно хотите удалить этот скилл из базы данных?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=80&num=0&record_id="+n);
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
			skillTable._fnAjaxUpdate();
		}
	};
	X.send();
}
</script>