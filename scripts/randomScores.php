<?php

$user = $_GET['user'];
include '../const/CONST.php';

$scoresArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 5);

$userID = 2;
$matchID =1;

echo "User # $user <br>  \n";

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

for ($i = $matchID; $i <= 91; $i++) { 
 	$a = array_rand($scoresArray);
	$b = array_rand($scoresArray);
	echo "Match " . $i . " Home Team - Away Team $scoresArray[$b]:$scoresArray[$a] <br> \n"; 
	
	$insert_query = "INSERT INTO guesses VALUES ($user, $i, $scoresArray[$b], $scoresArray[$a], NULL, NULL, NULL)";
	$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
}

	mysql_close($con);  

?>