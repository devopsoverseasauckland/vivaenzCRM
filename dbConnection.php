<?php	

	$serverName = "127.0.0.1";
	$userName = "vivaenzc_CRMAdm";
	$userPassword = "ACmilan2018";
	$database = "vivaenzc_CRM";
	
	$connection = mysqli_connect($serverName, $userName, $userPassword, $database, 3306);


/*

$mysqli = new mysqli("127.0.0.1", "vivaenzc_CRMAdm", "ACmilan2018", "vivaenzc_CRM", 3306);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo $mysqli->host_info . "\n";

*/

?>