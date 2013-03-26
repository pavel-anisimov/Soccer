<?php
session_start();
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

$user = $_GET['user'];
$match_id = $_GET['m_id'];
$user_id = $_GET['u_id'];

$com = $_GET['com'];
$goal_guess1 = $_GET['goal_guess1'];
$goal_guess2 = $_GET['goal_guess2'];
$pen_guess1 = $_GET['pen_guess1'];
$pen_guess2 = $_GET['pen_guess2'];

include './const/CONST.php';
include './const/header.php';

$head = new header("Remove User", $styleTag);
$head->getHeader();


if ($com == "red"){
	$q = $_GET['q'];	
	echo "<script language='Javascript'>";
	echo "window.location = 'thanx.php?user_id=$user_id&match_id=$match_id&goal_guess1=$goal_guess1&goal_guess2=$goal_guess2&pen_guess1=$pen_guess1&pen_guess2=$pen_guess2';";
	echo "</script>";	
}


/*u_id
match_id
goals_1
goals_2
pens_1
pens_2*/


	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	$query = "SELECT * FROM users WHERE u_login = '$user'";
	$result = mysql_query($query);
	list($u_id, $u_name, $u_password, $u_email, $u_nickname, $u_status) = mysql_fetch_row($result);

	$query_match = "SELECT * FROM matches WHERE m_id = '$match_id'";
	$result_match = mysql_query($query_match);
	list($match_id, $match_date, $match_team1, $match_team2, $match_goals1, $match_goals2, $match_penalty, $match_pens1, $match_pens2) = mysql_fetch_row($result_match);
	
	
	$query_count = "select count(*) from guesses";
	$result_count = mysql_query($query_count);
	list($guesses_number) = mysql_fetch_row($result_count);
 
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////




if ($match_penalty == 1) {
	$pen_message1 = "<td class='popup' width=100><font size=2 color=000050>(pens)</font><input type='text' name='pen_guess1' size=2></td>";
	$pen_message2 = "<td class='popup' width=100><font size=2 color=000050>(pens)</font><input type='text' name='pen_guess2' size=2></td>";
} else {
	$pen_message1 = "<td class='popup' width=100><input type='hidden' name='pen_guess1' value='NULL'></td>";
	$pen_message2 = "<td class='popup' width=100><input type='hidden' name='pen_guess2' value='NULL'></td>";
}	
	
	
echo "<form>\n"; 


echo "<center><div class='popup'><font size=2 color=000050>Match # $match_id</font></div><img src=images/null.png height=5></img></center>";


echo "<center><table width=350  cellpadding=3 cellspacing=2>";


echo "<tr><td class='popup' width=160><font size=2 color=000050>$match_team1</font></td><td class='popup' width=90><input type='text' name='goal_guess1' size=2></td>$pen_message1</tr>";

echo "<tr><td class='popup' width=160><font size=2 color=000050>$match_team2</font></td><td class='popup' width=90><input type='text' name='goal_guess2' size=2></td>$pen_message2</tr>";
echo "</table></center>";


echo "<input type='hidden' name='m_id' value='$match_id'>";
echo "<input type='hidden' name='u_id' value='$user_id'>";
echo "<input type='hidden' name='com' value=\"red\">";
echo "<center><input type=submit value='Submit!'></center>";
echo "</form>\n";


mysql_close($con);  
echo "</body></html>\n";

?>