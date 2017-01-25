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
?>
<?php
include('Connect.php');
session_start();
$session = $_SESSION['Logged_In'];
$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

if($session != true) {

    echo '<META http-equiv="refresh" content="0;URL=http://'.$baseurl.'/rejected_display.php">';

}
?>