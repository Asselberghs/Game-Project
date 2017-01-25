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

include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');
session_start();

echo 'Denne side er lavet med det form&aring;l at tage backup af databasens indhold på en let m&aring;de s&aring; du kan sikrer dig mod data tab i fremtiden.<br />';
echo 'Dette kunne g&oslash;res ved hjaelig;lp af phpmyadmin men jeg ville ikke antage at brugerne af dette script n&oslash;dvendigvis vidste hvordan dette g&oslash;res s&aring; jeg har fors&oslash;gt at implementere<br />';
echo 'En let m&aring;de at tage backup og genetablere en backup til dette system<br />';
echo 'Du kan blot markere teksten for neden, kopiere den over i en tekst fil på din computer og gemme den som en .sql fil, indholdet af denne fil kopiere du s&aring; over i en boks til gendannelse p&aring; gendan backup af databse linket og k&aring;rer den gennem databasen<br /><br />';

$query = $db->prepare('SELECT * FROM `Game`');
try {
    $query->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
    
    
$backup = "Backup from Game Database sent from Asselberghs.dk:<br /><br />";
$headers = "From: nick@asselberghs.dk\r\n";
$headers .= "Reply-To: nick@asselberghs.dk\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
while($row = $query->fetch(PDO::FETCH_OBJ))
{
			echo 'INSERT INTO `Game` (`Title`, `Platform`, `Genre`, `Developer`, `Lend`, `Loaner`, `Price`) VALUES (\'' . $row->Title . '\', \'' . $row->Platform . '\', \'' . $row->Genre . '\', \'' . $row->Developer . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Price . '\');';
        	echo '<br />';
            $backup .= 'INSERT INTO `Game` (`Title`, `Platform`, `Genre`, `Developer`, `Lend`, `Loaner`, `Price`) VALUES (\'' . $row->Title . '\', \'' . $row->Platform . '\', \'' . $row->Genre . '\', \'' . $row->Developer . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Price . '\');<br />';
}

$user = $_SESSION['User'];

$user_query = $db->prepare("SELECT Email FROM `Users` WHERE User LIKE :user");
$user_query->bindParam(':user', $user, PDO::PARAM_STR);
try{
    $user_query->execute();
}catch(PDOException $e) {
    echo $e->getMessage();    
}
$user_email = $user_query->fetch();
$subject = 'Backup from Game Database';
$email = $user_email['Email'];
mail($email, $subject, $backup, $headers);
?>