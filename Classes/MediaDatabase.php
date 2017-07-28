<?php

class MediaDatabase
{
    //__construct
    protected $db;
    protected $user;
    protected $password;
    protected $dsn;
    //showLogin
    protected $authUser;
    protected $authPassword;
    protected $serverAuthUser;
    protected $serverAuthPassword;
    protected $serverAuthSalt;
    protected $password_and_salt;
    protected $SALT;
    protected $encrypted_password;
    protected $serverUserVariable;
    protected $serverPasswordVariable;
    //backup
    protected $database;


    public function __construct($server, $user, $password, $dbname)
    {
        session_start();
        $this->dsn = 'mysql:dbname='.$dbname.';host='.$server;
        $this->user = $user;
        $this->password = $password;

        try {
            $this->db = new PDO($this->dsn, $this->user, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die('Could not connect to database:<br />' . $e->getMessage());
        }
    }

    public function showLogin() {
        echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
        echo '<p>Brugernavn: <input type="text" name="user"><br>';
        echo 'Password: <input type="password" name="password"><br>';
        //echo 'Yubikey: <input type="text" name="yubikey"><br><br />';
        echo '<input type="submit" name="submit" value="Login">';
        echo '</form>';

        $this->login($_POST['user'],$_POST['password']);
    }

    public function showSearch() {
        echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
        echo '<p><select name="Type"><option value="Title">Titel</option><option value="Genre">Genre</option><option value="Format">Format</option><option value="Production_Year">Productions Aar</option><option value="Actor">Skuespiller</option><option value="Director">Instruktoeer</option></select> <input type="text" name="Search">';
        echo '<input type="submit" name="submit" id="Searchsubmit" value="Search"></p>';
        echo '</form>';
    }

    protected function login($username, $password) {
        if($username != '' && $password != '') {

            $this->authUser = $username;
            $this->authPassword = $password;

            $this->serverAuthUser = $this->db->prepare("SELECT User FROM Users WHERE User LIKE :user");
            $this->serverAuthPassword = $this->db->prepare("SELECT Password FROM Users WHERE User LIKE :user");
            $this->serverAuthSalt = $this->db->prepare("SELECT SALT FROM Users WHERE User LIKE :user");

            $this->serverAuthUser->bindParam(':user', $this->authUser, PDO::PARAM_STR);
            $this->serverAuthPassword->bindParam(':user', $this->authUser, PDO::PARAM_STR);
            $this->serverAuthSalt->bindParam(':user', $this->authUser, PDO::PARAM_STR);

            try {
                $this->serverAuthSalt->execute();
            }catch (PDOException $e) {
                echo $e->getMessage();
            }

            while($row = $this->serverAuthSalt->fetch(PDO::FETCH_OBJ)) {
                $this->SALT = $row->SALT;
            }

            $this->password_and_salt = $this->authPassword.$this->SALT;

            $this->encrypted_password = hash('SHA512',$this->password_and_salt);

            try {
                $this->serverAuthUser->execute();
            }catch (PDOException $e) {
                echo $e->getMessage();
            }

            try {
                $this->serverAuthPassword->execute();
            }catch (PDOException $e) {
                echo $e->getMessage();
            }

            while ($row = $this->serverAuthUser->fetch(PDO::FETCH_OBJ)) {

                $this->serverUserVariable = $row->User;

            }

            while ($row = $this->serverAuthPassword->fetch(PDO::FETCH_OBJ)) {

                $this->serverPasswordVariable = $row->Password;

            }


            if($this->authUser == $this->serverUserVariable && $this->encrypted_password == $this->serverPasswordVariable) {

                echo 'Login Successful';
                $_SESSION['Logged_In'] = true;
                $_SESSION['User'] = $this->serverUserVariable;
                $_SESSION['Password'] = $this->encrypted_password;

            }
            else {
                echo 'Login Failed';
            }

        }
    }

    public function logout() {
        session_destroy();
        echo '<p>Your are Logged Out</p>';
    }

    public function showRestore() {
        echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
        echo '<textarea name="restore" rows="10" cols="100">';
        echo '</textarea><br /><br>';
        echo '<input type="submit" name="submit" value="Restore" >';
        echo '</form>';
    }

    public function showAddUser() {
        if($_SESSION['Logged_In']) {
            echo "<form name=\"add_user\" action=" . $_SERVER['PHP_SELF'] . " method=\"post\">";
            echo "User: <input type=\"text\" name=\"scriptuser\" value=\"\"><br />";
            echo "Password: <input type=\"password\" name=\"scriptpass\" value=\"\"><br />";
            echo "Confirm Password: <input type=\"password\" name=\"scriptpassconfirm\" value=\"\"> <br />";
            echo "E-mail: <input type=\"text\" name=\"Email\"><br />";
            //echo "Yubikey: <input type=\"text\" name=\"yubikey\"><br>";
            echo "Note: Your e-mail will only be stored in your own database, I am not using it neither for myself nor for a third party.<br />";
            echo "The reason you should enter your e-mail is, because of the Backup function in the admin area.<br />";
            echo "It will send you a dump of your database on your e-mail, provided you enter your e-mail here.<br /><br />";
            echo "<input type=\"submit\" name=\"submit\" value=\"submit\">";

            $this->addUser($_POST['scriptuser'], $_POST['scriptpass'], $_POST['scriptpassconfirm'], $_POST['Email']);
        } else {
            echo 'You are not logged in, you cannot add a user to the database.';
        }
    }

    protected function addUser($scriptuser, $scriptpass, $scriptpassconfirm, $Email, $yubikey = '') {
        if($_SESSION['Logged_In']) {
            if($scriptuser != '' && $scriptpass != '' && $scriptpassconfirm != '' && $Email != '') {
                if($scriptpass != $scriptpassconfirm) {
                    echo 'The passwords you entered for your user does not match please try again.<br /><br />';
                } else {
                    $passwordSALT = time() . uniqid(rand(), TRUE);
                    $hashresult = hash('sha512', $scriptpass . $passwordSALT);
                    $populate_user = $this->db->prepare("INSERT INTO Users (User, Password, SALT, Email) VALUES (:user,:hash,:password,:email)");
                    $populate_user->bindParam(':user',$scriptuser, PDO::PARAM_STR);
                    $populate_user->bindParam(':hash',$hashresult,PDO::PARAM_STR);
                    $populate_user->bindParam(':password',$passwordSALT,PDO::PARAM_STR);
                    $populate_user->bindParam(':email',$Email,PDO::PARAM_STR);

                    try {
                        $populate_user->execute();
                    }catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    echo 'The user: '.$scriptuser.' has been added to the database.<br /><br />';
                }
            } else {
                echo 'Some required field´s are empty.<br /><br />';
            }
        } else {
            echo 'You are not logged in, it follows you are not authorized to add a user to the database.<br /><br />';
        }
    }

    public function backup($database) {

        $this->database = ucfirst($database);

        if($_SESSION['Logged_In']) {
            $BackupStatement = $this->db->prepare('SELECT * FROM `'.$this->database.'`');
            try {
                $BackupStatement->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $backup = "Backup from ".$this->database." Database sent from Asselberghs.dk:<br /><br />";
            $headers = "From: nick@asselberghs.dk\r\n";
            $headers .= "Reply-To: nick@asselberghs.dk\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            while ($row = $BackupStatement->fetch(PDO::FETCH_OBJ)) {
                if($this->database == 'Book') {
                    echo 'INSERT INTO `Book` (`Title`, `Author`, `Genre`, `Series`, `Copyright`, `Publisher`, `ISBN`, `Price`, `Format`, `Lend`, `Loaner`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Author . '\', \'' . $row->Genre . '\', \'' . $row->Series . '\', \'' . $row->Copyright . '\', \'' . $row->Publisher . '\', \'' . $row->ISBN . '\', \'' . $row->Price . '\', \'' . $row->Format . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->User . '\');';
                    echo '<br />';
                    $backup .= 'INSERT INTO `Book` (`Title`, `Author`, `Genre`, `Series`, `Copyright`, `Publisher`, `ISBN`, `Price`, `Format`, `Lend`, `Loaner`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Author . '\', \'' . $row->Genre . '\', \'' . $row->Series . '\', \'' . $row->Copyright . '\', \'' . $row->Publisher . '\', \'' . $row->ISBN . '\', \'' . $row->Price . '\', \'' . $row->Format . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->User . '\');<br />';
                } else if($this->database == 'Game') {
                    echo 'INSERT INTO `Game` (`Title`, `Platform`, `Genre`, `Developer`, `Lend`, `Loaner`, `Price`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Platform . '\', \'' . $row->Genre . '\', \'' . $row->Developer . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Price . '\', \''.$row->User.'\');';
                    echo '<br />';
                    $backup .= 'INSERT INTO `Game` (`Title`, `Platform`, `Genre`, `Developer`, `Lend`, `Loaner`, `Price`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Platform . '\', \'' . $row->Genre . '\', \'' . $row->Developer . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Price . '\', \'' . $row->User . '\');<br />';
                } else if($this->database == 'Movie') {
                    echo 'INSERT INTO `Movie` (`Title`, `Format`, `Production_Year`, `Actor`, `Director`, `Lend`, `Loaner`, `Genre`, `Price`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Format . '\', \'' . $row->Production_Year . '\', \'' . $row->Actor . '\', \'' . $row->Director . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Genre . '\', \'' . $row->Price . '\', \''.$row->User.'\');';
                    echo '<br />';
                    $backup .= 'INSERT INTO `Movie` (`Title`, `Format`, `Production_Year`, `Actor`, `Director`, `Lend`, `Loaner`, `Genre`, `Price`, `User`) VALUES (\'' . $row->Title . '\', \'' . $row->Format . '\', \'' . $row->Production_Year . '\', \'' . $row->Actor . '\', \'' . $row->Director . '\', \'' . $row->Lend . '\', \'' . $row->Loaner . '\', \'' . $row->Genre . '\', \'' . $row->Price . '\', \''.$row->User.'\');<br />';
                } else {
                    echo 'The application is not familiar with the database table you are attempting to backup';
                }
            }

            $user = $_SESSION['User'];

            $user_query = $this->db->prepare("SELECT Email FROM `Users` WHERE User LIKE :user");
            $user_query->bindParam(':user', $user, PDO::PARAM_STR);
            try {
                $user_query->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $user_email = $user_query->fetch();
            $subject = 'Backup from'. $this->database .'Database';
            $email = $user_email['Email'];

            mail($email, $subject, $backup, $headers);

            echo 'Backup completed and e-mail sent to the user';
        } else {
            echo 'Du er ikke logget ind du har ikke rettighed til at lave backup';
        }
    }

    public function restore($SQL) {
        $quries = explode(';',$SQL,-1);

        foreach($quries as $query){
            try {
                $this->db->query($query);
            }catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        echo 'Backup fra SQL fil er gendannet i databasen';
    }

}