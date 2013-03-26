<?php 
echo "<table width=160 height=100% class='box'><tr><td><font size=2 color=000050>";

echo "<center><font size=2 color=maroon>Message Bord</font></center>";

$threatsArray = array();

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);
$query = "SELECT b.mid, u.nickname, b.topic, b.body, b.day FROM board AS b, users AS u WHERE b.uid=u.uid ORDER BY b.mid DESC LIMIT 0, 5";
 

$result = mysql_query($query);
mb_internal_encoding('UTF-8');

while($threats = mysql_fetch_object($result)){
	//$threatsArray[] = $threats;
	
	echo "<hr noshade align=center width=140 color=maroon>";
	echo "<font size=1 color=000080><b>" . mb_strcut($threats->topic, 0, 20) . "...</b></font><br>";
	echo "<font size=1 color=005000>" . mb_strcut($threats->body, 0, 40) . " ...</font>";
	echo "<div align=right><font color=000080 size=1>by " . $threats->nickname . "</font></div>";

}
mysql_close($con);  


echo "</font></td></tr></table>";
?>
