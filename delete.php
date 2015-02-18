<?php
include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');
$Title=$_GET['Title'];
$ID=$_GET['ID'];

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: <input type="text" name="Title" value="'.$Title.'"><br>';
echo 'Platform: <select name="Platform">';
echo '<option value="PS3">PS3</option>';
echo '<option vaue="Xbox 360">Xbox 360</option>';
echo '<option vaue="PC">PC</option>';
echo '<option vaue="Wii">Wii</option>';
echo '</select><br>';
echo 'Genre: <input type="text" name="Genre"><br>';
echo 'Udvikler: <input type="text" name="Developer"><br>';
echo '<input type="hidden" name="ID" value="'.$ID.'">';
echo '</p>';
echo '<input type="submit" name="submit" value="Slet">';


$TitleErrCheckin=$_POST['Title'];
$GenreErrCheckin=$_POST['Genre'];
$DeveloperErrCheckin=$_POST['Developer'];

$TitleErrCheck=ErrorControl($TitleErrCheckin);
$GenreErrCheck=ErrorControl($GenreErrCheckin);
$DeveloperErrCheck=ErrorControl($DeveloperErrCheckin);

if($TitleErrCheck==TRUE || $GenreErrCheck==TRUE || $DeveloperErrCheck==TRUE) {

$ErrCheck=TRUE;
}



if(isset($_POST['submit']) && $ErrCheck != TRUE){

$Title=$_POST['Title'];
$ID=$_POST['ID'];

$Query_String=$db->prepare("DELETE FROM Game WHERE ID = :id");
$Query_String->bindParam(':id', $ID, PDO::PARAM_INT);
try{
    $Query_String->execute();
}catch(PDOException $e) {
    echo $e->getMessage();
}

echo '<p>Spillet er blevet slettet</p>';

}

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}
?>