<?php
session_start();    
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

$uid = $_GET['uid'];


$action = $_GET['action'];
$week = $_GET['week'];
$order = $_GET['order'];
$revSort =  $_GET['rev'];

include './const/CONST.php';
include './const/header.php';



//////////////////////  CASES //////////////////////////
if ($order == NULL) 
	$order = "name";
if ($action == NULL) 
	$action = "matches";
if ($week == NULL) 
	$week = (int) date("W") - $startingWeek - 1;
if ($week < 1)
	$week = 1;
//////////////////////  CASES //////////////////////////

	
	

if (!$user)	{
	echo "<script language='Javascript'>";
	echo "window.location = 'index.php?id=timeout';";
	echo "</script>";
}



$head = new header("Fantasy Sports", $styleTag);
$head->getHeader();


$matchesPerPage = 10;

?>

<script language='Javascript'>
function openWin1(URL1)	{
	aWindow1 = window.open(URL1, '_blank', 'width=400, height=250, scrollbars=0, resizable=0, toolbar=0, status=0, menubar=0');	
}
function openWin2(URL2) {
	aWindow2 = window.open(URL2, '_blank', 'width=400, height=250, scrollbars=1, resizable=0, toolbar=0, status=0, menubar=0');	
}	
function openWin3(URL3) { 
	aWindow3 = window.open(URL3, '_blank', 'width=800, height=450, scrollbars=1, resizable=1, toolbar=0, status=0, menubar=0');	 
} 
</script>

<?php 


//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);

$query = "SELECT * FROM users WHERE login = '$user'";
$result = mysql_query($query);
list($uid, $name, $password, $email, $nickname, $status) = mysql_fetch_row($result);

mysql_close($con);  
//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////


	

echo "<center><table width=100% class='box'><tr><td align=center>";
echo "<b><font color=blue size=3>Soccer Nostradamus</font></b>";
echo "</td></tr></table><img src=images/null.png></img></center>";


	
echo "<center><table width=100% border=0 cellpadding=1 cellspacing=0 align=center class='top'>";
echo "<tr width=100%>";
date_default_timezone_set ('America/Los_Angeles');
echo "<td align=left><font size=1>&nbsp;&nbsp;&nbsp;Server time: <b>" . date('M j, H:i, e', time()) . "</b></font></font></td>";
date_default_timezone_set ('CET');
echo "<td align=left><font size=1>European time: <b>" . date('M j, H:i, e', time()) . "</b></font></font></td>";
date_default_timezone_set ('America/Los_Angeles');
echo "<td align=right><font size=2>Welcome, " . $nickname . "&nbsp;&nbsp;&nbsp;</font></td></tr>";
echo "</table></center>";
echo "<img src='images/null.png' border=0 height=5></img>";



echo "<table width=100% border=0 cellpadding=0 cellspacing=0  align=center>";
echo "<tr width=100% >";

echo "<td width=100% valign=top>";



//////////////////////// LINKS START ///////////////////////////

include "./menu/menuMobilLinks.php";
if ($status == "admin")
	include "./menu/menuMobilAdmin.php";

//////////////////////// BLINKS END ///////////////////////////

echo "<img src='images/null.png' border=0 height=5></img>";


echo "</td></tr>";
echo "<tr width=100%><td width=100% valign=top>";



///////////////////////////////// BODY STARTS ////////////////////////////////
switch($action) {
	case 'matches';
		include './body/bodyMatches.php';
		break;
	case 'rules';
		include './body/bodyRules.php';
		break;
	case 'about';
		include './body/bodyAbout.php';
		break;
	case 'links';
		include './body/bodyMatches.php';
		break;
	case 'board';
		include './body/bodyBoard.php';
		break;
	case 'log';
		include './body/bodyLog.php';
		break;	
	case 'editUser';
		include './body/bodyEditUser.php';
		break;	
	case 'addUser';
		include './body/bodyAddUser.php';
		break;				
	case 'userRequest';
		include './body/bodyUserRequest.php';
		break;				
	default;
		echo "<center><h4>ERROR: No Links</h4></center>";
		break;
}
////////////////////////////////// BODY ENDS /////////////////////////////////


echo "</td></tr>";
echo "<tr><td width=160 valign=top>";


////////////////////////////// POINT TABLE STARTS ////////////////////////////

include './menu/menuPointTable.php';

/////////////////////////////// POINT TABLE ENDS /////////////////////////////



echo "<img src='images/null.png' border=0 height=5></img>";




echo "</td></tr></table>";

echo "<img src='images/null.png' border=0 height=5></img>";

echo "<center><table width=100% border=0 align=center class='copyright'>";
echo "<tr><td align=right><font size=1 color=000080><b>Pavel Anisimov &copy 2010</b></font>";
echo "</td></tr>";
echo "</table></center>";



echo "</body></html>\n";
?>