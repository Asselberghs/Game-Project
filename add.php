<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('AccessControl.php');

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: <input type="text" name="Title" value="'.$Title.'"><br>';
echo 'Platform:<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="PS3">PS3<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="Xbox 360">Xbox 360<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="PC">PC<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="Wii">Wii<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="Board Game">Board Game<br />';
echo '<input type="checkbox" name="PlatformCheck[]" value="Card Game">Card Game<br />';
echo 'Genre: <input type="text" name="Genre"><br>';
echo 'Udvikler: <input type="text" name="Developer"><br>';
echo 'Pris: <input type="text" name="Price"><br>';
echo '</p>';
echo '<input type="submit" name="submit" value="Add">';


if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!=''){

$Title=$_POST['Title'];
$Platform=$_POST['PlatformCheck'];
$PlatformData = implode(",", $Platform);
$Genre=$_POST['Genre'];
$Developer=$_POST['Developer'];
$Price=$_POST['Price'];
$Price=(int)$Price;

$Query_Check=$db->prepare("SELECT * FROM Game WHERE Title LIKE :title");
$Query_Check->bindParam(':title', $Title, PDO::PARAM_STR);
$titlecheck="";
try {
    $Query_Check->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}

	while($row = $Query_Check->fetch(PDO::FETCH_OBJ)) 
		{
		$titlecheck=$row->Title;		
		}

	if($titlecheck!=$Title){

	$Query_String=$db->prepare("INSERT INTO Game (Title, Platform, Genre, Developer, Price) VALUES (:title,:platformdata,:genre,:developer,:price)");
    $Query_String->bindParam(':title', $Title, PDO::PARAM_STR);
    $Query_String->bindParam(':platformdata', $PlatformData, PDO::PARAM_STR);
    $Query_String->bindParam(':genre', $Genre, PDO::PARAM_STR);
    $Query_String->bindParam(':developer', $Developer, PDO::PARAM_STR);
    $Query_String->bindParam(':price', $Price, PDO::PARAM_INT);
    try{
        $Query_String->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

	echo '<p>Spillet er tilfoejet til databasen</p>';

	} 
	else 
	{
	
	echo '<p>Spillet findes allerede i databasen</p>';
	
	}
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}


?>