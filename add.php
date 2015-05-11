<?php
/*
    This is a media database to mange your Games.
    Copyright (C) 2013 Nick Tranholm Asselberghs

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: <input type="text" name="Title" value="'.$Title.'"><br>';
echo 'Platform:<br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="PS4" value="PS4"> <label for="PS4">PS4</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="PS3" value="PS3"> <label for="PS3">PS3</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox One" value="Xbox One"> <label for="Xbox One">Xbox One</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox 360" value="Xbox 360"> <label for="Xbox 360">Xbox 360</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="PC" value="PC"> <label for="PC">PC</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Wii" value="Wii"> <label for="Wii">Wii</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Board Game" value="Board Game"> <label for="Board Game">Board Game</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Card Game" value="Card Game"> <label for="Card Game">Card Game</label><br />';
echo 'Genre: <input type="text" name="Genre"><br>';
echo 'Udvikler: <input type="text" name="Developer"><br>';
echo 'Pris: <input type="text" name="Price"><br>';
echo '</p>';
echo '<input type="submit" name="submit" value="Add">';

$TitleErrCheckIn=$_POST['Title'];
$GenreErrCheckIn=$_POST['Genre'];
$DeveloperErrCheckIn=$_POST['Developer'];
$PriceErrCheckIn=$_POST['Price'];



$TitleErrCheck=ErrorControl($TitleErrCheckIn);
$GenreErrCheck=ErrorControl($GenreErrCheckIn);
$DeveloperErrCheck=ErrorControl($DeveloperErrCheckIn);
$PriceErrCheck=ErrorControl($PriceErrCheckIn);

if($TitleErrCheck==TRUE || $GenreErrCheck==TRUE || $DeveloperErrCheck==TRUE || $PriceErrCheck==TRUE) {
	
	$ErrCheck=TRUE;
}


if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!='' && $ErrCheck != TRUE){

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

	$Query_String=$db->prepare("INSERT INTO Game (Title, Platform, Genre, Developer, Price, User) VALUES (:title,:platformdata,:genre,:developer,:price,:user)");
    $Query_String->bindParam(':title', $Title, PDO::PARAM_STR);
    $Query_String->bindParam(':platformdata', $PlatformData, PDO::PARAM_STR);
    $Query_String->bindParam(':genre', $Genre, PDO::PARAM_STR);
    $Query_String->bindParam(':developer', $Developer, PDO::PARAM_STR);
    $Query_String->bindParam(':price', $Price, PDO::PARAM_INT);
    $Query_String->bindParam(':user', $_SESSION['User'], PDO::PARAM_STR);
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

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}


?>