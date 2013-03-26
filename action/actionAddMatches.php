<?php
session_start();    
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

$uid = $_GET['uid'];

include '../const/CONST.php';
include '../const/header.php';
include '../classes/classAddMatch.php';


 

$curentWeek = (int)$_GET['week'] + $startingWeek;

$flag = true;
$dateError = false;
$weekError = false;
$pens = 0;
$errorMessage = "";

$match = array();

for ($i = 1; $i <= $matchesPerWeek ; $i++) {
	$match[$i] = new matches ($_GET['teamA'.$i], $_GET['teamB'.$i], $_GET['competition'.$i], $_GET['pens'.$i], (int)$_GET['year'.$i], (int)$_GET['month'.$i], (int)$_GET['day'.$i], (int)$_GET['hour'.$i], (int)$_GET['minute'.$i], $_GET['timezone'.$i]);

	if ($match[$i]->month == "")
		$match[$i]->month = (int)date("m") ; 
	if ($match[$i]->year == "")
		$match[$i]->year = (int)date("Y") ; 
	if ($match[$i]->day == "")
		$match[$i]->day = (int)date("d") ; 
	$match[$i]->MatchDate();		
		
	if ($match[$i]->isFormComplete == false)
		$flag = false;

	if (strtotime("now") > $match[$i]->matchDateUET) {
		$dateError = true;
	} 
	
	if ( (int) date("W", mktime($match[$i]->hour, $match[$i]->minute, 0, $match[$i]->month, $match[$i]->day, $match[$i]->year)) != $curentWeek) {
		//$weekError = true;
	} 
}



//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$query = "select count(*) from matches";
$result = mysql_query($query);
list($m_id) = mysql_fetch_row($result);

//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////

 
if ($weekError == true) 
	$errorMessage = $errorMessage . " Match Date doesn't fall in within this week scope. ";		

if ($dateError == true) 
	$errorMessage = $errorMessage . " Match Date cannot be in the past. ";

if ($flag == true && $dateError == false && $weekError == false) {
	
	for ($i = 1; $i <= $matchesPerWeek; $i++) { 
		if ($match[$i]->pens == true)
			$pen = 1;
		else 
			$pen = 0;
		 
		$mNumber = $m_id+$i;	
		$insert_query = "INSERT INTO matches VALUES (" 
				. ($m_id+$i) . ", '" 
				. $match[$i]->matchDate . "', '" 
				. $match[$i]->timezone . "', '" 
				. $match[$i]->teamA . "' , '" 
				. $match[$i]->teamB . "' , '" 				
				. $match[$i]->competition . "' , NULL, NULL, " 
				. $pen . ", NULL, NULL)";

		//echo $insert_query . "<br>";
		$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
		
		////////////////// HISTORY LOG STARTED //////////////////////////
		$time = date("Y-m-d H:i:s");
		$log = "added match number " . $mNumber . ", " . $match[$i]->teamA . " - " . $match[$i]->teamB . " to be played on " . $match[$i]->matchDate . " " . $match[$i]->timezone;
		$insert_history = "INSERT INTO history VALUES ('$time',  '$uid', '$log')";
		$insert_result = mysql_query($insert_history) or die ("Unable to record a query. Try later");
		////////////////// HISTORY LOG ENDED////////////////////////////
			
		
	}
	mysql_close($con);  
	
	echo "<script language = 'Javascript'> ";
	echo "window.close(); ";
	echo "if (window.opener && !window.opener.closed) {";
	echo "window.opener.location.reload();";
	echo "}";
	echo "</script> ";

} else {
	$errorMessage = $errorMessage . " You must fill out the form completelly. ";
}

$head = new header("Add Matches", $styleTag);
$head->getHeader();


echo "<center><table width=100% class='box' border=0><tr><td align=center>";
echo "<font color=maroon size=2 face=verdana> Week # " . ( $m_id / $matchesPerWeek + 1 ). " </font>";
echo "</td></tr></table></center>";

echo "<center><img src='../images/null.png' height=5></img></center>";

echo "<center><table width=100% class='box' border=0><tr><td align=center>";
echo "<font color=maroon size=2 face=verdana>" . $errorMessage . " </font>";
echo "</td></tr></table></center>";

echo "<center><img src='../images/null.png' height=5></img></center>";




/////////////////////////////////// FORM STARTS /////////////////////////////////////////////
echo "<form method='get' action='actionAddMatches.php'>";

echo "<center><table border=0 align=center class='box' width=100%>\n";

echo "<tr><td><font size=2 face=verdana color=000080>#.</font></td>";
echo "<td align=left><font size=2 face=verdana color=000080>Home Team</font></td>";
echo "<td align=left><font size=2 face=verdana color=000080>Visitor Team</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Competition</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Pens</td>";
echo "<td align=center><font size=2 face=verdana color=000080>Year</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Month</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Day</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Hour</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>Minutes</font></td>";
echo "<td align=center><font size=2 face=verdana color=000080>TZ</font></td>";
echo "</tr>";

for ($i = 1; $i <= $matchesPerWeek ; $i++) {
	echo "<tr><td><font size=2 face=verdana color=000080>" . ($m_id + $i) . "</font></td>";
	echo "<td><input type='text' id='teamA$i' name='teamA$i' size=10 value='" . $match[$i]->teamA . "'></td>";
	echo "<td><input type='text' id='teamB$i' name='teamB$i' size=10 value='" . $match[$i]->teamB . "'></td>";
	echo "<td><input type='text' id='competitio$i' name='competition$i' size=10 value='" . $match[$i]->competition . "'></td>";
	
	if ($match[$i]->pens == true) 
		echo "<td align=center><input type='checkbox' name='pens$i' checked></td>";
	else 
		echo "<td align=center><input type='checkbox' name='pens$i'></td>";
	

	echo "<td>\n";
	echo "<select name=\"year$i\">\n";
	echo "<option value=''></option>	\n";
	
	for ($j = (int)date("Y"); $j < (int)date("Y") + 2; $j++) {
		if ( $match[$i]->year == $j )
			echo "<option value='$j' selected='selected'>$j</option>\n";
		else 	
			echo "<option value='$j'>$j</option>\n";
	}
	echo "</select>\n";
	echo " / </td>";	
	
	echo "<td>\n";
	echo "<select name=\"month$i\">\n";
	echo "<option value=''></option>	\n";
	
	for ($j = 1; $j <= 12; $j++) {
		if ( $match[$i]->month == $j )
			echo "<option value='$j' selected='selected'>$j</option>\n";
		else 	
			echo "<option value='$j'>$j</option>\n";
	}
	echo "</select>\n";
	echo " / </td>";	
	
	
	echo "<td>\n";
	echo "<select name=\"day$i\">\n";
	echo "<option value=''></option>	\n";	
	for ($j = 1; $j <= 31; $j++) {
		if ( $match[$i]->day == $j )
			echo "<option value='$j' selected='selected'>$j</option>\n";
		else 	
			echo "<option value='$j'>$j</option>\n";
	}
	echo "</select>\n";
	echo " , </td>";	

	echo "<td>\n";
	echo " <select name=\"hour$i\">\n";	
	for ($j = 0; $j < 24; $j++) {
		if ( $match[$i]->hour == $j )
			echo "<option value='$j' selected='selected'>$j</option>\n";
		else 	
			echo "<option value='$j'>$j</option>\n";
	}
	echo "</select>	\n";
	echo " : </td>		\n";		
	
	
	echo "<td>		\n";
	echo " <select name=\"minute$i\">	\n";
	for ($j = 0; $j < 60; $j=$j+5) {
		if ( $match[$i]->minute == $j )
			echo "<option value='$j' selected='selected'>$j</option>	\n";
		else 	
			echo "<option value='$j'>$j</option>	\n";
	}
	echo "</select>	\n";
	echo "</td>		\n";	
	echo "<td><input type='text' id='timezone$i' name='timezone$i' size=2 value='" . $match[$i]->timezone . "'></td>";
	echo "</tr>		\n";
}


echo "<tr><td colspan=11 align=center><input type=hidden name='week' value=" . ($m_id / $matchesPerWeek + 2) . ">";
echo "<input type=hidden name='uid' value=" . $uid . ">";
echo "<input type=submit value='Push!'></td></tr></table></center>";

/////////////////////////////////// FORM ENDS /////////////////////////////////////////////


echo "</body> </html>";

?>



