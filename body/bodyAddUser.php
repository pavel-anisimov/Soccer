<?php


	$regUid = $_GET['regUid'];	//8
	$regLogin = $_GET['regLogin'];	//Pavel
	$regPassword = $_GET['regPassword'];	//russia
	$regEmail = $_GET['regEmail'];		//anisimov%40hotmail.com
	$regNickname = $_GET['regNickname'];	//Krasavcheg
	$regStatus = $_GET['regStatus'];	//user
	$flag = $_GET['flag'];				//flag
	
	

	if ($flag == true ) { 
		
		$con = mysql_connect($db_host, $db_user, $db_pass);
		if (!$con) {
			die('Could not connect: ' . mysql_error());
		} 
		mysql_select_db($db_name);
		
		$query = "UPDATE users SET login='$regLogin', password='$regPassword', email='$regEmail', nickname='$regNickname', status='$regStatus' 
		WHERE uid=$regUid";
		//echo $query . "<br>";
		$result = mysql_query($query) or die ("Unable to record a query. Try later");
		
		mysql_close($con); 
	}


echo "<center><table width=95%  border=0 class=box><tr><td align=center>";
echo "<font size=2 color=000080>Add User</font></tr></tr></table><img src=images/null.png height=6></img></center>";


	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	$result = mysql_query("SELECT * FROM users WHERE status='pend'");
	
	$a = 0;
	
while($requests = mysql_fetch_object($result)){
	//$threatsArray[] = $threats;
	$a++;
	echo "<form method='get' action='scores.php'>";
	echo "<center><table class='weekbox' width=95% cellpadding=3 cellspacing=3>";
	
	echo "<tr><td align=right><font face=verdana size=2 color=000050>User ID:</font></td> \n";
	echo "<td><font size=2 color=000050>" . $requests->uid . "</font>";
	echo "<input type='hidden' id='pass' name='regUid' value='" . $requests->uid . "'>\n";
	echo "<input type='hidden' id='pass' name='uid' value='" . $uid . "'>\n";
	echo "<input type='hidden' id='pass' name='flag' value='true'>\n";
	echo "<input type='hidden' id='pass' name='action' value='addUser'></td></tr>\n";	
			
	echo "<tr><td align=right><font size=2 color=000050>Login:</font></td>"; 
	echo "<td>\n<input type='text' id='pass' name='regLogin' size=10 value='" . $requests->login . "'></td></tr>\n";
	
	echo "<tr><td align=right><font face=verdana size=2 color=000050>Password:</font></td> \n";
	echo "<td><input type='text' id='user' name='regPassword' size=10 value='" . $requests->password . "'></td></tr>\n";
	
	echo "<tr><td align=right><font face=verdana size=2 color=000050>Email:</font></td> \n";
	echo "<td><input type='text' id='user' name='regEmail' size=10 value='" . $requests->email . "'></td></tr>\n";

	echo "<tr><td align=right><font face=verdana size=2 color=000050>Nickname:</font></td> \n";
	echo "<td><input type='text' id='user' name='regNickname' size=10 value='" . $requests->nickname . "'></td></tr>\n";

	echo "<tr><td align=right><font face=verdana size=2 color=000050>Status:</font></td> \n";
	echo "<td><select name='regStatus'><option value='admin'>admin</option><option value='pend'>pending</option<option value='user' selected='selected'>user</option></select></td></tr>\n";
	
	echo "<tr><td colspan=2 align=center><input type=submit value='Aprove!'></form></td></tr></table><img src=images/null.png height=10></img></center>";
	
}
	mysql_close($con); 
?>