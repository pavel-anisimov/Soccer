<?php
session_start();    
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];



$teamA1 = $_GET['teamA1'];
$teamB1 = $_GET['teamB1'];
$day1 = $_GET['dat1'];
$time1 = $_GET['time1'];

$teamA2 = $_GET['teamA2'];
$teamB2 = $_GET['teamB2'];
$day2 = $_GET['dat2'];
$time2 = $_GET['time2'];

$teamA3 = $_GET['teamA3'];
$teamB3 = $_GET['teamB3'];
$day3 = $_GET['dat3'];
$time3 = $_GET['time3'];

$teamA4 = $_GET['teamA4'];
$teamB4 = $_GET['teamB4'];
$day4 = $_GET['dat4'];
$time4 = $_GET['time4'];

$teamA5 = $_GET['teamA5'];
$teamB5 = $_GET['teamB5'];
$day5 = $_GET['dat5'];
$time5 = $_GET['time5'];

$teamA6 = $_GET['teamA6'];
$teamB6 = $_GET['teamB6'];
$day6 = $_GET['dat6'];
$time6 = $_GET['time6'];

$teamA7 = $_GET['teamA7'];
$teamB7 = $_GET['teamB7'];
$day7 = $_GET['dat7'];
$time7 = $_GET['time7'];

$teamA8 = $_GET['teamA8'];
$teamB8 = $_GET['teamB8'];
$day8 = $_GET['dat8'];
$time8 = $_GET['time8'];

$teamA9 = $_GET['teamA9'];
$teamB9 = $_GET['teamB9'];
$day9 = $_GET['dat9'];
$time9 = $_GET['time9'];

$teamA10 = $_GET['teamA10'];
$teamB10 = $_GET['teamB10'];
$day10 = $_GET['dat10'];
$time10 = $_GET['time10'];

include 'database.php';

/*
//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);
	
$query_count = "select count(*) from guesses";
$result_count = mysql_query($query_count);
list($g_id) = mysql_fetch_row($result_count);
$g_id++;

if ($pen_guess1 == "")
	$pen_guess1 = "NULL";
if ($pen_guess2 == "")
	$pen_guess2 = "NULL";	
	
$insert_query = "INSERT INTO guesses VALUES ($g_id, $user_id, $match_id, $goal_guess1, $goal_guess2, $pen_guess1, $pen_guess2, NULL)";
//echo $insert_query . "<br>";
$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
	
//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
*/ 
 


if (isset($_REQUEST['vopr1']) && isset($_REQUEST['vopr2']) && isset($_REQUEST['vopr3']) && isset($_REQUEST['vopr4']) && isset($_REQUEST['vopr5']) && isset($_REQUEST['vopr6']) && isset($_REQUEST['vopr7']) && isset($_REQUEST['vopr8']) && isset($_REQUEST['vopr9']) && isset($_REQUEST['vopr10']))
	{
	if ($_REQUEST['vopr1'] != NULL && $_REQUEST['vopr2'] != NULL && $_REQUEST['vopr3'] != NULL && $_REQUEST['vopr4'] != NULL && $_REQUEST['vopr5'] != NULL && $_REQUEST['vopr6'] != NULL && $_REQUEST['vopr7'] != NULL && $_REQUEST['vopr8'] != NULL && $_REQUEST['vopr9'] != NULL && $_REQUEST['vopr10'] != NULL)
		{
		$question1 = $_REQUEST['num1']."|".$_REQUEST['vopr1']; 
		$question2 = $_REQUEST['num2']."|".$_REQUEST['vopr2']; 
		$question3 = $_REQUEST['num3']."|".$_REQUEST['vopr3']; 
		$question4 = $_REQUEST['num4']."|".$_REQUEST['vopr4']; 
		$question5 = $_REQUEST['num5']."|".$_REQUEST['vopr5']; 
		$question6 = $_REQUEST['num6']."|".$_REQUEST['vopr6']; 
		$question7 = $_REQUEST['num7']."|".$_REQUEST['vopr7']; 
		$question8 = $_REQUEST['num8']."|".$_REQUEST['vopr8']; 
		$question9 = $_REQUEST['num9']."|".$_REQUEST['vopr9']; 
		$question10 = $_REQUEST['num10']."|".$_REQUEST['vopr10']; 
		
 
		
		$input = "\n$question1\n$question2\n$question3\n$question4\n$question5\n$question6\n$question7\n$question8\n$question9\n$question10";

		
		
		$fp = fopen('questions.txt', 'a');
		$input = stripslashes($input);
		fwrite($fp, "$input");
		fclose($fp);
		
		echo "<script language = 'Javascript'>";
		echo "window.close()";
		echo "</script>";
		
		}
	else 
		{
		$opr1 = stripslashes($_REQUEST['vopr1']);
		$opr2 = stripslashes($_REQUEST['vopr2']);
		$opr3 = stripslashes($_REQUEST['vopr3']);		
		$opr4 = stripslashes($_REQUEST['vopr4']);
		$opr5 = stripslashes($_REQUEST['vopr5']);
		$opr6 = stripslashes($_REQUEST['vopr6']);
		$opr7 = stripslashes($_REQUEST['vopr7']);
		$opr8 = stripslashes($_REQUEST['vopr8']);
		$opr9 = stripslashes($_REQUEST['vopr9']);		
		$opr10 = stripslashes($_REQUEST['vopr10']);			
		

		echo "<script language = 'Javascript'>";
		echo "window.location = 'add.php?value1=$opr1&value2=$opr2&value3=$opr3&value4=$opr4&value5=$opr5&value6=$opr6&value7=$opr7&value8=$opr8&value9=$opr9&value10=$opr10';";
		echo "</script> ";
		}
	}




$id = $_GET['user'];
$q_num = count($lines2);	
$br_num = $q_num / 10 + 1; 
echo "<html><head>";
echo $styleTag;
echo "</head><body bgcolor=91D2FF background='images/back.gif'>";
echo "<center><font color=maroon size=2 face=verdana> Brain storm # $br_num </font></center><br>";

 



 

echo "<form method='post' action='add.php?user=$user'>";

echo "<table border=0>\n";


$vopr_n1 = $q_num + 1;
$vopr_hid = "q"."$var";



echo "<tr><td>#.</td>";
echo "<td>Home Team</td>";
echo "<td>Visitor Team</td>";
echo "<td>Day</td>";
echo "<td>Time</td>";
echo "</tr>";

for ($i=0; $i<10; $i++) {
	echo "<tr><td>" . ($i + 1) . "</td>";
	echo "<td><input type='text' id='vopr1' name='vopr1' size=15 value='$value1'></td>";
	echo "<td><input type='text' id='vopr1' name='vopr1' size=15 value='$value1'></td>";
	echo "<td><input type='text' id='vopr1' name='vopr1' size=5 value='$value1'></td>";
	echo "<td><input type='text' id='vopr1' name='vopr1' size=5 value='$value1'></td>";
	echo "</tr>";
}


echo "<tr><td></td><td><input type=submit value='Æìè!'></td></tr></table>";
 

?>



</body>
</html>