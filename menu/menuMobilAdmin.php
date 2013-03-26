<?php
include './const/CONST.php';

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
	} 
mysql_select_db($db_name);

$result = mysql_query("SELECT COUNT(*) FROM users WHERE status='pend'");
list($num) = mysql_fetch_row($result);
mysql_close($con); 
	

$URL5 = "./action/actionAddMatches.php";
	
echo "<table width=100% cellpadding=1 cellspacing=1><tr>";
 
echo "<td class='popup' align=center><font size=2 color=000050><a href = \"javascript:openWin3('$URL5');\">Add " . $matchesPerWeek . " Matches</a></font></td>"; 
echo "<td class='popup' align=center><font size=2 color=000050><a href=mobile.php?action=log&uid=$uid>Log</a></font></td>"; 
echo "<td class='popup' align=center><font size=2 color=000050><a href=mobile.php?action=history&uid=$uid>History</a></font></td>"; 
echo "<td class='popup' align=center><font size=2 color=000050><a href=mobile.php?action=addUser&uid=$uid>Add User</a> <font color=red><b>($num)</b></font></td>"; 
echo "<td class='popup' align=center><font size=2 color=000050><a href=mobile.php?action=editUser&uid=$uid>Edit User</a></font></td>";

echo "</tr></table>";
?>