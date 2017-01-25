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

session_start();

echo 'Denne side er lavet med det form&aring;l at genetablere en backup af databasens indhold på en let m&aring;de s&aring; du kan f&aring; dine data tilbage n&aring;r uheldet har været ude.<br />';
echo 'Dette kunne g&oslash;res ved hjaelig;lp af phpmyadmin men jeg ville ikke antage at brugerne af dette script n&oslash;dvendigvis vidste hvordan dette g&oslash;res s&aring; jeg har fors&oslash;gt at implementere<br />';
echo 'En let m&aring;de at tage backup og genetablere en backup til dette system<br />';
echo 'Du kan blot indsaelig;tte den teksten du har fra backup i tekst feltet, og klikke på knappen så skulle den gendanne din backup til din nu tomme database<br /><br />';

if($_POST) 
{
	$data = $_POST['restore'];
    
    $quries = explode(';',$data, -1);
    
    foreach($quries as $query) {
        try{
        $db->query($query);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    echo 'Backup fra SQL fil er gendannet i databasen';
	
}




echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
echo '<textarea name="restore" rows="10" cols="100">';
echo '</textarea>';
echo '<input type="submit" name="submit" value="Restore" >';
echo '</form>';
?>