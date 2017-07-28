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
require('Classes/GameDatabase.php');
$database = new GameDatabase('IP_Address','Username','Password','Database_Name');
?>
<html>
<head>
<Title>Asselberghs.dk
</Title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>
<meta charset="UTF-8">
</head>
<body>
<div id="Top"><br>
Asselberghs.dk
</div>
<div id="MainMenu">
    <?php
    $MainMenu= include('mainmenu.php');
    $MainNav=str_replace('1', '', $MainMenu);
    echo ''.$MainNav;
    ?>
</div>
<div id="Menu">
    <?php
    $Menu=include('menu.php');
    $Nav=str_replace('1', '', $Menu);
    echo ''.$Nav;
    ?>
</div>
<div id="Content">
    <?php
    $database->logout();
    ?>
</div>
<div id="Footer">
    <?php
    $Footer=include('footer.php');
    $Foot=str_replace('1','',$Footer);
    echo ''.$Foot;
    ?>
</div>
</body>
</html>
