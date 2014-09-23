<?php
function ErrorControl($var) {

$ErrArray=array('"','\'',';','=','/','DROP','DELETE','TRUNCATE');
$Pattern="(".$ErrArray['0']."|".$ErrArray['1']."|".$ErrArray['2']."|".$ErrArray['3']."|".$ErrArray['4']."|".$ErrArray['5']."|".$ErrArray['6']."|".$ErrArray['7'].")";
$Match=preg_match($Pattern, $var);

	switch ($Match) {
		case 1:
			$result=TRUE;
			return $result;
			break;
	
		default:
			$result=FALSE;
			return $result;
			break;
	}
	}
?>