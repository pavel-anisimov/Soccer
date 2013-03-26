<?php
include './const/CONST.php';

echo "<table width=100% align=center border=0 cellpadding=3 cellspacing=1 bordercolor=white>";
echo "<tr><td align=center class='popup' colspan=4><font size=1 color=000050><b>Most Points in One Week</b></font></td></tr>";
echo "<tr><td align=left class='popup'><font size=1 color=000050><b>User</b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b>Week</b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b>Pts</b></font></td></tr>";


class pointWeekClass {
	public $userID;
	public $user;
	public $points;
	public $week;

	function __construct($userID, $user, $points, $week) {
		$this->userID = $userID;
		$this->user = $user;
		$this->points = $points;
		$this->week = $week;
	}
}

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$query = "select count(*) from users";
$result = mysql_query($query);
list($usersNumber) = mysql_fetch_row($result);

$query = "select count(*) from matches";
$result = mysql_query($query);
list($matchesNumber) = mysql_fetch_row($result);

$numberOfWeeks =  $matchesNumber / $matchesPerWeek;

for ($i = 1; $i <= $usersNumber; $i++) {
	$weekPoints = new pointWeekClass(0, "", 0, 0);
		
    for ($j = 0; $j < $numberOfWeeks; $j++) {
    	
  		$a = $j * $matchesPerWeek + 1; 
		$z = ($j + 1) * $matchesPerWeek;

		$query = "SELECT u.nickname AS user, g.uid AS userID, sum(g.points) AS points 
				FROM guesses AS g, users AS u 
				WHERE u.uid = g.uid AND g.uid = " . $i . " AND g.mid >= " . $a . " AND g.mid <= " . $z . " 
				ORDER BY user DESC" ;
					
		$result = mysql_query($query);
   		$sumObj = mysql_fetch_object($result);
    			
   		if ($sumObj->points > $weekPoints->points) {
   			$weekPoints->points = $sumObj->points;
   			$weekPoints->user = $sumObj->user;
   			$weekPoints->userID = $sumObj->userID;
   			$weekPoints->week = $j + 1;
		}
    } 

    if ($weekPoints->points > 0) {
	    echo "<tr><td align=left class='popup' ><font size=1 color=003000>" . $weekPoints->user . "</font></td>";
	    echo "<td align=center class='popup' ><font size=1 color=003000>" . $weekPoints->week . "</font></td>";
	    echo "<td align=center class='popup' ><font size=1 color=003000>" . $weekPoints->points . "</font></td></tr>";
    }
}

echo "</table>";

?>