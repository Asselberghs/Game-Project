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
$MainMenu= include('mainmenu.php');
$MainNav=str_replace('1', '', $MainMenu);
echo ''.$MainNav;
echo '</div>';
echo '<div id="Menu">';
$Menu=include('menu.php');
$Nav=str_replace('1', '', $Menu);
echo ''.$Nav;
echo '</div>';

echo '<div id="Content">';
$Content=include('rejected.php');
$Content=str_replace('1', '', $Content);
echo ''.$Content; 
echo '</div>';
echo '<div id="Footer">';
$Footer=include('footer.php');
$Foot=str_replace('1','',$Footer);
echo ''.$Foot;
echo '</div>';

echo '</body>';
echo '</html>';
?>