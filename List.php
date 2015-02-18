<?php
/*
    This is a media database to mange your Game.
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

session_start();

echo '<link rel="stylesheet" type="text/css" href="style.css">';
include('Connect.php');

try{
$result = $db->prepare("SELECT * FROM Game ORDER BY Title");
$result->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
echo '<center>';
echo '<table border="1">';
echo '<tr>';
echo '<td><p>Titel</p></td><td><p>Platform</p></td><td><p>Genre</p></td><td><p>Udvikler</p></td><td><p>Ejer</p></td>';
if(isset($_SESSION['Logged_In'])) {
echo '<td><p>Pris</p></td>';	
}
echo '</tr>';

while($row = $result->fetch(PDO::FETCH_OBJ)) 
{

	if($row->Lend == 'Yes') {
	
	echo "<tr>";
    $User = $row->User;
    $User = ucfirst($User);
    echo "<td bgcolor='red'>$row->Title</td><td bgcolor='red'>$row->Platform</td><td bgcolor='red'>$row->Genre</td><td bgcolor='red'>$row->Developer</td><td bgcolor='red'>".$User."</td>";
if(isset($_SESSION['Logged_In'])) 
	{
	 	echo "<td bgcolor='red'><p>$row->Price</p></td>";
	}

      	if(isset($_SESSION['Logged_In'])){
         	 echo "<td bgcolor='red'><a href='update_display.php?Title=$row->Title&ID=$row->ID&Platform=$row->Platform&Genre=$row->Genre&Developer=$row->Developer'>Edit</a></td><td bgcolor='red'><a href='delete_display.php?Title=$row->Title&ID=$row->ID'>Delete</a></td><td><p>$row->Loaner</p></td>";
      	}

echo "</tr>";
	
	}
	else {

echo "<tr>";
$User = $row->User;
$User = ucfirst($User);
echo "<td><p>$row->Title</p></td><td><p>$row->Platform</p></td><td><p>$row->Genre</p></td><td><p>$row->Developer</p></td><td><p>".$User."</p></td>";

if(isset($_SESSION['Logged_In'])) 
{
	echo "<td><p>$row->Price</p></td>";
}

      if(isset($_SESSION['Logged_In'])){
          echo "<td bgcolor='#808080'><a href='update_display.php?Title=$row->Title&ID=$row->ID&Platform=$row->Platform&Genre=$row->Genre&Developer=$row->Developer'>Edit</a></td><td bgcolor='#808080'><a href='delete_display.php?Title=$row->Title&ID=$row->ID'>Delete</a></td>";
      }

echo "</tr>";
	}
}

$CountQuery=$db->prepare('SELECT COUNT(id) FROM Game');
$CountQuery->execute();
$CountResult = $CountQuery->fetch();

$WorthQuery=$db->prepare('SELECT SUM(Price) FROM Game');
$WorthQuery->execute();
$WorthResult = $WorthQuery->fetch();

echo '<tr>';
echo "<td></td><td></td><td></td><td><p>Total ".$CountResult['COUNT(id)']." Titler</p></td>";
if(isset($_SESSION['Logged_In'])) {
echo "<td><p>Spillenes V&aelig;rdi ".$WorthResult['SUM(Price)']."</p></td>";	
} else {
echo '<td></td>';	
}
echo '</tr>';

echo '</table>';
echo '</center>';
?>