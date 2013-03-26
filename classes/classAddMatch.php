<?php
class matches {
	public $teamA;
	public $teamB;
	public $pens;
	public $year;
	public $month;
	public $day;
	public $hour;
	public $minute;
	public $timezone;
	public $competition;
	public $matchDate;
	public $matchDateUET;
	public $isFormComplete;
	
	function __construct ($teamA, $teamB, $competition, $pens, $year, $month, $day, $hour, $minute, $timezone) {
		$this->teamA = $teamA;
		$this->teamB = $teamB;
		$this->pens = $pens;
		$this->year = $year;
		$this->month = $month;
		$this->day = $day;
		$this->hour = $hour;
		$this->minute = $minute;
		$this->timezone = $timezone;
		$this->competition = $competition;
		$this->isComplete();
		$this->MatchDate();
	}
	
	function MatchDate () {
		if ($this->month != NULL && $this->day != NULL) {
			$this->matchDate = $this->year . "-" . $this->month . "-" . $this->day . " " . $this->hour . "-" . $this->minute;  
			$this->matchDateUET = mktime ($this->hour, $this->minute, 0, $this->month, $this->day, $this->year);
		} else 
			$this->matchDate = "";
	}
	
	function isComplete () {
		if ($this->competition == NULL)
			$this->competition = "N/A";
		if ($this->timezone == NULL)
			$this->timezone = "NZST";
			
		if ($this->teamA != NULL && $this->teamB != NULL && $this->day != NULL && $this->month != NULL)
			$this->isFormComplete = true;
		else 
			$this->isFormComplete = false;
	}
}

?>
