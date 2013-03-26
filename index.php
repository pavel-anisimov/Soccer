<?php
session_start();    
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

include './CONST.php';
include './classes/classRegister.php';




$regObj = new register($_GET['regUser'], $_GET['regPass1'], $_GET['regPass2'], $_GET['regEmail'], $_GET['regNickname'], $_GET['flag']);
	
$id = $_GET['id'];

if ($id == "error") {
	$errorMessage = "Your user name and password don't match our records.";
} elseif ($id == "okay") {
	$errorMessage = "Thank You for regestring. You'll be aproved shortelly.";
} elseif ($id == "timeout") {
	$errorMessage = "You've been logged out automatically.";
} elseif ($id == "reg") {
	$regFlag = true;
} else {
	$errorMessage = "<br>";
}


$head = new header("Fantasy Sports", $styleTag);
$head->getHeader();

echo "<center><img src=images/top.png class='top'></img>";

if ($regObj->okay == true) {

	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	$result = mysql_query("SELECT COUNT(*) FROM users");
	list($un) = mysql_fetch_row($result);
	$un++;
	
	$query = "INSERT INTO users VALUES (" . $un . ", '" . $regObj->regUser . "', '" . $regObj->regPass1 . "', '" . $regObj->regEmail . "', '" . $regObj->regNickname . "', 'pend')";
	echo $query . "<br>";
	$result = mysql_query($query) or die ("Unable to record a query. Try later");
	
	mysql_close($con); 	
	
	echo "<script language='Javascript'>";
	echo "window.location = 'index.php?id=okay';";
	echo "</script>";
	
} else {
	$regFlag = $regObj->regFlag;
}

$wap = htmlentities($_REQUEST['wap']);
$user = htmlentities($_REQUEST['user']);
$pass = htmlentities($_REQUEST['pass']);
	
if (strlen($user) > 0 && strlen($pass) > 0) {

	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	$query = "SELECT * FROM users WHERE login = '$user'";
	$result = mysql_query($query);
	list($uid, $login, $password, $email, $nickname, $status) = mysql_fetch_row($result);
 
	$result = mysql_query("select count(*) from log");
	list ($lid) = mysql_fetch_row($result);
	$lid++;
 
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$hostaddress = gethostbyaddr($ip);
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$referred = $_SERVER['HTTP_REFERER']; 
	
	
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
		
	if ($login == $user && $password == $pass) {
		//create cookies
		session_start();
		$_SESSION['pass'] = $pass;
		$_SESSION['user'] = $user;
		
		$insert_query = "INSERT INTO log VALUES (" 
				. $lid . ", " 
				. $uid . ", '" 
				. date("Y-m-d H:i") . "', '" 
				. $ip . "' , '" 
				. $hostaddress . "' , '"  
				. $browser . "')";

		//echo $insert_query . ";<br>";
		$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");

		echo "<script language='Javascript'>";
		if ($wap == true)
			echo "window.location = 'mobile.php?action=matches&uid=$uid';";
		else
			echo "window.location = 'scores.php?action=matches&uid=$uid';";
		echo "</script>";
						
	} else {
		//refresh the page if user do not match password
		echo "<script language='Javascript'>";
		echo "window.location = 'index.php?id=error';";
		echo "</script>";
	}
} 
//mysql_close($con); 		


// Pavel   | russia   | anisimov@hotmail.com | Pavel    | admin  
if ($regFlag == true) {
	echo "<form method='get' action='index.php?id=reg'>";
	echo "<br><br><br><center>";
	echo "<table width=400 border=0 cellpadding=0 cellspacing=0 class='login'>";
	echo "<tr><td align=middle><font size=2 color=maroon><br>" . $regObj->errorMessage . "<br><br>";
		
	echo "<table border=0>";
	
	echo "<tr><td align=right><font face=verdana size=2 color=000050>Login:</td> \n";
	echo "<td><input type='text' id='user' name='regUser' size=10 value='" . $regObj->regUser . "'></td></tr>\n";
	
	echo "<tr><td align=right><font size=2 color=000050>Password:</td>"; 
	echo "<td>\n<input type='password' id='pass' name='regPass1' size=10 value='" . $regObj->regPass1 . "'></td></tr>\n";

	echo "<tr><td align=right><font size=2 color=000050>Password (repeat):</td>"; 
	echo "<td>\n<input type='password' id='pass' name='regPass2' size=10 value='" . $regObj->regPass2 . "'></td></tr>\n";
	
	echo "<tr><td align=right><font face=verdana size=2 color=000050>Email:</td> \n";
	echo "<td><input type='text' id='user' name='regEmail' size=10 value='" . $regObj->regEmail . "'></td></tr>\n";

	echo "<tr><td align=right><font face=verdana size=2 color=000050>Nickname:</td> \n";
	echo "<td><input type='text' id='user' name='regNickname' size=10 value='" . $regObj->regNickname . "'></td></tr>\n";
		
	echo "<tr><td></td><td><input type=submit value='Push!'></td></tr></table>";
	echo "<input type='hidden' name='flag' value='true'></form>\n<br>\n";
	echo "<div width=100 align=right class='copyright'><font size=0 color=000080>Pavel Anisimov &copy 2010</font></div>";
		
} else {
	echo "<br><br><br><center>";
	echo "<table width=320 border=0 cellpadding=0 cellspacing=0 class='login'><tr><td align=middle><font size=2 color=maroon><br>" . $errorMessage . "<br><br>";
	echo "<form method='post' action='index.php'>";
	echo "<table border=0><tr><td align=right>";
	echo "<font face=verdana size=2 color=000050>Name:</td> \n";
	echo "<td><input type='text' id='user' name='user' size=10></td></tr>\n";
	echo "<tr><td align=right><font size=2 color=000050>Password:</td>"; 
	echo "<td>\n<input type='password' id='pass' name='pass' size=10></td></tr>\n";
	echo "<tr><td align=right><font size=2 color=000050>Mobile:</td>"; 
	echo "<td><input type='checkbox' id='wap' name='wap'></td></tr>\n";
	echo "<tr><td></td><td><input type=submit value='Push!'></td></tr></table>";
	echo "<font size=2 color=maroon><a href='index.php?id=reg&flag=true'>:: Registration ::</a></font></form>\n<br><br>\n";
	echo "<div width=100 align=right class='copyright'><font size=0 color=000080>Pavel Anisimov &copy 2010</font></div>";
}

echo "</font></td></tr></table>\n";
echo "</body></html>\n";
?>
