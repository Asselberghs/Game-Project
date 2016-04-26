<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php
/*
    This is a media database to mange your Books.
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

echo '<a href="index.php">Forside</a> &#124; <a href="login_display.php">Login</a> &#124; <a href="List_display.php">Bog Oversigt</a> &#124; <a href="search_display.php">S&#248;g i databasen</a>';

if(isset($_SESSION['Logged_In'])){

echo '&#124; <a href="add_display.php">Tilf&#248;j film</a> &#124; <a href="backup_display.php">Tag backup af database</a> &#124; <a href="restore_display.php">Gendan backup af database</a> &#124; <a href="add_user_display.php">Tilf&#248;j Bruger</a> &#124; <a href="Logout_display.php">Logout</a>';

}
?>