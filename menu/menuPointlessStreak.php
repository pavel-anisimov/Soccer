<?php

echo "<table width=100% align=center border=0 cellpadding=3 cellspacing=1 bordercolor=white>";
echo "<tr><td align=center class='popup' colspan=4><font size=1 color=000050><b>Pointless Streak</b></font></td></tr>";
echo "<tr><td align=left class='popup'><font size=1 color=000050><b>User</b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b>Gms</b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b>From</b></font></td>";
echo "<td align=center class='popup'><font size=1 color=000050><b>To</b></font></td></tr>";


include './const/CONST.php';

class pointlessClass {
	public $userID;
	public $user;
	public $streak;
	public $startingMatch;
	public $endingMatch;
	
	function __construct($userID, $user, $steak, $start, $end) {
		$this->userID = $userID;
		$this->user = $user;
		$this->streak = $streak;
		$this->start = $start;
		$this->end = $end;
	}
	
	function out(){
		$msg = "User number " . $this->user . " had " . $this->streak . " points streak from game " . $this->start . " to game " . $this->end . ". ";
		return $msg;
	}
}

$pointlessStreak = new pointlessClass(0, "", 0, 0, 0);

$guessesArray = array();

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$query = "select count(*) from users";
$result = mysql_query($query);
list($usersNumber) = mysql_fetch_row($result);


$start = 0;
$end = 0;
$streak = 0;
$next = 0;


for ($i = 1; $i <= $usersNumber; $i++) {
	$guessesArray = array();
	
	$query = "SELECT u.nickname AS user, g.uid AS userID, g.mid AS matchID, g.points AS points 
	FROM guesses AS g, users AS u 
	WHERE u.uid=g.uid AND g.points=0 AND g.uid=" . $i . " ORDER BY g.mid";
	$result = mysql_query($query);
	
    while($guesses = mysql_fetch_object($result)){
        $guessesArray[] = $guesses;
        //echo $guesses->userID . " " . $guesses->matchID . " " . $guesses->points . "<br>";
    }

    
    $start = $guessesArray[0]->matchID;   

    $next = $start;
    
    for ($j = 0; $j < sizeof($guessesArray); $j++) {
    	
    	$next++;

    	if ($next == $guessesArray[$j]->matchID) {
    		$streak++;
    	} else {
    		
    		if ($streak > $pointlessStreak->streak) {
    			
    			$pointlessStreak->streak = $streak;
    			$pointlessStreak->user = $guessesArray[$j]->user;
    			$pointlessStreak->userID = $guessesArray[$j]->userID;
    			$pointlessStreak->start = $start;
    			$pointlessStreak->end = $start + $streak - 1;
    			   			
    		}
    		$streak = 1;
    		$start = $guessesArray[$j]->matchID;   
    		$next = $start;
    			
    	}
    	
    }
    
    if ($pointlessStreak->streak > 0) {
    	echo "<tr><td align=left class='popup' ><font size=1 color=003000>" . $pointlessStreak->user . "</font></td>";
    	echo "<td align=center class='popup' ><font size=1 color=003000>" . $pointlessStreak->streak . "</font></td>";
    	echo "<td align=center class='popup' ><font size=1 color=003000>" . $pointlessStreak->start . "</font></td>";
    	echo "<td align=center class='popup' ><font size=1 color=003000>" . $pointlessStreak->end . "</font></td></tr>";
    }
    
	//echo "Started at $start <br>"; 
	//echo $pointStreak->user . " had " . $pointStreak->streak;
	//echo " points streak from game " . $pointStreak->start . " to game " . $pointStreak->end . ". <br><br>"; 

	$pointlessStreak = new pointClass(0, "", 0, 0, 0);
	
}

//echo "<font color=000080 size=2 face=verdana>";
//echo "<b>" . $pointlessStreak->user . "</b> has the longest point streak, (<b>" . $pointlessStreak->streak;
//echo "</b> games) from game <b>" . $pointlessStreak->start . "</b> to game <b>" . $pointlessStreak->end . "</b>. "; 

echo "</table>";

?>