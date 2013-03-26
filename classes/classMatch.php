<?php

class classMatch {
	public $mid;
	public $time;
	public $timezone;
	public $matchTime;
//	public $timeLeft;
	public $competition;
	public $teamA;
	public $teamB;
	public $goalsA;
	public $goalsB;
	public $pens;
	public $uid;
	public $status;
	
	
	function __construct ($mid, $time, $timezone, $competition, $teamA, $teamB, $goalsA, $goalsB, $pensA, $pensB, $uid, $status){
		$this->mid = $mid;
		$this->time = $time;
		$this->timezone = $timezone;
//		$this->$timeLeft;
		$this->competition = $competition;
		$this->teamA = $teamA;
		$this->teamB = $teamB;
		$this->goalsA = $goalsA;
		$this->goalsB = $goalsB;
		$this->matchTime = strtotime($time . " " . $timezone) - 300;
		$this->uid = $uid;
		$this->status= $status;
		if ($pensA || $pensB)
			$this->pens = "($pensA:$pensB)";
	}
	
	function show () {
		
		$timeNow = time();
		
		echo "<center><table class='box' width=95%><tr><td colspan=2 align=center><font size=2>";
		echo "<font color=blue size=2>Match # $this->mid</font></td></tr>";
		echo "<tr><td><font color=003000 size=2>$this->time $this->timezone</font> ";
	
 		
		if (($this->matchTime-$timeNow) / 604800 > 1 ) {
			$left = round (($this->matchTime-$timeNow) / 604800 ) . " week(s) ";
			$clr = "000080";
		} else if (($this->matchTime-$timeNow) / 86400 % 7 > 0 ) {
			$left = ($this->matchTime-$timeNow) / 86400 % 7 . " day(s) ";
			$clr = "003000";
		} else if (($this->matchTime-$timeNow) / 3600 % 24 > 0) {
			$left = ($this->matchTime-$timeNow) / 3660 % 24 . " hour(s) ";
			$clr = "ff6600";
		} else {
			$left = ($this->matchTime-$timeNow) / 60 % 60 . " minute(s) ";
			$clr = "red";
		}
			
		
		
		echo "<td align=right>";	
		if ($timeNow < $this->matchTime) 	{
			echo "<font color=$clr size=2>(" . $left . " left)</font>";
		}
		echo "</font></td></tr><tr><td colspan=2><font size=2>";
		
		echo "<font color=blue>$this->competition</font><br> ";	
		
		echo "<font color=000040>$this->teamA - $this->teamB ";
		if ( $this->goalsA == NULL || $this->goalsB == NULL )
			echo "?:?";
		else  
			echo "$this->goalsA:$this->goalsB ";
		echo $pens_score . "</font><br>";
		
		$URL1 = "./action/actionAddGuess.php?mid=$this->mid&uid=$this->uid";
		$URL2 = "./action/actionViewResuls.php?mid=$this->mid&uid=$this->uid";
		$URL3 = "./action/actionSubmitResult.php?mid=$this->mid";
		$URL4 = "./action/actionEditGuess.php?mid=$this->mid&uid=$this->uid";
		
	
		if ($timeNow < $this->matchTime) {
			$change_result = mysql_query("SELECT * FROM guesses WHERE uid=$this->uid and mid=$this->mid");
			list($guid, $mid, $goalz1, $goalz2, $pensA, $pensB, $points) = mysql_fetch_row($change_result);
			
			if ($goalz1 || $goalz2)
				$guess_link = "<a href = \"javascript:openWin1('$URL4');\">Change</a>";
			else
				$guess_link = "<a href = \"javascript:openWin1('$URL1');\">Guess</a>";
		} else { 
			$guess_link = "<a><font color=303030><strike>Guess</strike></font></a> ";
		}

				
		if (($this->goalsA == NULL || $this->goalsB == NULL) && $timeNow > $this->matchTime )
			$real_score_link = "<a href = \"javascript:openWin2('$URL3');\">Real Score</a>  "; 
		else 
			$real_score_link = "<a><font color=303030><strike>Real Score</strike></font></a> ";
	
		echo "[ $guess_link | ";	
		echo "<a href = \"javascript:openWin2('$URL2');\">Results</a> ";
		if ($this->status == "admin")
			echo "| $real_score_link "; 
		echo "]";
	
		echo "</font></td></tr></table></center>";
		echo "<img src=images/null.png border=0 height=5></img>";	
	} 
}

?>