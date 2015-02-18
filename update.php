<?php
echo '<link rel="stylesheet" type="text/css" href="style.css">';

include('Connect.php');
include('ErrorControl.php');
include('AccessControl.php');
$Title=$_GET['Title'];
$ID=$_GET['ID'];
$Platform=$_GET['Platform'];
$Genre=$_GET['Genre'];
$Developer=$_GET['Developer'];
$Price=$_GET['Price'];

$result = $db->prepare("SELECT * FROM Game WHERE ID =:ID");
$result->bindParam(':ID', $ID, PDO::PARAM_INT);
try {
    $result->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
    
while($row = $result->fetch(PDO::FETCH_OBJ)) 
{
$Lend=$row->Lend;
$Loaner=$_row->Loaner;
}

echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Titel: </p><input type="text" name="Title" value="'.$Title.'"><br>';
echo '<p>Platform: </p>';
echo '<input type="checkbox" name="PlatformCheck[]" id="PS3" value="PS3"> <label for="PS3">PS3</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox 360" value="Xbox 360"> <label for="Xbox 360">Xbox 360</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="PC" value="PC"> <label for="PC">PC</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Wii" value="Wii"> <label for="Wii">Wii</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Board Game" value="Board Game"> <label for="Board Game">Board Game</label><br />';
echo '<input type="checkbox" name="PlatformCheck[]" id="Card Game" value="Card Game"> <label for="Card Game">Card Game</label><br />';
echo '<p>Genre: </p><input type="text" name="Genre" value="'.$Genre.'"><br>';
echo '<p>Udvikler: </p><input type="text" name="Developer" value="'.$Developer.'"><br>';
echo '<p>Price: </p><input type="text" name="Price" value="'.$Price.'"><br>';

echo '<p>Udlaant?</p><select name="Lend">';
echo '<option value="Yes">Yes</option>';
echo '<option value="No" selected="selected">No</option>';
echo '</select><br>';

echo '<p>Udlaant til: </p><input type="text" name="Loaner" value="'.$Loaner.'">'; 
 
echo '<input type="hidden" name="ID" value="'.$ID.'"><br>';
echo '<input type="submit" name="submit" value="Opdater">';


$TitleErrCheckIn = $_POST['Title'];
$GenreErrCheckIn = $_POST['Genre'];
$DeveloperErrCheckIn = $_POST['Developer'];
$PriceErrCheckIn = $_POST['Price'];
$LoanerErrCheckIn = $_POST['Loaner'];

$TitleErrCheck = ErrorControl($TitleErrCheckIn);
$GenreErrCheck = ErrorControl($GenreErrCheckIn);
$DeveloperErrCheck = ErrorControl($DeveloperErrCheckIn);
$PriceErrCheck = ErrorControl($PriceErrCheckIn);
$LoanerErrCheck = ErrorControl($LoanerErrCheckIn);

if($TitleErrCheck==TRUE || $GenreErrCheck==TRUE || $DeveloperErrCheck==TRUE || $PriceErrCheck==TRUE || $LoanerErrCheck==TRUE) {
	
	$ErrCheck = TRUE;
}

if(isset($_POST['submit']) && $_POST['Title']!='' && $_POST['Genre']!='' && $_POST['Developer']!='' && $ErrCheck != TRUE){

$Title=$_POST['Title'];
$ID=$_POST['ID'];
$Platform=$_POST['PlatformCheck'];
$PlatformData = implode(",", $Platform);
$Genre=$_POST['Genre'];
$Developer=$_POST['Developer'];
$Lend=$_POST['Lend'];
$Loaner=$_POST['Loaner'];
$Price=$_POST['Price'];
$Price=(int)$Price;


$Query_String=$db->prepare("UPDATE Game SET Title = :title WHERE ID = :id");
$Query_String->bindParam(':title',$Title, PDO::PARAM_STR);
$Query_String->bindParam(':id', $ID, PDO::PARAM_STR);

try{

$Query_String->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String2=$db->prepare("UPDATE Game SET Platform = :platformdata WHERE ID = :id");
$Query_String2->bindParam(':platformdata',$PlatformData, PDO::PARAM_STR);
$Query_String2->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String2->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String3=$db->prepare("UPDATE Game SET Genre = :genre WHERE ID = :id");
$Query_String3->bindParam(':genre',$Genre, PDO::PARAM_STR);
$Query_String3->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String3->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String4=$db->prepare("UPDATE Game SET Developer = :developer WHERE ID = :id");
$Query_String4->bindParam(':developer',$Developer, PDO::PARAM_STR);
$Query_String4->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String4->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String5=$db->prepare("UPDATE Game SET Lend = :lend WHERE ID = :id");
$Query_String5->bindParam(':lend',$Lend, PDO::PARAM_STR);
$Query_String5->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String5->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String6=$db->prepare("UPDATE Game SET Loaner = :loaner WHERE ID = :id");
$Query_String6->bindParam(':loaner',$Loaner, PDO::PARAM_STR);
$Query_String6->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String6->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}
$Query_String7=$db->prepare("UPDATE Game SET Price = :price WHERE ID = :id");
$Query_String7->bindParam(':price',$Price, PDO::PARAM_INT);
$Query_String7->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String7->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}

$Query_String8=$db->prepare("UPDATE Game SET User = :user WHERE ID = :id");
$Query_String8->bindParam(':user',$_SESSION['User'], PDO::PARAM_INT);
$Query_String8->bindParam(':id', $ID, PDO::PARAM_STR);

try{
    
$Query_String8->execute();

}catch(PDOException $e) {
    
echo $e->getMessage();

}

echo '<p>Spillet er blevet opdateret</p>';

}

if ($ErrCheck==TRUE) {
	
	
	echo '<p>Du har indtastet ugyldige karaktere</p>';
	
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}

?>