<?php
	if (!defined('main_def')) die();
	if (isset($_GET['r'])) {
		echo GetErrorTxt($_GET['r']);
	}
?>
		<h3>Раздел для проведения PVP турнира</h3>

	        <p>В этом разделе можно выдать пригласительные билеты на PVP турнир для участников и зрителей.</p>  
<script language="javascript">
	var xmlHttp = false;
	var ResID = '';
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	try {
	  xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	  try {
	    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (e2) {
	    xmlHttp = false;
	  }
	}
	@end @*/
	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
	  xmlHttp = new XMLHttpRequest();
	}
		
	function getName(t,A) {  
		ResID = A;  
		var id = t.value;
		var url = 'index.php?op=act&n=17&num=0&id=0&i='+id+'&r='+Math.random();
		document.getElementById(ResID).innerHTML='';
		if ((id == null) || (id == "") || id == 0) return;
		xmlHttp.open("GET", url, true);  
		xmlHttp.onreadystatechange = updatePage;
		xmlHttp.send(null);     
	}
	
	function updatePage() {
		if (xmlHttp.readyState == 4) {				
		    var response = xmlHttp.responseText;
			A = document.getElementById(ResID);		
			A.innerHTML = response;				
		}		
	}
	
	function checksend(A){
		if ((A.i.value.length < 1)||(A.i.value.length > 7)||(A.i.value == 0)||(A.i.value < 32)) { 
			alert ("Введите корректный ID");
		} else {
			if (window.confirm("Отправить пригласительный билет персонажу №"+A.i.value+"?")) {A.submit();}
		}
	}
	function checksend1(A){
		if (window.confirm("Отправить пригласительные билеты зрителей всем персонажам онлайн?")) {A.submit();}
	}
	</script>	
	
	<div align="center">
		<table class="table table-striped table-bordered">
			<thead>
        			<tr>
          				<th>Отправить билет участнику <font color="red">красной</font> команды</th>
				        <th>Отправить билет участнику <font color="blue">синей</font> команды</th>
				        <th>Отправить билет зрителю</th>
		        	</tr> 
			</thead>  
			<tr>	
	<td><form name="redform" method="get">ID:<input name="i" maxlength="7" type="text" onkeyup="getName(this, 'redname');" style="width:50px">
		<input type="hidden" name="op" value="act">
		<input type="hidden" name="n" value="18">
		<input type="hidden" name="num" value="0">
		<input type="button" class="btn btn-danger" value="Отправить приглашение" onclick="checksend(document.redform);"><br>
		<span id="redname"></span>
	</form></td>		
	<td><form name="blueform" method="get">ID:<input name="i" maxlength="7" type="text" onkeyup="getName(this, 'bluename');" style="width:50px">
		<input type="hidden" name="op" value="act">
		<input type="hidden" name="n" value="18">
		<input type="hidden" name="num" value="1">
		<input type="button" class="btn btn-primary" value="Отправить приглашение" onclick="checksend(document.blueform);"><br>
		<span id="bluename"></span>
	</form>
	</form></td>
	<td style="border-right:0"><form name="zritform1" method="get">ID:<input name="i" maxlength="7" type="text" onkeyup="getName(this, 'zritname');" style="width:50px">
		<input type="hidden" name="op" value="act">
		<input type="hidden" name="n" value="18">
		<input type="hidden" name="num" value="3">
		<input type="button" class="btn btn-inverse" value="Отправить приглашение" onclick="checksend(document.zritform1);"><br>
		<span id="zritname"></span>
	</form>
	</form></td>
	</tr>
		</table>
<center>
	<br><br>
	<form name="zritform" method="post" action="?op=act&n=18&num=2">		
		<input type="button" class="btn btn-inverse" value="Отправить приглашение зрителям" onclick="checksend1(document.zritform);" style="width:250px">
		<p>Приглашение зрителям будет отправлено всем персонажам онлайн на момент выдачи.</p>
	</form>
	</center>
	</div>
