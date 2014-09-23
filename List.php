<?php

session_start();

echo '<link rel="stylesheet" type="text/css" href="style.css">';
include('Connect.php');

try{
$result = $db->prepare("SELECT * FROM Game");
$result->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}
echo '<center>';
echo '<table border="1">';
echo '<tr>';
echo '<td><p>Titel</p></td><td><p>Platform</p></td><td><p>Genre</p></td><td><p>Udvikler</p></td>';
if(isset($_SESSION['Logged_In'])) {
echo '<td><p>Pris</p></td>';	
}
echo '</tr>';

while($row = $result->fetch(PDO::FETCH_OBJ)) 
{

	if($row->Lend == 'Yes') {
	
	echo "<tr>";
    echo "<td bgcolor='red'>$row->Title</td><td bgcolor='red'>$row->Platform</td><td bgcolor='red'>$row->Genre</td><td bgcolor='red'>$row->Developer</td>";
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
echo "<td><p>$row->Title</p></td><td><p>$row->Platform</p></td><td><p>$row->Genre</p></td><td><p>$row->Developer</p></td>";

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