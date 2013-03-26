<?php

echo "<center><table width=95% border=0 class=box><tr><td align=center>";
echo "<font size=2 color=maroon>LOG</font></tr></tr></table><img src=images/null.png height=6></img></center>";

$threatsArray = array();

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);
$query = "SELECT l.lid, u.nickname, l.day, l.ip, l.hostaddress, l.browser 
	FROM log AS l, users AS u 
	WHERE l.uid=u.uid 
	ORDER BY l.lid DESC LIMIT 0, 20";
 

$result = mysql_query($query);
mb_internal_encoding('UTF-8');

while($threats = mysql_fetch_object($result)){
	//$threatsArray[] = $threats;
	
	echo "<center><table width=95%  border=0 cellpadding=1 cellspacing=1 >";
	echo "<tr><td align=center rowspan=2 class='popup'><font size=2 color=000050>" . $threats->lid . "</font></td>";
	echo "<td align=center class='popup'><font size=2 color=000050>" . $threats->nickname . "</font></td>";
	echo "<td align=center class='popup'><font size=2 color=000050>" . $threats->day . "</font></td>";
	echo "<td align=center class='popup'><font size=2 color=000050>" . $threats->ip . "</font></td></tr>";
	echo "<tr><td colspan=3 align=center class='popup'><font size=2 color=000050>" . $threats->hostaddress . "</font></td></tr>";
	echo "</table><img src=images/null.png height=3></img></center>";
}
mysql_close($con);  

?>