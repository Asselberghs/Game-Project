<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');

session_start();

echo '<form name="Game" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p><select name="Type"><option value="Title">Titel</option><option value="Platform">Platform</option><option value="Genre">Genre</option><option value="Developer">Udvikler</option></select> <input type="text" name="Search"></p><br>';
echo '<input type="submit" name="submit" value="Search">';
echo '</form>';



if(isset($_POST['submit']) && $_POST['Search']!=''){

$Search=$_POST['Search'];
$Type=$_POST['Type'];
$Search = '%'.$Search.'%';

$Query_String=$db->prepare("SELECT * FROM Game WHERE ".$Type." LIKE :search");
$Query_String->bindParam(':search', $Search, PDO::PARAM_STR);
try{
   $Query_String->execute(); 
}catch(PDOException $e) {
    echo $e->getMessage();
}

echo '<center>';
echo '<table border="1">';
echo '<tr>';
echo '<td><p>Titel</p></td><td><p>Platform</p></td><td><p>Genre</p></td><td><p>Udvikler</p></td>';
echo '</tr>';

while($row = $Query_String->fetch(PDO::FETCH_OBJ)) 
{


if($row->Lend == 'Yes') {
	
echo "<tr>";
echo "<td bgcolor='red'>$row->Title</td><td bgcolor='red'>$row->Platform</td><td bgcolor='red'>$row->Genre</td><td bgcolor='red'>$row->Developer</td>";

			if(isset($_SESSION['Logged_In'])){
          			echo "<td><a href='update.php?Title=$row->Title&ID=$row->ID&Platform=$row->Platform&Genre=$row->Genre&Developer=$row->Developer'>Edit</a></td><td><a href='delete.php?Title=$row->Title&ID=$row->ID'>Delete</a></td><td><p>$row->Loaner</p></td>";
      					}
			
	echo "</tr>";
	
	}
	else {


echo "<tr>";
echo "<td><p>$row->Title</p></td><td><p>$row->Platform</p></td><td><p>$row->Genre</p></td><td><p>$row->Developer</p></td>";

			if(isset($_SESSION['Logged_In'])){
          			echo "<td bgcolor='#808080'><a href='update.php?Title=$row->Title&ID=$row->ID&Platform=$row->Platform&Genre=$row->Genre&Developer=$row->Developer'>Edit</a></td><td bgcolor='#808080'><a href='delete.php?Title=$row->Title&ID=$row->ID'>Delete</a></td>";
      					}
		}
echo "</tr>";
}

echo "</table>";
echo "</center>";
}
?>