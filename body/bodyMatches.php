<?php

include './classes/classMatch.php';


//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$min_query = "SELECT min(day) FROM matches;";
$max_query = "SELECT max(day) FROM matches;";
$count_query = "SELECT count(*) FROM matches";


$count_result = mysql_query($count_query);
list($numberOfMatches) = mysql_fetch_row($count_result);


$count_result = mysql_query($max_query);
list($lastMatchDate) = mysql_fetch_row($count_result);

$lastWeek = date('W', strtotime($lastMatchDate)); 

$numberOfSeries = $lastWeek - $startingWeek - 1;
//$numberOfSeries = 3;


//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////


echo "<center><table class='weekbox' width=95%><tr><td align=center><font size=2 color=003000>";

for ($i = 1; $i <= $numberOfSeries; $i++) {
	
	if ($i == $week)
		echo " [ <b>" . $i . "</b> ] ";
	else
		echo " [ <b><a href=" . $url . "?week=$i class='white'>" . $i . "</a></b> ] ";
}


echo "</font></td></tr></table></center>";

echo "<img src=images/null.png border=0 height=5></img>";	

echo "<center><table class='weekbox' width=95%><tr><td align=center><font size=2 color=003000>";
$wk = (int) $week + $startingWeek;
echo "Week " . $week . ". ";
$startWeekDate = date("Y-m-d", strtotime(date("Y").'W'."$wk"."7") + 24*60*60  );
echo date("M d", strtotime(date("Y").'W'."$wk"."7") + 24*60*60 );
echo " - ";
$wk++;
$endWeekDay = date("Y-m-d", strtotime(date("Y").'W'."$wk"."7") + 24*60*60 );
echo date("M d", strtotime(date("Y").'W'."$wk"."7"));
echo "</font></td></tr></table></center>";


echo "<img src=images/null.png border=0 height=5></img>";	


$match_query = "SELECT * FROM matches WHERE day > '$startWeekDate' AND day <= '$endWeekDay' ORDER by day";



$match_result = mysql_query($match_query);

while (list($mid, $day, $timezone, $teamA, $teamB, $competition, $goalsA, $goalsB, $pens, $pensA, $pensB) = mysql_fetch_row($match_result)) {

	
	$matchView = new classMatch ($mid, $day, $timezone, $competition, $teamA, $teamB, $goalsA, $goalsB, $pensA, $pensB, $uid, $status);
	$matchView->show();
		
}

mysql_close($con);  
?>