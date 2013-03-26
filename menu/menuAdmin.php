

<?php

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
	} 
mysql_select_db($db_name);

$result = mysql_query("SELECT COUNT(*) FROM users WHERE status='pend'");
list($num) = mysql_fetch_row($result);
mysql_close($con); 
	

$URL5 = "action/actionAddMatches.php?uid=$uid";
	
echo "<br> "; 
echo "Administrator: <br> "; 
 
echo "<a href=scores.php><a href = \"javascript:openWin3('$URL5');\">Add " . $matchesPerWeek . " Matches</a>  <br> "; 
echo "<a href=scores.php?action=log&uid=$uid>Log</a>  <br> "; 
echo "<a href=scores.php?action=history&uid=$uid>History</a>  <br> "; 
echo "<a href=scores.php?action=addUser&uid=$uid>Add User</a> <font color=red><b>($num)</b></font> <br> "; 
echo "<a href=scores.php?action=editUser&uid=$uid>Edit User</a>  <br> ";
?>