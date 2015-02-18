<?php

$dsn = 'mysql:dbname=AsselberghsMedia;host=188.121.44.159';
$user = 'AsselberghsMedia';
$pass = 'r%zUW6MP7@f8Uz';

try {

$db = new PDO($dsn, $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
    die('Could not connect to database:<br />' . $e->getMessage());   
}

?>