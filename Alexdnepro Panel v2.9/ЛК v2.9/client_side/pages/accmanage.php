<?php
if (!defined('main_def')) die();
?>
<table class="table table-bordered table-striped" id="acctable">
<thead>
<tr>
	<th style="width:50px">ID</th>
	<th style="width:140px">Login</th>
	<th style="width:50px">№ счета</th>
	<th style="width:130px">VK</th>
	<th style="width:170px">Steam</th>
	<th style="width:90px">Имя</th>
	<th style="width:120px">E-Mail</th>
	<th style="width:90px">IP</th>
	<th style="width:70px">Дата реги</th>
	<th style="width:70px"><span class="gold">&nbsp;</span></th>
	<th style="width:70px"><span class="silver">&nbsp;</span></th>
	<th style="width:80px">Referal</th>
	<th style="width:30px">Ref. stat</th>
	<th style="width:50px"><span class="gold">Ref. bonus</span></th>
	<th>Bonus Data</th>
</tr>
</thead>
<tfoot>
<tr>
	<th><input name="search_userid" id="search_userid" value="Поиск ID..." class="search_init" /></th>
	<th><input name="search_login" id="search_login" value="Поиск Login..." class="search_init" /></th>
	<th><input name="search_lkid" id="search_lkid" value="Поиск №..." class="search_init" /></th>
	<th><input name="search_vk" id="search_quest" value="Поиск VK ID..." class="search_init" /></th>
	<th><input name="search_steam" id="search_answ" value="Поиск SteamID..." class="search_init" /></th>
	<th><input name="search_name" id="search_name" value="Поиск Имени..." class="search_init" /></th>
	<th><input name="search_email" id="search_email" value="Поиск Email..." class="search_init" /></th>
	<th><input name="search_ip" id="search_ip" value="Поиск IP..." class="search_init" /></th>
	<th><input name="search_date" value="Поиск по дате..." class="search_init" /></th>	
	<th><input name="search_cost_gold" value="Голд..." class="search_init" /></th>
	<th><input name="search_cost_silver" value="Серебро..." class="search_init" /></th>
	<th><input name="search_referal" value="Реферал..." class="search_init" /></th>
	<th><input name="search_referal" value="Статус..." class="search_init" /></th>
	<th><input name="search_referal" value="Бонус..." class="search_init" /></th>
	
	<th></th>
</tr>
</tfoot>
</table>
<script type="text/javascript">

var oTable = $('#acctable').dataTable( {
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
	"sAjaxSource": "pages/server_processing.php?accmanage",
	"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		if (aData[15]!='') nRow.className=aData[15]+' '+nRow.className;
	},
	"aaSorting": [[ 0, "desc" ]]
} );

var CurUserInfoID = 1;

function act_acc(id){	
	if (!window.confirm('Вы действительно хотите активировать аккаунт '+id+'?')) return;
	var X = new XMLHttpRequest();
	X.open("POST", "index.php?op=act&n=77&num=0&userid="+id);
	X.onreadystatechange = function() {
		if (X.readyState == 4) {				
			if(X.status == 200) {
				var txt = "error"; var txt1 = X.responseText;
				if (txt1 == "ok") {
					txt = "success";
					txt1 = "Аккаунт успешно активирован";
				}
				noty({"text":txt1,"layout":"top","type":txt});				
			}
			oTable._fnAjaxUpdate();
		}
	};
	X.send();
}

/* Formating function for row details */
function fnFormatDetails ( nTr )
{
	var aData = oTable.fnGetData( nTr );
	var sOut = '<div id="info_'+CurUserInfoID+'" class="userinfo"><center><img src="img/ajax-loaders/ajax-loader-1.gif" border=0> Получение данных с сервера <img src="img/ajax-loaders/ajax-loader-1.gif" border=0></center></div>';
	CurId = '#info_'+CurUserInfoID;
	CurUserInfoID++;
	$.ajax({
	     url: 'pages/server_processing.php?id='+aData[16]+'&r='+Math.random(),             // указываем URL и
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

	$('#acctable tbody td img').live( 'click', function () {
		var nTr = this.parentNode.parentNode;
		if ( this.src.match('details_close') )
		{
			/* This row is already open - close it */
			this.src = "img/details_open.png";
			oTable.fnClose( nTr );
		}
		else
		if ( this.src.match('details_open') )
		{
			/* Open this row */
			this.src = "img/details_close.png";
			oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details' );
		}
	} );
	
	var asInitVals = new Array();
	$("tfoot input").keyup( function () {
		oTable.fnFilter( this.value, $("tfoot input").index(this) );
	} );	
	$("tfoot input").each( function (i) {
		asInitVals[i] = this.value;
	} );
	
	$("tfoot input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "search_focus";
			this.value = "";
		}
	} );
	
	$("tfoot input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("tfoot input").index(this)];
		}
	} );

	function fnuser(s) {
		$('#search_userid').val(s);
		$('#search_userid').addClass("search_focus");
		$('#search_userid').keyup();
	}
	function fnemail(s) {
		$('#search_email').val(s);
		$('#search_email').addClass("search_focus");
		$('#search_email').keyup();
	}
	function fnlkid(s) {
		$('#search_lkid').val(s);
		$('#search_lkid').addClass("search_focus");
		$('#search_lkid').keyup();
	}
	function fnip(s) {
		$('#search_ip').val(s);
		$('#search_ip').addClass("search_focus");
		$('#search_ip').keyup();
	}
</script>