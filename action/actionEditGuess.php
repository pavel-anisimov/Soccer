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


$head = new header("Gues again", $styleTag);
$head->getHeader();




$flag = false;

if ( ctype_digit($goalsA) && ctype_digit($goalsB) ){
	$q = $_GET['q'];	
	
	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);
	
	$query_count = "SELECT COUNT(*) FROM guesses";
	$result_count = mysql_query($query_count);
	list($gid) = mysql_fetch_row($result_count);
	$gid++;
	
	if (!ctype_digit($pensB) || !ctype_digit($pensA)) {
		$pensA = "NULL";
		$pensB = "NULL";
	}
	
	$insert_query = "UPDATE guesses SET goalsA=$goalsA, goalsB=$goalsB, pensA=$pensA, pensB=$pensB WHERE uid=$uid AND mid=$mid";
	//echo $insert_query . "<br>";
	$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");

	
	////////////////// HISTORY LOG STARTED //////////////////////////
	$query_teams = "SELECT teamA, teamB FROM matches WHERE mid=$mid";
	$result_teams = mysql_query($query_teams);
	list($teamA, $teamB) = mysql_fetch_row($result_teams);
	
	$time = date("Y-m-d H:i:s");
	if ($pensA != 'NULL' || $pensB != 'NULL')
		$pens = "(" . $pensA . ":" .$pensB . ")";
	$log = "changed the score for match number " . $mid . ", " . $teamA . " - " . $teamB . " " . $goalsA . ":" . $goalsB . " " . $pens;
	$insert_query = "INSERT INTO history VALUES ('$time',  '$uid', '$log')";
	$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
	////////////////// HISTORY LOG ENDED////////////////////////////
	
	
	echo "<script language = 'Javascript'> ";
	echo "setTimeout('window.close()',5250); ";
	echo "if (window.opener && !window.opener.closed) {";
	echo "window.opener.location.reload();";
	echo "}";
	echo "</script> ";
	
	
	echo "<center><div class='transbox'><br><br><font size=2 color=blue>Thank you.</font><br><br></div></center>";	
	mysql_close($con); 
	
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
	
} else {
	
	echo "<center>";
	echo "<table class='box'  width=348><tr><td align=center><font size=2 color=000050>Match # $mid</font></td></tr></table>";

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
	
	$query = "SELECT * FROM users WHERE login = '$user'";
	$result = mysql_query($query);
	list($id, $login, $password, $email, $nickname, $status) = mysql_fetch_row($result);

	$query_match = "SELECT * FROM matches WHERE mid = '$mid'";
	$result_match = mysql_query($query_match);
	list($mid, $day, $timezone, $teamA, $teamB, $competition, $goalsA, $goalsB, $pens, $pensA, $pensB) = mysql_fetch_row($result_match);
	
	$query_count = "SELECT COUNT(*) FROM guesses";
	$result_count = mysql_query($query_count);
	list($guesses_number) = mysql_fetch_row($result_count);

	mysql_close($con);  
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////

	if ($pens == 1) {
		$pen_message1 = "<td class='popup' width=100><font size=2 color=000050>(pens)</font><input type='text' name='pensA' size=2 value='$pA'></td>";
		$pen_message2 = "<td class='popup' width=100><font size=2 color=000050>(pens)</font><input type='text' name='pensB' size=2 value='$pB'></td>";
	} else {
		$pen_message1 = "<td class='popup' width=100><input type='hidden' name='pensA' value='NULL'></td>";
		$pen_message2 = "<td class='popup' width=100><input type='hidden' name='pensB' value='NULL'></td>";
	}	
	
	echo "<form>\n"; 
	echo "<center><table width=350  cellpadding=3 cellspacing=2>";
	echo "<tr><td class='popup' width=160><font size=2 color=000050>$teamA</font></td><td class='popup' width=90><input type='text' name='goalsA' size=2  value='$gA'></td>$pen_message1</tr>";
	echo "<tr><td class='popup' width=160><font size=2 color=000050>$teamB</font></td><td class='popup' width=90><input type='text' name='goalsB' size=2  value='$gB'></td>$pen_message2</tr>";
	echo "</table></center>";
	echo "<input type='hidden' name='mid' value='$mid'>";
	echo "<input type='hidden' name='uid' value='$uid'>";
	echo "<input type='hidden' name='com' value=\"red\">";
	echo "<center><input type=submit value='Submit!'></center>";
	echo "</form>\n";
	
 
//goalsA=&pensA=NULL&goalsB=1&  pensB=NULL&mid=10&uid=1&com=red
}
echo "</body></html>\n";

?>