<?php
/*
    This is a media database to mange your Game.
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
session_start();
echo '<html>';
echo '<head>';
echo '<Title>Asselberghs.dk';
echo '</Title>';
echo '<link href="style.css" rel="stylesheet" type="text/css">';
echo "<link href='http://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>";
echo '</head>';
echo '<body>';
echo '<div id="Top"><br>';
echo 'Asselberghs.dk';
echo '</div>';
echo '<div id="MainMenu">';
include('mainmenu.php');
echo '</div>';
echo '<div id="Menu">';
include('menu.php');
echo '</div>';
echo '<div id="Content">';
include('restore.php');
echo '</div>';
echo '<div id="Footer">';
include('footer.php');
echo '</div>';
echo '</body>';
echo '</html>';
?>