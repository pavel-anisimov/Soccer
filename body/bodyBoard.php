<?php

include './const/CONST.php';
include './classes/classBoard.php';

$uid = $_GET['uid'];
$date = $_GET['date'];
$topic = $_GET['topic'];
$message = $_GET['message'];
$z = $_GET['z'];
$wap = $_GET['wap'];



$boardOjb = new BoardClass($uid, $date, $topic, $message);


if (strlen($boardOjb->message) < 10 ) {
	$errorMsg = "You Message is too short!";
} 
	
if (strlen($boardOjb->topic) < 3 ) {
	$errorMsg = "You must include a topic!";
}

if (strlen($boardOjb->topic) >= 3 && strlen($boardOjb->message) >= 10  ){

	//////////////////////////// DATA BASE OPERATIONS START //////////////////////////////////
	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);
	
	$query = "SELECT COUNT(*) FROM board";
	
	$result = mysql_query($query);
	list($mid) = mysql_fetch_row($result);
		
	$insert_query = "INSERT INTO board VALUES (" . ($mid+1) . ", "
		. $boardOjb->uid . ", \"" 
		. $boardOjb->date . "\" , \"" 
		. $boardOjb->topic . "\" , \"" 
		. $boardOjb->message . "\" )";
		
		
	$insert_result = mysql_query($insert_query) or die ("Unable to record a query. Try later");
	
	if ($wap == "1") 
		$URL="mobile.php?action=board&uid=$uid&z=1wap=$wap"; 
	else
		$URL="scores.php?action=board&uid=$uid&z=1"; 
		
//	header ("Location: $URL"); 

	
	echo "<script language='Javascript'>";
	echo "window.location = '$URL';";
	echo "</script>";
		
	//////////////////////////// DATA BASE OPERATIONS END ////////////////////////////////////
	echo "<h5><font color=maroon>Hell, Yeah!!!</font></h5>";

}


echo "<center><table class='weekbox' width=95% cellpadding=0 cellspacing=0><tr><td><font size=2 color=000050>";

echo "<h5><font color=maroon>$date</font></h5>";

echo "<form method='get'>";
echo "<input type='hidden' id='uid' name='uid' value='" . $uid . "'>";
echo "<input type='hidden' id='wap' name='wap' value='" . $wap . "'>";
echo "<input type='hidden' id='action' name='action' value='board'>";
echo "<input type='hidden' id='date' name='date' value='" . date('Y-m-d H:i:s') . "'>";


echo "<center><table width=95%><tr><td align=right><font size=2 color=000080>Topic: </font></td><td align=right>";
echo "<input type='text' id='topic' name='topic' size=30 value='" . $topic . "'>";
echo "</td></tr><tr><td colspan=2 align=center>";
echo "<textarea rows='5' cols='38' id='message' name='message'>" . $message . "</textarea>";
echo "</td></tr><tr><td>";
echo "<input type=submit value='Push!'>";
echo "</td><td></td></tr></table></center>";

echo "</form>";
echo "</font></td></tr></table></center>";


echo "<img src=images/null.png border=0 height=5></img>";	

$threatsArray = array();

$con = mysql_connect($db_host, $db_user, $db_pass);
if (!$con) {
	die('Could not connect: ' . mysql_error());
} 
mysql_select_db($db_name);
$query = "SELECT b.mid, u.nickname, b.topic, b.body, b.day FROM board AS b, users AS u WHERE b.uid=u.uid ORDER BY b.mid DESC LIMIT 0 , 10";
 

$result = mysql_query($query);
	
while($threats = mysql_fetch_object($result) ){
	//$threatsArray[] = $threats;
	
	echo "<center><table width=95% cellpadding=3 cellspacing=1 >";

	echo "<tr><td width=100 align=center class='popup'><font size=2 colof=0040000><b>Topic:</b></font></td>";
	echo "<td align=left class='popup' ><font size=2 color=000080>" . $threats->topic . "</font></td></tr>";

	echo "<tr><td colspan=2 class='popup' ><font size=2 color=005000>" . nl2br($threats->body) . "</font></td></tr>";
	
	echo "<tr><td align=left class='popup' ><font color=000080 size=2  width=100>" . $threats->nickname . "</font></td>";
	echo "<td align=right class='popup' ><font size=1>" . $threats->day . "</font></td></tr>";
	
	echo "</table></center>";
	echo "<img src=images/null.png border=0 height=5></img>";	
	
}

mysql_close($con);  

//SELECT msg_id AS msgID, u_nickname AS msgUser, msg_topic AS msgTopic, msg_body AS msgBody, msg_day AS msgDate FROM board, users WHERE msg_uid=u_id;

?>