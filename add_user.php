<?php
echo '<html><head><title>Adding a user to the database</title></head><body>';
/*
    This is a setup script for the media databases.
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
include('ErrorControl.php');
include('Connect.php');
include('Yubico.php');
include('AccessControl.php');
echo "<form name=\"add_user\" action=". $_SERVER['PHP_SELF'] ." method=\"post\">";?>
User: <input type="text" name="scriptuser" value=""><br />
Password: <input type="password" name="scriptpass" value=""><br />
Confirm Password: <input type="password" name="scriptpassconfirm" value=""> <br />
E-mail: <input type="text" name="Email"><br />
Yubikey: <input type="text" name="yubikey"><br>
Note: Your e-mail will only be stored in your own database, I am not using it neither for myself nor for a third party.<br />
The reason you should enter your e-mail is, because of the Backup function in the admin area.<br />
It will send you a dump of your database on your e-mail, provided you enter your e-mail here.<br /><br />
<input type="submit" name="submit" value="submit">
<?php
$scriptuser = $_POST['scriptuser'];
$scriptpassword = $_POST['scriptpass'];
$scriptpasswordconfirm = $_POST['scriptpassconfirm'];
$scriptemail = $_POST['Email'];
$yubikeyErrCheckIn=$_POST['yubikey'];

$scriptuserErrCheck = ErrorControl($scriptuser);
$scriptpassErrCheck = ErrorControl($scriptpassword);
$scriptpassconfirmErrCheck = ErrorControl($scriptpasswordconfirm);
$scriptemailErrCheck = ErrorControl($scriptemail);
$yubikeyErrCheck=ErrorControl($yubikeyErrCheckIn);

if($scriptuserErrCheck == TRUE || $scriptpassErrCheck == TRUE || $scriptpassconfirmErrCheck == TRUE || $scriptemailErrCheck == TRUE || $yubikeyErrCheck == TRUE) { $ErrCheck = TRUE; }			
if($_POST['submit'] && $_POST['scriptuser'] != '' && $_POST['scriptpass'] != '' && $_POST['scriptpassconfirm'] != '' && $_POST['Email'] != '' && $ErrCheck != TRUE) {
    if($_POST['scriptpass'] != $_POST['scriptpassconfirm']) { echo 'Passwords for the user in the database dosen�t match try again <br /><br />'; }
	           	$passwordSALT = time().uniqid(rand(),TRUE);
			    $hashresult = hash('sha512', $scriptpassword.$passwordSALT);
                if($_POST['yubikey'] != '') {
                $populate_user = $db->prepare("INSERT INTO Users (User, Password, SALT, Email,Yubikey,Yubikey_Used) VALUES (:user,:hash,:password,:email,:yubikey,:yubikeyused)");
                }else {
                $populate_user = $db->prepare("INSERT INTO Users (User, Password, SALT, Email) VALUES (:user,:hash,:password,:email)");
                }
                $populate_user->bindParam(':user', $scriptuser, PDO::PARAM_STR);
                $populate_user->bindParam(':hash', $hashresult, PDO::PARAM_STR);
                $populate_user->bindParam(':password', $passwordSALT, PDO::PARAM_STR);
                $populate_user->bindParam(':email', $scriptemail, PDO::PARAM_STR);
                if($_POST['yubikey'] != '') {
                    //Yubikey Authentication
                    $yubi = new Auth_Yubico('28274', 'eqp96B8xrLUvu7+VybDGd9l14no=');
                    $auth = $yubi->verify($_POST['yubikey']);
                    if (PEAR::isError($auth)) {
                        print "<p>Authentication failed: " . $auth->getMessage()."</p>";
                        print "<p>Debug output from server: " . $yubi->getLastResponse()."</p>";
                    } else {
                    $yubikey_id = substr($_POST['yubikey'], 0, 12);
                    $yubikey_used = TRUE;
                    $populate_user->bindParam(':yubikey', $yubikey_id, PDO::PARAM_STR);
                    $populate_user->bindParam(':yubikeyused', $yubikey_used, PDO::PARAM_STR);
                    }
                }
                try { $populate_user->execute(); }catch(PDOException $e) { echo $e->getMessage(); }
        	/*$populate_user = "INSERT INTO Users (User, Password, SALT, Email) VALUES ('".$scriptuser."','".$hashresult."','".$passwordSALT."', '".$scriptemail."')";
            	mysql_query($populate_user) or die('Could not create user for the database');*/
				echo 'User successfully added<br /><br />'; 
                } else { echo 'User could not be added'; }
?>