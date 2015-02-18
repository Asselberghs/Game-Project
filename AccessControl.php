<?php
include('Connect.php');
session_start();
$session = $_SESSION['Logged_In'];
$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

if($session != true) {

    echo '<META http-equiv="refresh" content="0;URL=http://'.$baseurl.'/rejected_display.php">';

}
?>