<?php
session_start();
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

$mid = $_GET['mid']; 
$uid = $_GET['uid']; 
$user = $_GET['user'];

include '../const/CONST.php';
include '../const/header.php';

$head = new header("View Results", $styleTag);
$head->getHeader();

 
$var = 1;
	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);

	
	$match_query = "
		SELECT teamA, teamB, goalsA, goalsB, pensA, pensB 
		FROM matches 
		WHERE mid=$mid";
	$match_result = mysql_query($match_query);
	list($teamA, $teamB, $goalsA, $goalsB, $pensA, $pensB) = mysql_fetch_row($match_result);
	
if ($goalsA != NULL && $goalsB != NULL)
	$final_score = "$goalsA:$goalsB";
else 
	$final_score = "";

if ($pensA != NULL && $pensB != NULL)
	$final_score = $final_score . " ($pensA:$pensB pens.)";
	
	
echo "<center>";
echo "<table class='box'  width=346><tr><td align=center><font size=2 color=000080>$teamA - $teamB</font> <font size=2 color=maroon>$final_score</font></td></tr></table>";	
echo "</center>";		
	
	$query = "
		SELECT g.goalsA, g.goalsB, g.pensA, g.pensB, g.points, u.nickname 
		FROM guesses AS g, users AS u, matches AS m 
		WHERE g.mid=$mid AND g.mid=m.mid and g.uid=u.uid;
	";
	$result = mysql_query($query);
	
echo "<img src=../images/null.png height=5><center><table width=350 cellpadding=3 cellspacing=2><tr>";
echo "<td align=left class='popup' width=159><font size=2 color=000060><b>User:</b></font></td>";
echo "<td align=center class='popup' width=120><font size=2 color=000060><b>Score:</b></font></td>";
echo "<td align=center class='popup' width=75><font size=2 color=000060><b>Points:</b></font></td></tr>";


while (list($goalsA, $goalsB, $pensA, $pensB, $points, $nickname) = mysql_fetch_row($result)) {
	if ($pensA != NULL || $pensB != NULL)
		$pens_score = "($pensA:$pensB pens.)";
	else
		$pens_score = "";

	
	echo "<tr><td class='popup' align=left><font size=2>$nickname</font></td>";
	echo "<td class='popup' align=center><font size=2>$goalsA:$goalsB $pens_score</font></td>";
	echo "<td class='popup' align=center><font size=2>$points</font></td></tr>";
}	
echo "</table></center>";
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
	 

 
		
mysql_close($con);  
echo "</body></html>\n";


?>
 
