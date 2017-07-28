<?php
require('MediaDatabase.php');


class GameDatabase extends MediaDatabase
{
    //showTable
    protected $table_stmt;
    protected $row;
    //addGame
    protected $title;
    protected $genre;
    protected $developer;
    protected $price;
    protected $platformdata;

    public function __construct($server, $user, $password, $dbname)
    {
        parent::__construct($server,$user,$password,$dbname);
    }

    public function showTable($search = '', $field = '') {
        if($search == '' && $field == '') {
            $this->table_stmt = $this->db->prepare("SELECT * FROM Game");
        } else {
            $this->table_stmt = $this->db->prepare("SELECT * FROM Game WHERE $field LIKE '%$search%'");
        }

        try {
            $this->table_stmt->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
        echo '<center>';
        echo '<table border="1">';
        echo '<tr>';
        echo '<td><p>Titel</p></td><td><p>Platform</p></td><td><p>Genre</p></td><td><p>Udvikler</p></td><td><p>Ejer</p></td></tr>';

        while($this->row = $this->table_stmt->fetch(PDO::FETCH_OBJ)) {
            if($this->row->Lend == 'Yes') {
                echo '<tr class="borrowed">';
            } else {
                echo '<tr>';
            }
            $User = $this->row->User;
            $User = ucfirst($User);
            echo '<td>'.$this->row->Title.'</td>';
            echo '<td>'.$this->row->Platform.'</td>';
            echo '<td>'.$this->row->Genre.'</td>';
            echo '<td>'.$this->row->Developer.'</td>';
            echo '<td>'.$User.'</td>';
            if($_SESSION['Logged_In']) {
                echo "<td><a href=\"update.php?Title=". $this->row->Title ."&ID=".$this->row->ID."&Platform=".$this->row->Platform."&Genre=".$this->row->Genre."&Developer=".$this->row->Developer."&Price=".$this->row->Price."&Loaner=".$this->row->Loaner."\">Edit</a></td>";
                echo "<td><a href=\"delete.php?Title=".$this->row->Title ."&ID=".$this->row->ID."\">Delete</a></td>";
            }
            echo '</tr>';
        }

        echo '</table>';
    }

    public function showAddGame() {
        if($_SESSION['Logged_In']) {
            echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo '<p>Titel: <input type="text" name="Title" value="'.$Title.'"><br>';
            echo 'Platform:<br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS4" value="PS4"> <label for="PS4">PS4</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS4_Digital" value="PS4 Digital"> <label for="PS4 Digital">PS4 Digital</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS3" value="PS3"> <label for="PS3">PS3</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_One" value="Xbox One"> <label for="Xbox One">Xbox One</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_One_Digital" value="Xbox One Digital"> <label for="Xbox One Digital">Xbox One Digital</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_360" value="Xbox 360"> <label for="Xbox 360">Xbox 360</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PC" value="PC"> <label for="PC">PC</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Wii" value="Wii"> <label for="Wii">Wii</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Wii_U" value="Wii U"> <label for="Wii U">Wii U</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Board_Game" value="Board Game"> <label for="Board Game">Board Game</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Card_Game" value="Card Game"> <label for="Card Game">Card Game</label><br />';
            echo 'Genre: <input type="text" name="Genre"><br>';
            echo 'Udvikler: <input type="text" name="Developer"><br>';
            echo 'Pris: <input type="text" name="Price"><br>';
            echo '</p>';
            echo '<input type="submit" name="submit" value="Add"><br />';

            $this->addGame($_POST['Title'],$_POST['PlatformCheck'],$_POST['Genre'],$_POST['Developer'],$_POST['Price']);
        } else {
            echo 'You need to login to be able to add a game to the database.';
        }
    }

    public function showUpdateGame($ID, $Title, $Genre, $Developer, $Price, $Loaner) {
        if($_SESSION['Logged_In']) {
            echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo '<p>Titel: </p><input type="text" name="Title" value="'.$Title.'"><br>';
            echo '<p>Platform: </p>';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS4" value="PS4"> <label for="PS4">PS4</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS4_Digital" value="PS4 Digital"> <label for="PS4 Digital">PS4 Digital</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PS3" value="PS3"> <label for="PS3">PS3</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_One" value="Xbox One"> <label for="Xbox One">Xbox One</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_One_Digital" value="Xbox One Digital"> <label for="Xbox One Digital">Xbox One Digital</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Xbox_360" value="Xbox 360"> <label for="Xbox 360">Xbox 360</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="PC" value="PC"> <label for="PC">PC</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Wii" value="Wii"> <label for="Wii">Wii</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Wii_U" value="Wii U"> <label for="Wii U">Wii U</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Board_Game" value="Board Game"> <label for="Board Game">Board Game</label><br />';
            echo '<input type="checkbox" name="PlatformCheck[]" id="Card_Game" value="Card Game"> <label for="Card Game">Card Game</label><br />';
            echo '<p>Genre: </p><input type="text" name="Genre" value="'.$Genre.'"><br>';
            echo '<p>Udvikler: </p><input type="text" name="Developer" value="'.$Developer.'"><br>';
            echo '<p>Price: </p><input type="text" name="Price" value="'.$Price.'"><br>';

            echo '<p>Udlaant?</p><select name="Lend">';
            echo '<option value="Yes">Yes</option>';
            echo '<option value="No" selected="selected">No</option>';
            echo '</select><br>';

            echo '<p>Udlaant til: </p><input type="text" name="Loaner" value="'.$Loaner.'"><br />';

            echo '<input type="hidden" name="ID" value="'.$ID.'"><br>';
            echo '<input type="submit" name="submit" value="Opdater"><br />';

            $this->updateGame($_POST['ID'],$_POST['Title'],$_POST['PlatformCheck'],$_POST['Genre'],$_POST['Developer'],$_POST['Price'], $_POST['Lend'], $_POST['Loaner']);

        }else {
            echo 'You need to login to be able to update a game in the database.';
        }
    }

    public function showSearch() {
        parent::showSearch();
        $this->showTable($_POST['Search'],$_POST['Type']);
    }

    public function showRestore(){
        parent::showRestore();
        $this->restore($_POST['restore']);
    }

    private function updateGame($ID,$title,$platform_check,$genre,$developer,$price,$lend = '',$loaner = '') {
        @$platformdata = implode(",",$platform_check);

        $update_query_title = $this->db->prepare("UPDATE Game SET Title = :title WHERE ID = :id");
        $update_query_title->bindParam(':title',$title,PDO::PARAM_STR);
        $update_query_title->bindParam(':id',$ID,PDO::PARAM_INT);
        try{
            $update_query_title->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_platform = $this->db->prepare("UPDATE Game SET Platform = :platform WHERE ID = :id");
        $update_query_platform->bindParam(':platform',$platformdata,PDO::PARAM_STR);
        $update_query_platform->bindParam(':id',$ID,PDO::PARAM_INT);
        try{
            $update_query_platform->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_genre = $this->db->prepare("UPDATE Game SET Genre = :genre WHERE ID = :id");
        $update_query_genre->bindParam(':genre',$genre,PDO::PARAM_STR);
        $update_query_genre->bindParam(':id',$ID);
        try {
            $update_query_genre->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_developer = $this->db->prepare("UPDATE Game SET Developer = :developer WHERE ID = :id");
        $update_query_developer->bindParam(':developer', $developer, PDO::PARAM_STR);
        $update_query_developer->bindParam(':id', $ID,PDO::PARAM_INT);
        try {
            $update_query_developer->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_price = $this->db->prepare("UPDATE Game SET Developer = :price WHERE ID = :id");
        $update_query_price->bindParam(':price',$price, PDO::PARAM_STR);
        $update_query_price->bindParam(':id', $ID, PDO::PARAM_INT);
        try {
            $update_query_price->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_lend = $this->db->prepare("UPDATE Game SET Lend = :lend WHERE ID = :id");
        $update_query_lend->bindParam(':lend', $lend, PDO::PARAM_STR);
        $update_query_lend->bindParam(':id', $ID, PDO::PARAM_INT);
        try {
            $update_query_lend->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $update_query_loaner = $this->db->prepare("UPDATE Game SET Loaner = :loaner WHERE ID = :id");
        $update_query_loaner->bindParam(':loaner', $loaner, PDO::PARAM_STR);
        $update_query_loaner->bindParam(':id',$ID, PDO::PARAM_INT);
        try {
            $update_query_loaner->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        echo 'Game has been updated.';
    }

    private function addGame($title, $platform_check, $genre, $developer, $price) {
        $this->title = $title;
        $this->genre = $genre;
        $this->developer = $developer;
        $this->price = (int)$price;
        @$this->platformdata = implode(",",$platform_check);

        $query_for_game = $this->db->prepare("SELECT * FROM Game WHERE Title LIKE :title");
        $query_for_game->bindParam(':title', $this->title,PDO::PARAM_STR);

        try{
            $query_for_game->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        $titlecheck = '';

        while($row = $query_for_game->fetch(PDO::FETCH_OBJ)) {
            $titlecheck = $row->Title;
        }

        if($titlecheck != $this->title) {
            $insert_statement = $this->db->prepare("INSERT INTO Game (Title, Platform, Genre, Developer, Price, User) VALUES (:title,:platform,:genre,:developer,:price,:user)");
            $insert_statement->bindParam(':title', $this->title,PDO::PARAM_STR);
            $insert_statement->bindParam(':platform',$this->platformdata, PDO::PARAM_STR);
            $insert_statement->bindParam(':genre',$this->genre,PDO::PARAM_STR);
            $insert_statement->bindParam(':developer',$this->developer,PDO::PARAM_STR);
            $insert_statement->bindParam(':price',$this->price,PDO::PARAM_INT);
            $insert_statement->bindParam(':user',$_SESSION['User'],PDO::PARAM_STR);

            try {
                $insert_statement->execute();
            }catch (PDOException $e) {
                $e->getMessage();
            }

            echo 'Spillet er tilføjet databasen.';
        } else {
            echo 'Spillet findes allerede i databasen.';
        }
    }

    public function deleteGame($Title) {
        $delete_query_statement = $this->db->prepare("DELETE FROM Game WHERE Title = :title");
        $delete_query_statement->bindParam(':title',$Title);
        try{
            $delete_query_statement->execute();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        echo 'The game "'.$Title.'" has been deleted.';
    }
}