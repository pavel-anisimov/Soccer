<?php
include 'CONST.php';

$os = "Android";
$user_sys = $_SERVER['HTTP_USER_AGENT']; 
if (strpos($user_sys,$os))
echo "Android!!!<br>";
else 
echo "Not Android!!!<br>";



echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";
echo "GATEWAY_INTERFACE: " . $_SERVER['GATEWAY_INTERFACE']  . "<br>";
echo "SERVER_ADDR: " . $_SERVER['SERVER_ADDR'] . "<br>";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME']  . "<br>";
echo "SERVER_SOFTWARE: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "SERVER_PROTOCOL: " . $_SERVER['SERVER_PROTOCOL']  . "<br>";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "REQUEST_TIME: " . $_SERVER['REQUEST_TIME']  . "<br>";
echo "QUERY_STRING: " . $_SERVER['QUERY_STRING'] . "<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['HTTP_ACCEPT']  . "<br>";
echo "HTTP_USER_AGENT: " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
echo "HTTP_REFERER: " . $_SERVER['HTTP_REFERER']  . "<br>";
echo "HTTP_ACCEPT_CHARSET: " . $_SERVER['HTTP_ACCEPT_CHARSET'] . "<br>";
echo "HTTP_REFERER: " . $_SERVER['HTTP_ACCEPT_ENCODING']  . "<br>";
echo "HTTP_ACCEPT_LANGUAGE: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";
echo "HTTP_CONNECTION: " . $_SERVER['HTTP_CONNECTION']  . "<br>";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "<br>";
echo "HTTP_REFERER: " . $_SERVER['HTTP_REFERER']  . "<br>";
echo "HTTPS: " . $_SERVER['HTTPS']  . "<br>";
echo "REMOTE_ADDR: " . $_SERVER['REMOTE_ADDR'] . "<br>";
echo "REMOTE_HOST: " . $_SERVER['REMOTE_HOST']  . "<br>";
echo "REMOTE_PORT: " . $_SERVER['REMOTE_PORT'] . "<br>";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME']  . "<br>";
echo "SERVER_ADMIN: " . $_SERVER['SERVER_ADMIN'] . "<br>";
echo "SERVER_PORT: " . $_SERVER['SERVER_PORT']  . "<br>";
echo "SERVER_SIGNATURE: " . $_SERVER['SERVER_SIGNATURE'] . "<br>";
echo "PATH_TRANSLATED: " . $_SERVER['PATH_TRANSLATED']  . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI']  . "<br>";
echo "PHP_AUTH_DIGEST: " . $_SERVER['PHP_AUTH_DIGEST'] . "<br>";
echo "PHP_AUTH_USER: " . $_SERVER['PHP_AUTH_USER']  . "<br>";
echo "PHP_AUTH_PW: " . $_SERVER['PHP_AUTH_PW'] . "<br>";
echo "AUTH_TYPE: " . $_SERVER['AUTH_TYPE']  . "<br>";
echo "PATH_INFO: " . $_SERVER['PATH_INFO'] . "<br>";
echo "ORIG_PATH_INFO: " . $_SERVER['ORIG_PATH_INFO']  . "<br>";
echo "<hr width=80% noshade color=00080>";





	$con = mysql_connect($db_host, $db_user, $db_pass);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} 
	mysql_select_db($db_name);
	
		
	$query = "SELECT DISTINCT browser FROM log ORDER BY browser";
		
	$result = mysql_query($query);
	
	while($threats = mysql_fetch_object($result)){
		echo $threats->browser . "<br>";	
	}
 mysql_close($con);  

?>