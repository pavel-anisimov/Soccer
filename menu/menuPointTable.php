<?php
$url = "./" . $url . "?week=" . $week;


echo "<table width=100% align=center border=0 cellpadding=3 cellspacing=1 bordercolor=white>";
echo "<tr><td align=center class='popup' colspan=4><font size=1 color=000050><b>Points</b></font></td></tr>";
echo "<tr><td align=left class='popup'><font size=1 color=000050><b><a href='$url&order=name'>User</a></b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b><a href='$url&order=games&rev=DESC'>Gm</a></b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b><a href='$url&order=points&rev=DESC'>Pts</a></b></font></td></tr>";



//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$user_result = mysql_query("
		SELECT nickname AS name, count(g.mid) AS games, sum(g.points) AS points 
		FROM users AS u INNER JOIN guesses AS g ON u.uid=g.uid 
		GROUP BY name 
		ORDER BY " . $order . " " . $revSort);
while ( list($user_nick, $user_games, $user_points) = mysql_fetch_row($user_result) ) {

	echo "<tr><td align=left class='popup' ><font size=1 color=003000>$user_nick<font></td>";
	echo "<td align=center class='popup'><font size=1 color=003000>$user_games</font></td>";	
	echo "<td align=center class='popup'><font size=1 color=003000>$user_points</font></td></tr>";
}

mysql_close($con);  
//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////



echo "</table>";

?>