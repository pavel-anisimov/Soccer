<?php

echo "<center><table width=95% border=0 class=box><tr><td align=center>";
echo "<font size=2 color=maroon>LOG</font></tr></tr></table><img src=images/null.png height=6></img></center>";

$threatsArray = array();

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);
$query = "SELECT h.time, u.nickname, h.log 
	FROM history AS h, users AS u 
	WHERE h.uid=u.uid 
	ORDER BY h.time DESC LIMIT 0, 20";
 

$result = mysql_query($query);
mb_internal_encoding('UTF-8');

echo "<center><table width=95%  border=0 cellpadding=5 cellspacing=1 ><tr><td rowspan=2 class='popup'>";

while($threats = mysql_fetch_object($result)){
	
	echo "<font size=2 color=000050>" . $threats->time . "<br>";
	echo $threats->nickname . " " . $threats->log . "</font>";
	echo "<hr width=85% noshade bgcolor=black align=center>";
}

echo "</table><img src=images/null.png height=3></img></center>";


mysql_close($con);  

?>