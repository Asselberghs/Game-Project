<?php
include('Connect.php');
echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<p>Brugernavn: <input type="text" name="user"><br>';
echo 'Password: <input type="password" name="password"><br>';
echo '<input type="submit" name="submit" value="Submit">';

if(isset($_POST['submit']) && $_POST['user']!='' && $_POST['password']!=''){

	$user=$_POST['user'];
	$password=$_POST['password'];
	

	$serveruser=$db->prepare("SELECT User FROM Users WHERE User LIKE :user");
	$serverpassword=$db->prepare("SELECT Password FROM Users WHERE User LIKE :user");
	$serverSALT=$db->prepare("SELECT SALT FROM Users WHERE User LIKE :user");
	
    $serveruser->bindParam(':user', $user, PDO::PARAM_STR);
    $serverpassword->bindParam(':user', $user, PDO::PARAM_STR);
    $serverSALT->bindParam(':user', $user, PDO::PARAM_STR);

    try{
        $serverSALT->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

	while($row = $serverSALT->fetch(PDO::FETCH_OBJ)) 
	{
	$SALT = $row->SALT;
		
	}
	
	$password_and_salt = $password.$SALT;
	
	$encrypted_password=hash('sha512',$password_and_salt);

	try{
        $serveruser->execute();
	}catch(PDOException $e) {
     echo $e->getMessage();   
	}
    
    try{
        $serverpassword->execute();
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

	while($row = $serveruser->fetch(PDO::FETCH_OBJ)){

		$serveruservar=$row->User;

	}

	while($row = $serverpassword->fetch(PDO::FETCH_OBJ)){

		$serverpassvar=$row->Password;

	}

	echo '<br><br>';

	if($user==$serveruservar && $encrypted_password==$serverpassvar){
	
		echo 'Login successful';

        	session_start();
        	$_SESSION['Logged_In'] = 1;
	}

	else {
	echo 'Login failed';
	}

echo '</p>';
}

else {
	
		echo '<p>Formen er tom, ingen data er indsaette</p>';
}

?>