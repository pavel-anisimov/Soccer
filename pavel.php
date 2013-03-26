<?php

$user = "Pavel";
$pass = "russia";
$uid = 1;

//create cookies
session_start();
$_SESSION['pass'] = $pass;
$_SESSION['user'] = $user;
		
//$insert_query = "INSERT INTO log VALUES (" 
//		. $lid . ", " 
//		. $uid . ", '" 
//		. date("Y-m-d H:i") . "', '" 
//		. $ip . "' , '" 
//		. $hostaddress . "' , '"  
//		. $browser . "')";
//
//echo $insert_query . ";<br>";
//$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
		
echo "<script language='Javascript'>";
echo "window.location = 'scores.php?action=matches&uid=$uid';";
echo "</script>";


//mysql_close($con); 		

?>