<?php





//$db_host = 'anisimov.db.4274355.hostedresource.com';
//$db_user = 'anisimov';
//$db_pass = 'kvn4ALL';
//$db_name = 'anisimov';

$name = "pavel";
$host = $_SERVER['HTTP_HOST']; 
if (strpos($host,$name)) {
	$db_host = 'pavelsoccer.db.4274355.hostedresource.com';
	$db_user = 'pavelsoccer';
	$db_pass = 'kvn4ALL';
	$db_name = 'pavelsoccer';
} else {
	$db_host = 'localhost';
	$db_user = 'pavel';
	$db_pass = 'russia';
	$db_name = 'scores';
}

$matchesPerWeek = 1;
$startingWeek = 29;

date_default_timezone_set ('America/Los_Angeles');


$os = "Android";
$user_sys = $_SERVER['HTTP_USER_AGENT']; 


$phpSelf = $_SERVER['PHP_SELF'];

if (strpos($phpSelf, "action"))
	$dir = "../";
else 
	$dir = "./";


if (strpos($phpSelf, "mobile"))
	$url = "mobile.php";
else 
	$url = "scores.php";
	
	
	

if (strpos($user_sys,$os))
	$styleTag = "<link rel='stylesheet' type='text/css' href='" . $dir . "scripts/stylesAndroid.css' />\n";
else
	$styleTag = "<link rel='stylesheet' type='text/css' href='" . $dir . "scripts/styles.css' />\n";

?>
