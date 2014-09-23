<?php

$dsn = 'mysql:dbname=database_name;host=mysql_server_IP';
$user = 'database_username';
$pass = 'database_password';

try {

$db = new PDO($dsn, $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
    die('Could not connect to database:<br />' . $e->getMessage());   
}

?>