<?php
session_start();
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

$user = $_GET['user'];
$mid = $_GET['mid'];
$uid = $_GET['uid'];

$com = $_GET['com'];
$goalsA = $_GET['goalsA'];
$goalsB = $_GET['goalsB'];
$pensA = $_GET['pensA'];
$pensB = $_GET['pensB'];

$pA = $pensA;
$pB = $pensB;
$gA = $goalsA;
$gB = $goalsB;

include '../const/CONST.php';
include '../const/header.php';

$head = new header("Submit Result", $styleTag);
$head->getHeader();

$errorMsg = "";
$errorMsg .= "<center><table class='box'  width=348><tr><td align=left><font size=2 color=000050>";
$errorMsg .= "There is an error. You might fix it by going " ; 
$errorMsg .= " <a href=actionSubmitResult.php??goalsA=$gA&pensA=$pA&goalsB=$gB&pensB=$pB&mid=$mid&uid=$uid>  back</a> "; 
$errorMsg .= " and entering correct data. ";
$errorMsg .= "If this won't work please contact website administrator.</tr></tr></table></center>";


if (ctype_digit($goalsA) && ctype_digit($goalsB) ){
	$q = $_GET['q'];	

	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);
	
	if (!ctype_digit($pensB) || !ctype_digit($pensA)) {
		$pensA = "NULL";
		$pensB = "NULL";
	}
	
	$update_query = "UPDATE matches SET goalsA=$goalsA, goalsB=$goalsB, pensA=$pensA, pensB=$pensB WHERE (mid=$mid)";

	$update_result = mysql_query($update_query) or die ("Unable to record a query. Try later");
		
	$query_check = "SELECT * FROM guesses WHERE mid=$mid";
	$result_check = mysql_query($query_check);
	
	while (list($uid, $mid, $goals1, $goals2, $pens1, $pens2, $points) = mysql_fetch_row($result_check)) {
		
		echo "<table class='box'  width=348><tr><td align=left><font size=2 color=000050> ";
		echo "User ID: $uid <br>Match ID: $mid <br>Goals by first team: $goalsA "; 
		echo "<br>Goals by second team: $goalsB <br>Pens by first team: $pensA <br>Pens by second team: $pensB  ";
			
		if ($goalsA == $goals1 && $goalsB == $goals2)
			$goal_points = 3;
		else if ( ($goalsA-$goalsB) > 0 && ($goals1-$goals2) > 0 ) 
			$goal_points = 1;
		else if ( ($goalsA-$goalsB) == 0 && ($goals1-$goals2) == 0 ) 
			$goal_points = 1;
		else if ( ($goalsA-$goalsB) < 0 && ($goals1-$goals2) < 0 ) 
			$goal_points = 1;
		else 
			$goal_points = 0;	
		
		if ($pensA == $pens1 && $pensB == $pens2)
			$pen_points = 3;
		else if ( ($pensA-$pensB) > 0 && ($pens1-$pens2) > 0 ) 
			$pen_points = 1;
		else if ( ($pensA-$pensB) < 0 && ($pens1-$pens2) < 0 ) 
			$pen_points = 1;
		else
			$pen_points = 0;		

		if ($goal_points == 0)
			$points = 0;
		else 
			$points = $goal_points + $pen_points;
	
		echo "<br>Points by user: $points ";

		$update_points = "UPDATE guesses SET points=$points WHERE uid=$uid AND mid=$mid";
		$update_points = mysql_query($update_points) or die ($errorMsg);
		echo "</font></td></tr></table>";
		echo "<img src=../images/null.png height=10></img>";
		 
	}
	mysql_close($con); 
	
//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////

	echo "<script language = 'Javascript'> ";
	echo "setTimeout('window.close()',25250); ";
	echo "if (window.opener && !window.opener.closed) {";
	echo "window.opener.location.reload();";
	echo "}";
	echo "</script> ";

} else {
	echo "<center>";
	echo "<table class='box'  width=346><tr><td align=center><font size=2 color=000080>Match # $mid</font></td></tr></table>";	
	
	if ($goalsA != "" || $goalsB != "") {
		echo "<img src=../images/null.png height=10></img>";
		echo "<table class='box' width=348><tr><td align=center><font size=2 color=maroon>You need to double check the score and correct it.</font></td></tr></table>";
	}
	echo "</center>";
	echo "<img src=../images/null.png height=15></img>";
	
	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	//$query = "SELECT * FROM users WHERE u_login = '" . $user . "'";
	//$result = mysql_query($query);
	//list($uid, $login, $password, $email, $nickname, $status) = mysql_fetch_row($result);

	$query_match = "SELECT * FROM matches WHERE mid = '$mid'";
	$result_match = mysql_query($query_match);
	list($mid, $day, $timezone, $teamA, $teamB, $competion, $goalsA, $goalsB, $pens, $pensA, $pensB) = mysql_fetch_row($result_match);
	
	
	$query_count = "SELECT COUNT(*) FROM guesses";
	$result_count = mysql_query($query_count);
	list($guesses_number) = mysql_fetch_row($result_count);
 
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////


	if ($pens == 1) {
		$pen_message1 = "<td width=50 class='popup'><input type='text' name='pensA' value='$pA' size=2></td>";
		$pen_message2 = "<td width=50 class='popup'><input type='text' name='pensB' value='$pB'  size=2></td>";
	} else {
		$pen_message1 = "<td width=50 class='popup'><input type='hidden' name='pensA' value='NULL'></td>";
		$pen_message2 = "<td width=50 class='popup'><input type='hidden' name='pensB' value='NULL'></td>";
	}	
	
	echo "<form>\n"; 
	echo "<img src=../images/null.png height=5><center><table width=350 cellpadding=3 cellspacing=2>";
	echo "<tr><td align=left class='popup' width=250><b><font size=2 color=000080>Teams</font></b></td>";
	echo "<td align=center class='popup' width=50><b><font size=2 color=000080>Goals</font></b></td>";
	echo "<td align=center class='popup' width=50><b><font size=2 color=000080>Pens</font></b></td></tr>";
	
	echo "<tr><td align=left class='popup' width=250><font color=005000 size=2>$teamA</font></td>";
	echo "<td align=center class='popup' width=50><input type='text' name='goalsA' size=2 value='$gA'></td>$pen_message1</tr>";
	echo "<tr><td align=left class='popup' width=250><font color=005000 size=2>$teamB</font></td>";
	echo "<td align=center class='popup' width=50><input type='text' name='goalsB' size=2 value='$gB'></td>$pen_message2</tr>";
	echo "</table>";

	echo "<input type='hidden' name='mid' value='$mid'>";
	echo "<input type='hidden' name='uid' value='$uid'>";
	echo "<input type='hidden' name='com' value=\"red\">";
	echo "<input type=submit value='Submit!'>";
	echo "</form>\n";

	mysql_close($con);  

}

echo "</body></html>\n";


?>