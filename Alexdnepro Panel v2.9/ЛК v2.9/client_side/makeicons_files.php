<?php
if (!defined('make_icons')) die();

set_time_limit(200);

function GetIconNum($s,$l){	
	foreach ($l as $i => $val){	
		if(strtolower($val)==strtolower($s)) {			
			return $i;						
		}		
	}
	return 0;
}

function ReadIconFile($n){
	global $imw;
	global $imh;
	global $rows;
	global $cols;
	global $l;
	$img = imageCreateFromPng($n.'.png');
	if ($img === false) die($n.'.png open error');
	//imagesavealpha($img,true);	
	$f=fopen($n.'.txt','r');
	if (!$f) die($n.'.txt open error');
	$imw=(int)fgets($f);
	$imh=(int)fgets($f);
	$rows=(int)fgets($f);
	$cols=(int)fgets($f);
	$l=array();
	$c=1;
	while (!feof($f)){
		$line = trim(fgets($f));
		$line = @mb_convert_encoding( $line, "UTF-8", "GBK" );		
		$l[$c] = $line;
		//echo $line.'<br>';
		$c++;
	}
	fclose($f);	
	return $img;
}

function clear($folder) {
    if (file_exists($folder)) {
        foreach (glob($folder.'*.jpg') as $file) {
            unlink($file);
        }
    }
}

if ($cron_act == 'make_icons') {
	$folder = 'items';
	$fname = 'iconlist_ivtrm';
} else
if ($cron_act == 'make_skill_icons') {
	$folder = 'skills';
	$fname = 'iconlist_skill';
} else die('Input data error');
$full_folder = __dir__.'/img/ico_'.$folder.'/';
if (!is_writable($full_folder)) die($full_folder.' is not writable');
clear($full_folder);
$img = ReadIconFile($fname);
$im1 = imagecreatetruecolor($imw,$imh);
$n = 0;
foreach ($l as $num => $val){
	if ($val=='') continue;
	if ($num > $cols) $row = floor(($num-1)/$cols); else $row=0;
	$col=$num-($row*$cols)-1;
	if ($col<0) $col=0;	
	imageCopy($im1,$img,0,0,$col*$imw,$row*$imh,$imw,$imh);
	ob_start();
	imagejpeg($im1,null,90);
	$result = ob_get_clean();
	$fname = $full_folder.EncodeIconFileName($val).'.jpg';
	$res = file_put_contents($fname, $result);
	if (!$res) echo 'Error writing '.$val.' to '.$fname."<br>"; else
	$n++;
}
echo "$n icons done.";